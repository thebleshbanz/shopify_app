<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\Mail\WelcomeMail;
use App\Models\Pages;
use App\User;
use App\Setting;

class AfterAuthenticateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $shop;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $shop)
    {
        $this->shop = $shop;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $log_arr = [];
        $shop = $this->shop;

        Log::info( ['shop'=> $shop] );

        if(empty($shop->shop_id)){

            // store shop extra data to user table
            $shop_api = $shop->api()->rest('GET', '/admin/api/2021-07/shop.json');
            
            if(!$shop_api['errors']){
                // split shop API data into variable
                $shop_data = $shop_api['body']['container']['shop'];
                
                $shop->shop_id          =   $shop_data['id'];
                $shop->original_email   =   $shop_data['email'];
                $shop->domain           =   $shop_data['domain'];
                $shop->country          =   $shop_data['country'];
                $shop->money_formate    =   $shop_data['money_format'];
                $shop->primary_location_id =   $shop_data['primary_location_id'];
                $shop->shop_json        =   json_encode($shop_data);
                $shop->save();
                
                $setting = Setting::updateOrCreate(
                    ['shop_id' => $shop_data['id'] ],
                    ['activated' => 1]
                );            
            }
            
            // create a new template name wishlist on main theme
            
            // /admin/api/2021-07/themes.json
            $themes = $shop->api()->rest('GET', '/admin/api/2021-07/themes.json')['body'];
            
            // get Active Theme Id
            $activeThemeId = '';
            foreach ($themes['container']['themes'] as $theme) {
                if($theme['role'] == 'main'){
                    $activeThemeId = $theme['id'];
                }
            }
            
            Log::info( ['activeThemeId'=> $activeThemeId] );
            
            // snippet code which put in wishlist template liquid file.
            $snippet = '
                <div class="page-width">
                    <div class="grid">
                        <div class="grid__item medium-up--five-sixths medium-up--push-one-twelfth">
                        
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
            // PUT /admin/api/2021-07/themes/828155753/assets.json
            $put_asset = $shop->api()->rest('PUT', '/admin/api/2021-07/themes/'.$activeThemeId.'/assets.json', $array );
            
            Log::info( ['put_asset'=> $put_asset] );
            
            // check put assests have no errors
            if(!$put_asset['errors']){
                $array = ['page' =>
                    [
                        "title" => "Wishlist", 
                        "body_html" => "",
                        "template_suffix" => "wishlist",
                    ]
                ];
                $page = $shop->api()->rest('POST', '/admin/api/2021-07/pages.json', $array);
                
                // if create page api response any error then show
                if($page['errors']){
                    Log::info( ['page_error'=> $page] );
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

            /* Send Welcome Mail to store Owner */
            $res = Mail::to($shop->original_email)->send(new WelcomeMail($shop));
            // $res = Mail::to('parkhya.developer@gmail.com')->send(new WelcomeMail($shop));
        }
    }
}
