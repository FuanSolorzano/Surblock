<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $product = Product::find($request->product_id);
        $cartItem = CartItem::where('user_id', Auth::id())
                            ->where('product_id', $product->id)
                            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            $cartItem = new CartItem();
            $cartItem->user_id = Auth::id();
            $cartItem->product_id = $product->id;
            $cartItem->quantity = $request->quantity;
            $cartItem->save();
        }

        return response()->json([
            'message' => 'Producto añadido al carrito con éxito!',
            'data' => $cartItem
        ]);
    }

    public function showCart()
    {
        $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();
        $totalQuantity = $cartItems->sum('quantity');
        $totalAmount = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return response()->json([
            'cart_items' => $cartItems,
            'total_quantity' => $totalQuantity,
            'total_amount' => $totalAmount
        ]);
    }

    public function updateCart(Request $request, $id)
    {
        $cartItem = CartItem::findOrFail($id);

        if ($cartItem->user_id != Auth::id()) {
            return response()->json(['error' => 'Acceso no autorizado.'], 403);
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return response()->json([
            'message' => 'Cantidad actualizada con éxito!',
            'data' => $cartItem
        ]);
    }

    public function removeFromCart($id)
    {
        $cartItem = CartItem::findOrFail($id);

        if ($cartItem->user_id != Auth::id()) {
            return response()->json(['error' => 'Acceso no autorizado.'], 403);
        }

        $cartItem->delete();

        return response()->json(['message' => 'Producto eliminado del carrito con éxito!']);
    }

    public function clearCart()
    {
        CartItem::where('user_id', Auth::id())->delete();

        return response()->json(['message' => 'Carrito limpiado con éxito!']);
    }
}
