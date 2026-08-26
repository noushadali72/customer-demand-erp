<x-layouts.app title="Edit Raw Material">

    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-900">
            Edit Raw Material
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Update raw material information.
        </p>
    </div>

    <div class="rounded-xl bg-white p-6 shadow-sm">

        <form method="POST" action="{{ route('raw-materials.update', $rawMaterial) }}">
            @csrf
            @method('PUT')

            @include('raw_materials._form')

            <div class="mt-6 flex justify-end gap-3">

                <a
                    href="{{ route('raw-materials.index') }}"
                    class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-800"
                >
                    Update Raw Material
                </button>

            </div>
        </form>

    </div>

</x-layouts.app>