<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class OrderItemController extends Controller
{
    public function index()
    {
        $items = OrderItem::with(['order', 'product'])
            ->orderBy('id', 'desc')
            ->simplePaginate(10);
        return response()->view('cms.order_item.index', compact('items'));
    }

    public function create()
    {
        $orders   = Order::all();
        $products = Product::where('status', 'available')->get();
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

        // تحديث الـ total_price في الأوردر
        if ($isSaved) {
            $this->recalculateTotal($request->order_id);
            return response()->json([
                'icon'  => 'success',
                'title' => 'Item added successfully',
            ], 200);
        } else {
            return response()->json([
                'icon'  => 'error',
                'title' => 'Something went wrong',
            ], 500);
        }
    }

    public function show($id)
    {
        $item = OrderItem::with(['order', 'product'])->findOrFail($id);
        return response()->view('cms.order_item.show', compact('item'));
    }

    public function edit($id)
    {
        $item     = OrderItem::findOrFail($id);
        $orders   = Order::all();
        $products = Product::where('status', 'available')->get();
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

        $item             = OrderItem::findOrFail($id);
        $item->order_id   = $request->order_id;
        $item->product_id = $request->product_id;
        $item->quantity   = $request->quantity;
        $item->price      = $product->price;
        $item->save();

        $this->recalculateTotal($request->order_id);

        return response()->json([
            'icon'     => 'success',
            'title'    => 'Updated Successfully',
            'redirect' => route('order_item.index'),
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
}
