<?php
namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // عرض الكارت
    public function index()
    {
        $customer = auth('customer')->user();
        $cartItems = $customer->carts()->with('product.images')->get();
        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        return view('frontend.cart.index', compact('customer', 'cartItems', 'total'));
    }

    // إضافة للكارت
    public function add(Request $request)
    {
        $customer = auth('customer')->user();
        if (!$customer) return redirect()->route('front.login');

        $cart = Cart::where('customer_id', $customer->id)
                    ->where('product_id', $request->product_id)
                    ->first();

        if ($cart) {
            $cart->increment('quantity', $request->quantity ?? 1);
        } else {
            Cart::create([
                'customer_id' => $customer->id,
                'product_id'  => $request->product_id,
                'quantity'    => $request->quantity ?? 1,
            ]);
        }

        return back()->with('success', 'Added to cart!');
    }

    // تعديل الكمية
    public function update(Request $request, $id)
    {
        $customer = auth('customer')->user();
        $cart = Cart::where('id', $id)->where('customer_id', $customer->id)->firstOrFail();

        if ($request->quantity < 1) {
            $cart->delete();
        } else {
            $cart->update(['quantity' => $request->quantity]);
        }

        return back();
    }

    // حذف من الكارت
    public function remove($id)
    {
        $customer = auth('customer')->user();
        Cart::where('id', $id)->where('customer_id', $customer->id)->delete();
        return back()->with('success', 'Removed from cart!');
    }

public function checkout()
{
    $customer = auth('customer')->user();
    $cartItems = $customer->carts()->with('product')->get();

    if ($cartItems->isEmpty()) {
        return back()->with('error', 'Your cart is empty!');
    }

    $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

    // إنشاء الأوردر
    $order = \App\Models\Order::create([
        'customer_id'  => $customer->id,
        'total_price'  => $total,
        'order_status' => 'pending',
        'address_id'   => null, // بتعدليها لاحقاً إذا عندك عنوان
    ]);

    // إنشاء الأوردر آيتمز
    foreach ($cartItems as $item) {
        $order->orderItems()->create([
            'product_id' => $item->product_id,
            'quantity'   => $item->quantity,
            'price'      => $item->product->price,
        ]);
    }

    // مسح الكارت
    $customer->carts()->delete();

    return redirect()->route('front.orders')->with('success', 'Order placed successfully!');
}

}
