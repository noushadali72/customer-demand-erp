<?php

namespace App\Http\Controllers;

use App\Http\Requests\RawMaterial\StoreRawMaterialRequest;
use App\Http\Requests\RawMaterial\UpdateRawMaterialRequest;
use App\Models\RawMaterial;
use App\Models\Unit;
use Exception;
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

    public function store(StoreRawMaterialRequest $request)
    {
        $validated = $request->validated();
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

    public function update(UpdateRawMaterialRequest $request, RawMaterial $rawMaterial)
    {
        $validated = $request->validated();
        $rawMaterial->update($validated);
        return redirect()
            ->route('raw-materials.index')
            ->with('success', 'Raw material updated successfully.');
    }

    public function destroy(RawMaterial $rawMaterial)
    {
        try{
            $rawMaterial->delete();
        }catch(Exception $e){
             return redirect()
            ->route('raw-materials.index')
            ->with('error', 'Unable to Delete Raw Material.');
        }
        return redirect()
            ->route('raw-materials.index')
            ->with('success', 'Raw material deleted successfully.');
    }
}