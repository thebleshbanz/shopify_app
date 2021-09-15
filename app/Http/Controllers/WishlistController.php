<?php

namespace App\Http\Controllers;

use App\Wishlist;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shop = Auth::user();

        $shopWishlists = Wishlist::where('shop_id', $shop->shop_id)
                                    ->where('customer_id', '!=', '0')
                                    ->groupBy('product_id')
                                    ->orderBy('updated_at', 'desc')
                                    ->get();
        $lists = [];
        
        $products = [];

        foreach($shopWishlists as $item){
            if($item->product_id){
                array_push($lists, "gid://shopify/Product/{$item->product_id}");
            }
        }
        
        $mylist = json_encode($lists);

        $query = "
            {
                nodes(ids:  $mylist ) {
                ... on Product {
                    id
                    title
                    handle
                    featuredImage {
                      originalSrc
                    }
                    totalInventory
                    vendor
                    onlineStorePreviewUrl
                    priceRange{
                    maxVariantPrice{
                        currencyCode
                        amount
                        }
                    }
                    }
                }
            }
        ";
// echo $query;die;
        $response = $shop->api()->graph($query);

        if(!empty($response)){
            $data = $response['body']->container['data']['nodes'];
            foreach($data as $value){
                $product_id = last(explode('/', $value['id']));
                $row = [];
                $row['store'] = $value;
                $row['count'] = Wishlist::where('shop_id', $shop->shop_id)->where('customer_id', '!=', '0')->where('product_id', $product_id)->count();
                $products[] = $row;
            }
        }

        return view('admin.products', compact('products'));
        // return view('partials.wishlist-table', compact('products'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ownWishlistTest(Request $request)
    {
        $result = [];
        $post = $request->all();
        // dd($post);
        $shop_id      = isset($post['shop_id']) ? $post['shop_id'] : '';
        $customer_id  = isset($post['customer_id']) ? $post['customer_id'] : 0;
        $session_id   = isset($post['session_id']) ? $post['session_id'] : '';
        $title        = isset($post['title']) ? $post['title'] : '';
        
        $shop = User::where('shop_id', $shop_id)->first();
        
        $shopWishlists  = Wishlist::where('shop_id', $shop_id)
                            ->where('customer_id', $customer_id)
                            ->where('session_id', $session_id)
                            ->orderBy('updated_at', 'desc')
                            ->get();
        // dd($shopWishlists);
        if(count($shopWishlists) != 0 ){
            $lists = [];
            foreach($shopWishlists as $item){
                if($item->product_id){
                    array_push($lists, $item->product_id);
                }
            }
            
            if(count($lists) != 0){
                //  /admin/api/2021-07/products.json
                $pera = ['ids' => implode(',',$lists)];

                if($title != ''){
                    $pera['handle'] = $title;
                }
                // dd($pera);
                $products = $shop->api()->rest('GET', '/admin/api/2021-07/products.json', $pera);
    
                dd($products);
                if(!empty($products)){
                    $result = ['status'=>true, 'code'=>200, 'data'=>$products];
                }else{
                    $result = ['status'=>false, 'code'=>404, 'msg'=>'data not found'];
                }
            }else{
                $result = ['status'=>false, 'code'=>404, 'msg'=>'data not found'];
            }

        }else{
            $result = ['status'=>false, 'code'=>404, 'msg'=>'data not found'];
        }
        return $result;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // backup of function on 2021-08-05 dev@ashish
    public function ownWishlist(Request $request)
    {
        $result = [];
        $post = $request->all();
        $shop_id      = isset($post['shop_id']) ? $post['shop_id'] : '';
        $customer_id  = isset($post['customer_id']) ? $post['customer_id'] : 0;
        $session_id   = isset($post['session_id']) ? $post['session_id'] : '';
        
        $shop = User::where('shop_id', $shop_id)->first();
        
        $shopWishlists  = Wishlist::where('shop_id', $shop_id)->where('customer_id', $customer_id)->where('session_id', $session_id)->orderBy('updated_at', 'desc')->get();

        if(count($shopWishlists) != 0 ){
            $lists = [];
            foreach($shopWishlists as $item){
                if($item->product_id){
                    array_push($lists, "gid://shopify/Product/{$item->product_id}");
                }
            }
            
            if(count($lists) != 0){
                $mylist = json_encode($lists);
                // dd($mylist);
                $query = "
                    {
                        nodes(ids:  $mylist ) {
                        ... on Product {
                                id
                                title
                                handle
                                featuredImage {
                                    originalSrc
                                }
                                totalInventory
                                vendor
                                onlineStorePreviewUrl
                                priceRange {
                                    maxVariantPrice {
                                        amount
                                        currencyCode
                                    }
                                    minVariantPrice {
                                        amount
                                        currencyCode
                                    }
                                }
                                priceRangeV2 {
                                    maxVariantPrice {
                                        amount
                                        currencyCode
                                    }
                                    minVariantPrice {
                                        amount
                                        currencyCode
                                    }
                                }
                                variants(first: 10) {
                                    edges {
                                        node {
                                            id
                                            title
                                            price
                                            compareAtPrice
                                        }
                                    }
                                }
                            }
                        }
                    }
                ";
    
                $products = $shop->api()->graph($query);
                if(!empty($products)){
                    $result = ['status'=>true, 'code'=>200, 'data'=>$products];
                }else{
                    $result = ['status'=>false, 'code'=>404, 'msg'=>'data not found'];
                }
            }else{
                $result = ['status'=>false, 'code'=>404, 'msg'=>'data not found'];
            }

        }else{
            $result = ['status'=>false, 'code'=>404, 'msg'=>'data not found'];
        }
        return $result;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function customerProducts(Request $request)
    {
        $result     = [];
        $products   = [];
        $post = $request->all();
        $customer_id  = isset($post['customer_id']) ? $post['customer_id'] : 0;
        
        $shop = Auth::user();
        
        $shopWishlists  = Wishlist::where('shop_id', $shop->shop_id)
                            ->where('customer_id', $customer_id)
                            ->orderBy('updated_at', 'desc')
                            ->get();

        if(count($shopWishlists) != 0 ){
            $lists = [];
            foreach($shopWishlists as $item){
                if($item->product_id){
                    array_push($lists, "gid://shopify/Product/{$item->product_id}");
                }
            }
            
            if(count($lists) != 0){
                $mylist = json_encode($lists);
                $query = "
                    {
                        nodes(ids:  $mylist ) {
                        ... on Product {
                                id
                                title
                                handle
                                featuredImage {
                                    originalSrc
                                }
                                totalInventory
                                vendor
                                onlineStorePreviewUrl
                                priceRange{
                                    maxVariantPrice{
                                        currencyCode
                                        amount
                                    }
                                }
                                variants(first: 10) {
                                    edges {
                                        node {
                                            id
                                            title
                                        }
                                    }
                                }
                            }
                        }
                    }
                ";
    
                $response = $shop->api()->graph($query);
                
                if(!empty($response)){
                    $data = $response['body']->container['data']['nodes'];
                    foreach($data as $value){
                        $product_id = last(explode('/', $value['id']));
                        $row = [];
                        $row['store'] = $value;
                        $row['count'] = Wishlist::where('shop_id', $shop->shop_id)->where('customer_id', '!=', '0')->where('product_id', $product_id)->count();
                        $products[] = $row;
                    }
                }
            }

        }
        
        return view('partials.customer-products-table', compact('products'));
    }

    public function syncWishlist(Request $request){
        $post = $request->all();
        $shop_id      = isset($post['shop_id']) ? $post['shop_id'] : '';
        $customer_id  = isset($post['customer_id']) ? $post['customer_id'] : 0;
        $session_id   = isset($post['session_id']) ? $post['session_id'] : '';
        
        $wishlist = Wishlist::where('session_id', $session_id)->update(['customer_id'=>$customer_id, 'session_id'=>0]);

        if(!empty($wishlist)){
            $result = ['status'=>true, 'code'=>200, 'data'=> $wishlist];
        }else{
            $result = ['status'=>false, 'code'=>404, 'msg'=>'data not found'];
        }

        return $result;
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
        $post = $request->all();

        // $wishlist = new Wishlist;
        $data['shop_id']      = isset($post['shop_id']) ? $post['shop_id'] : '';
        $data['customer_id']  = isset($post['customer_id']) ? $post['customer_id'] : 0;
        $data['session_id']   = isset($post['session_id']) ? $post['session_id'] : '';
        $data['product_id']   = isset($post['product_id']) ? $post['product_id'] : '';
        $wishlist = Wishlist::updateOrCreate($data);
        if($wishlist){
            $data = ['status'=>true, 'code'=>200, 'data'=>$wishlist];
        }else{
            $data = ['status'=>false, 'code'=>404, 'msg'=>'data not found'];
        }
        return $data;
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $post = $request->all();
        
        $shop_id      = isset($post['shop_id']) ? $post['shop_id'] : '';
        $customer_id  = isset($post['customer_id']) ? $post['customer_id'] : 0;
        $product_id   = isset($post['product_id']) ? $post['product_id'] : '';
        $session_id   = isset($post['session_id']) ? $post['session_id'] : '';
        
        $item = Wishlist::where('shop_id', $shop_id)
                            ->where('customer_id', $customer_id)
                            ->where('session_id', $session_id)
                            ->where('product_id', $product_id)
                            ->first();
        
        if($item){
            $res = Wishlist::destroy($item->id);
            $data = ['status'=>true, 'code'=>200, 'data'=>$item];
        }else{
            $data = ['status'=>false, 'code'=>404, 'msg'=>'data not found'];
        }
        return $data;
    }

    /**
     * check the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function check(Request $request)
    {
        $post = $request->all();
        
        $shop_id      = isset($post['shop_id']) ? $post['shop_id'] : '';
        $customer_id  = isset($post['customer_id']) ? $post['customer_id'] : 0;
        $product_id   = isset($post['product_id']) ? $post['product_id'] : '';
        $session_id   = isset($post['session_id']) ? $post['session_id'] : '';
        
        $item = Wishlist::where('shop_id', $shop_id)
                            ->where('customer_id', $customer_id)
                            ->where('session_id', $session_id)
                            ->where('product_id', $product_id)
                            ->first();
        
        if($item){
            $data = ['status'=>true, 'code'=>200, 'data'=>$item];
        }else{
            $data = ['status'=>false, 'code'=>404, 'msg'=>'data not found'];
        }
        return $data;
    }
}
