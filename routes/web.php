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



Route::middleware(['auth.shopify', 'billable'])->group(function(){
    
    Route::get('/', 'ShopifyAppController@index' )->name('home');
    
    // Navbar Routing
    Route::view('/products', 'products')->name('products');
    Route::view('/customers', 'customers')->name('customers');
    Route::view('/settings', 'settings')->name('settings');

    Route::get('wishlists', "WishlistController@index")->name('wishlists');
    
    // All customer who wishlisted products
    Route::get('wishlist/customers', "CustomerController@index")->name('wishlist-customers');

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

    // create a webhook for app uninstalled
    // app/uninstalled
    // /admin/api/2021-07/webhooks.json
    /*Route::get('/create/webhook', function(){
        $shop = Auth::user();
        $url = 'https://parkhyamapps.co.in/shopify_app/webhook/ps-app-uninstalled';
        $array = ['webhook' => ["topic" => "app/uninstalled", "address" => $url, "format"=>"json" ] ];
        $webhook = $shop->api()->rest('POST', '/admin/api/2021-07/webhooks.json', $array);
        
        return $webhook;
    });*/

    // get all webhook
    // /admin/api/2021-07/webhooks.json
    /*Route::get('/webhooks', function(){
        $shop = Auth::user();
        $webhooks = $shop->api()->rest('GET', '/admin/api/2021-07/webhooks.json');
        
        return $webhooks;
    });*/

    // Delete webhook
    // /admin/api/2021-07/webhooks/{webhook_id}.json
    /*Route::get('/delete/webhook', function(){
        $shop = Auth::user();
        $webhook = $shop->api()->rest('DELETE', '/admin/api/2021-07/webhooks/1046082617528.json');
        return $webhook;
    });*/
        
});