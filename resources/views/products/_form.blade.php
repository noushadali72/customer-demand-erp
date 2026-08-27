<div class="grid grid-cols-1 gap-6 md:grid-cols-2">

    {{-- Name --}}
    <div>
        <label
            for="name"
            class="mb-1 block text-sm font-medium text-gray-700"
        >
            Product Name
        </label>

        <input
            type="text"
            id="name"
            name="name"
            value="{{ old('name', $product->name ?? '') }}"
            class="w-full rounded-lg border-gray-300 px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
            required
        >

        @error('name')
            <span class="mt-1 block text-sm text-red-600">{{ $message }}</span>
        @enderror
    </div>

    {{-- SKU --}}
    <div>
        <label
            for="sku"
            class="mb-1 block text-sm font-medium text-gray-700"
        >
            SKU
        </label>

        <input
            type="text"
            id="sku"
            name="sku"
            value="{{ old('sku', $product->sku ?? '') }}"
            class="w-full rounded-lg border-gray-300 px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
        >

        @error('sku')
            <span class="mt-1 block text-sm text-red-600">{{ $message }}</span>
        @enderror
    </div>

    {{-- Unit --}}
    <div>
        <label
            for="unit_id"
            class="mb-1 block text-sm font-medium text-gray-700"
        >
            Unit
        </label>

        <select
            id="unit_id"
            name="unit_id"
            required
            class="w-full rounded-lg border-gray-300 px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
        >
            <option value="">Select Unit</option>

            @foreach ($units as $unit)
                <option
                    value="{{ $unit->id }}"
                    @selected(old('unit_id', $product->unit_id ?? '') == $unit->id)
                >
                    {{ $unit->name }}
                </option>
            @endforeach
        </select>

        @error('unit_id')
            <span class="mt-1 block text-sm text-red-600">{{ $message }}</span>
        @enderror
    </div>

    {{-- Cost Price --}}
    <div>
        <label
            for="cost_price"
            class="mb-1 block text-sm font-medium text-gray-700"
        >
            Cost Price
        </label>

        <input
            type="number"
            step="0.01"
            min="0"
            id="cost_price"
            name="cost_price"
            value="{{ old('cost_price', $product->cost_price ?? '') }}"
            class="w-full rounded-lg border-gray-300 px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
        >

        @error('cost_price')
            <span class="mt-1 block text-sm text-red-600">{{ $message }}</span>
        @enderror
    </div>

    {{-- Sale Price --}}
    <div>
        <label
            for="sale_price"
            class="mb-1 block text-sm font-medium text-gray-700"
        >
            Sale Price
        </label>

        <input
            type="number"
            step="0.01"
            min="0"
            id="sale_price"
            name="sale_price"
            value="{{ old('sale_price', $product->sale_price ?? '') }}"
            class="w-full rounded-lg border-gray-300 px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
        >

        @error('sale_price')
            <span class="mt-1 block text-sm text-red-600">{{ $message }}</span>
        @enderror
    </div>

    {{-- Stock --}}
    <div>
        <label
            for="stock"
            class="mb-1 block text-sm font-medium text-gray-700"
        >
            Stock
        </label>

        <input
            type="number"
            min="0"
            id="stock"
            name="stock"
            value="{{ old('stock', $product->stock ?? 0) }}"
            class="w-full rounded-lg border-gray-300 px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
            required
        >

        @error('stock')
            <span class="mt-1 block text-sm text-red-600">{{ $message }}</span>
        @enderror
    </div>

    {{-- Minimum Stock --}}
    <div>
        <label
            for="minimum_stock"
            class="mb-1 block text-sm font-medium text-gray-700"
        >
            Minimum Stock
        </label>

        <input
            type="number"
            min="0"
            id="minimum_stock"
            name="minimum_stock"
            value="{{ old('minimum_stock', $product->minimum_stock ?? 5) }}"
            class="w-full rounded-lg border-gray-300 px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
            required
        >

        @error('minimum_stock')
            <span class="mt-1 block text-sm text-red-600">{{ $message }}</span>
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
            rows="4"
            class="w-full rounded-lg border-gray-300 px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
        >{{ old('description', $product->description ?? '') }}</textarea>

        @error('description')
            <span class="mt-1 block text-sm text-red-600">{{ $message }}</span>
        @enderror
    </div>

  

</div>