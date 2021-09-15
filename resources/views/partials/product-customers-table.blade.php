<table class="table-auto w-full bg-white ">
    <thead>
      <tr>
        <th class="px-4 py-2 text-left">Customer</th>
        <th class="px-4 py-2 text-left">Email</th>
        <th class="px-4 py-2 text-left">Mobile</th>
      </tr>
    </thead>
    <tbody>
    @if($customers)
        @foreach ($customers as $customer)
            <tr>
                <td class="border px-4 py-2">
                    {{$customer['store']['first_name']}} {{$customer['store']['last_name']}}
                </td>
                <td class="border px-4 py-2">
                    {{$customer['store']['email']}}
                </td>
                <td class="border px-4 py-2">
                    {{$customer['store']['phone']}}
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td> Data Not Found. </td>
        </tr>
    @endif

    </tbody>
</table>