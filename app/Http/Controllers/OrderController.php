<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['customer', 'address', 'orderItems'])
            ->orderBy('id', 'desc')
            ->simplePaginate(10);
        return response()->view('cms.order.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::all();
        $addresses = Address::all();
        $products  = Product::where('status', 'available')->get();
        return response()->view('cms.order.create', compact('customers', 'addresses', 'products'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id'        => 'required|integer|exists:customers,id',
            'address_id'         => 'required|integer|exists:addresses,id',
            'order_status'       => 'required|in:pending,processing,shipped,delivered,cancelled',
            'items'              => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'icon'  => 'error',
                'title' => $validator->getMessageBag()->first(),
            ], 400);
        }

        DB::beginTransaction();
        try {
            $total = 0;
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $total  += $product->price * $item['quantity'];
            }

            $order               = new Order();
            $order->customer_id  = $request->customer_id;
            $order->address_id   = $request->address_id;
            $order->order_status = $request->order_status;
            $order->total_price  = $total;
            $order->save();

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity'   => $item['quantity'],
                    'price'      => $product->price,
                ]);
            }

            DB::commit();
            return response()->json([
                'icon'  => 'success',
                'title' => 'Order created successfully',
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'icon'  => 'error',
                'title' => 'Something went wrong',
            ], 500);
        }
    }

    public function show($id)
    {
        $order = Order::with([
            'customer',
            'address',
            'orderItems' => function($query) {
                $query->with(['product' => function($q) {
                    $q->withTrashed();
                }]);
            }
        ])->findOrFail($id);
        return response()->view('cms.order.show', compact('order'));
    }

    public function edit($id)
    {
        $order     = Order::with('orderItems')->findOrFail($id);
        $customers = Customer::all();
        $addresses = Address::all();
        $products  = Product::where('status', 'available')->get();
        return response()->view('cms.order.edit', compact('order', 'customers', 'addresses', 'products'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'customer_id'        => 'required|integer|exists:customers,id',
            'address_id'         => 'required|integer|exists:addresses,id',
            'order_status'       => 'required|in:pending,processing,shipped,delivered,cancelled',
            'items'              => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'icon'  => 'error',
                'title' => $validator->getMessageBag()->first(),
            ], 400);
        }

        DB::beginTransaction();
        try {
            $order = Order::findOrFail($id);

            $total = 0;
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $total  += $product->price * $item['quantity'];
            }

            $order->customer_id  = $request->customer_id;
            $order->address_id   = $request->address_id;
            $order->order_status = $request->order_status;
            $order->total_price  = $total;
            $order->save();

            $order->orderItems()->delete();
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity'   => $item['quantity'],
                    'price'      => $product->price,
                ]);
            }

            DB::commit();
            return response()->json([
                'icon'     => 'success',
                'title'    => 'Updated Successfully',
                'redirect' => route('orders.index'),
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'icon'  => 'error',
                'title' => 'Something went wrong',
            ], 500);
        }
    }

  public function destroy($id)
{
    // أول شي احذفي الـ items قبل الـ order
    OrderItem::where('order_id', $id)->delete();

    // ثم احذفي الـ order
    Order::findOrFail($id)->delete();

    return response()->json([
        'icon'  => 'success',
        'title' => 'Deleted Successfully',
    ], 200);
}

    public function trashed()
    {
        $orders = Order::with(['customer'])
            ->onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->get();
        return response()->view('cms.order.trashed', compact('orders'));
    }

    public function restore($id)
    {
        $order = Order::onlyTrashed()->findOrFail($id);
        OrderItem::onlyTrashed()->where('order_id', $id)->restore();
        $order->restore();
        return back()->with('success', 'Restored Successfully');
    }

    public function force($id)
    {
        $order = Order::onlyTrashed()->findOrFail($id);
        OrderItem::onlyTrashed()->where('order_id', $id)->forceDelete();
        $order->forceDelete();
        return back()->with('success', 'Deleted Successfully');
    }

    public function forceAll()
    {
        $orders = Order::onlyTrashed()->get();
        foreach ($orders as $order) {
            OrderItem::onlyTrashed()->where('order_id', $order->id)->forceDelete();
            $order->forceDelete();
        }
        return back()->with('success', 'All Deleted Successfully');
    }
}
