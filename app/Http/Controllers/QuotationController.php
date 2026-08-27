<?php

namespace App\Http\Controllers;

use App\Http\Requests\Quotation\StoreQuotationRequest;
use App\Http\Requests\Quotation\UpdateQuotationRequest;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\PurchaseRequest;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuotationController extends Controller
{
    /**
     * Display quotations.
     */
    public function index()
    {
        $quotations = Quotation::with([
            'purchaseRequest',
            'vendor',
            'items'
        ])
            ->latest()
            ->paginate(10);

        return view('quotations.index', compact('quotations'));
    }

    /**
     * Show create form for a purchase request.
     */
    public function create(PurchaseRequest $purchaseRequest)
    {
        $purchaseRequest->load([
            'items.rawMaterial',
            'items.unit',
        ]);

        $vendors = Vendor::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('quotations.create', compact(
            'purchaseRequest',
            'vendors'
        ));
    }

    /**
     * Store quotation.
     */
    public function store(StoreQuotationRequest $request)
    {
        $validated = $request->validated();

        $purchaseRequest = PurchaseRequest::with('items')
            ->findOrFail($validated['purchase_request_id']);

        // Prevent duplicate vendor quotation for same purchase request.
        $exists = Quotation::where('purchase_request_id', $purchaseRequest->id)
            ->where('vendor_id', $validated['vendor_id'])
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'vendor_id' => 'This vendor has already submitted a quotation for this purchase request.',
                ]);
        }

        DB::transaction(function () use ($validated) {

            $quotation = Quotation::create([
                'purchase_request_id' => $validated['purchase_request_id'],
                'vendor_id' => $validated['vendor_id'],
                'quotation_number' => $validated['quotation_number'] ?? null,
                'status' => $validated['status'],
                'quotation_date' => $validated['quotation_date'],
                'valid_until' => $validated['valid_until'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['items'] as $item) {

                $total = $item['qty'] * $item['price'];

                QuotationItem::create([
                    'quotation_id' => $quotation->id,
                    'raw_material_id' => $item['raw_material_id'],
                    'qty' => $item['qty'],
                    'unit_id' => $item['unit_id'],
                    'price' => $item['price'],
                    'total' => $total,
                ]);
            }
        });

        return redirect()
            ->route('quotations.index')
            ->with('success', 'Quotation created successfully.');
    }

    /**
     * Show quotation.
     */
    public function show(Quotation $quotation)
    {
        $quotation->load([
            'purchaseRequest.items.rawMaterial',
            'purchaseRequest.items.unit',
            'vendor',
            'items.rawMaterial',
            'items.unit',
        ]);

        return view('quotations.show', compact('quotation'));
    }

    /**
     * Edit quotation.
     */
public function edit(Quotation $quotation)
{
    $quotation->load([
        'purchaseRequest.items.rawMaterial',
        'purchaseRequest.items.unit',
        'items',
    ]);

    $purchaseRequest = $quotation->purchaseRequest;

    $vendors = Vendor::where('is_active', true)
        ->orderBy('name')
        ->get();

    // Map existing quotation items by raw material
    $quotationItems = $quotation->items->keyBy('raw_material_id');

    return view('quotations.edit', compact(
        'quotation',
        'purchaseRequest',
        'quotationItems',
        'vendors'
    ));
}

    /**
     * Update quotation.
     */
    public function update(UpdateQuotationRequest $request, Quotation $quotation)
    {
        $validated = $request->validated();

        $exists = Quotation::where('purchase_request_id', $quotation->purchase_request_id)
            ->where('vendor_id', $validated['vendor_id'])
            ->where('id', '!=', $quotation->id)
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'vendor_id' => 'This vendor already has a quotation for this purchase request.',
                ]);
        }

        DB::transaction(function () use ($validated, $quotation) {

            $quotation->update([
                'vendor_id' => $validated['vendor_id'],
                'quotation_number' => $validated['quotation_number'] ?? null,
                'status' => $validated['status'],
                'quotation_date' => $validated['quotation_date'],
                'valid_until' => $validated['valid_until'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);

            $quotation->items()->delete();

            foreach ($validated['items'] as $item) {

                $total = $item['qty'] * $item['price'];

                QuotationItem::create([
                    'quotation_id' => $quotation->id,
                    'raw_material_id' => $item['raw_material_id'],
                    'qty' => $item['qty'],
                    'unit_id' => $item['unit_id'],
                    'price' => $item['price'],
                    'total' => $total,
                ]);
            }
        });

        return redirect()
            ->route('quotations.index')
            ->with('success', 'Quotation updated successfully.');
    }

    /**
     * Delete quotation.
     */
    public function destroy(Quotation $quotation)
    {
        DB::transaction(function () use ($quotation) {
            $quotation->items()->delete();
            $quotation->delete();
        });

        return redirect()
            ->route('quotations.index')
            ->with('success', 'Quotation deleted successfully.');
    }
}