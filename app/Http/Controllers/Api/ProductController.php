<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    public function index()
    {
        try {
            $products = Product::all();
            return response()->json([
                'message' => 'Productos obtenidos con éxito.',
                'data' => $products
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener productos.'], 500);
        }
    }

    public function store(StoreProductRequest $request)
    {
        try {
            $product = Product::create($request->validated());
            return response()->json([
                'message' => '¡Se ha agregado un nuevo producto!',
                'data' => $product
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al agregar producto.'], 500);
        }
    }

    public function show(Product $product)
    {
        try {
            return response()->json([
                'message' => 'Producto obtenido con éxito.',
                'data' => $product
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener el producto.'], 500);
        }
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            $product->update($request->validated());
            return response()->json([
                'message' => 'Producto actualizado con éxito.',
                'data' => $product
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar el producto.'], 500);
        }
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return response()->json([
                'message' => 'Producto eliminado con éxito.'
            ], 200); // Cambia a 200 para devolver el mensaje
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar el producto.'], 500);
        }
    }
}
