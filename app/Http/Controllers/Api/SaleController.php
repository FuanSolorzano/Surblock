<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;


class SaleController extends Controller
{
    public function index()
    {
        try {
            $sales = Sale::all();
            return response()->json([
                'message' => 'Ventas obtenidas con éxito.',
                'data' => $sales
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener ventas.'], 500);
        }
    }

    public function store(StoreSaleRequest $request)
    {
        try {
            $sale = Sale::create($request->validated());
            return response()->json([
                'message' => '¡Se ha registrado una nueva venta!',
                'data' => $sale
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al registrar la venta.'], 500);
        }
    }

    public function show(Sale $sale)
    {
        try {
            return response()->json([
                'message' => 'Venta obtenida con éxito.',
                'data' => $sale
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener la venta.'], 500);
        }
    }

    public function update(UpdateSaleRequest $request, Sale $sale)
    {
        try {
            $sale->update($request->validated());
            return response()->json([
                'message' => 'Venta actualizada con éxito.',
                'data' => $sale
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar la venta.'], 500);
        }
    }

    public function destroy(Sale $sale)
    {
        try {
            $sale->delete();
            return response()->json([
                'message' => 'Venta eliminada con éxito.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar la venta.'], 500);
        }
    }
}
