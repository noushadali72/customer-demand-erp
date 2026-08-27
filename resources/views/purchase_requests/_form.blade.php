@php

    $oldItems = old('items');
    if ($oldItems) {
        $formItems = $oldItems;
    } elseif (isset($purchaseRequest)) {
        $formItems = $purchaseRequest->items->map(
            function ($item) {
                return [
                    'raw_material_id' => $item->raw_material_id,
                    'qty' => $item->qty,
                    'unit_id' => $item->unit_id,
                ];
            }
        )->toArray();

    } else {
        $formItems = [
            [
                'raw_material_id' => '',
                'qty' => 1,
                'unit_id' => '',
            ]
        ];
    }

@endphp
{{-- Purchase Request Information --}}
<div class="grid grid-cols-1 gap-6 md:grid-cols-2">

    {{-- Request Number --}}
    <div>

        <label
            for="request_number"
            class="mb-1 block text-sm font-medium text-gray-700"
        >
            Request Number
        </label>

        <input
            type="number"
            id="request_number"
            name="request_number"
            value="{{ old('request_number', $purchaseRequest->request_number ?? '') }}"
            required
            class="w-full rounded-lg border-gray-300 px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
        >

        @error('request_number')
            <span class="mt-1 block text-sm text-red-600">
                {{ $message }}
            </span>
        @enderror

    </div>


    {{-- Status --}}
    <div>

        <label
            for="status"
            class="mb-1 block text-sm font-medium text-gray-700"
        >
            Status
        </label>

        <select
            id="status"
            name="status"
            required
            class="w-full rounded-lg border-gray-300 px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
        >

            <option
                value="active"
                @selected(old('status', $purchaseRequest->status ?? 'active') === 'active')
            >
                Active
            </option>

            <option
                value="pending"
                @selected(old('status', $purchaseRequest->status ?? '') === 'pending')
            >
                Pending
            </option>

            <option
                value="complete"
                @selected(old('status', $purchaseRequest->status ?? '') === 'complete')
            >
                Complete
            </option>

        </select>

        @error('status')
            <span class="mt-1 block text-sm text-red-600">
                {{ $message }}
            </span>
        @enderror

    </div>


    {{-- Notes --}}
    <div class="md:col-span-2">

        <label
            for="notes"
            class="mb-1 block text-sm font-medium text-gray-700"
        >
            Notes
        </label>

        <textarea
            id="notes"
            name="notes"
            rows="4"
            class="w-full rounded-lg border-gray-300 px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
        >{{ old('notes', $purchaseRequest->notes ?? '') }}</textarea>

        @error('notes')
            <span class="mt-1 block text-sm text-red-600">
                {{ $message }}
            </span>
        @enderror

    </div>

</div>


{{-- Purchase Request Items --}}
<div class="mt-8 border-t pt-6">

    <div class="mb-4 flex items-center justify-between">

        <div>

            <h3 class="text-base font-semibold text-gray-900">
                Raw Materials
            </h3>

            <p class="mt-1 text-sm text-gray-500">
                Add the raw materials that need to be purchased.
            </p>

        </div>


        <button
            type="button"
            id="add-item"
            class="rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white hover:bg-gray-800"
        >
            + Add Item
        </button>

    </div>


    <div
        id="items-container"
        class="space-y-3"
    >

        @foreach ($formItems as $index => $item)

            <div class="purchase-item rounded-lg border border-gray-200 bg-gray-50 p-4">

                <div class="grid grid-cols-1 gap-4 md:grid-cols-12">

                    {{-- Raw Material --}}
                    <div class="md:col-span-5">

                        <label class="mb-1 block text-sm font-medium text-gray-700">
                            Raw Material
                        </label>

                        <select
                            name="items[{{ $index }}][raw_material_id]"
                            required
                            class="raw-material-select w-full rounded-lg border-gray-300 bg-white px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
                        >

                            <option value="">
                                Select Raw Material
                            </option>

                            @foreach ($rawMaterials as $rawMaterial)

                                <option
                                    value="{{ $rawMaterial->id }}"
                                    @selected(($item['raw_material_id'] ?? '') == $rawMaterial->id)
                                >
                                    {{ $rawMaterial->name }}
                                    @if($rawMaterial->sku)
                                        ({{ $rawMaterial->sku }})
                                    @endif
                                </option>

                            @endforeach

                        </select>

                        @error("items.$index.raw_material_id")
                            <span class="mt-1 block text-sm text-red-600">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    {{-- Quantity --}}
                    <div class="md:col-span-3">

                        <label class="mb-1 block text-sm font-medium text-gray-700">
                            Quantity
                        </label>

                        <input
                            type="number"
                            name="items[{{ $index }}][qty]"
                            value="{{ $item['qty'] ?? 1 }}"
                            min="1"
                            required
                            class="item-qty w-full rounded-lg border-gray-300 bg-white px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
                        >

                        @error("items.$index.qty")
                            <span class="mt-1 block text-sm text-red-600">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    {{-- Unit --}}
                    <div class="md:col-span-3">

                        <label class="mb-1 block text-sm font-medium text-gray-700">
                            Unit
                        </label>

                        <select
                            name="items[{{ $index }}][unit_id]"
                            required
                            class="unit-select w-full rounded-lg border-gray-300 bg-white px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
                        >

                            <option value="">
                                Select Unit
                            </option>

                            @foreach ($units as $unit)

                                <option
                                    value="{{ $unit->id }}"
                                    @selected(($item['unit_id'] ?? '') == $unit->id)
                                >
                                    {{ $unit->name }}
                                    ({{ $unit->short_name }})
                                </option>

                            @endforeach

                        </select>

                        @error("items.$index.unit_id")
                            <span class="mt-1 block text-sm text-red-600">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    {{-- Remove --}}
                    <div class="md:col-span-1 flex items-end">

                        <button
                            type="button"
                            class="remove-item text-sm font-medium text-red-600 hover:text-red-700"
                        >
                            Remove
                        </button>

                    </div>

                </div>

            </div>

        @endforeach

    </div>

