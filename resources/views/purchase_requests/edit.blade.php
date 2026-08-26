<x-layouts.app title="Edit Purchase Request">

    <div class="mb-6">

        <h2 class="text-xl font-semibold text-gray-900">
            Edit Purchase Request
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Update the purchase request and its raw materials.
        </p>

    </div>


    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

        <form
            method="POST"
            action="{{ route('purchase-requests.update', $purchaseRequest) }}"
        >

            @csrf
            @method('PUT')

            @include('purchase_requests._form')

            <div class="mt-6 flex justify-end">

                <button
                    type="submit"
                    class="rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-gray-800"
                >
                    Update Purchase Request
                </button>

            </div>

        </form>

    </div>

</x-layouts.app>