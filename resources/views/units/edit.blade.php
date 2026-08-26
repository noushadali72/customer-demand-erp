<x-layouts.app title="Edit Unit">

    <div class="mb-6">

        <h2 class="text-xl font-semibold text-gray-900">
            Edit Unit
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Update the unit information.
        </p>

    </div>


    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

        <form
            method="POST"
            action="{{ route('units.update', $unit) }}"
        >

            @csrf
            @method('PUT')

            @include('units._form')

        </form>

    </div>

</x-layouts.app>