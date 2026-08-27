<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManufacturingFormula\UpdateManufacturingFormulaRequest;
use App\Http\Requests\ManufacturingFormula\StoreManufacturingFormulaRequest;
use App\Models\ManufacturingFormula;
use App\Models\Product;
use App\Models\RawMaterial;
use App\Models\Unit;
use Exception;
use Illuminate\Support\Facades\DB;

class ManufacturingFormulaController extends Controller
{
    public function index()
    {
        $formulas = ManufacturingFormula::with(['product','items.rawMaterial','items.unit'])
            ->latest()
            ->paginate(15);

        return view('manufacturing_formulas.index', compact('formulas'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();
        $rawMaterials = RawMaterial::orderBy('name')->get();
        $units = Unit::orderBy('name')->get();
        return view(
            'manufacturing_formulas.create',
            compact('products', 'rawMaterials', 'units')
        );
    }

    public function store(StoreManufacturingFormulaRequest $request)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($request, $validated) {

            $formula = ManufacturingFormula::create([
                'product_id' => $validated['product_id'],
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
               
            ]);

            foreach ($validated['items'] as $item) {
                $formula->items()->create([
                    'raw_material_id' => $item['raw_material_id'],
                    'quantity' => $item['quantity'],
                    'unit_id' => $item['unit_id'],
                ]);
            }
        });

        return redirect()
            ->route('manufacturing-formulas.index')
            ->with('success', 'Manufacturing formula created successfully.');
    }

    public function edit(ManufacturingFormula $manufacturingFormula)
    {
        $manufacturingFormula->load('items');
        $products = Product::orderBy('name')->get();
        $rawMaterials = RawMaterial::orderBy('name')->get();
        $units = Unit::orderBy('name')->get();

        return view(
            'manufacturing_formulas.edit',
            compact(
                'manufacturingFormula',
                'products',
                'rawMaterials',
                'units'
            )
        );
    }

    public function update(
        UpdateManufacturingFormulaRequest $request,
        ManufacturingFormula $manufacturingFormula
    ) {
        $validated = $request->validated();

        DB::transaction(function () use ($request, $validated, $manufacturingFormula) {
            $manufacturingFormula->update([
                'product_id' => $validated['product_id'],
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
            ]);

            // Remove old items
            $manufacturingFormula->items()->delete();

            // Create updated items
            foreach ($validated['items'] as $item) {
                $manufacturingFormula->items()->create([
                    'raw_material_id' => $item['raw_material_id'],
                    'quantity' => $item['quantity'],
                    'unit_id' => $item['unit_id'],
                ]);
            }
        });

        return redirect()
            ->route('manufacturing-formulas.index')
            ->with('success', 'Manufacturing formula updated successfully.');
    }

    public function destroy(ManufacturingFormula $manufacturingFormula)
    {
        try{
            $manufacturingFormula->delete();
        }catch(Exception $e){
         return redirect()
            ->route('manufacturing-formulas.index')
            ->with('error', 'Unable to delete Manufacturing formula.');
        }

        return redirect()
            ->route('manufacturing-formulas.index')
            ->with('success', 'Manufacturing formula deleted successfully.');
    }
}