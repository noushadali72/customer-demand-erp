<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UnitController extends Controller
{
    /**
     * Display all units.
     */
    public function index()
    {
        $units = Unit::latest()->paginate(15);

        return view('units.index', compact('units'));
    }


    /**
     * Show create form.
     */
    public function create()
    {
        return view('units.create');
    }


    /**
     * Store unit.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:units,name',
            ],
            'short_name' => [
                'required',
                'string',
                'max:50',
                'unique:units,short_name',
            ],
        ]);

        Unit::create($validated);

        return redirect()
            ->route('units.index')
            ->with('success', 'Unit created successfully.');
    }


    /**
     * Show unit.
     */
    public function show(Unit $unit)
    {
        return view('units.show', compact('unit'));
    }


    /**
     * Show edit form.
     */
    public function edit(Unit $unit)
    {
        return view('units.edit', compact('unit'));
    }


    /**
     * Update unit.
     */
    public function update(Request $request, Unit $unit)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('units', 'name')->ignore($unit->id),
            ],
            'short_name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('units', 'short_name')->ignore($unit->id),
            ],
        ]);

        $unit->update($validated);

        return redirect()
            ->route('units.index')
            ->with('success', 'Unit updated successfully.');
    }


    /**
     * Delete unit.
     */
    public function destroy(Unit $unit)
    {
        try {

            $unit->delete();

            return redirect()
                ->route('units.index')
                ->with('success', 'Unit deleted successfully.');

        } catch (\Throwable $e) {

            return redirect()
                ->route('units.index')
                ->with('error', 'Unable to delete this unit because it is being used.');
        }
    }
}