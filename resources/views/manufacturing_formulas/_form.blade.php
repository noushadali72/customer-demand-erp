{{-- Formula Information --}}

<div class="grid grid-cols-1 gap-6 md:grid-cols-2">

    {{-- Product --}}
    <div>
        <label
            for="product_id"
            class="mb-1 block text-sm font-medium text-gray-700"
        >
            Product
        </label>

        <select
            id="product_id"
            name="product_id"
            required
            class="w-full rounded-lg border-gray-300 px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
        >
            <option value="">Select Product</option>

            @foreach ($products as $product)

                <option
                    value="{{ $product->id }}"
                    @selected(old('product_id', $manufacturingFormula->product_id ?? '') == $product->id)
                >
                    {{ $product->name }}
                </option>

            @endforeach

        </select>

        @error('product_id')
            <span class="mt-1 block text-sm text-red-600">
                {{ $message }}
            </span>
        @enderror
    </div>

    {{-- Name --}}
    <div>
        <label
            for="name"
            class="mb-1 block text-sm font-medium text-gray-700"
        >
            Formula Name
        </label>

        <input
            type="text"
            id="name"
            name="name"
            value="{{ old('name', $manufacturingFormula->name ?? '') }}"
            required
            class="w-full rounded-lg border-gray-300 px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
        >

        @error('name')
            <span class="mt-1 block text-sm text-red-600">
                {{ $message }}
            </span>
        @enderror
    </div>

    {{-- Description --}}
    <div class="md:col-span-2">

        <label
            for="description"
            class="mb-1 block text-sm font-medium text-gray-700"
        >
            Description
        </label>

        <textarea
            id="description"
            name="description"
            rows="3"
            class="w-full rounded-lg border-gray-300 px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
        >{{ old('description', $manufacturingFormula->description ?? '') }}</textarea>

        @error('description')
            <span class="mt-1 block text-sm text-red-600">
                {{ $message }}
            </span>
        @enderror

    </div>

    {{-- Active --}}
    <div class="md:col-span-2">

        <label class="inline-flex cursor-pointer items-center gap-3">

            <input
                type="checkbox"
                name="is_active"
                value="1"
                class="rounded border-gray-300 text-gray-900 focus:ring-gray-500"
                @checked(old('is_active', $manufacturingFormula->is_active ?? true))
            >

            <span class="text-sm font-medium text-gray-700">
                Active Formula
            </span>

        </label>

    </div>

</div>


{{-- Raw Materials --}}

<div class="mt-8 border-t pt-6">

    <div class="mb-4 flex items-center justify-between">

        <div>
            <h3 class="text-base font-semibold text-gray-900">
                Raw Materials
            </h3>

            <p class="mt-1 text-sm text-gray-500">
                Add the raw materials and quantities required for this formula.
            </p>
        </div>

        <button
            type="button"
            id="add-item"
            class="rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white hover:bg-gray-800"
        >
            + Add Material
        </button>

    </div>


    @php
        $oldItems = old('items');

        if ($oldItems) {
            $formItems = $oldItems;
        } elseif (isset($manufacturingFormula)) {
            $formItems = $manufacturingFormula->items->map(function ($item) {
                return [
                    'raw_material_id' => $item->raw_material_id,
                    'quantity' => $item->quantity,
                    'unit_id' => $item->unit_id,
                ];
            })->toArray();
        } else {
            $formItems = [
                [
                    'raw_material_id' => '',
                    'quantity' => 1,
                    'unit_id' => '',
                ]
            ];
        }
    @endphp


    <div
        id="items-container"
        class="space-y-3"
    >

        @foreach ($formItems as $index => $item)

            <div class="formula-item rounded-lg border border-gray-200 bg-gray-50 p-4">

                <div class="grid grid-cols-1 gap-4 md:grid-cols-12">

                    {{-- Raw Material --}}
                    <div class="md:col-span-5">

                        <label class="mb-1 block text-sm font-medium text-gray-700">
                            Raw Material
                        </label>

                        <select
                            name="items[{{ $index }}][raw_material_id]"
                            required
                            class="raw-material w-full rounded-lg border-gray-300 bg-white px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
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
                            name="items[{{ $index }}][quantity]"
                            value="{{ $item['quantity'] ?? 1 }}"
                            min="1"
                            required
                            class="w-full rounded-lg border-gray-300 bg-white px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
                        >

                        @error("items.$index.quantity")
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
                            class="w-full rounded-lg border-gray-300 bg-white px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
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
                    <div class="flex items-end justify-end md:col-span-1">

                        <button
                            type="button"
                            class="remove-item rounded-lg border border-red-200 px-3 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50"
                        >
                            Remove
                        </button>

                    </div>

                </div>

            </div>

        @endforeach

    </div>

</div>


{{-- Dynamic item template --}}

<template id="item-template">

    <div class="formula-item rounded-lg border border-gray-200 bg-gray-50 p-4">

        <div class="grid grid-cols-1 gap-4 md:grid-cols-12">

            <div class="md:col-span-5">

                <label class="mb-1 block text-sm font-medium text-gray-700">
                    Raw Material
                </label>

                <select
                    name="items[INDEX][raw_material_id]"
                    required
                    class="w-full rounded-lg border-gray-300 bg-white px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
                >
                    <option value="">
                        Select Raw Material
                    </option>

                    @foreach ($rawMaterials as $rawMaterial)

                        <option value="{{ $rawMaterial->id }}">
                            {{ $rawMaterial->name }}
                        </option>

                    @endforeach

                </select>

            </div>

            <div class="md:col-span-3">

                <label class="mb-1 block text-sm font-medium text-gray-700">
                    Quantity
                </label>

                <input
                    type="number"
                    name="items[INDEX][quantity]"
                    value="1"
                    min="1"
                    required
                    class="w-full rounded-lg border-gray-300 bg-white px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
                >

            </div>

            <div class="md:col-span-3">

                <label class="mb-1 block text-sm font-medium text-gray-700">
                    Unit
                </label>

                <select
                    name="items[INDEX][unit_id]"
                    required
                    class="w-full rounded-lg border-gray-300 bg-white px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
                >
                    <option value="">
                        Select Unit
                    </option>

                    @foreach ($units as $unit)

                        <option value="{{ $unit->id }}">
                            {{ $unit->name }}
                        </option>

                    @endforeach

                </select>

            </div>

            <div class="flex items-end justify-end md:col-span-1">

                <button
                    type="button"
                    class="remove-item rounded-lg border border-red-200 px-3 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50"
                >
                    Remove
                </button>

            </div>

        </div>

    </div>

</template>


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const container = document.getElementById('items-container');
        const template = document.getElementById('item-template');
        const addButton = document.getElementById('add-item');

        let index = {{ count($formItems) }};

        addButton.addEventListener('click', function () {

            const html = template.innerHTML.replaceAll(
                'INDEX',
                index
            );

            container.insertAdjacentHTML('beforeend', html);

            index++;
        });


        container.addEventListener('click', function (event) {

            if (!event.target.classList.contains('remove-item')) {
                return;
            }

            const items = container.querySelectorAll('.formula-item');

            if (items.length <= 1) {
                alert('At least one raw material is required.');
                return;
            }

            event.target.closest('.formula-item').remove();
        });

    });
</script>
@endpush