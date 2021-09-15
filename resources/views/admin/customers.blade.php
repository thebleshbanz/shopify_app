@extends('shopify-app::layouts.default')

@section('content')
    <div class="container mx-auto customer">

        <div class="bg-gray-50">
            <div class="max-w-screen-xl mx-auto p-3 lg:flex lg:items-center lg:justify-between bg-gray-50">
                <div class="flex justify-between">
                    <div class="bg-gray-100 p-3">
                        <h4 class="text-xl leading-6 font-medium text-gray-900">Wishlisted Customers</h4>
                        <p class="mt-2 text-sm leading-6 text-gray-600">
                            List of all customers who wishlist at least one product, Here product column shows that A customer has wishlisted number of products.
                        </p>
                    </div>

                    <div class="w-56">
                        <img src="/img/wishlist-header.svg" alt="">
                    </div>

                </div>
            </div>
        </div>



        <div class="mt-4" >
            <table class="table-auto w-full bg-white ">
                <thead>
                <tr>
                    <th class="px-4 py-2 text-left">Customer</th>
                    <th class="px-4 py-2 text-left">Wishlisted</th>
                    <th class="px-4 py-2 text-left">Country</th>
                    <th class="px-4 py-2 text-left">View</th>
                </tr>
                </thead>
                <tbody>
                @if($customers)
                    @foreach ($customers as $customer)
                        <tr>
                            <td class="border px-4 py-2">
                                <div class="flex items-center">
                                    <div class="ml-4">
                                    <div class="text-sm leading-5 font-medium text-gray-900">{{$customer['store']['first_name']}} {{$customer['store']['last_name']}}</div>
                                    <div class="text-sm leading-5 font-medium text-gray-900">{{$customer['store']['email']}}</div>
                                    <div class="text-sm leading-5 text-gray-500">{{$customer['store']['phone']}}</div>
                                    </div>
                                </div>

                            </td>
                            <td class="border px-4 py-2">
                                {{ $customer['count'] }}
                            </td>
                            <td class="border px-4 py-2">
                                {{ ($customer['store']['addresses']) ? $customer['store']['addresses'][0]['country'] : '' }}
                            </td>
                            <td class="border px-4 py-2">
                                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm showProducts" data-customer_id="{{ $customer['store']['id'] }}">
                                    View
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>No Data Found...</td>
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
            title: 'Customers',
        };
        var myTitleBar = TitleBar.create(app, titleBarOptions);
    </script>
@endsection
