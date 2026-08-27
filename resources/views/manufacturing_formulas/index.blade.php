<x-layouts.app title="Manufacturing Formulas">

    <div class="mb-6 flex items-center justify-between">

        <div>
            <h2 class="text-xl font-semibold text-gray-900">
                Manufacturing Formulas
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Manage product manufacturing formulas and raw materials.
            </p>
        </div>

        <a
            href="{{ route('manufacturing-formulas.create') }}"
            class="rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-800"
        >
            + Add Formula
        </a>

    </div>

    @if (session('success'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-xl bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                <thead class="border-b bg-gray-50 text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-6 py-4">Formula</th>
                        <th class="px-6 py-4">Product</th>
                        <th class="px-6 py-4">Raw Materials</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse ($formulas as $formula)

                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-4">

                                <div class="font-medium text-gray-900">
                                    {{ $formula->name }}
                                </div>

                                @if ($formula->description)
                                    <div class="mt-1 max-w-xs truncate text-xs text-gray-500">
                                        {{ $formula->description }}
                                    </div>
                                @endif

                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ $formula->product->name ?? '-' }}
                            </td>

                            <td class="px-6 py-4">

                                <div class="space-y-1">

                                    @foreach ($formula->items as $item)

                                        <div class="text-gray-700">
                                            {{ $item->rawMaterial->name ?? '-' }}

                                            <span class="text-gray-400">
                                                × {{ $item->quantity }}
                                                {{ $item->unit->name ?? '' }}
                                            </span>
                                        </div>

                                    @endforeach

                                </div>

                            </td>

                            <td class="px-6 py-4">

                                @if ($formula->is_active)

                                    <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700">
                                        Active
                                    </span>

                                @else

                                    <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600">
                                        Inactive
                                    </span>

                                @endif

                            </td>

                            <td class="px-6 py-4">

                                <div class="flex items-center justify-end gap-2">

                                    <a
                                        href="{{ route('manufacturing-formulas.edit', $formula) }}"
                                        class="rounded-lg border border-blue-300 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-blue-500 hover:text-white"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('manufacturing-formulas.destroy', $formula) }}"
                                        onsubmit="return confirm('Are you sure you want to delete this formula?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-500 hover:text-white cursor-pointer"
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
                                class="px-6 py-12 text-center text-sm text-gray-500"
                            >
                                No manufacturing formulas found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if ($formulas->hasPages())
            <div class="border-t px-6 py-4">
                {{ $formulas->links() }}
            </div>
        @endif

    </div>

</x-layouts.app>