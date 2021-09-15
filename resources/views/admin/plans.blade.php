@extends('shopify-app::layouts.default')

@section('content')

   <div class="bg-gray-50 p-3 mb-4">
       <div class="bg-gray-100 p-3">
            <h4 class="text-xl text-center leading-6 font-medium text-gray-900">Plans</h4>
            <p class="mt-2 text-sm text-center leading-6 text-gray-600">
                Here are Plans of app which describe a list of features with thier price. And you can enable/switch a plan with any suitable plans.
            </p>
        </div>
    </div>
    
    <div class="container">
        <div class="mb-3 text-center row">
            <div class="card plan col-md-6 offset-md-3 mb-4 box-shadow p-0">
                <div class="card-header">
                    <h3 class="my-0 text-white">Free</h3>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">$0 <small class="text-muted">/ mo</small></h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>Unlimited Product Wishlist</li>
                        <li>Wishlist Dashboard</li>
                        <li>Setting Custamization</li>
                        <li>Email support</li>
                        <li>Email Reminder</li>
                        <li>Help center access</li>
                    </ul>
                    <!-- <button type="button" class="btn btn-lg btn-block btn-outline-primary">Sign up for free</button> -->
                </div>
            </div>
            <!-- <div class="card col-md-4 mb-4 box-shadow">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Pro</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">$15 <small class="text-muted">/ mo</small></h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>20 users included</li>
                        <li>10 GB of storage</li>
                        <li>Priority email support</li>
                        <li>Help center access</li>
                    </ul>
                    <button type="button" class="btn btn-lg btn-block btn-primary">Get started</button>
                </div>
            </div> -->
            
        </div>

        
    </div>

@endsection


@section('scripts')
    @parent

    <script type="text/javascript">
        var AppBridge   = window['app-bridge'];
        var actions     = AppBridge.actions;
        var TitleBar    = actions.TitleBar;
        var Button      = actions.Button;
        var Redirect    = actions.Redirect;
        var titleBarOptions = {
            title: 'Plans',
        };
        var myTitleBar = TitleBar.create(app, titleBarOptions);
    </script>
@endsection