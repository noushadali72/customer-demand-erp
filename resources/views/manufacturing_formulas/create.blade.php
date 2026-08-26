<x-layouts.app title="Create Manufacturing Formula">

    <div class="mb-6">

        <h2 class="text-xl font-semibold text-gray-900">
            Create Manufacturing Formula
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Define the raw materials required to manufacture a product.
        </p>

    </div>

    <div class="rounded-xl bg-white p-6 shadow-sm">

        <form
            method="POST"
            action="{{ route('manufacturing-formulas.store') }}"
        >
            @csrf

            @include('manufacturing_formulas._form')

            <div class="mt-6 flex justify-end gap-3">

                <a
                    href="{{ route('manufacturing-formulas.index') }}"
                    class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-800"
                >
                    Create Formula
                </button>

            </div>

        </form>

    </div>

</x-layouts.app>