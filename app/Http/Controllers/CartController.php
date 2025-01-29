<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;

class CartController extends Controller
{
    public function index()
    {
        // Récupérer le panier de l'utilisateur connecté
        $cart = Cart::where('user_id', auth()->id())->first();

        // Si le panier n'existe pas, créer un nouveau panier
        if (!$cart) {
            $cart = Cart::create(['user_id' => auth()->id()]);
        }

        // Calculer le total du panier
        $total = 0;
        foreach ($cart->items as $item) {
            $total += $item->price * $item->quantity;
        }

        // Passer les variables $cart et $total à la vue
        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        // Validation de la requête
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        // Récupérer le produit demandé
        $product = Product::findOrFail($request->product_id);

        // Récupérer ou créer le panier de l'utilisateur
        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);

        // Vérifier si l'article existe déjà dans le panier
        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            // Si l'article existe déjà, on augmente la quantité
            $cartItem->quantity++;
            $cartItem->save();
        } else {
            // Si l'article n'existe pas, on l'ajoute au panier
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->price,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produit ajouté au panier');
    }

    public function delete(Request $request, $product_id)
    {
        // Récupérer le panier de l'utilisateur
        $cart = Cart::where('user_id', auth()->id())->first();

        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Panier introuvable');
        }

        // Récupérer l'item du panier à supprimer
        $cartItem = $cart->items()->where('product_id', $product_id)->first();

        if ($cartItem) {
            // Supprimer l'article du panier
            $cartItem->delete();
            return redirect()->route('cart.index')->with('success', 'Produit supprimé du panier');
        }

        // Si l'article n'est pas trouvé dans le panier
        return redirect()->route('cart.index')->with('error', 'Produit introuvable dans le panier');
    }
}
