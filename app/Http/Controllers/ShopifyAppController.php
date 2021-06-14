<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopifyAppController extends Controller
{
    public function index(Request $request){
        dd(get_included_files ());
        // random_code();
    }
}
