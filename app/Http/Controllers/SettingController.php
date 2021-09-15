<?php

namespace App\Http\Controllers;

use App\Setting;
use App\Models\Pages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $put_asset = $shop->api()->rest('PUT', '/admin/api/2021-04/themes/'.$activeThemeId.'/assets.json', $array );

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
        $response = $shop->api()->rest('POST', '/admin/api/2021-04/pages.json', $array);
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
    public function index()
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
