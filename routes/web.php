<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth.shopify'])->name('home');

//This will redirect user to login page.
Route::get('/login', function () {
    if (Auth::user()) {
        return redirect()->route('home');
    }
    return view('login');
})->name('login');


// Navbar Routing
Route::view('/products', 'products');
Route::view('/customers', 'customers');
Route::view('/settings', 'settings');
Route::get('/test', function(){
    $shop = Auth::user();
    if(!empty($shop)){
        return $shop;
    }else{
        echo "user is empty";
    }
});
/*
Route::middleware(['auth.shopify'])->group(function(){

})*/