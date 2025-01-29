<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function apply(Request $request)
    {
        $request->validate([
            'code' => 'required|exists:coupons,code'
        ]);

        $coupon = Coupon::where('code', $request->code)->first();

        if (!$coupon->isValid()) {
            return back()->withErrors(['code' => 'Ce coupon n\'est plus valide.']);
        }

        $cart = session()->get('cart', []);
        $total = collect($cart)->sum(function($item) {
            return $item['price'] * $item['quantity'];
        });

        $discount = $coupon->type === 'percentage' 
            ? ($total * $coupon->value / 100)
            : $coupon->value;

        session()->put('coupon', [
            'code' => $coupon->code,
            'discount' => $discount
        ]);

        return back()->with('success', 'Coupon appliqué avec succès !');
    }
} 