<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use App\Models\Artisan;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Product;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FrontController extends Controller
{
    public function home()
    {
       $featuredProducts = Product::with(['category', 'artisan', 'images'])
    ->where('status', 'available')
    ->latest()->take(4)->get();

$categories = Category::withCount(['products' => function($q) {
    $q->where('status', 'available');
}])->get();

        return view('frontend.home', compact('featuredProducts', 'categories'));
    }
    public function products(Request $request)
{
    $products = Product::with(['category', 'artisan'])
        ->where('status', 'available')
->when($request->category, fn($q) => $q->whereIn('category_id', (array) $request->category))
        ->when($request->sort == 'price_asc', fn($q) => $q->orderBy('price', 'asc'))
->when($request->sort == 'price_desc', fn($q) => $q->orderBy('price', 'desc'))
->when(!$request->sort, fn($q) => $q->latest())
->when($request->max_price, fn($q) => $q->where('price', '<=', $request->max_price))
        ->paginate(12);

    $categories = Category::all();

    return view('frontend.products.index', compact('products', 'categories'));
}

public function productShow($id)
{
    $product = Product::with(['images', 'category', 'artisan', 'reviews'])->findOrFail($id);

    $isWishlisted = false;
    if (auth('customer')->check()) {
        $isWishlisted = auth('customer')->user()
            ->wishlists()
            ->where('product_id', $id)
            ->exists();
    }

    return view('frontend.products.show', compact('product', 'isWishlisted'));
}





public function teams()
{
    $teams = Team::with('city')
        ->where('status', 'active')
        ->latest()
        ->paginate(9);

    return view('frontend.teams.index', compact('teams'));
}

public function teamShow($id)
{
    $team = Team::with(['city', 'bookings'])
        ->findOrFail($id);

    return view('frontend.teams.show', compact('team'));
}


public function storeFront(Request $request)
{
    // تحقق إن الكستومر logged in
    if (!Auth::guard('customer')->check()) {
        return response()->json([
            'icon'  => 'error',
            'title' => 'Please login first to book a team',
        ], 401);
    }

    $validator = Validator::make($request->all(), [
        'team_id'      => 'required|integer|exists:teams,id',
        'booking_date' => 'required|date|after:today',
        'notes'        => 'nullable|string',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'icon'  => 'error',
            'title' => $validator->getMessageBag()->first(),
        ], 400);
    }

    // تحقق إن الفرقة مش محجوزة بنفس التاريخ
    $exists = Booking::where('team_id', $request->team_id)
                     ->where('booking_date', $request->booking_date)
                     ->where('status', '!=', 'cancelled')
                     ->exists();

    if ($exists) {
        return response()->json([
            'icon'  => 'error',
            'title' => 'This team is already booked on this date',
        ], 400);
    }

    $booking               = new Booking();
    $booking->team_id      = $request->team_id;
    $booking->customer_id  = Auth::guard('customer')->id();
    $booking->booking_date = $request->booking_date;
    $booking->status       = 'pending';
    $booking->notes        = $request->notes;
    $booking->save();

    // إشعار للكستومر
    NotificationController::send(
        Auth::guard('customer')->user(),
        'Booking Confirmed',
        'Your booking has been submitted successfully!'
    );

    // إشعار للفرقة
    $team = Team::find($request->team_id);
    NotificationController::send(
        $team,
        'New Booking',
        'You have a new booking on ' . $request->booking_date
    );

    return response()->json([
        'icon'    => 'success',
        'title'   => 'Booking submitted successfully!',
        'redirect' => route('front.home'),
    ], 200);
}

public function profile()
{
    /** @var \App\Models\Customer $customer */
    $customer = Auth::guard('customer')->user();

    $customer->load(['orders', 'bookings', 'wishlists']);

    return view('frontend.profile.index', compact('customer'));
}

public function wishlist()
{
    $customer = auth('customer')->user();
    $wishlists = $customer->wishlists()->with('product.images')->get();

    return view('frontend.profile.wishlist', compact('customer', 'wishlists'));
}

public function removeWishlist($id)
{
    $customer = auth('customer')->user();
    $customer->wishlists()->where('id', $id)->delete();

    return back()->with('success', 'Removed from wishlist!');
}


public function bookings()
{
    $customer = auth('customer')->user();
    $bookings = $customer->bookings()->with('team')->latest()->get();

    return view('frontend.profile.bookings', compact('customer', 'bookings'));
}

public function orders()
{
    $customer = auth('customer')->user();
    $orders = $customer->orders()->with('orderItems.product.images')->latest()->get();

    return view('frontend.profile.orders', compact('customer', 'orders'));
}

public function toggleWishlist(Request $request)
{
    $customer = auth('customer')->user();
    $existing = $customer->wishlists()->where('product_id', $request->product_id)->first();

    if ($existing) {
        $existing->delete();
    } else {
        $customer->wishlists()->create(['product_id' => $request->product_id]);
    }

    return back();
}

public function artisans()
{
    $artisans = Artisan::withCount(['products', 'reviews'])->get();
    return view('frontend.artisans.index', compact('artisans'));
}

public function artisanShow($id)
{
    $artisan = Artisan::with(['products.images', 'reviews'])->findOrFail($id);
    return view('frontend.artisans.show', compact('artisan'));
}

public function about()
{
    $admins = \App\Models\Admin::all();
    return view('frontend.about', compact('admins'));
}

public function contact()
{
    return view('frontend.contact');
}


}
