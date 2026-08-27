<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\OrderAttachment;
use App\Models\RawMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PurchaseOrderController extends Controller
{
    /**
     * Display orders.
     */
    public function index()
    {
        $orders = PurchaseOrder::with([
            'vendor',
            'quotation',
        ])
            ->latest()
            ->paginate(15);

        return view('purchase_orders.index', compact('orders'));
    }

    /**
     * Display order.
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load([
            'vendor',
            'quotation.purchaseRequest',
            'items.rawMaterial',
            'items.unit',
            'attachments',
        ]);

        return view('purchase_orders.show', compact('purchaseOrder'));
    }

    /**
     * Delete order.
     */
    public function destroy(PurchaseOrder $purchaseOrder)
    {
        
        // Delete attachments from storage first
        foreach ($purchaseOrder->attachments as $attachment) {
            if (Storage::disk('public')->exists($attachment->file_path)) {
                Storage::disk('public')->delete($attachment->file_path);
            }
        }

        $purchaseOrder->delete();

        return redirect()
            ->route('purchase-orders.index')
            ->with('success', 'Purchase order deleted successfully.');
    }

    /**
     * Mark order as received and upload attachments.
     */

    public function receive(Request $request, PurchaseOrder $purchaseOrder)
    {
        $request->validate([
            'received_date' => [
                'required',
                'date',
            ],

            'attachments' => [
                'nullable',
                'array',
            ],

            'attachments.*' => [
                'file',
                'mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx',
                'max:10240',
            ],
        ]);

        // Prevent receiving the same order twice
        if ($purchaseOrder->status === 'recieved') {
            return back()->with(
                'error',
                'This purchase order has already been received.'
            );
        }

        $purchaseOrder->load('items');

        DB::transaction(function () use ($request, $purchaseOrder) {

            /*
            |--------------------------------------------------------------------------
            | Add received quantities to raw material stock
            |--------------------------------------------------------------------------
            */

            foreach ($purchaseOrder->items as $item) {

                $rawMaterial = RawMaterial::find($item->raw_material_id);

                if (!$rawMaterial) {
                    throw new \Exception("Raw material not found for order item #{$item->id}.");
                }

                $rawMaterial->increment('stock', $item->qty);
            }

            /*
            |--------------------------------------------------------------------------
            | Mark purchase order as received
            |--------------------------------------------------------------------------
            */

            $purchaseOrder->update([
                'status' => 'recieved',
                'received_date' => $request->received_date,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Save attachments
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('attachments')) {

                foreach ($request->file('attachments') as $file) {

                    $path = $file->store(
                        'purchase-orders/' . $purchaseOrder->id,
                        'public'
                    );

                    $purchaseOrder->attachments()->create([
                        'file_path' => $path,
                    ]);
                }
            }
        });

        return redirect()
            ->route('purchase-orders.show', $purchaseOrder)
            ->with(
                'success',
                'Purchase order received and stock updated successfully.'
            );
    }

    /**
     * Delete attachment.
     */
    public function destroyAttachment(OrderAttachment $attachment)
    {
        if (Storage::disk('public')->exists($attachment->file_path)) {
            Storage::disk('public')->delete($attachment->file_path);
        }

        $purchaseOrder = $attachment->purchase_order_id;

        $attachment->delete();

        return redirect()
            ->route('purchase-orders.show', $purchaseOrder)
            ->with('success', 'Attachment deleted successfully.');
    }
}