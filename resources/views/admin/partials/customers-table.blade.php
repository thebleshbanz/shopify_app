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
                    {{ $customer['store']['addresses'][0]['country'] }}
                </td>
                <td class="border px-4 py-2">
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                            @click="axios.get('https://parkhyamapps.co.in/shopify_app/customer/products?customer_id={{ $customer['store']['id'] }}')
                            .then(function(response) {
                                $refs.customerProductsTable.innerHTML =  response.data;
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