<x-layouts.app title="Purchase Order">

    <div class="mb-6 flex items-center justify-between">

        <div>

            <a href="{{ route('purchase-orders.index') }}"
                class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-900">

                <i class="bx bx-arrow-back"></i>

                Back to Orders

            </a>

            <h2 class="mt-3 text-xl font-semibold text-gray-900">
                Purchase Order #{{ $purchaseOrder->order_number }}
            </h2>

        </div>

        @if($purchaseOrder->status === 'placed')

            <button type="button"
                onclick="document.getElementById('receive-modal').classList.remove('hidden')"
                class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-green-700">

                <i class="bx bx-package"></i>

                Receive Order

            </button>

        @endif

    </div>

    @if(session('success'))

        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>

    @endif

    @if($errors->any())

        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">

            <ul class="list-inside list-disc text-sm text-red-700">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif

    {{-- Order Information --}}
    <div class="mb-6 rounded-xl border border-gray-200 bg-white shadow-sm">

        <div class="border-b px-6 py-4">
            <h3 class="font-semibold text-gray-900">
                Order Information
            </h3>
        </div>

        <div class="grid grid-cols-1 gap-6 p-6 md:grid-cols-3">

            <div>
                <p class="text-sm text-gray-500">
                    Order Number
                </p>

                <p class="mt-1 font-semibold text-gray-900">
                    {{ $purchaseOrder->order_number }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">
                    Vendor
                </p>

                <p class="mt-1 font-semibold text-gray-900">
                    {{ $purchaseOrder->vendor->company_name ?: $purchaseOrder->vendor->name }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">
                    Purchase Request
                </p>

                <p class="mt-1 font-semibold text-gray-900">
                    PR-{{ $purchaseOrder->quotation->purchaseRequest->request_number }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">
                    Order Date
                </p>

                <p class="mt-1 font-semibold text-gray-900">
                    {{ $purchaseOrder->order_date->format('d M Y') }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">
                    Status
                </p>

                <div class="mt-1">

                    @if($purchaseOrder->status === 'recieved')

                        <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                            Received
                        </span>

                    @else

                        <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700">
                            Placed
                        </span>

                    @endif

                </div>

            </div>

            <div>
                <p class="text-sm text-gray-500">
                    Received Date
                </p>

                <p class="mt-1 font-semibold text-gray-900">
                    {{ $purchaseOrder->received_date?->format('d M Y') ?? '-' }}
                </p>
            </div>

            @if($purchaseOrder->notes)

                <div class="md:col-span-3">

                    <p class="text-sm text-gray-500">
                        Notes
                    </p>

                    <p class="mt-1 whitespace-pre-line text-gray-900">
                        {{ $purchaseOrder->notes }}
                    </p>

                </div>

            @endif

        </div>

    </div>

    {{-- Items --}}
    <div class="mb-6 rounded-xl border border-gray-200 bg-white shadow-sm">

        <div class="border-b px-6 py-4">

            <h3 class="font-semibold text-gray-900">
                Order Items
            </h3>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                <thead class="border-b bg-gray-50 text-xs uppercase text-gray-500">

                    <tr>

                        <th class="px-6 py-4">
                            Raw Material
                        </th>

                        <th class="px-6 py-4">
                            Quantity
                        </th>

                        <th class="px-6 py-4">
                            Unit
                        </th>

                        <th class="px-6 py-4">
                            Price
                        </th>

                        <th class="px-6 py-4 text-right">
                            Total
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y">

                    @foreach($purchaseOrder->items as $item)

                        <tr>

                            <td class="px-6 py-4">

                                <p class="font-medium text-gray-900">
                                    {{ $item->rawMaterial->name }}
                                </p>

                                <p class="text-xs text-gray-500">
                                    {{ $item->rawMaterial->sku }}
                                </p>

                            </td>

                            <td class="px-6 py-4">
                                {{ $item->qty }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $item->unit->short_name ?? $item->unit->name }}
                            </td>

                            <td class="px-6 py-4">
                                {{ number_format($item->price, 2) }}
                            </td>

                            <td class="px-6 py-4 text-right font-semibold">
                                {{ number_format($item->total, 2) }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

                <tfoot class="border-t bg-gray-50">

                    <tr>

                        <td colspan="4"
                            class="px-6 py-4 text-right font-semibold">

                            Grand Total

                        </td>

                        <td class="px-6 py-4 text-right text-lg font-bold">

                            {{ number_format($purchaseOrder->items->sum('total'), 2) }}

                        </td>

                    </tr>

                </tfoot>

            </table>

        </div>

    </div>

    {{-- Attachments --}}
    <div class="rounded-xl border border-gray-200 bg-white shadow-sm">

        <div class="flex items-center justify-between border-b px-6 py-4">

            <div>

                <h3 class="font-semibold text-gray-900">
                    Attachments
                </h3>

                <p class="mt-1 text-sm text-gray-500">
                    Documents uploaded when the order was received.
                </p>

            </div>

            @if($purchaseOrder->status === 'recieved')

                <button type="button"
                    onclick="document.getElementById('receive-modal').classList.remove('hidden')"
                    class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">

                    <i class="bx bx-upload"></i>

                    Upload More

                </button>

            @endif

        </div>

        <div class="p-6">

            @forelse($purchaseOrder->attachments as $attachment)

                <div class="mb-3 flex items-center justify-between rounded-lg border border-gray-200 px-4 py-3">

                    <div class="flex items-center gap-3">

                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-100">
                            <i class="bx bx-file text-lg text-gray-600"></i>
                        </div>

                        <span class="text-sm text-gray-700">
                            {{ basename($attachment->file_path) }}
                        </span>

                    </div>

                    <div class="flex items-center gap-2">

                        <a href="{{ asset('storage/' . $attachment->file_path) }}"
                            target="_blank"
                            class="rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">

                            View

                        </a>

                        <form action="{{ route('order-attachments.destroy', $attachment) }}"
                            method="POST"
                            onsubmit="return confirm('Delete this attachment?');">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                class="rounded-lg px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50">

                                Delete

                            </button>

                        </form>

                    </div>

                </div>

            @empty

                <div class="py-8 text-center text-sm text-gray-500">
                    No attachments uploaded.
                </div>

            @endforelse

        </div>

    </div>


    {{-- Receive Modal --}}
    <div id="receive-modal"
        class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/50">

        <div class="flex min-h-full items-center justify-center p-4">

            <div class="w-full max-w-lg rounded-xl bg-white shadow-xl">

                <form action="{{ route('purchase-orders.receive', $purchaseOrder) }}"
                    method="POST"
                    enctype="multipart/form-data">

                    @csrf

                    <div class="border-b px-6 py-4">

                        <h3 class="font-semibold text-gray-900">
                            Receive Purchase Order
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            Mark this order as received and upload receiving documents.
                        </p>

                    </div>

                    <div class="space-y-5 p-6">

                        <div>

                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Received Date
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="date"
                                name="received_date"
                                value="{{ now()->format('Y-m-d') }}"
                                required
                                class="block w-full rounded-lg border-gray-300 px-3 py-2.5 text-sm shadow-sm focus:border-gray-900 focus:ring-gray-900">

                        </div>

                        <div>

                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Attachments
                            </label>

                            <input type="file"
                                name="attachments[]"
                                multiple
                                accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx"
                                class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm">

                            <p class="mt-1 text-xs text-gray-500">
                                You can upload multiple files. Maximum 10MB per file.
                            </p>

                        </div>

                    </div>

                    <div class="flex justify-end gap-3 border-t bg-gray-50 px-6 py-4">

                        <button type="button"
                            onclick="document.getElementById('receive-modal').classList.add('hidden')"
                            class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-100">

                            Cancel

                        </button>

                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-green-700">

                            <i class="bx bx-check"></i>

                            Mark as Received

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-layouts.app>