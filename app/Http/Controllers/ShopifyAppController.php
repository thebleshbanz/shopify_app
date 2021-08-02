<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Setting;
use App\Models\Pages;

class ShopifyAppController extends Controller
{
    public function index(Request $request){
        $shop = Auth::user();
        // check if shop data not stored
        if($shop->shop_id === ''){
            // store shop extra data to user table
            $shop_api = $shop->api()->rest('GET', '/admin/api/2021-04/shop.json');
            if(!$shop_api['errors']){
                $shop_data = $shop_api['body']['container']['shop'];
                $shop->shop_id          =   $shop_data['id'];
                $shop->domain           =   $shop_data['domain'];
                $shop->country          =   $shop_data['country'];
                $shop->money_formate    =   $shop_data['money_format'];
                $shop->primary_location_id =   $shop_data['primary_location_id'];
                $shop->shop_json        =   json_encode($shop_data);
                $shop->save();
            }
            // create a new template name wishlist on mail theme
            // /admin/api/2021-04/themes.json
            $themes = $shop->api()->rest('GET', '/admin/api/2021-04/themes.json')['body'];
            // get Active Theme Id
            $activeThemeId = '';
            foreach ($themes['container']['themes'] as $theme) {
                if($theme['role'] == 'main'){
                    $activeThemeId = $theme['id'];
                }
            }
            // snippet code which put in wishlist template liquid file.
            $snippet = '
                <div class="page-width">
                    <div class="grid">
                        <div class="grid__item medium-up--five-sixths medium-up--push-one-twelfth">
                        <div class="section-header text-center">
                            <h1>{{ page.title }}</h1>
                        </div>

                        <div class="rte">
                            <div id="ps-wishlist-page">
                                <ps-wishlist-page :shop_id="{{ shop.id }}" :customer_id=" {% if customer %} {{ customer.id }} {% else %} 0 {% endif %} " ></ps-wishlist-page>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                ';

            $array = ['asset' => ["key" => "templates/page.wishlist.liquid", "value" => $snippet ] ];
            // PUT /admin/api/2021-04/themes/828155753/assets.json
            $put_asset = $shop->api()->rest('PUT', '/admin/api/2021-04/themes/'.$activeThemeId.'/assets.json', $array );
            // check put assests have no errors
            if(!$put_asset['errors']){
                $array = ['page' =>
                    [
                        "title" => "Wishlist", 
                        "body_html" => "",
                        "template_suffix" => "wishlist",
                    ]
                ];
                $page = $shop->api()->rest('POST', '/admin/api/2021-04/pages.json', $array);
                // if create page api response any error then show
                if($page['errors']){
                    dd($page);
                }else{
                    $pdata = $page['body']['container']['page'];
                    $shop_page = new Pages;
                    $shop_page->page_id = $pdata['id'];
                    $shop_page->title   = $pdata['title'];
                    $shop_page->shop_id = $pdata['shop_id'];
                    $shop_page->handle  = $pdata['handle'];
                    $shop_page->template_suffix  = $pdata['template_suffix'];
                    $shop_page->save();
                }
            }
        }

        $setting = Setting::where('shop_id', $shop->name)->first();
        return view('dashboard', compact('setting'));
    }

    public function appUninstalled(Request $request){
        // $hmac_header = $this->input->server('HTTP_X_SHOPIFY_HMAC_SHA256');
		$data = file_get_contents('php://input');

        dd($request->all(), $data);
    }
}