</div>



{{-- Item Card --}}
<template id="item-template">
    <div class="purchase-item rounded-lg border border-gray-200 bg-gray-50 p-4">

        <div class="grid grid-cols-1 gap-4 md:grid-cols-12">

            {{-- Raw Material --}}
            <div class="md:col-span-5">

                <label class="mb-1 block text-sm font-medium text-gray-700">
                    Raw Material
                </label>

                <select
                    name="items[INDEX][raw_material_id]"
                    required
                    class="raw-material-select w-full rounded-lg border-gray-300 bg-white px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
                >

                    <option value="">
                        Select Raw Material
                    </option>

                    @foreach ($rawMaterials as $rawMaterial)

                        <option value="{{ $rawMaterial->id }}">
                            {{ $rawMaterial->name }}

                            @if($rawMaterial->sku)
                                ({{ $rawMaterial->sku }})
                            @endif
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Quantity --}}
            <div class="md:col-span-3">

                <label class="mb-1 block text-sm font-medium text-gray-700">
                    Quantity
                </label>

                <input
                    type="number"
                    name="items[INDEX][qty]"
                    value="1"
                    min="1"
                    required
                    class="item-qty w-full rounded-lg border-gray-300 bg-white px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
                >

            </div>


            {{-- Unit --}}
            <div class="md:col-span-3">

                <label class="mb-1 block text-sm font-medium text-gray-700">
                    Unit
                </label>

                <select
                    name="items[INDEX][unit_id]"
                    required
                    class="unit-select w-full rounded-lg border-gray-300 bg-white px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
                >

                    <option value="">
                        Select Unit
                    </option>

                    @foreach ($units as $unit)

                        <option value="{{ $unit->id }}">
                            {{ $unit->name }}
                            ({{ $unit->short_name }})
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Remove --}}
            <div class="md:col-span-1 flex items-end">

                <button
                    type="button"
                    class="remove-item text-sm font-medium text-red-600 hover:text-red-700"
                >
                    Remove
                </button>

            </div>

        </div>

    </div>

</template>


{{-- ========================================================= --}}
{{-- jQuery --}}
{{-- ========================================================= --}}

@push('scripts')

<script>

$(document).ready(function () {

    let index = {{ count($formItems) }};

    const $container = $('#items-container');

    const template = $('#item-template').html();


    /*
    |--------------------------------------------------------------------------
    | Get Raw Material
    |--------------------------------------------------------------------------
    */

    function getRawMaterial(rawMaterialId, $item)
    {
        if (!rawMaterialId) {

            $item.find('.unit-select').val('');

            return;
        }


        $.ajax({

            url: "{{ route('purchase-requests.raw-material', ':id') }}"
                .replace(':id', rawMaterialId),

            type: 'GET',

            success: function (rawMaterial) {

                /*
                |--------------------------------------------------------------------------
                | Populate Unit
                |--------------------------------------------------------------------------
                */

                if (rawMaterial.unit_id) {

                    $item
                        .find('.unit-select')
                        .val(rawMaterial.unit_id);

                }

            },

            error: function (xhr) {

                console.error(xhr);

                alert(
                    'Unable to fetch raw material information.'
                );

            }

        });
    }


    /*
    |--------------------------------------------------------------------------
    | Raw Material Changed
    |--------------------------------------------------------------------------
    |
    | Delegated event means this works for newly added rows too.
    |
    */

    $container.on(
        'change',
        '.raw-material-select',
        function () {

            const rawMaterialId = $(this).val();

            const $item = $(this)
                .closest('.purchase-item');


            getRawMaterial(
                rawMaterialId,
                $item
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Add Item
    |--------------------------------------------------------------------------
    */

    $('#add-item').on('click', function () {

        const html = template.replaceAll(
            'INDEX',
            index
        );


        $container.append(html);


        index++;

    });


    /*
    |--------------------------------------------------------------------------
    | Remove Item
    |--------------------------------------------------------------------------
    */

    $container.on(
        'click',
        '.remove-item',
        function () {

            const itemCount = $container
                .find('.purchase-item')
                .length;


            if (itemCount <= 1) {

                alert(
                    'At least one raw material is required.'
                );

                return;
            }


            $(this)
                .closest('.purchase-item')
                .remove();

        }
    );

});

</script>

@endpush