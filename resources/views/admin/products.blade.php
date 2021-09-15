@extends('shopify-app::layouts.default')

@section('content')
    <div class="row">
        
        <div class="bg-gray-50 p-0">
            <div class="w-100 mx-3 lg:py-4 lg:flex lg:items-center lg:justify-between">
                <div class="flex justify-between">

                    <div class="bg-gray-100 p-3">
                        <h4 class="text-xl leading-6 font-medium text-gray-900">Products wishlisted</h4>
                        <p class="mt-2 text-sm leading-6 text-gray-600">
                            List of all products which wishlisted by over all customers. Customers Column shows that Number of customers has added a product in thier wishlist.
                        </p>
                    </div>

                    <div class="w-56">
                        <!-- <img src="/img/wishlist-header.svg" alt=""> -->
                    </div>

                </div>


            </div>
        </div>


        <div class="p-0 mt-4" >
            <table class="table-auto w-full bg-white ">
                <thead>
                <tr>
                    <th class="px-4 py-2 text-left">Product</th>
                    <th class="px-4 py-2 text-left">Customers</th>
                    <th class="px-4 py-2 text-left">Price</th>
                    <th class="px-4 py-2 text-left">View</th>
                </tr>
                </thead>
                <tbody>

                @if($products)

                    @foreach ($products as $product)
                        <tr>
                            <td class="border px-4 py-2">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-20 w-20">
                                        <img class="h-20 w-20 rounded-sm object-cover" src="{{ $product['store']['featuredImage']['originalSrc'] }}" alt="">
                                    </div>
                                    <div class="ml-4">
                                    <div class="text-sm leading-5 font-medium text-gray-900">{{ $product['store']['title'] }}</div>
                                    <div class="text-sm leading-5 text-gray-500">{{ $product['store']['vendor'] }}</div>
                                    </div>
                                </div>

                            </td>
                            <td class="border px-4 py-2">
                                {{  $product['count'] }}
                            </td>
                            <td class="border px-4 py-2">
                                {{ $product['store']['priceRange']['maxVariantPrice']['currencyCode'] }} {{ number_format(($product['store']['priceRange']['maxVariantPrice']['amount'] / 100), 2, '.', ' ') }}
                            </td>
                            <td class="border px-4 py-2">
                                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm showCustomers" data-product_id="{{ $product['store']['id'] }}" >View</button>
                            </td>
                        </tr>
                    @endforeach

                @else

                    <tr>
                        <td> Data Not Found... </td>
                    </tr>

                @endif

                </tbody>
            </table>
        </div>

    </div>

    @include('admin.partials.customers-modal')
@endsection

@section('scripts')

    @parent

    <script type="text/javascript">
        var AppBridge = window['app-bridge'];
        var actions = AppBridge.actions;
        var TitleBar = actions.TitleBar;
        var Button = actions.Button;
        var Redirect = actions.Redirect;
        var titleBarOptions = {
            title: 'Products',
        };
        var myTitleBar = TitleBar.create(app, titleBarOptions);
    </script>
@endsection
