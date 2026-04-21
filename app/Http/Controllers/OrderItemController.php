<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\NotificationController;

class OrderItemController extends Controller
{
    public function index()
    {
       $items = OrderItem::with(['order', 'product' => function($query) {
            $query->withTrashed(); // لضمان عدم حدوث خطأ null إذا حُذف المنتج
        }])
        ->orderBy('id', 'desc')
        ->simplePaginate(10);

    return response()->view('cms.order_item.index', compact('items'));
    }

    public function create()
    {


        $orders   = Order::has('customer')->with('customer')->orderBy('id', 'desc')->get();
        $products = Product::where('status', 'available')->orderBy('id', 'desc')->get();

        return response()->view('cms.order_item.create', compact('orders', 'products'));
    }


    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'order_id'   => 'required|integer|exists:orders,id',
        'product_id' => 'required|integer|exists:products,id',
        'quantity'   => 'required|integer|min:1',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'icon'  => 'error',
            'title' => $validator->getMessageBag()->first(),
        ], 400);
    }

    $product = Product::findOrFail($request->product_id);

    $item             = new OrderItem();
    $item->order_id   = $request->order_id;
    $item->product_id = $request->product_id;
    $item->quantity   = $request->quantity;
    $item->price      = $product->price;
    $isSaved = $item->save();

    if ($isSaved) {
        $this->recalculateTotal($request->order_id);

        // ✅ إشعار للأرتيزن
        NotificationController::send(
            $product->artisan,
            'New Order',
            'Your product ' . $product->name . ' has been ordered!'
        );

        // ✅ تحقق من الستوك
        if ($product->stock_quantity <= 5) {
            NotificationController::send(
                $product->artisan,
                'Low Stock Alert',
                'Product ' . $product->name . ' is running low on stock!'
            );
        }

        return response()->json([
            'icon'  => 'success',
            'title' => 'Item added successfully',
        ], 200);
    }

    return response()->json([
        'icon'  => 'error',
        'title' => 'Something went wrong',
    ], 500);
}

    public function restore($id)
{
    $item = OrderItem::onlyTrashed()->findOrFail($id);
    $orderId = $item->order_id;

    // ✅ استرجع الأوردر لو كان محذوف
    $order = Order::withTrashed()->find($orderId);
    if ($order && $order->trashed()) {
        $order->restore();
    }

    $item->restore();

    // أعد حساب الـ total
    $total = OrderItem::where('order_id', $orderId)
                      ->sum(DB::raw('price * quantity'));
    Order::where('id', $orderId)->update(['total_price' => $total]);

    return back()->with('success', 'Restored Successfully');
}

    public function show($id)
    {
        $item = OrderItem::with(['order', 'product'])->findOrFail($id);
        return response()->view('cms.order_item.show', compact('item'));
    }

 public function edit($id)
{
    $item     = OrderItem::findOrFail($id);
    $orders   = Order::has('customer')->with('customer')->orderBy('id', 'desc')->get();

    // ✅ اضف withTrashed + orWhere للمنتج الحالي
    $products = Product::where('status', 'available')
                       ->withTrashed()
                       ->get();

    return response()->view('cms.order_item.edit', compact('item', 'orders', 'products'));
}

  public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'order_id'   => 'required|integer|exists:orders,id',
        'product_id' => 'required|integer|exists:products,id',
        'quantity'   => 'required|integer|min:1',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'icon'  => 'error',
            'title' => $validator->getMessageBag()->first(),
        ], 400);
    }

    $product = Product::findOrFail($request->product_id);

    $item = OrderItem::findOrFail($id);

    $oldOrderId = $item->order_id; // ← احفظ الأوردر القديم قبل التعديل

    $item->order_id   = $request->order_id;
    $item->product_id = $request->product_id;
    $item->quantity   = $request->quantity;
    $item->price      = $product->price;
    $item->save();


    $this->recalculateTotal($oldOrderId);
    if ($oldOrderId !== $request->order_id) {
        $this->recalculateTotal($request->order_id); //   لو تغير الأوردر
    }

    return response()->json([
        'icon'     => 'success',
        'title'    => 'Updated Successfully',
       'redirect' => route('order-items.index'),
    ], 200);
}
    public function destroy($id)
    {
        $item = OrderItem::findOrFail($id);
        $orderId = $item->order_id;
        $item->delete();

        $this->recalculateTotal($orderId);

        return response()->json([
            'icon'  => 'success',
            'title' => 'Deleted Successfully',
        ], 200);
    }

    // دالة لإعادة حساب الـ total_price
    private function recalculateTotal($orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->total_price = $order->orderItems()->sum(DB::raw('price * quantity'));
        $order->save();


    }

    public function trashed()
{
    $orderItems = OrderItem::with(['order', 'product' => function($query) {
        $query->withTrashed();
    }])
    ->onlyTrashed()
    ->orderBy('deleted_at', 'desc')
    ->get();

    return response()->view('cms.order_item.trashed', compact('orderItems'));
}


public function force($id)
{
    OrderItem::onlyTrashed()->findOrFail($id)->forceDelete();
    return back()->with('success', 'Deleted Successfully');
}

public function forceAll()
{
    OrderItem::onlyTrashed()->forceDelete();
    return back()->with('success', 'All Deleted Successfully');
}
}



