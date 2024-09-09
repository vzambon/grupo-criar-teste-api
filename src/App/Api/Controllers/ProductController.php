<?php

namespace App\Api\Controllers;

use App\Api\Requests\ProductStoreRequest;
use Domain\Shared\Actions\PersistTempFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Products\Models\Product;
use Support\Storage\TempFile;

class ProductController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Cache::rememberForever('products', fn() => Product::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        $validated = $request->validated();
        
        $tempFile = new TempFile($validated['image_url']);
        $file = (new PersistTempFile($tempFile, "products/img", Str::uuid()))->execute();

        $validated['image_url'] = $file;
        
        return Product::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return $product;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::where('id', $id)->delete();

        return response()->json(['message' => 'Product deleted successfully!']);
    }
}
