<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use App\Models\Unit;
use Exception;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('unit')
            ->latest()
            ->paginate(15);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $units = Unit::orderBy('name')->get();
        return view('products.create', compact('units'));
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();
        Product::create($validated);
        return redirect()
            ->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'sku' => $product->sku,
            'cost_price' => $product->cost_price,
            'sale_price' => $product->sale_price,
            'stock' => $product->stock,
            'minimum_stock' => $product->minimum_stock,
            'unit_id' => $product->unit_id,
            'description' => $product->description,
        ]);
    }

    public function edit(Product $product)
    {
        $units = Unit::orderBy('name')->get();
        return view('products.edit', compact('product', 'units'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();
        $product->update($validated);
        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        try{
            $product->delete();
        }catch(Exception $e){
            return redirect()
            ->route('products.index')
            ->with('error', 'Unable to Delete Product.');
        }
        return redirect()
            ->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }
}