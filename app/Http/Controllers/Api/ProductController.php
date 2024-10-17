<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Traits\UploadTrait;
class ProductController extends Controller
{
    use UploadTrait;

    public function store(StoreProductRequest $request)
    {
        try {
            $data = $request->validated();

            // Manejar la carga de la imagen
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time().'_'.str_replace(' ', '_', $image->getClientOriginalName());
                $folder = 'uploads/images/';
                $filePath = $folder . $name;
                $image->storeAs($folder, $name, 'public');
                $data['image'] = $filePath;
            }

            $product = Product::create($data);

            return response()->json([
                'message' => '¡Se ha agregado un nuevo producto!',
                'data' => $product
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al agregar producto: ' . $e->getMessage()], 500);
        }
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            $data = $request->validated();

            // Manejar la carga de la imagen
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time().'_'.str_replace(' ', '_', $image->getClientOriginalName());
                $folder = 'uploads/images/';
                $filePath = $folder . $name;
                $image->storeAs($folder, $name, 'public');
                $data['image'] = $filePath;
            }

            $product->update($data);

            return response()->json([
                'message' => 'Producto actualizado con éxito.',
                'data' => $product
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar el producto: ' . $e->getMessage()], 500);
        }
    }
}
