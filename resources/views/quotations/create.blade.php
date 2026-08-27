<x-layouts.app title="Create Quotation">

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-semibold text-gray-900">
                Create Quotation
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Create a quotation for Purchase Request #{{ $purchaseRequest->request_number }}.
            </p>
        </div>

        <a href="{{ route('quotations.index') }}"
            class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
            <i class="bx bx-arrow-back"></i>
            Back
        </a>
    </div>

    @if($errors->any())
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">
            <div class="flex gap-3">
                <i class="bx bx-error-circle mt-0.5 text-xl text-red-500"></i>

                <div>
                    <h3 class="text-sm font-semibold text-red-800">
                        Please fix the following errors:
                    </h3>

                    <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-red-700">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- Purchase Request --}}
    <div class="mb-6 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

        <div class="flex items-center gap-3 border-b bg-gray-50 px-6 py-4">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-900 text-white">
                <i class="bx bx-file text-xl"></i>
            </div>

            <div>
                <h3 class="font-semibold text-gray-900">
                    Purchase Request #{{ $purchaseRequest->request_number }}
                </h3>

                <p class="text-sm text-gray-500">
                    Requested materials
                </p>
            </div>
        </div>

        <div class="p-6">

            <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">

                <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                        Request Number
                    </p>
                    <p class="mt-1 text-lg font-semibold text-gray-900">
                        PR-{{ $purchaseRequest->request_number }}
                    </p>
                </div>

                <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                        Status
                    </p>
                    <p class="mt-1">
                        <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-medium capitalize text-blue-700">
                            {{ $purchaseRequest->status }}
                        </span>
                    </p>
                </div>

                <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                        Created
                    </p>
                    <p class="mt-1 text-lg font-semibold text-gray-900">
                        {{ $purchaseRequest->created_at->format('d M Y') }}
                    </p>
                </div>

            </div>

            @if($purchaseRequest->notes)
                <div class="mb-6 rounded-lg border border-gray-200 bg-white p-4">
                    <p class="mb-1 text-xs font-medium uppercase tracking-wide text-gray-500">
                        Notes
                    </p>

                    <p class="text-sm leading-6 text-gray-700">
                        {{ $purchaseRequest->notes }}
                    </p>
                </div>
            @endif


        </div>
    </div>

    {{-- Quotation Form --}}
    <form action="{{ route('quotations.store') }}" method="POST">
        @csrf

        <input type="hidden"
            name="purchase_request_id"
            value="{{ $purchaseRequest->id }}">

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

            <div class="border-b bg-gray-50 px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-900 text-white">
                        <i class="bx bx-receipt text-xl"></i>
                    </div>

                    <div>
                        <h3 class="font-semibold text-gray-900">
                            Quotation Information
                        </h3>

                        <p class="text-sm text-gray-500">
                            Enter vendor and quotation details.
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 p-6 md:grid-cols-2">

                {{-- Vendor --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Vendor <span class="text-red-500">*</span>
                    </label>

                    <select name="vendor_id"
                        class="block w-full rounded-lg border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm focus:border-gray-900 focus:ring-gray-900"
                        required>

                        <option value="">Select Vendor</option>

                        @foreach($vendors as $vendor)
                            <option value="{{ $vendor->id }}"
                                {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                {{ $vendor->company_name ?: $vendor->name }}
                            </option>
                        @endforeach

                    </select>

                    @error('vendor_id')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Quotation Number --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Quotation Number
                    </label>

                    <input type="number"
                        name="quotation_number"
                        value="{{ old('quotation_number') }}"
                        placeholder="Enter quotation number"
                        class="block w-full rounded-lg border-gray-300 px-3 py-2.5 text-sm shadow-sm focus:border-gray-900 focus:ring-gray-900">

                    @error('quotation_number')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Quotation Date --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Quotation Date <span class="text-red-500">*</span>
                    </label>

                    <input type="date"
                        name="quotation_date"
                        value="{{ old('quotation_date', now()->format('Y-m-d')) }}"
                        class="block w-full rounded-lg border-gray-300 px-3 py-2.5 text-sm shadow-sm focus:border-gray-900 focus:ring-gray-900"
                        required>

                    @error('quotation_date')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Valid Until --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Valid Until
                    </label>

                    <input type="date"
                        name="valid_until"
                        value="{{ old('valid_until') }}"
                        class="block w-full rounded-lg border-gray-300 px-3 py-2.5 text-sm shadow-sm focus:border-gray-900 focus:ring-gray-900">

                    @error('valid_until')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Status <span class="text-red-500">*</span>
                    </label>

                    <select name="status"
                        class="block w-full rounded-lg border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm focus:border-gray-900 focus:ring-gray-900"
                        required>

                        <option value="pending"
                            {{ old('status', 'pending') === 'pending' ? 'selected' : '' }}>
                            Pending
                        </option>

                        <option value="accepted"
                            {{ old('status') === 'accepted' ? 'selected' : '' }}>
                            Accepted
                        </option>

                    </select>

                    @error('status')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Notes --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Notes
                    </label>

                    <textarea name="notes"
                        rows="3"
                        placeholder="Enter any notes..."
                        class="block w-full resize-none rounded-lg border-gray-300 px-3 py-2.5 text-sm shadow-sm focus:border-gray-900 focus:ring-gray-900">{{ old('notes') }}</textarea>

                    @error('notes')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>

        {{-- Items --}}
        <div class="border-t">

            <div class="border-b bg-gray-50 px-6 py-4">
                <h3 class="font-semibold text-gray-900">
                    Quotation Items
                </h3>

                <p class="mt-1 text-sm text-gray-500">
                    Enter the price offered by the vendor. You can remove materials that are not included in the quotation.
                </p>
            </div>

            <div class="p-6">

                <div class="overflow-hidden rounded-lg border border-gray-200">

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">

                            <thead class="border-b bg-gray-50">
                                <tr class="text-xs uppercase tracking-wide text-gray-500">
                                    <th class="px-4 py-3 font-medium">Raw Material</th>
                                    <th class="px-4 py-3 font-medium">Quantity</th>
                                    <th class="px-4 py-3 font-medium">Unit</th>
                                    <th class="px-4 py-3 font-medium">Unit Price</th>
                                    <th class="px-4 py-3 text-right font-medium">Total</th>
                                    <th class="px-4 py-3 text-right font-medium">Action</th>
                                </tr>
                            </thead>

                            <tbody id="quotation-items"
                                class="divide-y divide-gray-100">

                                @foreach($purchaseRequest->items as $index => $item)

                                    <tr class="quotation-item">

                                        <td class="px-4 py-4">
                                            <p class="font-medium text-gray-900">
                                                {{ $item->rawMaterial->name }}
                                            </p>

                                            <p class="mt-0.5 text-xs text-gray-500">
                                                {{ $item->rawMaterial->sku }}
                                            </p>

                                            <input type="hidden"
                                                name="items[{{ $index }}][raw_material_id]"
                                                value="{{ $item->raw_material_id }}">
                                        </td>

                                        <td class="px-4 py-4">

                                            <input type="number"
                                                step="0.001"
                                                min="0.001"
                                                name="items[{{ $index }}][qty]"
                                                value="{{ old("items.$index.qty", $item->qty) }}"
                                                class="item-qty w-28 rounded-lg border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-gray-900 focus:ring-gray-900"
                                                data-index="{{ $index }}"
                                                required>

                                        </td>

                                        <td class="px-4 py-4 text-gray-600">

                                            {{ $item->unit->short_name ?? $item->unit->name }}

                                            <input type="hidden"
                                                name="items[{{ $index }}][unit_id]"
                                                value="{{ $item->unit_id }}">

                                        </td>

                                        <td class="px-4 py-4">

                                            <input type="number"
                                                step="0.01"
                                                min="0"
                                                name="items[{{ $index }}][price]"
                                                value="{{ old("items.$index.price", '') }}"
                                                placeholder="0.00"
                                                class="item-price w-32 rounded-lg border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-gray-900 focus:ring-gray-900"
                                                data-index="{{ $index }}"
                                                required>

                                        </td>

                                        <td class="px-4 py-4 text-right">

                                            <span id="total-{{ $index }}"
                                                class="font-semibold text-gray-900">
                                                0.00
                                            </span>

                                        </td>

                                        <td class="px-4 py-4 text-right">

                                            <button type="button"
                                                class="remove-item inline-flex items-center gap-1 rounded-lg px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50"
                                                title="Remove item">
                                                <i class="bx bx-trash text-lg"></i>
                                                Remove
                                            </button>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                            <tfoot class="border-t bg-gray-50">

                                <tr>
                                    <td colspan="5"
                                        class="px-4 py-4 text-right font-semibold text-gray-700">
                                        Grand Total
                                    </td>

                                    <td class="px-4 py-4 text-right">
                                        <span id="grand-total"
                                            class="text-lg font-bold text-gray-900">
                                            0.00
                                        </span>
                                    </td>
                                </tr>

                            </tfoot>

                        </table>
                    </div>

                </div>

                <div id="no-items-message"
                    class="mt-4 hidden rounded-lg border border-yellow-200 bg-yellow-50 px-4 py-3 text-sm text-yellow-700">
                    No quotation items selected. Please keep at least one item.
                </div>

            </div>

        </div>

            {{-- Footer --}}
            <div class="flex items-center justify-end gap-3 border-t bg-gray-50 px-6 py-4">

                <a href="{{ route('quotations.index') }}"
                    class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-100">
                    Cancel
                </a>

                <button type="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-gray-800">
                    <i class="bx bx-save"></i>
                    Save Quotation
                </button>

            </div>

        </div>

    </form>

@push('scripts')
    <script>
        $(document).ready(function () {

            function calculateTotals() {

                let grandTotal = 0;

                $('.quotation-item').each(function () {

                    const row = $(this);

                    const price = parseFloat(
                        row.find('.item-price').val()
                    ) || 0;

                    const qty = parseFloat(
                        row.find('.item-qty').val()
                    ) || 0;

                    const total = qty * price;

                    row.find('[id^="total-"]').text(total.toFixed(2));

                    grandTotal += total;
                });

                $('#grand-total').text(grandTotal.toFixed(2));

                if ($('.quotation-item').length === 0) {
                    $('#no-items-message').removeClass('hidden');
                } else {
                    $('#no-items-message').addClass('hidden');
                }
            }

            // Calculate when quantity or price changes
            $(document).on(
                'input',
                '.item-price, .item-qty',
                calculateTotals
            );

            // Remove quotation item
            $(document).on('click', '.remove-item', function () {

                $(this).closest('.quotation-item').remove();

                calculateTotals();
            });

            calculateTotals();
        });
    </script>
@endpush

</x-layouts.app>