<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function checkout()
    {
        $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();

        // Filtre les items sans produit pour éviter les erreurs
        $cartItems = $cartItems->filter(function ($item) {
            return $item->product !== null;
        });

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('orders.checkout', [
            'cartItems' => $cartItems,
            'total' => $total
        ]);
    }

    public function store(Request $request)
    {
        $order = Order::create([
            'user_id' => $request->user_id,
            'total_amount' => $this->calculateTotal(),
            'status' => 'pending',
            'shipping_address' => $request->address,
        ]);

        session()->flush();

        return redirect()->route('orders.success');
    }

    public function success()
    {
        return view('orders.success');
    }

    private function calculateTotal()
    {
        $total = 0;
        $cart = session()->get('cart');

        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return $total;
    }

    private function createOrderItems($order)
    {
        $cart = session()->get('cart');

        foreach($cart as $id => $details) {
            $order->items()->create([
                'product_id' => $id,
                'quantity' => $details['quantity'],
                'price' => $details['price']
            ]);
        }
    }
}
