<x-layouts.app title="Purchase Request Details">

    @if(session('success'))

        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>

    @endif


    @if(session('error'))

        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>

    @endif


    <div class="mb-6 flex items-center justify-between">

        <div>

            <h2 class="text-xl font-semibold text-gray-900">
                Purchase Request
                #{{ $purchaseRequest->request_number }}
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Raw material purchase request details.
            </p>

        </div>


        <div class="flex gap-2">

            <a
                href="{{ route('purchase-requests.edit', $purchaseRequest) }}"
                class="rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-800"
            >
                Edit
            </a>

            <a
                href="{{ route('purchase-requests.index') }}"
                class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
                Back
            </a>

        </div>

    </div>


    {{-- Request Information --}}
    <div class="mb-6 rounded-xl border border-gray-200 bg-white shadow-sm">

        <div class="grid grid-cols-1 divide-y divide-gray-100 md:grid-cols-3 md:divide-x md:divide-y-0">

            <div class="p-6">

                <p class="text-sm text-gray-500">
                    Request Number
                </p>

                <p class="mt-1 font-semibold text-gray-900">
                    PR-{{ $purchaseRequest->request_number }}
                </p>

            </div>


            <div class="p-6">

                <p class="text-sm text-gray-500">
                    Status
                </p>

                <div class="mt-2">

                    @if($purchaseRequest->status === 'complete')

                        <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700">
                            Complete
                        </span>

                    @elseif($purchaseRequest->status === 'pending')

                        <span class="rounded-full bg-yellow-100 px-2.5 py-1 text-xs font-medium text-yellow-700">
                            Pending
                        </span>

                    @else

                        <span class="rounded-full bg-blue-100 px-2.5 py-1 text-xs font-medium text-blue-700">
                            Active
                        </span>

                    @endif

                </div>

            </div>


            <div class="p-6">

                <p class="text-sm text-gray-500">
                    Created
                </p>

                <p class="mt-1 font-semibold text-gray-900">
                    {{ $purchaseRequest->created_at->format('d M Y') }}
                </p>

            </div>

        </div>


        @if($purchaseRequest->notes)

            <div class="border-t border-gray-100 p-6">

                <p class="text-sm text-gray-500">
                    Notes
                </p>

                <p class="mt-2 whitespace-pre-line text-sm text-gray-900">
                    {{ $purchaseRequest->notes }}
                </p>

            </div>

        @endif

    </div>


    {{-- Items --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

        <div class="border-b px-6 py-4">

            <h3 class="font-semibold text-gray-900">
                Raw Materials
            </h3>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                <thead class="border-b bg-gray-50 text-xs uppercase text-gray-500">

                    <tr>

                        <th class="px-6 py-4">
                            #
                        </th>

                        <th class="px-6 py-4">
                            Raw Material
                        </th>

                        <th class="px-6 py-4">
                            SKU
                        </th>

                        <th class="px-6 py-4">
                            Quantity
                        </th>

                        <th class="px-6 py-4">
                            Unit
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @foreach($purchaseRequest->items as $item)

                        <tr>

                            <td class="px-6 py-4 text-gray-500">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $item->rawMaterial->name }}
                            </td>

                            <td class="px-6 py-4 text-gray-500">
                                {{ $item->rawMaterial->sku ?? '-' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $item->qty }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $item->unit->name }}
                                ({{ $item->unit->short_name }})
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</x-layouts.app>