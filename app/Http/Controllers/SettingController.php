<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $cartLimit = Setting::where('key', 'cart_limit')->first()->value ?? 2;
        return view('settings.index', compact('cartLimit'));
    }

    public function updateCartLimit(Request $request)
    {
        $request->validate([
            'cart_limit' => 'required|integer|min:1',
        ]);

        Setting::updateOrCreate(
            ['key' => 'cart_limit'],
            ['value' => $request->cart_limit]
        );

        return redirect()->route('settings.index')->with('success', 'Cart limit updated successfully.');
    }
}
