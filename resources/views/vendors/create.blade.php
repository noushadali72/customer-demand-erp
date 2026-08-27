<x-layouts.app title="Create Vendor">

    <div class="mb-6">

        <h2 class="text-xl font-semibold text-gray-900">
            Create Vendor
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Add a new raw material supplier/vendor.
        </p>

    </div>


    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

        <form
            method="POST"
            action="{{ route('vendors.store') }}"
        >

            @csrf

            @include('vendors._form')

            <div class="mt-6 flex justify-end gap-3">

                <a
                    href="{{ route('vendors.index') }}"
                    class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-gray-800"
                >
                    Create Vendor
                </button>

            </div>

        </form>

    </div>

</x-layouts.app>