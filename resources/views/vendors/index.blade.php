<x-layouts.app title="Vendors">

    <div class="mb-6 flex items-center justify-between">

        <div>

            <h2 class="text-xl font-semibold text-gray-900">
                Vendors
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Manage your raw material suppliers.
            </p>

        </div>


        <a
            href="{{ route('vendors.create') }}"
            class="rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-800"
        >
            + Add Vendor
        </a>

    </div>


    {{-- Success Alert --}}
    @if(session('success'))

        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>

    @endif


    {{-- Error Alert --}}
    @if(session('error'))

        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>

    @endif


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
                            Company
                        </th>

                        <th class="px-6 py-4">
                            Contact
                        </th>

                        <th class="px-6 py-4">
                            Phone
                        </th>

                        <th class="px-6 py-4">
                            Status
                        </th>

                        <th class="px-6 py-4 text-right">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @forelse($vendors as $vendor)

                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-4 text-gray-500">
                                {{ $vendors->firstItem() + $loop->index }}
                            </td>


                            <td class="px-6 py-4">

                                <div class="font-medium text-gray-900">
                                    {{ $vendor->name }}
                                </div>

                                @if($vendor->email)

                                    <div class="mt-1 text-xs text-gray-500">
                                        {{ $vendor->email }}
                                    </div>

                                @endif

                            </td>


                            <td class="px-6 py-4 text-gray-600">
                                {{ $vendor->company_name ?? '-' }}
                            </td>


                            <td class="px-6 py-4 text-gray-600">
                                {{ $vendor->contact_person ?? '-' }}
                            </td>


                            <td class="px-6 py-4 text-gray-600">
                                {{ $vendor->phone ?? '-' }}
                            </td>


                            <td class="px-6 py-4">

                                @if($vendor->is_active)

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
                                        href="{{ route('vendors.show', $vendor) }}"
                                        class="rounded-lg px-3 py-1.5 text-xs border border-gray-300 font-medium text-gray-600 hover:bg-gray-400 cursor-pointer hover:text-white"
                                    >
                                        View
                                    </a>


                                    <a
                                        href="{{ route('vendors.edit', $vendor) }}"
                                        class="rounded-lg border border-blue-300 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-blue-500 hover:text-white"
                                    >
                                        Edit
                                    </a>


                                    <form
                                        method="POST"
                                        action="{{ route('vendors.destroy', $vendor) }}"
                                        class="delete-vendor"
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
                                colspan="7"
                                class="px-6 py-12 text-center text-gray-500"
                            >
                                No vendors found.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if($vendors->hasPages())

            <div class="border-t px-6 py-4">
                {{ $vendors->links() }}
            </div>

        @endif

    </div>


    @push('scripts')

        <script>

            $(document).on(
                'submit',
                '.delete-vendor',
                function (e) {

                    if (!confirm(
                        'Are you sure you want to delete this vendor?'
                    )) {
                        e.preventDefault();
                    }

                }
            );

        </script>

    @endpush

</x-layouts.app>