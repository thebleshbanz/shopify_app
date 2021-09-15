<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use App\Setting;
use App\Wishlist;
use App\Cart;
use App\ContactUs;
use App\User;
use App\Models\Pages;
use App\Mail\SympathyMail;

class ShopifyAppController extends Controller
{
    public function index(Request $request){
        $shop = Auth::user();
        // dd($shop);
        $setting = Setting::where('shop_id', $shop->name)->first();
        $statistics = [];
        // /admin/api/2021-07/customers/count.json
        if($shop->password != ''){
            $admin_customers = $shop->api()->rest('GET', '/admin/api/2021-07/customers/count.json');
            if(!$admin_customers['errors']){
                $statistics['total_customer'] =  $admin_customers['body']->container['count'];
            }else{
                $statistics['total_customer'] =  0;
            }
            // dd($admin_customers);
            $statistics['total_wishlist_customer']      =  count(Wishlist::where('shop_id', $shop->shop_id)->where('customer_id', '!=', 0)->groupBy('customer_id')->get());
            $statistics['total_wishlist_product']       =  count(Wishlist::where('shop_id', $shop->shop_id)->where('customer_id', '!=', 0)->groupBy('product_id')->get());
            $statistics['total_wishlist_product_cart']  =  0;
        }else{
            $statistics['total_customer']               =  0;
            $statistics['total_wishlist_customer']      =  0;
            $statistics['total_wishlist_product']       =  0;
            $statistics['total_wishlist_product_cart']  =  0;
        }

        return view('admin.dashboard', compact('setting', 'shop', 'statistics'));
    }

    public function appUninstalled(Request $request){
        // $hmac_header = $this->input->server('HTTP_X_SHOPIFY_HMAC_SHA256');
		$data = file_get_contents('php://input');

        dd($request->all(), $data);
    }

    public function addToCart(Request $request){
        $post = $request->all();

        // $wishlist = new Wishlist;
        $data['shop_id']      = isset($post['shop_id']) ? $post['shop_id'] : '';
        $data['customer_id']  = isset($post['customer_id']) ? $post['customer_id'] : 0;
        $data['product_id']   = isset($post['product_id']) ? $post['product_id'] : '';
        $wishlist = Cart::updateOrCreate($data);
        if($wishlist){
            $data = ['status'=>true, 'code'=>200, 'data'=>$wishlist];
        }else{
            $data = ['status'=>false, 'code'=>404, 'msg'=>'data not found'];
        }
        return $data;
    }

    public function contactUs(){
        $user = Auth::user();
        return view('admin.contact_us', compact('user') );
    }

    public function storeContactUs(Request $request){
        // $shop = Auth::user();

        $rules = [
            'store_name' => 'required|max:255',
            'email' => 'required|max:255',
            'subject' => 'required|max:255',
        ];

        $file = $request->file('contact_file');

        if($file){
            $rules['contact_file'] = 'mimes:jpeg,jpg,png,gif|required';
        }

        $request->validate($rules);
        
        $contact_us = new ContactUs;
        $contact_us->store_name     = ($request->input('store_name')) ? $request->input('store_name') : '';
        $contact_us->email          = ($request->input('email')) ? $request->input('email') : '';
        $contact_us->subject        = ($request->input('subject')) ? $request->input('subject') : '';
        $contact_us->message        = ($request->input('message')) ? $request->input('message') : '';
        
        if($file){
            $filename   = $file->getClientOriginalName();
            $name       = "contact_file";
            $extension  = $file->extension();
            $filenew    =  date('d-M-Y').'_'.str_replace($filename,$name,$filename).'_'.time().''.rand(). "." .$extension;
            $file->move(base_path('/public/uploads/contact'), $filenew);
            $contact_us->contact_file   = asset('/uploads/contact/'.$filenew);
        }
        $contact_us->status = 0;
        $res = $contact_us->save();

        if($res){
            // $res = Mail::to($contact_us->email)->send(new SympathyMail($contact_us));
            // $res = Mail::to('appsupport@parkhya.com')->cc('rashmi@parkhya.com')->send(new AdminReportMail($contact_us));
            // $res = Mail::to('appsupport@parkhya.com')->cc('ashish.banjare@parkhya.com')->send(new AdminReportMail($contact_us));
            
            $data               = $contact_us;
            $contact_email      = $contact_us->email;
            $contact_subject    = $contact_us->subject;
            
            Mail::send('mails.sympathy', compact('data'), function($message) use ($contact_email, $contact_subject) {
                $message->to($contact_email)->subject($contact_subject);
            });
            
            Mail::send('mails.admin-report', compact('data'), function($message) use ($contact_email, $contact_subject) {
                $message->to('appsupport@parkhya.com')->cc('rashmi@parkhya.com')->subject($contact_subject);
            });

            return redirect(route('contact_us'))->with('success', __('The request has been successfully send'));
        }else{
            return redirect(route('contact_us'))->with('fail', __('Something went wrong'));
        }
    }

