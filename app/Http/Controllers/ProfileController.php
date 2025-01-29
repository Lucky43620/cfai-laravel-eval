<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        $orders = Order::where('user_id', $user->id)
                      ->with(['items.product'])
                      ->latest()
                      ->get();

        return view('profile.show', compact('user', 'orders'));
    }

    public function edit()
    {
        return view('profile.edit', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'nullable',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = $request->password;
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Profil mis à jour avec succès');
    }
}
