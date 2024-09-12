<?php

namespace App\Api\Controllers;

use App\Api\Requests\ProductStoreRequest;
use App\Api\Requests\ProductUpdateRequest;
use Domain\Shared\Actions\PersistTempFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
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
        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        $validated = $request->validated();

        if (isset($validated['image_url'])) {
            $tempFile = new TempFile($validated['image_url']);
            $file = (new PersistTempFile($tempFile, 'products/img', Str::uuid()))->execute();

            $validated['image_url'] = $file;
        }

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
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $validated = $request->validated();

        if ($validated['image_url']) {
            $tempFile = new TempFile($validated['image_url']);
            $file = (new PersistTempFile($tempFile, 'products/img', Str::uuid()))->execute();

            if ($file) {
                Storage::disk('private')->delete($product->image_url);
            }

            $validated['image_url'] = $file;
        }

        $product->update($validated);

        return $product;
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
