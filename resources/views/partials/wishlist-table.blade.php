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
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                            @click="axios.get('https://parkhyamapps.co.in/shopify_app/product/customers?product_id={{ $product['store']['id'] }}')
                            .then(function(response) {
                                $refs.wishlistCustomersTable.innerHTML =  response.data;
                                console.log(response)
                                open = true
                            })
                            .catch(function(error){
                                console.log('ERROR:', error)
                            });"
                    >
                        View
                    </button>
                </td>
            </tr>
        @endforeach

    </tbody>
</table>

