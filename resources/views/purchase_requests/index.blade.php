<x-layouts.app title="Purchase Requests">

    <div class="mb-6 flex items-center justify-between">

        <div>

            <h2 class="text-xl font-semibold text-gray-900">
                Purchase Requests
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Manage raw material purchase requests.
            </p>

        </div>


        <a
            href="{{ route('purchase-requests.create') }}"
            class="rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-800"
        >
            + Create Request
        </a>

    </div>


    {{-- Success --}}
    @if(session('success'))

        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>

    @endif


    {{-- Error --}}
    @if(session('error'))

        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>

    @endif


    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                <thead class="border-b bg-gray-50 text-xs uppercase text-gray-500">

                    <tr>

                        <th class="px-6 py-4">
                            #
                        </th>

                        <th class="px-6 py-4">
                            Request Number
                        </th>

                        <th class="px-6 py-4">
                            Items
                        </th>

                        <th class="px-6 py-4">
                            Status
                        </th>

                        <th class="px-6 py-4">
                            Created
                        </th>

                        <th class="px-6 py-4 text-right">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @forelse($purchaseRequests as $purchaseRequest)

                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-4 text-gray-500">
                                {{ $purchaseRequests->firstItem() + $loop->index }}
                            </td>


                            <td class="px-6 py-4 font-medium text-gray-900">
                                PR-{{ $purchaseRequest->request_number }}
                            </td>


                            <td class="px-6 py-4 text-gray-600">
                                {{ $purchaseRequest->items->count() }}
                            </td>


                            <td class="px-6 py-4">

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

                            </td>


                            <td class="px-6 py-4 text-gray-500">
                                {{ $purchaseRequest->created_at->format('d M Y') }}
                            </td>


                            <td class="px-6 py-4">

                                <div class="flex items-center justify-end gap-2">

                                    <a
                                        href="{{ route('purchase-requests.show', $purchaseRequest) }}"
                                        class="rounded-lg px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100"
                                    >
                                        View
                                    </a>


                                    <a
                                        href="{{ route('purchase-requests.edit', $purchaseRequest) }}"
                                        class="rounded-lg px-3 py-2 text-sm font-medium text-blue-600 hover:bg-blue-50"
                                    >
                                        Edit
                                    </a>


                                    <form
                                        method="POST"
                                        action="{{ route('purchase-requests.destroy', $purchaseRequest) }}"
                                        class="delete-purchase-request"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="rounded-lg px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50"
                                        >
                                            Delete
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="px-6 py-12 text-center text-gray-500"
                            >
                                No purchase requests found.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if($purchaseRequests->hasPages())

            <div class="border-t px-6 py-4">
                {{ $purchaseRequests->links() }}
            </div>

        @endif

    </div>


    @push('scripts')

    <script>

        $(document).on(
            'submit',
            '.delete-purchase-request',
            function (e) {

                if (!confirm(
                    'Are you sure you want to delete this purchase request?'
                )) {

                    e.preventDefault();

                }

            }
        );

    </script>

    @endpush

</x-layouts.app>