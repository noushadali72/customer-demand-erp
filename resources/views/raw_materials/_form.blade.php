<div class="grid grid-cols-1 gap-6 md:grid-cols-2">

    {{-- Name --}}
    <div>
        <label
            for="name"
            class="mb-1 block text-sm font-medium text-gray-700"
        >
            Raw Material Name
        </label>

        <input
            type="text"
            id="name"
            name="name"
            value="{{ old('name', $rawMaterial->name ?? '') }}"
            required
            class="w-full rounded-lg border-gray-300 px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
        >

        @error('name')
            <span class="mt-1 block text-sm text-red-600">
                {{ $message }}
            </span>
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
            value="{{ old('sku', $rawMaterial->sku ?? '') }}"
            class="w-full rounded-lg border-gray-300 px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
        >

        @error('sku')
            <span class="mt-1 block text-sm text-red-600">
                {{ $message }}
            </span>
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
                    @selected(old('unit_id', $rawMaterial->unit_id ?? '') == $unit->id)
                >
                    {{ $unit->name }}
                </option>
            @endforeach
        </select>

        @error('unit_id')
            <span class="mt-1 block text-sm text-red-600">
                {{ $message }}
            </span>
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
            value="{{ old('cost_price', $rawMaterial->cost_price ?? '') }}"
            required
            class="w-full rounded-lg border-gray-300 px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
        >

        @error('cost_price')
            <span class="mt-1 block text-sm text-red-600">
                {{ $message }}
            </span>
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
            value="{{ old('stock', $rawMaterial->stock ?? 0) }}"
            required
            class="w-full rounded-lg border-gray-300 px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
        >

        @error('stock')
            <span class="mt-1 block text-sm text-red-600">
                {{ $message }}
            </span>
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
            value="{{ old('minimum_stock', $rawMaterial->minimum_stock ?? 5) }}"
            required
            class="w-full rounded-lg border-gray-300 px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
        >

        @error('minimum_stock')
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
            rows="4"
            class="w-full rounded-lg border-gray-300 px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
        >{{ old('description', $rawMaterial->description ?? '') }}</textarea>

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
                @checked(old('is_active', $rawMaterial->is_active ?? true))
            >

            <span class="text-sm font-medium text-gray-700">
                Active Raw Material
            </span>

        </label>

        @error('is_active')
            <span class="mt-1 block text-sm text-red-600">
                {{ $message }}
            </span>
        @enderror
    </div>

</div>