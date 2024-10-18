<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        try {
            $products = Product::all();
            return response()->json($products);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener los productos: ' . $e->getMessage()], 500);
        }
    }

    public function show(Product $product)
    {
        try {
            return response()->json($product);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener el producto: ' . $e->getMessage()], 500);
        }
    }

    public function store(StoreProductRequest $request)
    {
        try {
            $data = $request->validated();

            // Manejar la carga de la imagen
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time().'_'.str_replace(' ', '_', $image->getClientOriginalName());
                $filePath = $image->storeAs('uploads/images', $name, 'public');
                $data['image'] = 'storage/' . $filePath; // Asegurar la URL completa de la imagen
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

            // Manejar la actualización de la imagen
            if ($request->hasFile('image')) {
                // Eliminar la imagen anterior si existe
                if ($product->image && Storage::disk('public')->exists($product->image)) {
                    Storage::disk('public')->delete($product->image);
                }
                $image = $request->file('image');
                $name = time().'_'.str_replace(' ', '_', $image->getClientOriginalName());
                $filePath = $image->storeAs('uploads/images', $name, 'public');
                $data['image'] = 'storage/' . $filePath; // Asegurar la URL completa de la imagen
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
