<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamDashboardController extends Controller
{
    private function team()
    {
        return Auth::guard('team')->user();
    }

    public function index()
    {
        $team     = $this->team()->load('bookings.customer', 'city');
        $bookings = $team->bookings()->with('customer')->latest()->get();
        return view('frontend.teams.dashboard', compact('team', 'bookings'));
    }
}