    public function profile(){
        $user = Auth::user();
        return view('admin.profile', compact('user') );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateUser(Request $request, User $user)
    {
        $post = $request->all();
        dd($post, $user);
        /* $setting->activated               = isset($post['activated']) ? 1 : 0;
        $setting->redirect_product_page   = isset($post['redirect_product_page']) ? 1 : 0;
        $setting->disable_guests          = isset($post['disable_guests']) ? 1 : 0;
        $setting->wishlist_btn_size       = isset($post['wishlist_btn_size']) ? 1 : 0;
        $setting->wishlist_btn_color      = isset($post['wishlist_btn_color']) ? $post['wishlist_btn_color'] : '';
        $setting->is_heart_icon           = isset($post['is_heart_icon']) ? 1 : 0;
        $setting->is_wishlist_collection  = isset($post['is_wishlist_collection']) ? 1 : 0;
        $setting->share_social_media      = isset($post['share_social_media']) ? 1 : 0;
        $setting->reminder_mail           = isset($post['reminder_mail']) ? 1 : 0;
        $setting->mail_recursive_days     = isset($post['mail_recursive_days']) ? $post['mail_recursive_days'] : '';
        $setting->wishlist_label_btn      = isset($post['wishlist_label_btn']) ? $post['wishlist_label_btn'] : '';
        $res = $setting->save();
        if($res){
            return redirect(route('settings', ['shop_id'=>$setting->shop_id ] ))->with('success', __('The Setting has been successfully updated'));
        }else{
            return redirect(route('settings', ['shop_id'=>$setting->shop_id ] ))->with('fail', __('Something went wrong'));
        } */
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function customerDataRequest(Request $request){
        // $currentURL  = url()->current();
		$hmac_header = $_SERVER('HTTP_X_SHOPIFY_HMAC_SHA256');
		$data = file_get_contents('php://input');
		$calculated_hmac = base64_encode(hash_hmac('sha256', $data, SHOPIFY_SECRET, true));
		$verified        = hash_equals($hmac_header, $calculated_hmac);
		$webhook_payload = json_decode($data);
		$shop_id         = $webhook_payload['shop_id'];
        Log::info($webhook_payload);
		if ($shop_id != '') 
		{
			$shop_domain     = $webhook_payload['shop_domain'];
			$customer_email  = $webhook_payload['customer']['email'];
			$customer_id     = $webhook_payload['customer']['id'];
			$webhookType     = 'customers/data_request';
            $created         = date('Y-m-d h:i:s');
			$webhookData     = array(
				'store_id'   => $shop_id ,
				'type'       => $webhookType, 
				'url'        => $currentURL, 
				'created_at' => $created,
				'updated_at' => $created
			);
            DB::table('webhooks')->insert($webhookData);
						
			//echo json_encode($response);
			return http_response_code(200);
            // return true;
		}
		else
		{
			return http_response_code(200);
            // return true;
		}
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function customerRedact(Request $request){
        // $currentURL  = url()->current();
		$hmac_header = $_SERVER('HTTP_X_SHOPIFY_HMAC_SHA256');
		$data = file_get_contents('php://input');
		$calculated_hmac = base64_encode(hash_hmac('sha256', $data, SHOPIFY_SECRET, true));
		$verified        = hash_equals($hmac_header, $calculated_hmac);
		$webhook_payload = json_decode($data);
		$shop_id         = $webhook_payload['shop_id'];
        Log::info($webhook_payload);
		if ($shop_id != '') 
		{
			$shop_domain     = $webhook_payload['shop_domain'];
			$customer_email  = $webhook_payload['customer']['email'];
			$customer_id     = $webhook_payload['customer']['id'];
			$webhookType     = 'customers/redact';
            $created         = date('Y-m-d h:i:s');
			$webhookData     = array(
				'store_id'   => $shop_id ,
				'type'       => $webhookType, 
				'url'        => $currentURL, 
				'created_at' => $created,
				'updated_at' => $created
			);
            DB::table('webhooks')->insert($webhookData);

			// Delete all customer wishlist data
            DB::table('wishlists')->where('customer_id', $customer_id)->delete();
						
			//echo json_encode($response);
			return http_response_code(200);
            // return true;
		}
		else
		{
			return http_response_code(200);
            // return true;
		}
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function shopRedact(Request $request){
        // $currentURL  = url()->current();
		$hmac_header = $_SERVER('HTTP_X_SHOPIFY_HMAC_SHA256');
		$data = file_get_contents('php://input');
		$calculated_hmac = base64_encode(hash_hmac('sha256', $data, SHOPIFY_SECRET, true));
		$verified        = hash_equals($hmac_header, $calculated_hmac);
		$webhook_payload = json_decode($data);
		$shop_id         = $webhook_payload['shop_id'];
        Log::info($webhook_payload);
		if ($shop_id != '') 
		{
			$shop_domain     = $webhook_payload['shop_domain'];
			$customer_email  = $webhook_payload['customer']['email'];
			$customer_id     = $webhook_payload['customer']['id'];
			$webhookType     = 'shops/redact';
            $created         = date('Y-m-d h:i:s');
			$webhookData     = array(
				'store_id'   => $shop_id ,
				'type'       => $webhookType, 
				'url'        => $currentURL, 
				'created_at' => $created,
				'updated_at' => $created
			);
            DB::table('webhooks')->insert($webhookData);

			// Delete shop data
            DB::table('wishlists')->where('shop_id', $shop_id)->delete();

			// Delete shop data from user table
            DB::table('users')->where('shop_id', $shop_id)->delete();

			// Delete shop data from setting
            DB::table('settings')->where('shop_id', $shop_id)->delete();

			// Delete shop data from shop_pages
            DB::table('shop_pages')->where('shop_id', $shop_id)->delete();
						
			//echo json_encode($response);
			return http_response_code(200);
            // return true;
		}
		else
		{
			return http_response_code(200);
            // return true;
		}
    }
}
