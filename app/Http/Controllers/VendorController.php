<?php

namespace App\Http\Controllers;

use App\Http\Requests\Vendor\StoreVendorRequest;
use App\Http\Requests\Vendor\UpdateVendorRequest;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VendorController extends Controller
{
    /**
     * Display vendors.
     */
    public function index()
    {
        $vendors = Vendor::latest()->paginate(15);
        return view('vendors.index', compact('vendors'));
    }


    /**
     * Show create form.
     */
    public function create()
    {
        return view('vendors.create');
    }


    /**
     * Store vendor.
     */
    public function store(StoreVendorRequest $request)
    {
        $validated = $request->validated();
        $validated['is_active'] = $request->boolean('is_active');
        Vendor::create($validated);
        return redirect()
            ->route('vendors.index')
            ->with(
                'success',
                'Vendor created successfully.'
            );
    }


    /**
     * Display vendor.
     */
    public function show(Vendor $vendor)
    {
        return view('vendors.show', compact('vendor'));
    }


    /**
     * Show edit form.
     */
    public function edit(Vendor $vendor)
    {
        return view('vendors.edit', compact('vendor'));
    }


    /**
     * Update vendor.
     */
    public function update(UpdateVendorRequest $request, Vendor $vendor)
    {
        $validated = $request->validated();
        $validated['is_active'] = $request->boolean('is_active');

        $vendor->update($validated);


        return redirect()
            ->route('vendors.index', $vendor)
            ->with(
                'success',
                'Vendor updated successfully.'
            );
    }


    /**
     * Delete vendor.
     */
    public function destroy(Vendor $vendor)
    {
        try {
            $vendor->delete();
            return redirect()
                ->route('vendors.index')
                ->with('success','Vendor deleted successfully.');

        } catch (\Throwable $e) {

            return redirect()
                ->route('vendors.index')
                ->with('error', 'Unable to delete vendor.');
        }
    }
}