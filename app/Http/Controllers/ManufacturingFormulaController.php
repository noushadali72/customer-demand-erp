<?php

namespace App\Http\Controllers;

use App\Models\ManufacturingFormula;
use App\Models\Product;
use App\Models\RawMaterial;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ManufacturingFormulaController extends Controller
{
    public function index()
    {
        $formulas = ManufacturingFormula::with([
            'product',
            'items.rawMaterial',
            'items.unit',
        ])
            ->latest()
            ->paginate(15);

        return view('manufacturing_formulas.index', compact('formulas'));
    }

    public function create()
    {
        $products = Product::where('is_active', true)
            ->orderBy('name')
            ->get();

        $rawMaterials = RawMaterial::where('is_active', true)
            ->orderBy('name')
            ->get();

        $units = Unit::orderBy('name')->get();

        return view(
            'manufacturing_formulas.create',
            compact('products', 'rawMaterials', 'units')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],

            'items' => ['required', 'array', 'min:1'],

            'items.*.raw_material_id' => [
                'required',
                'exists:raw_materials,id',
                'distinct',
            ],

            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],

            'items.*.unit_id' => [
                'required',
                'exists:units,id',
            ],
        ]);

        DB::transaction(function () use ($request, $validated) {

            $formula = ManufacturingFormula::create([
                'product_id' => $validated['product_id'],
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'is_active' => $request->boolean('is_active'),
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

        $products = Product::where('is_active', true)
            ->orderBy('name')
            ->get();

        $rawMaterials = RawMaterial::where('is_active', true)
            ->orderBy('name')
            ->get();

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
        Request $request,
        ManufacturingFormula $manufacturingFormula
    ) {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],

            'items' => ['required', 'array', 'min:1'],

            'items.*.raw_material_id' => [
                'required',
                'exists:raw_materials,id',
                'distinct',
            ],

            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],

            'items.*.unit_id' => [
                'required',
                'exists:units,id',
            ],
        ]);

        DB::transaction(function () use ($request, $validated, $manufacturingFormula) {

            $manufacturingFormula->update([
                'product_id' => $validated['product_id'],
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'is_active' => $request->boolean('is_active'),
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
        $manufacturingFormula->delete();

        return redirect()
            ->route('manufacturing-formulas.index')
            ->with('success', 'Manufacturing formula deleted successfully.');
    }
}