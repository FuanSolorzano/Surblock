<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SalesDetail;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSalesDetailRequest;
use App\Http\Requests\UpdateSalesDetailRequest;

class SalesDetailController extends Controller
{
    public function index()
    {
        try {
            $salesDetails = SalesDetail::all();
            return response()->json([
                'message' => 'Detalles de ventas obtenidos con éxito.',
                'data' => $salesDetails
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener detalles de ventas.'], 500);
        }
    }

    public function store(StoreSalesDetailRequest $request)
    {
        try {
            $salesDetail = SalesDetail::create($request->validated());
            return response()->json([
                'message' => '¡Se ha agregado un nuevo detalle de venta!',
                'data' => $salesDetail
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al agregar detalle de venta.'], 500);
        }
    }

    public function show($id)
    {
        try {
            $salesDetail = SalesDetail::findOrFail($id);
            return response()->json([
                'message' => 'Detalle de venta obtenido con éxito.',
                'data' => $salesDetail
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener el detalle de venta.'], 500);
        }
    }

    public function update(UpdateSalesDetailRequest $request, $id)
    {
        try {
            $salesDetail = SalesDetail::findOrFail($id);
            $salesDetail->update($request->validated());
            return response()->json([
                'message' => 'Detalle de venta actualizado con éxito.',
                'data' => $salesDetail
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar el detalle de venta.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $salesDetail = SalesDetail::findOrFail($id);
            $salesDetail->delete();
            return response()->json([
                'message' => 'Detalle de venta eliminado con éxito.',
                'data' => $salesDetail
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar el detalle de venta.'], 500);
        }
    }
}
