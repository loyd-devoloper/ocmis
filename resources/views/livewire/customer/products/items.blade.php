<div>

</div>
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
        @foreach (json_decode($getRecord()->items) as $item)

        <tr >
            <td class="py-4 px-6 border-b border-gray-200"
                >{{ $item?->name }}</td>

            <td class="py-4 px-6 border-b border-gray-200 truncate">
                <div class="flex items-center">

                    <span class="text-center w-8"
                     >{{ $item?->quantity }}</span>

                </div>
            </td>
            <td class="py-4 px-6 border-b border-gray-200"
               >₱{{ $item?->price }}</td>

        </tr>
        @endforeach




        <!-- Add more rows here -->
    </tbody>
    <tfoot class="bg-white">

        <tr class="bg-gray-100">
            <td class="py-4 px-6 border-b border-gray-200"></td>

            <td class="py-4 px-6 border-b border-gray-200"><strong>Total</strong>
            </td>
            <td class="py-4 px-6 border-b border-gray-200"><strong
                   >₱{{ $getRecord()->total }}</strong></td>

        </tr>
        </tbody>
</table>
