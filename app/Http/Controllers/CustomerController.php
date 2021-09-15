<?php

namespace App\Http\Controllers;

use App\Wishlist;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shop = Auth::user();
        $customer_ids = [];
        $customers = [];
        
        $shopWishlists = Wishlist::where('shop_id', $shop->shop_id)
                        ->where('customer_id', '!=', '0')
                        ->groupBy('customer_id')
                        ->orderBy('updated_at', 'desc')
                        ->get();
        

        if(!empty($shopWishlists)){
            
            foreach($shopWishlists as $item){
                if($item->customer_id){
                    array_push($customer_ids, $item->customer_id);
                }
            }

            if($customer_ids){
                
                # Get a customer using the QueryRoot.node field and a GraphQL fragment
                $array = ['ids' => implode(',', $customer_ids), 'fields'=> 'id,email,first_name, last_name, addresses, phone'];
                $response = $shop->api()->rest('GET', '/admin/api/2021-07/customers.json', $array);
                
                if(!$response['errors']){
                    $data = $response['body']['container']['customers'];
                    foreach ($data as $value) {
                        $row = [];
                        $row['store'] = $value;
                        $row['count'] = Wishlist::where('customer_id', $value['id'])->count();
                        $customers[] = $row;
                    }
                }
            }
            
        }
        
        return view('admin.customers', compact('customers'));
        // return view('partials.customers-table', compact('customers'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function productCustomers(Request $request)
    {
        $shop = Auth::user();

        $customer_ids = [];
        $customers = [];

        $product_id = last(explode('/', $request->input('product_id') ));       

        $shopWishlists = Wishlist::where('shop_id', $shop->shop_id)
                        ->where('product_id', $product_id)
                        ->orderBy('updated_at', 'desc')
                        ->get();
                        
        if(!empty($shopWishlists)){
            foreach($shopWishlists as $item){
                if($item->customer_id){
                    array_push($customer_ids, $item->customer_id);
                }
            }
        }
        if(!empty($customer_ids)){
            # Get a customer using the QueryRoot.node field and a GraphQL fragment
            $array = ['ids' => implode(',', $customer_ids), 'fields'=> 'id,email,first_name, last_name, addresses, phone'];
            $response = $shop->api()->rest('GET', '/admin/api/2021-07/customers.json', $array);
            
            if(!$response['errors']){
                $data = $response['body']['container']['customers'];
                foreach ($data as $value) {
                    $row = [];
                    $row['store'] = $value;
                    $customers[] = $row;
                }
            }
        }
        // dd($customers);
        return view('partials.product-customers-table', compact('customers'));
    }
}
