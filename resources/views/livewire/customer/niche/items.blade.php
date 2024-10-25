<div>

<table class="w-full table-fixed">
    <thead>
        <tr class="bg-gray-100">
            <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">
                Product</th>
            <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">
                Quantity</th>
            <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">
                Price</th>

        </tr>
    </thead>
    <tbody class="bg-white">
        @foreach (json_decode($getRecord()->products) as $item)
            <tr>
                <td class="py-4 px-6 border-b border-gray-200">{{ $item->product_name }}</td>

                <td class="py-4 px-6 border-b border-gray-200 truncate">
                    <div class="flex items-center">

                        <span class="text-center w-8">{{ $item?->quantitys }}</span>

                    </div>
                </td>
                <td class="py-4 px-6 border-b border-gray-200">₱{{ $item?->price }}</td>

            </tr>
        @endforeach




        <!-- Add more rows here -->
    </tbody>

</table>

<table class="w-full table-fixed">
    <thead>
        <tr class="bg-gray-100">
            <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">
                Deceased Name</th>
            <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">
                Message</th>
            <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">
                Price</th>

        </tr>
    </thead>
    <tbody class="bg-white">

          @if (!!json_decode($getRecord()->service))
          <tr>
            <td class="py-4 px-6 border-b border-gray-200">{{ json_decode($getRecord()->service)?->deceased_name  }}</td>

            <td class="py-4 px-6 border-b border-gray-200 truncate">

                    {{ json_decode($getRecord()->service)?->message  }}
                    {{-- <span class="text-center w-8">{{ $item?->quantitys }}</span> --}}


            </td>
            <td class="py-4 px-6 border-b border-gray-200">₱10000</td>

        </tr>
          @endif





        <!-- Add more rows here -->
    </tbody>

</table>

</div>
