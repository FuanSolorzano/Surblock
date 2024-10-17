<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;

class CustomerController extends Controller
{
    public function index()
    {
        try {
            $customers = Customer::all();
            return response()->json([
                'message' => 'Clientes obtenidos con éxito.',
                'data' => $customers
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener clientes.'], 500);
        }
    }

    public function store(StoreCustomerRequest $request)
    {
        try {
            $customer = Customer::create($request->validated());
            return response()->json([
                'message' => '¡Se ha agregado un nuevo cliente!',
                'data' => $customer
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al agregar cliente.'], 500);
        }
    }

    public function show(Customer $customer)
    {
        try {
            return response()->json([
                'message' => 'Cliente obtenido con éxito.',
                'data' => $customer
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener el cliente.'], 500);
        }
    }

    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        try {
            $customer->update($request->validated());
            return response()->json([
                'message' => 'Cliente actualizado con éxito.',
                'data' => $customer
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar el cliente.'], 500);
        }
    }

    public function destroy(Customer $customer)
    {
        try {
            $customer->delete();
            return response()->json([
                'message' => 'Cliente eliminado con éxito.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar el cliente.'], 500);
        }
    }
}
