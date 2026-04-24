<?php

namespace App\Http\Controllers;

use App\Models\Artisan;
use App\Models\City;
use App\Models\Customer;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class FrontAuthController extends Controller
{
    // ===========================
    // Login
    // ===========================
    public function loginPage()
    {
        if (Auth::guard('customer')->check()) return redirect()->route('front.home');
        if (Auth::guard('artisan')->check())  return redirect()->route('front.home');
        if (Auth::guard('team')->check())     return redirect()->route('front.home');

        return view('frontend.auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');
        $email = $request->email;

        // Customer
        if (Customer::where('email', $email)->exists()) {
            if (Auth::guard('customer')->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->route('front.home');
            }
            return back()->withErrors(['email' => 'كلمة المرور غلط.'])->withInput();
        }

        // Artisan
        if (Artisan::where('email', $email)->exists()) {
            if (Auth::guard('artisan')->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->route('front.home');
            }
            return back()->withErrors(['email' => 'كلمة المرور غلط.'])->withInput();
        }

        // Team
        if (Team::where('email', $email)->exists()) {
            if (Auth::guard('team')->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->route('front.home');
            }
            return back()->withErrors(['email' => 'كلمة المرور غلط.'])->withInput();
        }

        return back()->withErrors(['email' => 'الإيميل مش موجود.'])->withInput();
    }

    // ===========================
    // Register - Redirect by type
    // ===========================
    public function registerPage(Request $request)
    {
        // لو جاي من select-type بـ user_type param
        $type = $request->get('user_type');

        return match($type) {
            'artisan'  => redirect()->route('front.register.artisan'),
            'team'     => redirect()->route('front.register.team'),
            'customer' => redirect()->route('front.register.customer'),
            default    => redirect()->route('front.register.select'),
        };
    }

    // ===========================
    // Register - Customer
    // ===========================
    public function registerCustomerPage()
    {
        return view('frontend.auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|min:3|max:45',
            'email'    => 'required|email|unique:customers,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $customer           = new Customer();
        $customer->name     = $request->name;
        $customer->email    = $request->email;
        $customer->password = Hash::make($request->password);
        $customer->save();

        Auth::guard('customer')->login($customer);
        return redirect()->route('front.home');
    }

    // ===========================
    // Register - Artisan
    // ===========================
    public function registerArtisanPage()
    {
        $cities = City::orderBy('name')->get();
        return view('frontend.auth.register-artisan', compact('cities'));
    }

    public function registerArtisan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'artisan_name' => 'required|string|min:3|max:45',
            'store_name'   => 'required|string|min:3|max:100',
            'email'        => 'required|email|unique:artisans,email',
            'city_id'      => 'required|exists:cities,id',
            'bio'          => 'nullable|string|max:500',
            'password'     => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $artisan               = new Artisan();
        $artisan->artisan_name = $request->artisan_name;
        $artisan->store_name   = $request->store_name;
        $artisan->email        = $request->email;
        $artisan->city_id      = $request->city_id;
        $artisan->bio          = $request->bio;
        $artisan->password     = Hash::make($request->password);
        $artisan->save();

        Auth::guard('artisan')->login($artisan);
        return redirect()->route('front.home');
    }

    // ===========================
    // Register - Team
    // ===========================
    public function registerTeamPage()
    {
        $cities = City::orderBy('name')->get();
        return view('frontend.auth.register-team', compact('cities'));
    }

    public function registerTeam(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'team_name'   => 'required|string|min:3|max:100',
            'email'       => 'required|email|unique:teams,email',
            'city_id'     => 'required|exists:cities,id',
            'hourly_rate' => 'required|numeric|min:1',
            'bio'         => 'nullable|string|max:500',
            'password'    => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $team              = new Team();
        $team->team_name   = $request->team_name;
        $team->email       = $request->email;
        $team->city_id     = $request->city_id;
        $team->hourly_rate = $request->hourly_rate;
        $team->bio         = $request->bio;
        $team->password    = Hash::make($request->password);
        $team->status      = 'active';
        $team->save();

        Auth::guard('team')->login($team);
        return redirect()->route('front.home');
    }

    // ===========================
    // Logout
    // ===========================
    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        Auth::guard('artisan')->logout();
        Auth::guard('team')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('front.login');
    }
}
