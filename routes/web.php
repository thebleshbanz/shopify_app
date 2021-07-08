<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Setting;
use App\Models\Pages;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/clear-cache', function() {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    return "Cache is cleared";
});

//This will redirect user to login page.
Route::get('/login', function () {
    if (Auth::user()) {
        return redirect()->route('home');
    }
    return view('login');
})->name('login');



Route::middleware(['auth.shopify'])->group(function(){
    
    Route::get('shopify', 'ShopifyAppController@index');
    
    Route::get('/', function () {
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
                            <ps-wishlist :shop_id="{{ shop.id }}" :customer_id=" {% if customer %} {{ customer.id }} {% else %} 0 {% endif %} " ></ps-wishlist>
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
    })->name('home');
    
    // Navbar Routing
    Route::view('/products', 'products')->name('products');
    Route::view('/customers', 'customers')->name('customers');
    Route::view('/settings', 'settings')->name('settings');

    Route::get('wishlists', "WishlistController@index")->name('wishlists');

    Route::get('configureTheme', 'SettingController@configureTheme')->name('configureTheme');
    
    Route::get('create-new-page', 'SettingController@createNewPage')->name('create_new_page');

    Route::get('/test', function(){
        $shop = Auth::user();
        $script_tags = $shop->api()->rest('GET', '/admin/api/2021-04/script_tags.json');
        dd($script_tags);
        return $script_tags;
    })->name('test');

    Route::get('/access_scopes', function(){
        $shop = Auth::user();
        // admin/oauth/access_scopes.json
        $access_scopes = $shop->api()->rest('GET', '/admin/api/2021-04/access_scopes.json');
        dd($access_scopes);
        return $access_scopes;
    })->name('test');

    Route::get('/myshop', function(){
        $shop = Auth::user();
        $request = $shop->api()->rest('GET', '/admin/shop.json');
        dd($request['body']['container']['shop']);
        return $request;
    })->name('test');
    
    // list of access scopes
    Route::get('/access_scopes', function(){
        $shop = Auth::user();
        $access_scopes = $shop->api()->rest('GET', '/admin/oauth/access_scopes.json');
        dd($access_scopes);
        return $access_scopes;
    })->name('access_scopes');

    // /admin/api/2021-04/script_tags.json
    /* Route::get('/create/script_tag', function(){
        
        $shop = Auth::user();
        // $array = ['script_tag' => ["event" => "onload", "src" => url('/public/scripts/shopify.js?shop_name='.$shop->name) ] ];
        $array = ['script_tag' => 
                    [
                        ["event" => "onload", "src" => url('/public/scripttags/parkhya-app.js')],
                        ["event" => "onload", "src" => url('/public/scripttags/parkhya-app.css')]
                    ]
                ];

        $script_tag = $shop->api()->rest('POST', '/admin/api/2021-04/script_tags.json', $array );
        
        return $script_tag;
    }); */

    // /admin/api/2021-04/script_tags/{script_tag_id}.json
    /* Route::get('/update/script_tag', function(){
        
        $shop = Auth::user();
        // $array = ['script_tag' => ["event" => "onload", "src" => url('/public/scripts/shopify.js?shop_name='.$shop->name) ] ];
        $array = ['script_tag' => ["id" => "174762492088", "src" => url('/public/scripts/ps-product.liquid') ] ];

        $script_tag = $shop->api()->rest('PUT', '/admin/api/2021-04/script_tags/174762492088.json', $array );
        
        return $script_tag;
    }); */

    // list of themes and put asset
    /* Route::get('/delete/script_tag', function(){
        $shop = Auth::user();

        $script_tag = $shop->api()->rest('DELETE', '/admin/api/2021-04/script_tags/174843003064.json');
        
        return $script_tag;
    }); */
});