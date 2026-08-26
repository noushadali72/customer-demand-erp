<x-layouts.app title="Raw Materials">

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-semibold text-gray-900">
                Raw Materials
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Manage your raw materials and inventory.
            </p>
        </div>

        <a
            href="{{ route('raw-materials.create') }}"
            class="rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-800"
        >
            + Add Raw Material
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
                        <th class="px-6 py-4">Raw Material</th>
                        <th class="px-6 py-4">SKU</th>
                        <th class="px-6 py-4">Unit</th>
                        <th class="px-6 py-4">Cost Price</th>
                        <th class="px-6 py-4">Stock</th>
                        <th class="px-6 py-4">Min. Stock</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse ($rawMaterials as $rawMaterial)

                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">
                                    {{ $rawMaterial->name }}
                                </div>

                                @if ($rawMaterial->description)
                                    <div class="mt-1 max-w-xs truncate text-xs text-gray-500">
                                        {{ $rawMaterial->description }}
                                    </div>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ $rawMaterial->sku ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ $rawMaterial->unit->name ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ number_format($rawMaterial->cost_price, 2) }}
                            </td>

                            <td class="px-6 py-4">
                                <span
                                    class="{{ $rawMaterial->stock <= $rawMaterial->minimum_stock
                                        ? 'text-red-600'
                                        : 'text-gray-700' }} font-medium"
                                >
                                    {{ $rawMaterial->stock }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ $rawMaterial->minimum_stock }}
                            </td>

                            <td class="px-6 py-4">
                                @if ($rawMaterial->is_active)
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
                                        href="{{ route('raw-materials.edit', $rawMaterial) }}"
                                        class="rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('raw-materials.destroy', $rawMaterial) }}"
                                        onsubmit="return confirm('Are you sure you want to delete this raw material?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50"
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
                                colspan="8"
                                class="px-6 py-12 text-center text-sm text-gray-500"
                            >
                                No raw materials found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>
            </table>
        </div>

        @if ($rawMaterials->hasPages())
            <div class="border-t px-6 py-4">
                {{ $rawMaterials->links() }}
            </div>
        @endif

    </div>

</x-layouts.app>