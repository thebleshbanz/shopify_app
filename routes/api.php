<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\User;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// /admin/api/2021-04/script_tags.json
Route::post('/post/script_tag', function(){
    
    // $shop = Auth::user();
    $shop = User::find(1);

    $array = ['script_tag' => ["event" => "onload", "src" => url('/public/scripts/shopify.js') ] ];

    $script_tag = $shop->api()->rest('POST', '/admin/api/2021-04/script_tags.json', $array );
    
    return $script_tag;
});

// add wish list
Route::post('/addToWishlist', 'WishlistController@store');

// remove wishlist
Route::post('/removeWishlist', 'WishlistController@destroy');

// check wishlist
Route::post('/checkWishlist', 'WishlistController@check');

// get customer wishlist
Route::post('/ownWishlist', 'WishlistController@ownWishlist');

// get customer wishlist test
Route::post('/testWishlist', 'WishlistController@ownWishlistTest');
//  sync customer wishlist
Route::post('/sync-wishlist', 'WishlistController@syncWishlist');

Route::post('/shop/settings', 'SettingController@shop')->name('shop.settings');

// add to cart
Route::post('/addToCart', 'ShopifyAppController@addToCart' )->name('add_cart');