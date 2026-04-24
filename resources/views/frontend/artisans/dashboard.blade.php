@extends('frontend.layout.app')
@section('title', 'My Dashboard')

@section('styles')
<style>
    .dash-page { max-width: 1100px; margin: 0 auto; padding: 2rem; }

    /* Header */
    .dash-header { background:#fff; border:1px solid #eee; border-radius:16px; padding:1.5rem 2rem; margin-bottom:1.5rem; display:flex; align-items:center; gap:1rem; }
    .dash-av { width:64px; height:64px; border-radius:50%; background:#E1F5EE; display:flex; align-items:center; justify-content:center; font-size:26px; font-weight:700; color:#2D6A4F; flex-shrink:0; }
    .dash-name { font-size:22px; font-weight:700; color:#1A1A2E; }
    .dash-store { font-size:13px; color:#aaa; margin-top:4px; }

    /* Stats */
    .stats-row { display:grid; grid-template-columns:repeat(3,1fr); gap:1.5rem; margin-bottom:1.5rem; }
    .stat-card { background:#fff; border:1px solid #eee; border-radius:16px; padding:1.5rem; text-align:center; }
    .stat-num { font-size:36px; font-weight:700; }
    .stat-num.green  { color:#2D6A4F; }
    .stat-num.blue   { color:#3498db; }
    .stat-num.yellow { color:#F4A261; }
    .stat-label { font-size:13px; color:#aaa; margin-top:6px; }

    /* Tabs */
    .tabs { display:flex; gap:.5rem; margin-bottom:1.5rem; border-bottom:2px solid #eee; }
    .tab-btn { padding:10px 20px; font-size:14px; font-weight:600; color:#888; background:none; border:none; cursor:pointer; border-bottom:2px solid transparent; margin-bottom:-2px; }
    .tab-btn.active { color:#2D6A4F; border-bottom-color:#2D6A4F; }
    .tab-content { display:none; }
    .tab-content.active { display:block; }

    /* Card */
    .dash-card { background:#fff; border:1px solid #eee; border-radius:16px; padding:1.5rem; margin-bottom:1.5rem; }
    .dash-card-title { font-size:16px; font-weight:700; margin-bottom:1.25rem; padding-bottom:.75rem; border-bottom:1px solid #eee; display:flex; justify-content:space-between; align-items:center; }

    /* Add Product Form */
    .add-form { background:#F8F6F2; border-radius:12px; padding:1.25rem; margin-bottom:1.5rem; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1rem; }
    .form-group { display:flex; flex-direction:column; gap:4px; }
    .form-group.full { grid-column:1/-1; }
    .form-group label { font-size:12px; font-weight:600; color:#555; }
    .form-group input,
    .form-group select,
    .form-group textarea { padding:9px 12px; border:1px solid #ddd; border-radius:8px; font-size:13px; outline:none; background:#fff; }
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus { border-color:#2D6A4F; }
    .btn-add { background:#2D6A4F; color:#fff; border:none; padding:10px 24px; border-radius:50px; font-size:13px; font-weight:600; cursor:pointer; }
    .btn-add:hover { background:#245c43; }
    .btn-toggle { background:#E1F5EE; color:#2D6A4F; border:none; padding:8px 18px; border-radius:50px; font-size:13px; font-weight:600; cursor:pointer; }

    /* Products Grid */
    .products-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:1rem; }
    .prod-item { border:1px solid #eee; border-radius:12px; overflow:hidden; transition:box-shadow .2s; }
    .prod-item:hover { box-shadow:0 4px 16px rgba(0,0,0,0.07); }
    .prod-img { height:140px; background:#F8F6F2; overflow:hidden; display:flex; align-items:center; justify-content:center; }
    .prod-img img { width:100%; height:100%; object-fit:cover; }
    .prod-body { padding:.875rem; }
    .prod-name { font-size:13px; font-weight:600; color:#1A1A2E; margin-bottom:4px; }
    .prod-price { font-size:14px; font-weight:700; color:#2D6A4F; }
    .prod-footer { padding:.5rem .875rem .875rem; display:flex; justify-content:space-between; align-items:center; }
    .prod-stock { font-size:11px; color:#aaa; }
    .btn-del { background:none; border:1px solid #fca5a5; color:#e74c3c; padding:4px 12px; border-radius:50px; font-size:12px; cursor:pointer; }
    .btn-del:hover { background:#fef2f2; }

    /* Table */
    .dash-table { width:100%; border-collapse:collapse; font-size:13px; }
    .dash-table th { text-align:left; padding:10px 12px; border-bottom:2px solid #eee; font-size:12px; color:#aaa; font-weight:600; }
    .dash-table td { padding:10px 12px; border-bottom:1px solid #f5f5f5; color:#444; vertical-align:top; }

    /* Badges */
    .badge { display:inline-block; padding:3px 10px; border-radius:50px; font-size:11px; font-weight:600; }
    .badge-pending   { background:#FFF3CD; color:#856404; }
    .badge-confirmed { background:#D1FAE5; color:#065F46; }
    .badge-completed { background:#D1FAE5; color:#065F46; }
    .badge-cancelled { background:#FEE2E2; color:#991B1B; }

    /* Reviews */
    .review-card { border:1px solid #f5f5f5; border-radius:10px; padding:1rem; margin-bottom:.75rem; }
    .review-header { display:flex; align-items:center; gap:10px; margin-bottom:6px; }
    .review-av { width:34px; height:34px; border-radius:50%; background:#E1F5EE; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; color:#2D6A4F; }
    .review-name { font-size:13px; font-weight:600; }
    .review-date { font-size:11px; color:#aaa; }
    .review-stars { font-size:13px; color:#F4A261; margin-bottom:4px; }
    .review-text { font-size:13px; color:#666; line-height:1.6; }

    /* Empty */
    .empty-msg { text-align:center; padding:2.5rem; color:#aaa; font-size:13px; }
    .empty-msg i { font-size:36px; color:#ddd; display:block; margin-bottom:.5rem; }

    /* Alerts */
    .alert-success { background:#D1FAE5; border:1px solid #6EE7B7; color:#065F46; padding:10px 16px; border-radius:10px; margin-bottom:1rem; font-size:13px; }
    .alert-error   { background:#FEE2E2; border:1px solid #FCA5A5; color:#991B1B; padding:10px 16px; border-radius:10px; margin-bottom:1rem; font-size:13px; }
</style>
@endsection

@section('content')
<div class="dash-page">

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert-error">
            @foreach($errors->all() as $e)<p style="margin:0">{{ $e }}</p>@endforeach
        </div>
    @endif

    {{-- Header --}}
    <div class="dash-header">
        <div class="dash-av">{{ strtoupper(substr($artisan->artisan_name, 0, 1)) }}</div>
        <div>
            <div class="dash-name">{{ $artisan->artisan_name }}</div>
            <div class="dash-store">
                <i class="fas fa-store" style="color:#2D6A4F;font-size:11px;"></i>
                {{ $artisan->store_name ?? 'My Store' }}
            </div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-num green">{{ $artisan->products->count() }}</div>
            <div class="stat-label"><i class="fas fa-box"></i> My Products</div>
        </div>
        <div class="stat-card">
            <div class="stat-num blue">{{ $orders->count() }}</div>
            <div class="stat-label"><i class="fas fa-shopping-bag"></i> Orders</div>
        </div>
        <div class="stat-card">
            <div class="stat-num yellow">{{ $artisan->reviews->count() }}</div>
            <div class="stat-label"><i class="fas fa-star"></i> Reviews</div>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="tabs">
        <button class="tab-btn active" onclick="switchTab('products', event)">
            <i class="fas fa-box"></i> My Products
        </button>
        <button class="tab-btn" onclick="switchTab('orders', event)">
            <i class="fas fa-shopping-bag"></i> Orders
        </button>
        <button class="tab-btn" onclick="switchTab('reviews', event)">
            <i class="fas fa-star"></i> Reviews
        </button>
    </div>

    {{-- ===== Tab: Products ===== --}}
    <div id="tab-products" class="tab-content active">
        <div class="dash-card">
            <div class="dash-card-title">
                <span>My Products ({{ $artisan->products->count() }})</span>
                <button class="btn-toggle" onclick="toggleForm()">
                    <i class="fas fa-plus"></i> Add Product
                </button>
            </div>

            {{-- Add Product Form --}}
            <div class="add-form" id="addForm" style="display:none;">
                <form method="POST" action="{{ route('artisan.products.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label>Product Name *</label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Handmade Vase" required>
                        </div>
                        <div class="form-group">
                            <label>Price ($) *</label>
                            <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0" placeholder="0.00" required>
                        </div>
                        <div class="form-group">
                            <label>Stock Quantity *</label>
                            <input type="number" name="stock_quantity" value="{{ old('stock_quantity', 1) }}" min="0" required>
                        </div>
                        <div class="form-group">
                            <label>Category *</label>
                            <select name="category_id" required>
                                <option value="">-- Select Category --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group full">
                            <label>Description</label>
                            <textarea name="description" rows="3" placeholder="Describe your product...">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group full">
                            <label>Product Images (first image = primary)</label>
                            <input type="file" name="images[]" multiple accept="image/*">
                        </div>
                    </div>
                    <button type="submit" class="btn-add">
                        <i class="fas fa-plus"></i> Add Product
                    </button>
                </form>
            </div>

            {{-- Products List --}}
            @if($artisan->products->isEmpty())
                <div class="empty-msg">
                    <i class="fas fa-box-open"></i>
                    No products yet. Add your first product!
                </div>
            @else
                <div class="products-grid">
                    @foreach($artisan->products as $product)
                    <div class="prod-item">
                        <div class="prod-img">
                            @if($product->images && $product->images->first())
                                <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                                     alt="{{ $product->name }}">
                            @else
                                <i class="fas fa-image" style="font-size:32px;color:#ddd;"></i>
                            @endif
                        </div>
                        <div class="prod-body">
                            <div class="prod-name">{{ $product->name }}</div>
                            <div class="prod-price">${{ number_format($product->price, 2) }}</div>
                        </div>
                        <div class="prod-footer">
                            <span class="prod-stock">Stock: {{ $product->stock_quantity }}</span>
                            <form method="POST"
                                  action="{{ route('artisan.products.destroy', $product->id) }}"
                                  onsubmit="return confirm('Delete this product?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-del">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- ===== Tab: Orders ===== --}}
    <div id="tab-orders" class="tab-content">
        <div class="dash-card">
            <div class="dash-card-title">Orders ({{ $orders->count() }})</div>

            @if($orders->isEmpty())
                <div class="empty-msg">
                    <i class="fas fa-shopping-bag"></i>
                    No orders yet.
                </div>
            @else
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->customer->name ?? '—' }}</td>
                            <td>
                                @foreach($order->orderItems->filter(fn($i) => $i->product && $i->product->artisan_id == $artisan->id) as $item)
                                    <div style="font-size:12px;color:#555;">
                                        {{ $item->product->name }}
                                        <span style="color:#2D6A4F;">× {{ $item->quantity }}</span>
                                    </div>
                                @endforeach
                            </td>
                            <td style="font-weight:600;color:#2D6A4F;">${{ number_format($order->total_price, 2) }}</td>
                            <td>
                                <span class="badge badge-{{ $order->order_status ?? 'pending' }}">
                                    {{ ucfirst($order->order_status ?? 'pending') }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    {{-- ===== Tab: Reviews ===== --}}
    <div id="tab-reviews" class="tab-content">
        <div class="dash-card">
            <div class="dash-card-title">Reviews ({{ $artisan->reviews->count() }})</div>

            @if($artisan->reviews->isEmpty())
                <div class="empty-msg">
                    <i class="fas fa-star"></i>
                    No reviews yet.
                </div>
            @else
                @foreach($artisan->reviews as $review)
                <div class="review-card">
                    <div class="review-header">
                        <div class="review-av">
                            {{ strtoupper(substr($review->reviewer_name ?? 'U', 0, 2)) }}
                        </div>
                        <div>
                            <div class="review-name">{{ $review->reviewer_name ?? 'Customer' }}</div>
                            <div class="review-date">{{ $review->created_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                    <div class="review-stars">
                        @for($i = 1; $i <= 5; $i++)
                            {{ $i <= $review->rating ? '★' : '☆' }}
                        @endfor
                    </div>
                    <div class="review-text">{{ $review->comment }}</div>
                </div>
                @endforeach
            @endif
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
function switchTab(name, e) {
    document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + name).classList.add('active');
    e.currentTarget.classList.add('active');
}

function toggleForm() {
    let f = document.getElementById('addForm');
    f.style.display = f.style.display === 'none' ? 'block' : 'none';
}
</script>
@endsection
