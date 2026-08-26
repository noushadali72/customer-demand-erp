<x-layouts.app title="Dashboard">

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">
            Dashboard
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Overview of your inventory and operations.
        </p>
    </div>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">

        <div class="rounded-xl bg-white p-6 shadow-sm">
            <p class="text-sm text-gray-500">Products</p>
            <p class="mt-2 text-3xl font-bold">0</p>
        </div>

        <div class="rounded-xl bg-white p-6 shadow-sm">
            <p class="text-sm text-gray-500">Raw Materials</p>
            <p class="mt-2 text-3xl font-bold">0</p>
        </div>

        <div class="rounded-xl bg-white p-6 shadow-sm">
            <p class="text-sm text-gray-500">Pending Quotations</p>
            <p class="mt-2 text-3xl font-bold">0</p>
        </div>

        <div class="rounded-xl bg-white p-6 shadow-sm">
            <p class="text-sm text-gray-500">Purchase Orders</p>
            <p class="mt-2 text-3xl font-bold">0</p>
        </div>

    </div>

    <div class="mt-6 rounded-xl bg-white p-6 shadow-sm">
        <h3 class="text-lg font-semibold">
            Recent Activity
        </h3>

        <div class="mt-4 text-sm text-gray-500">
            No recent activity.
        </div>
    </div>

</x-layouts.app>