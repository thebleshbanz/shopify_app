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

// Customer data request endpoint
Route::get('/store/customers/data_request', 'ShopifyAppController@customerDataRequest' )->name('store_customer_data_request');

// Customer data erasure endpoint
Route::get('/store/customers/redact', 'ShopifyAppController@customerRedact' )->name('store_customer_redact');

// Shop data erasure endpoint
Route::get('/shop/redact', 'ShopifyAppController@shopRedact' )->name('shop_redact');



Route::middleware(['auth.shopify'])->group(function(){

    // Dashboard
    Route::get('/', 'ShopifyAppController@index' )->name('home');

    /* list of All wishlisted products */
    Route::get('/products', "WishlistController@index")->name('products');
    // Get all customer who wishlisted on specifc product
    Route::get('product/customers', "CustomerController@productCustomers")->name('product-customers');

    // All customer who wishlisted products
    Route::get('/customers', "CustomerController@index")->name('customers');
    // Get all those products which wished by a customer.
    Route::get('customer/products', "WishlistController@customerProducts")->name('customer-products');
    
    /* wishlist app settings */
    Route::get('/settings/{user_id}', 'SettingController@index')->name('settings');
    // update setting by submited form
    Route::put('settings/update/{setting}', 'SettingController@update')->name('settings.update');

    /* App Plans set */
    Route::get('/plans', function(){
        return view('admin.plans');
    })->name('plans');

    /* App Integrations Rules */
    Route::get('/integrations', function(){
        return view('admin.integrations');
    })->name('integrations');


    /* App Contact Us */
    Route::get('/contact-us', 'ShopifyAppController@contactUs' )->name('contact_us');
    // Post Contact Us form
    Route::post('contact-us', 'ShopifyAppController@storeContactUs' )->name('contact_us.save');

    /* App User Profile */
    Route::get('/user/{user_id}', 'ShopifyAppController@profile')->name('user');
    // Post Contact Us form
    Route::put('user', 'ShopifyAppController@updateUser' )->name('user.update');

    Route::get('configureTheme', 'SettingController@configureTheme')->name('configureTheme');
    
    Route::get('create-new-page', 'SettingController@createNewPage')->name('create_new_page');
    
        
});