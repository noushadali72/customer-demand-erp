<x-layouts.app title="Quotations">

    <div class="mb-6 flex items-center justify-between">

        <div>
            <h2 class="text-xl font-semibold text-gray-900">
                Quotations
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Manage vendor quotations.
            </p>
        </div>

    </div>

    @if(session('success'))
        <div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                <thead class="border-b bg-gray-50 text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-6 py-4">SNo.</th>
                        <th class="px-6 py-4">Purchase Request</th>
                        <th class="px-6 py-4">Vendor</th>
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4">Items</th>
                        <th class="px-6 py-4">Total</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse($quotations as $index=>$quotation)

                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{$index+1 }}
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                PR-{{ $quotation->purchaseRequest->request_number }}
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ $quotation->vendor->company_name ?: $quotation->vendor->name }}
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ $quotation->quotation_date->format('d M Y') }}
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ $quotation->items->count() }}
                            </td>

                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ number_format($quotation->items->sum('total'), 2) }}
                            </td>

                            <td class="px-6 py-4">

                                @if($quotation->status === 'accepted')

                                    <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                        Accepted
                                    </span>

                                @else

                                    <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-700">
                                        Pending
                                    </span>

                                @endif

                            </td>

                            <td class="px-6 py-4">

                                <div class="flex justify-end gap-2">

                                    
                                    <a href="{{ route('quotations.show', $quotation) }}"
                                        class="rounded-lg p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-900"
                                        title="View">
                                        <i class="bx bx-show text-lg"></i>
                                    </a>

                                    <a href="{{ route('quotations.edit', $quotation) }}"
                                        class="rounded-lg p-2 text-blue-500 hover:bg-blue-50 hover:text-blue-700"
                                        title="Edit">
                                        <i class="bx bx-edit text-lg"></i>
                                    </a>

                                    <form action="{{ route('quotations.destroy', $quotation) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this quotation?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="rounded-lg p-2 text-red-500 hover:bg-red-50 hover:text-red-700"
                                            title="Delete">
                                            <i class="bx bx-trash text-lg"></i>
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8"
                                class="px-6 py-12 text-center text-gray-500">
                                No quotations found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if($quotations->hasPages())
            <div class="border-t px-6 py-4">
                {{ $quotations->links() }}
            </div>
        @endif

    </div>

</x-layouts.app>