<?php

namespace App\Http\Controllers;

use App\Models\PurchaseRequest;
use App\Models\RawMaterial;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PurchaseRequestController extends Controller
{
    /**
     * Display purchase requests.
     */
    public function index()
    {
        $purchaseRequests = PurchaseRequest::with('items')
            ->latest()
            ->paginate(15);

        return view(
            'purchase_requests.index',
            compact('purchaseRequests')
        );
    }


    /**
     * Show create form.
     */
    public function create()
    {
        $rawMaterials = RawMaterial::where('is_active', true)
            ->orderBy('name')
            ->get();

        $units = Unit::orderBy('name')->get();

        return view(
            'purchase_requests.create',
            compact('rawMaterials', 'units')
        );
    }


    /**
     * Store purchase request.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'request_number' => [
                'required',
                'integer',
                'unique:purchase_requests,request_number',
            ],

            'status' => [
                'required',
                Rule::in([
                    'complete',
                    'pending',
                    'active',
                ]),
            ],

            'notes' => [
                'nullable',
                'string',
            ],

            'items' => [
                'required',
                'array',
                'min:1',
            ],

            'items.*.raw_material_id' => [
                'required',
                'exists:raw_materials,id',
            ],

            'items.*.qty' => [
                'required',
                'integer',
                'min:1',
            ],

            'items.*.unit_id' => [
                'required',
                'exists:units,id',
            ],
        ]);


        DB::transaction(function () use ($validated) {

            $purchaseRequest = PurchaseRequest::create([
                'request_number' => $validated['request_number'],
                'status' => $validated['status'],
                'notes' => $validated['notes'] ?? null,
            ]);


            foreach ($validated['items'] as $item) {

                $purchaseRequest->items()->create([
                    'raw_material_id' => $item['raw_material_id'],
                    'qty' => $item['qty'],
                    'unit_id' => $item['unit_id'],
                ]);
            }
        });


        return redirect()
            ->route('purchase-requests.index')
            ->with(
                'success',
                'Purchase request created successfully.'
            );
    }


    /**
     * Show purchase request.
     */
    public function show(PurchaseRequest $purchaseRequest)
    {
        $purchaseRequest->load([
            'items.rawMaterial',
            'items.unit',
        ]);

        return view(
            'purchase_requests.show',
            compact('purchaseRequest')
        );
    }


    /**
     * Show edit form.
     */
    public function edit(PurchaseRequest $purchaseRequest)
    {
        $purchaseRequest->load('items');

        $rawMaterials = RawMaterial::where('is_active', true)
            ->orderBy('name')
            ->get();

        $units = Unit::orderBy('name')->get();

        return view(
            'purchase_requests.edit',
            compact(
                'purchaseRequest',
                'rawMaterials',
                'units'
            )
        );
    }


    /**
     * Update purchase request.
     */
    public function update(
        Request $request,
        PurchaseRequest $purchaseRequest
    ) {
        $validated = $request->validate([
            'request_number' => [
                'required',
                'integer',
                Rule::unique(
                    'purchase_requests',
                    'request_number'
                )->ignore($purchaseRequest->id),
            ],

            'status' => [
                'required',
                Rule::in([
                    'complete',
                    'pending',
                    'active',
                ]),
            ],

            'notes' => [
                'nullable',
                'string',
            ],

            'items' => [
                'required',
                'array',
                'min:1',
            ],

            'items.*.raw_material_id' => [
                'required',
                'exists:raw_materials,id',
            ],

            'items.*.qty' => [
                'required',
                'integer',
                'min:1',
            ],

            'items.*.unit_id' => [
                'required',
                'exists:units,id',
            ],
        ]);


        DB::transaction(function () use (
            $validated,
            $purchaseRequest
        ) {

            $purchaseRequest->update([
                'request_number' => $validated['request_number'],
                'status' => $validated['status'],
                'notes' => $validated['notes'] ?? null,
            ]);


            $purchaseRequest->items()->delete();


            foreach ($validated['items'] as $item) {

                $purchaseRequest->items()->create([
                    'raw_material_id' => $item['raw_material_id'],
                    'qty' => $item['qty'],
                    'unit_id' => $item['unit_id'],
                ]);
            }
        });


        return redirect()
            ->route(
                'purchase-requests.show',
                $purchaseRequest
            )
            ->with(
                'success',
                'Purchase request updated successfully.'
            );
    }


    /**
     * Delete purchase request.
     */
    public function destroy(PurchaseRequest $purchaseRequest)
    {
        try {

            $purchaseRequest->delete();

            return redirect()
                ->route('purchase-requests.index')
                ->with(
                    'success',
                    'Purchase request deleted successfully.'
                );

        } catch (\Throwable $e) {

            return redirect()
                ->route('purchase-requests.index')
                ->with(
                    'error',
                    'Unable to delete purchase request.'
                );
        }
    }

    public function rawMaterial(RawMaterial $rawMaterial)
    {
        $rawMaterial->load('unit');

        return response()->json([
            'id' => $rawMaterial->id,
            'name' => $rawMaterial->name,
            'sku' => $rawMaterial->sku,
            'cost_price' => $rawMaterial->cost_price,
            'stock' => $rawMaterial->stock,
            'minimum_stock' => $rawMaterial->minimum_stock,
            'unit_id' => $rawMaterial->unit_id,
            'unit_name' => $rawMaterial->unit?->name,
            'description' => $rawMaterial->description,
        ]);
    }


}