<div class="grid grid-cols-1 gap-6 md:grid-cols-2">

    {{-- Name --}}
    <div>

        <label
            for="name"
            class="mb-1 block text-sm font-medium text-gray-700"
        >
            Unit Name
        </label>

        <input
            type="text"
            id="name"
            name="name"
            value="{{ old('name', $unit->name ?? '') }}"
            required
            autofocus
            placeholder="e.g. Kilogram"
            class="w-full rounded-lg border-gray-300 px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
        >

        @error('name')
            <span class="mt-1 block text-sm text-red-600">
                {{ $message }}
            </span>
        @enderror

    </div>


    {{-- Short Name --}}
    <div>

        <label
            for="short_name"
            class="mb-1 block text-sm font-medium text-gray-700"
        >
            Short Name
        </label>

        <input
            type="text"
            id="short_name"
            name="short_name"
            value="{{ old('short_name', $unit->short_name ?? '') }}"
            required
            placeholder="e.g. kg"
            class="w-full rounded-lg border-gray-300 px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
        >

        @error('short_name')
            <span class="mt-1 block text-sm text-red-600">
                {{ $message }}
            </span>
        @enderror

    </div>

</div>


<div class="mt-6 flex items-center justify-end gap-3">

    <a
        href="{{ route('units.index') }}"
        class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50"
    >
        Cancel
    </a>

    <button
        type="submit"
        class="rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-800"
    >
        {{ isset($unit) ? 'Update Unit' : 'Create Unit' }}
    </button>

</div>