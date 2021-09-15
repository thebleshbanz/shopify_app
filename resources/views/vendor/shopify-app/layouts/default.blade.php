<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ \Osiset\ShopifyApp\getShopifyConfig('app_name') }}</title>
        <meta content="" name="description">
        <meta content="" name="keywords">
        <!-- Fonts -->
        <link href="//db.onlinewebfonts.com/c/89d11a443c316da80dcb8f5e1f63c86e?family=Bauhaus+93" rel="stylesheet" type="text/css"/>
        <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Vendor CSS Files -->
        <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
        <!-- Template Main CSS File -->
        <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet">
        <!-- =======================================================-->
        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
        <!--<script defer src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>-->
        @yield('styles')
    </head>    

    <body>
        <div class="app-wrapper">
            <div class="app-content">
	            <!-- ======= topbar section start ======= -->
	                @include('admin.partials.topbar')
	            <!-- ======= topbar section end ======= -->

				<!-- ======= left nav section start ======= -->
				<div class="left-sidenav">
	                @include('admin.partials.sidebar')
				</div>
				<!-- ======= left nav section end ======= -->

				<!-- ======= main page section start ======= -->
				<div class="page-wrapper">
			  		<!-- ======= page content start ======= -->
				  	<div class="page-content">
					    <div class="container-fluid">
                			@yield('content')
					    </div>
				  	</div>
			  		<!-- ======= page content end ======= -->
				<!-- ======= main page section end ======= -->
				</div>
            </div>
        </div>

        <!-- Vendor JS Files -->
		<script src="{{ asset('assets/vendor/jquery/jquery.min.js')}}"></script>
		<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

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
        <script type="text/javascript" src="{{ asset('js/app.js') }}" ></script>
    </body>
</html>
