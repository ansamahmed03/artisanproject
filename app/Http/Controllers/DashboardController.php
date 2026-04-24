<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request, $guard)
    {
        // لو artisan - روّحه على dashboard الخاص فيه
        if ($guard === 'artisan' && Auth::guard('artisan')->check()) {
            $artisan = Auth::guard('artisan')->user();
            return view('frontend.artisans.dashboard', compact('artisan'));
        }

        // باقي الـ guards (admin, team) - لوحة التحكم العادية
         return view('cms.home', compact('guard'));
    }
}
