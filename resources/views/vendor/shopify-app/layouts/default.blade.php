<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ \Osiset\ShopifyApp\getShopifyConfig('app_name') }}</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/app.min.css') }}">
        <script defer src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>
        @yield('styles')
    </head>

    <body>
        <div class="app-wrapper">
            <div class="app-content">
                <main role="main">
                    @include('partials.navbar')
                    @yield('content')
                </main>
            </div>
        </div>

        @if(\Osiset\ShopifyApp\getShopifyConfig('appbridge_enabled'))
            <script src="https://unpkg.com/@shopify/app-bridge{{ config('shopify-app.appbridge_version') ? '@'.config('shopify-app.appbridge_version') : '' }}"></script>
            <script>
                var AppBridge = window['app-bridge'];
                var createApp = AppBridge.default;
                var app = createApp({
                    apiKey: '{{ config('shopify-app.api_key') }}',
                    shopOrigin: '{{ (Auth::user()) ? Auth::user()->name : '' }}',
                    forceRedirect: {{ config('shopify-app.appbridge_enabled') ? config('shopify-app.appbridge_enabled') : true }},
                });
            </script>

            @include('shopify-app::partials.flash_messages')
        @endif

        @yield('scripts')
        <script type="text/javascript" src="{{ asset('js/parkhya-app.min.js') }}" ></script>
    </body>
</html>
