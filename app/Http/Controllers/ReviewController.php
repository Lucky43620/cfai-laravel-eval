<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer',
            'comment' => 'string',
        ]);

        $product = Product::find($id);

        $review = new Review([
            'rating' => $request->rating,
            'comment' => $request->comment,
            'user_id' => $request->user_id
        ]);

        $product->reviews()->save($review);

        return back()->with('success', 'Votre avis a été publié avec succès.');
    }
} 