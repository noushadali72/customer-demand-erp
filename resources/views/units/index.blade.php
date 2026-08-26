<x-layouts.app title="Units">

    <div class="mb-6 flex items-center justify-between">

        <div>
            <h2 class="text-xl font-semibold text-gray-900">
                Units
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Manage measurement units used by products and raw materials.
            </p>
        </div>

        <a
            href="{{ route('units.create') }}"
            class="rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-800"
        >
            + Add Unit
        </a>

    </div>


    {{-- Alerts --}}
    @if(session('success'))

        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>

    @endif


    @if(session('error'))

        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>

    @endif


    {{-- Table --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                <thead class="border-b bg-gray-50 text-xs uppercase text-gray-500">

                    <tr>

                        <th class="px-6 py-4">
                            #
                        </th>

                        <th class="px-6 py-4">
                            Name
                        </th>

                        <th class="px-6 py-4">
                            Short Name
                        </th>

                        <th class="px-6 py-4">
                            Created
                        </th>

                        <th class="px-6 py-4 text-right">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @forelse($units as $unit)

                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-4 text-gray-500">
                                {{ $units->firstItem() + $loop->index }}
                            </td>

                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $unit->name }}
                            </td>

                            <td class="px-6 py-4">

                                <span class="rounded-md bg-gray-100 px-2 py-1 text-xs font-medium text-gray-700">
                                    {{ $unit->short_name }}
                                </span>

                            </td>

                            <td class="px-6 py-4 text-gray-500">
                                {{ $unit->created_at->format('d M Y') }}
                            </td>

                            <td class="px-6 py-4">

                                <div class="flex items-center justify-end gap-2">

                                    <a
                                        href="{{ route('units.show', $unit) }}"
                                        class="rounded-lg px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-900"
                                    >
                                        View
                                    </a>

                                    <a
                                        href="{{ route('units.edit', $unit) }}"
                                        class="rounded-lg px-3 py-2 text-sm font-medium text-blue-600 hover:bg-blue-50"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('units.destroy', $unit) }}"
                                        class="delete-unit-form"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="rounded-lg px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50"
                                        >
                                            Delete
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="px-6 py-12 text-center text-gray-500"
                            >
                                No units found.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if($units->hasPages())

            <div class="border-t px-6 py-4">
                {{ $units->links() }}
            </div>

        @endif

    </div>


    @push('scripts')

        <script>

            $(document).on('submit', '.delete-unit-form', function (e) {

                if (!confirm('Are you sure you want to delete this unit?')) {
                    e.preventDefault();
                }

            });

        </script>

    @endpush

</x-layouts.app>