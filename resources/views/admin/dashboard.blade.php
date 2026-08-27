
<x-layouts.app title="Dashboard">

    {{-- Header --}}
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">
            Dashboard
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Overview of your inventory and operations.
        </p>
    </div>


    {{-- Statistics --}}
    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">

        {{-- Products --}}
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm text-gray-500">
                        Products
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-900">
                        {{ $productsCount ?? 0 }}
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-blue-100 text-blue-600">
                    <i class='bx bx-package text-2xl'></i>
                </div>

            </div>
        </div>


        {{-- Raw Materials --}}
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm text-gray-500">
                        Raw Materials
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-900">
                        {{ $rawMaterialCount ?? 0 }}
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-yellow-100 text-yellow-600">
                    <i class='bx bx-cube text-2xl'></i>
                </div>

            </div>
        </div>


        {{-- Purchase Requests --}}
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm text-gray-500">
                        Purchase Requests
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-900">
                        {{ $purchaseRequestsCount ?? 0 }}
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-purple-100 text-purple-600">
                    <i class='bx bx-file text-2xl'></i>
                </div>

            </div>
        </div>


        {{-- Quotations --}}
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm text-gray-500">
                        Active/Pending Quotations
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-900">
                        {{ $quotationsCount ?? 0 }}
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-green-100 text-green-600">
                    <i class='bx bx-receipt text-2xl'></i>
                </div>

            </div>
        </div>


        {{-- Purchase Orders --}}
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm text-gray-500">
                        Purchase Orders
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-900">
                        {{ $purchaseOrdersCount ?? 0 }}
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-red-100 text-red-600">
                    <i class='bx bx-cart text-2xl'></i>
                </div>

            </div>
        </div>

    </div>


    {{-- Recent Activity --}}
    <div class="mt-6 rounded-xl border border-gray-200 bg-white shadow-sm">

        <div class="border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-semibold text-gray-900">
                Recent Activity
            </h3>

            <p class="mt-1 text-sm text-gray-500">
                Latest activity across your inventory and purchasing.
            </p>
        </div>

        <div class="px-6 py-10 text-center">

            <i class='bx bx-history text-4xl text-gray-300'></i>

            <p class="mt-2 text-sm font-medium text-gray-700">
                No recent activity
            </p>

            <p class="mt-1 text-sm text-gray-500">
                Recent system activity will appear here.
            </p>

        </div>

    </div>

</x-layouts.app>