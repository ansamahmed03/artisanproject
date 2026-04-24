<?php

namespace App\Http\Controllers;

use App\Models\Artisan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ArtisanAuthController extends Controller
{
    public function loginPage()
    {
        if (Auth::guard('artisan')->check()) {
            return redirect()->route('artisan.dashboard');
        }
        return view('frontend.artisans.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if (Auth::guard('artisan')->attempt([
            'email'    => $request->email,
            'password' => $request->password,
        ])) {
            return redirect()->route('artisan.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
    }

    public function dashboard()
    {
        $artisan = Auth::guard('artisan')->user();
        return view('frontend.artisans.dashboard', compact('artisan'));
    }

    // ← بس نسخة وحدة من logout
    public function logout(Request $request)
    {
        Auth::guard('artisan')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('artisan.login');
    }
}
