<?php

namespace App\Http\Controllers;

use App\Setting;
use App\Models\Pages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SettingController extends Controller
{
    
    public function configureTheme(Request $request)
    {
        $shop = Auth::user();
        // /admin/api/2021-04/themes.json
        $themes = $shop->api()->rest('GET', '/admin/api/2021-04/themes.json')['body'];
        // get Active Theme Id
        $activeThemeId = '';
        foreach ($themes['container']['themes'] as $theme) {
            if($theme['role'] == 'main'){
                $activeThemeId = $theme['id'];
            }
        }

        $snippet = '
                    <div class="page-width">
                        <div class="grid">
                            <div class="grid__item medium-up--five-sixths medium-up--push-one-twelfth">
                            <div class="section-header text-center">
                                <h1>{{ page.title }}</h1>
                            </div>

                            <div class="rte">
                                <div id="ps-wishlist-page">
                                    <ps-wishlist :customer_id=" {% if customer %} {{ customer.id }} {% else %} 0 {% endif %} " ></ps-wishlist>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    ';

        $array = ['asset' => ["key" => "templates/page.wishlist.liquid", "value" => $snippet ] ];
        // PUT /admin/api/2021-04/themes/828155753/assets.json
        $put_asset = $shop->api()->rest('PUT', '/admin/api/2021-07/themes/'.$activeThemeId.'/assets.json', $array );

        Setting::updateOrCreate(
            ['shop_id' => $shop->name],
            ['activated' => true]
        );
        
        return $put_asset;
    }

    public function createNewPage(){
        $shop = Auth::user();
        // /admin/api/2021-04/pages.json
        /* {
            "page": {
                "title": "Warranty information",
                "body_html": "<h2>Warranty</h2>\n<p>Returns accepted if we receive items <strong>30 days after purchase</strong>.</p>"
            }
        } */
        $array = ['page' => 
                    [
                        "title" => "Wishlist", 
                        "body_html" => "",
                        "template_suffix" => "wishlist",
                    ]
                ];
        $response = $shop->api()->rest('POST', '/admin/api/2021-07/pages.json', $array);
        if(!$response['errors']){
            $pdata = $response['body']['container']['page'];
            $shop_page = new Pages;
            $shop_page->page_id = $pdata['id'];
            $shop_page->title   = $pdata['title'];
            $shop_page->shop_id = $pdata['shop_id'];
            $shop_page->handle  = $pdata['handle'];
            $shop_page->template_suffix  = $pdata['template_suffix'];

            $shop_page->save();
        }
        return $response;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        $shop_id = Auth::user()->shop_id;
        // Will return a ModelNotFoundException if no user with that id
        try
        {
            $setting = Setting::where('shop_id', $shop_id)->first();
        }
        // catch(Exception $e) catch any exception
        catch(ModelNotFoundException $e)
        {
            // dd(get_class_methods($e)); // lists all available methods for exception object
            // dd($e);
            $setting = '';
        }
        
        return view('settings', compact('setting'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function shop(Request $request)
    {
        $shop_id = $request->input('shop_id');
        $shop = Setting::where('shop_id', $shop_id)->first();
        if($shop){
            return ['status'=>true, 'code'=>200, 'data'=>$shop];
        }else{
            return ['status'=>false, 'code'=>404, 'msg'=>'data not found'];
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        $post = $request->all();
        $setting->activated               = isset($post['activated']) ? 1 : 0;
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
        return redirect()->back();
        /* if($res){
            return redirect(route('settings', ['shop_id'=>$setting->shop_id ] ))->with('success', __('The Setting has been successfully updated'));
        }else{
            return redirect(route('settings', ['shop_id'=>$setting->shop_id ] ))->with('fail', __('Something went wrong'));
        } */
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
