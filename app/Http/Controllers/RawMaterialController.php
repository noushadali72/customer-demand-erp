<?php

namespace App\Http\Controllers;

use App\Models\RawMaterial;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RawMaterialController extends Controller
{
    public function index()
    {
        $rawMaterials = RawMaterial::with('unit')
            ->latest()
            ->paginate(15);

        return view('raw_materials.index', compact('rawMaterials'));
    }

    public function create()
    {
        $units = Unit::orderBy('name')->get();

        return view('raw_materials.create', compact('units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['nullable', 'string', 'max:255', 'unique:raw_materials,sku'],
            'cost_price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'unit_id' => ['required', 'exists:units,id'],
            'minimum_stock' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        RawMaterial::create($validated);

        return redirect()
            ->route('raw-materials.index')
            ->with('success', 'Raw material created successfully.');
    }

    public function edit(RawMaterial $rawMaterial)
    {
        $units = Unit::orderBy('name')->get();

        return view('raw_materials.edit', compact('rawMaterial', 'units'));
    }

    public function update(Request $request, RawMaterial $rawMaterial)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sku' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('raw_materials', 'sku')->ignore($rawMaterial->id),
            ],
            'cost_price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'unit_id' => ['required', 'exists:units,id'],
            'minimum_stock' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $rawMaterial->update($validated);

        return redirect()
            ->route('raw-materials.index')
            ->with('success', 'Raw material updated successfully.');
    }

    public function destroy(RawMaterial $rawMaterial)
    {
        $rawMaterial->delete();

        return redirect()
            ->route('raw-materials.index')
            ->with('success', 'Raw material deleted successfully.');
    }
}