<?php
namespace App\Jobs;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Osiset\ShopifyApp\Actions\CancelCurrentPlan;
use Osiset\ShopifyApp\Contracts\Commands\Shop as IShopCommand;
use Osiset\ShopifyApp\Contracts\Queries\Shop as IShopQuery;
use Osiset\ShopifyApp\Objects\Values\ShopDomain;
use stdClass;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\UninstalledMail;

/**
 * Webhook job responsible for handling when the app is uninstalled.
 */
class AppUninstalledJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * The shop domain.
     *
     * @var ShopDomain|string
     */
    protected $domain;

    /**
     * The webhook data.
     *
     * @var object
     */
    protected $data;

    /**
     * Create a new job instance.
     *
     * @param string   $domain The shop domain.
     * @param stdClass $data   The webhook data (JSON decoded).
     *
     * @return void
     */
    public function __construct(string $domain, stdClass $data)
    {
        $this->domain = $domain;
        $this->data = $data;

        Log::info('Domain: '.$domain);
    }

    /**
     * Execute the job.
     *
     * @param IShopCommand      $shopCommand             The commands for shops.
     * @param IShopQuery        $shopQuery               The querier for shops.
     * @param CancelCurrentPlan $cancelCurrentPlanAction The action for cancelling the current plan.
     *
     * @return bool
     */
    public function handle(
        IShopCommand $shopCommand,
        IShopQuery $shopQuery,
        CancelCurrentPlan $cancelCurrentPlanAction
    ): bool {
        // Convert the domain
        $this->domain = ShopDomain::fromNative($this->domain);

        // Get the shop
        $shop = $shopQuery->getByDomain($this->domain);
        $shopId = $shop->getId();

        // Log::info( ['data'=>$this->data] );
        // Log::info( ['shop_email'=>$this->data->email] );
        // Log::info( ['shop_id'=>$this->data->id] );
        // Log::info( ['shop'=> $shop] );
        // Log::info( ['user_id'=> $shop->id] );

        $shop_id    = $this->data->id;
        $shop_email = $this->data->email;

        /* $shop_auth = Auth::user();
        $shop_auth->shop_id = '';
        $shop_auth->save(); */

        // Cancel the current plan
        $cancelCurrentPlanAction($shopId);

        // Purge shop of token, plan, etc.
        $shopCommand->clean($shopId);

        // Soft delete the shop.
        $shopCommand->softDelete($shopId);

        DB::table('users')->where('shop_id', $shop_id)->delete();
        DB::table('shop_pages')->where('shop_id', $shop_id)->delete();
        DB::table('wishlists')->where('shop_id', $shop_id)->delete();
        DB::table('settings')->where('shop_id', $shop_id)->delete();

        $res = Mail::to($shop_email)->send(new UninstalledMail($this->data));
        // $res = Mail::to('parkhya.developer@gmail.com')->send(new UninstalledMail($this->data));

        return true;
    }
}