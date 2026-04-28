<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdminController;
//use App\Http\Controllers\ArtisanAuthController;
use App\Http\Controllers\ArtisanController;
use App\Http\Controllers\ArtisanDashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontAuthController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\NotificationFrontController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TeamDashboardController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

// ===========================
// FRONTEND - Public Routes
// ===========================
Route::get('/', [FrontController::class, 'home'])->name('front.home');
Route::get('/products', [FrontController::class, 'products'])->name('front.products');
Route::get('/products/{id}', [FrontController::class, 'productShow'])->name('front.product.show');
Route::get('/teams', [FrontController::class, 'teams'])->name('front.teams');
Route::get('/teams/{id}', [FrontController::class, 'teamShow'])->name('front.team.show');
Route::get('/artisans', [FrontController::class, 'artisans'])->name('front.artisans');
Route::get('/artisans/{id}', [FrontController::class, 'artisanShow'])->name('front.artisan.show');
Route::get('/about', [FrontController::class, 'about'])->name('front.about');
Route::get('/contact', [FrontController::class, 'contact'])->name('front.contact');
Route::post('/bookings', [BookingController::class, 'storeFront'])->name('front.booking.store');
Route::get('/search', [FrontController::class, 'search'])->name('front.search');

// ===========================
// FRONTEND - Auth Routes (Guest Only)
// ===========================
Route::middleware('guest:customer,artisan,team,admin')->group(function () {

    Route::get('/login', [FrontAuthController::class, 'loginPage'])->name('front.login');
    Route::post('/login', [FrontAuthController::class, 'login'])->name('front.login.post');

    // Select type
    Route::get('/register/select-type', function () {
        return view('frontend.auth.select-type');
    })->name('front.register.select');

    // Redirect حسب النوع
    Route::get('/register', [FrontAuthController::class, 'registerPage'])->name('front.register');

    // Customer
    Route::get('/register/customer', [FrontAuthController::class, 'registerCustomerPage'])->name('front.register.customer');
    Route::post('/register/customer', [FrontAuthController::class, 'register'])->name('front.register.post');

    // Artisan
    Route::get('/register/artisan', [FrontAuthController::class, 'registerArtisanPage'])->name('front.register.artisan');
    Route::post('/register/artisan', [FrontAuthController::class, 'registerArtisan'])->name('front.register.artisan.post');

    // Team
    Route::get('/register/team', [FrontAuthController::class, 'registerTeamPage'])->name('front.register.team');
    Route::post('/register/team', [FrontAuthController::class, 'registerTeam'])->name('front.register.team.post');

});

Route::post('/logout', [FrontAuthController::class, 'logout'])->name('front.logout');

// ===========================
// FRONTEND - Customer Protected Routes
// ===========================
Route::middleware('auth:customer')->group(function () {
    Route::get('/profile', [FrontController::class, 'profile'])->name('front.profile');
    Route::get('/profile/wishlist', [FrontController::class, 'wishlist'])->name('front.wishlist');
    Route::delete('/profile/wishlist/{id}', [FrontController::class, 'removeWishlist'])->name('front.wishlist.remove');
    Route::post('/profile/wishlist/toggle', [FrontController::class, 'toggleWishlist'])->name('front.wishlist.toggle');
    Route::get('/profile/bookings', [FrontController::class, 'bookings'])->name('front.bookings');
    Route::get('/profile/orders', [FrontController::class, 'orders'])->name('front.orders');
    Route::get('/cart', [CartController::class, 'index'])->name('front.cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('front.cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('front.cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('front.cart.remove');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('front.checkout');
    Route::post('/contact', [FrontController::class, 'contactSend'])->name('front.contact.send');
Route::post('/review', [FrontController::class, 'addReview'])->name('review.add');
});
Route::post('/artisan/review', [FrontController::class, 'addArtisanReview'])
    ->name('artisan.review.add');
// ===========================
// FRONTEND - Notifications
// ===========================
Route::middleware('auth:customer,artisan,team')->group(function () {
    Route::post('/notifications/mark-all-read', [NotificationFrontController::class, 'markAllRead'])
        ->name('notifications.markAllRead');
    Route::post('/notifications/{id}/read', [NotificationFrontController::class, 'markRead'])
        ->name('notifications.markRead');
    Route::get('/notifications', [NotificationFrontController::class, 'index'])
        ->name('notifications.index');
});

// ===========================
// Artisan Dashboard Routes
// ===========================
Route::middleware('auth:artisan')->prefix('artisan')->group(function () {
    Route::get('dashboard', [ArtisanDashboardController::class, 'index'])->name('artisan.dashboard');
    Route::post('products', [ArtisanDashboardController::class, 'storeProduct'])->name('artisan.products.store');
    Route::delete('products/{id}', [ArtisanDashboardController::class, 'destroyProduct'])->name('artisan.products.destroy');
});

// ===========================
// Team Dashboard Routes
// ===========================
Route::middleware('auth:team')->prefix('team')->group(function () {
    Route::get('dashboard', [TeamDashboardController::class, 'index'])->name('team.dashboard');
});

// ===========================
// CMS - Login (Guest Only)
// ===========================
Route::middleware('guest:admin,artisan,team,customer')->group(function () {
    Route::get('cms/login', [UserAuthController::class, 'showLogin'])->name('view.login');
    Route::post('cms/login', [UserAuthController::class, 'login'])->name('home.login');
});

Route::get('cms/logout', [UserAuthController::class, 'logout'])->name('logout');



// ===========================
// CMS - Admin Panel (Admin & Team Only)
// ===========================
Route::prefix('cms/Admin')->middleware('auth:admin,team')->group(function () {

    Route::view('temp', 'cms.temp');

    // Artisans
    Route::get('artisans/create', [ArtisanController::class, 'create'])->name('artisans.create');
    Route::post('artisans', [ArtisanController::class, 'store'])->name('artisans.store');
    Route::get('artisans_trashed', [ArtisanController::class, 'trashed'])->name('artisans_trashed');
    Route::get('artisans_restore/{id}', [ArtisanController::class, 'restore'])->name('artisans_restore');
    Route::get('artisans_force/{id}', [ArtisanController::class, 'force'])->name('artisans_force');
    Route::get('artisans_force_all', [ArtisanController::class, 'forceAll'])->name('artisans_forceAll');
    Route::get('artisans/{id}/edit', [ArtisanController::class, 'edit'])->name('artisans.edit');
    Route::post('artisans-update/{id}', [ArtisanController::class, 'update'])->name('artisans-update');
    Route::delete('artisans/{id}', [ArtisanController::class, 'destroy'])->name('artisans.destroy');

    // Admins
    Route::post('admins-update/{id}', [AdminController::class, 'update'])->name('admins-update');
    Route::get('admins_trashed', [AdminController::class, 'trashed'])->name('admins_trashed');
    Route::get('admins_restore/{id}', [AdminController::class, 'restore'])->name('admins_restore');
    Route::get('admins_force/{id}', [AdminController::class, 'force'])->name('admins_force');
    Route::get('admins_force_all', [AdminController::class, 'forceAll'])->name('admins_forceAll');
    Route::resource('admins', AdminController::class);

    // Teams
    Route::get('teams/create', [TeamController::class, 'create'])->name('teams.create'); // ✅ أضف هاد قبل resource
    Route::post('teams-update/{id}', [TeamController::class, 'update'])->name('teams-update');
    Route::get('teams_trashed', [TeamController::class, 'trashed'])->name('teams_trashed');
    Route::get('teams_restore/{id}', [TeamController::class, 'restore'])->name('teams_restore');
    Route::get('teams_force/{id}', [TeamController::class, 'force'])->name('teams_force');
    Route::get('teams_force_all', [TeamController::class, 'forceAll'])->name('teams_forceAll');
    Route::resource('teams', TeamController::class)->except(['create']);
    Route::resource('teams', TeamController::class);

    // Countries
    Route::post('countries_update/{id}', [CountryController::class, 'update'])->name('countries_update');
    Route::get('countries_trashed', [CountryController::class, 'trashed'])->name('countries_trashed');
    Route::get('countries_restore/{id}', [CountryController::class, 'restore'])->name('countries_restore');
    Route::get('countries_force/{id}', [CountryController::class, 'force'])->name('countries_force');
    Route::get('countries_forceAll', [CountryController::class, 'forceAll'])->name('countries_forceAll');
    Route::resource('countries', CountryController::class);

    // Cities
    Route::post('cities_update/{id}', [CityController::class, 'update'])->name('cities_update');
    Route::get('cities_trashed', [CityController::class, 'trashed'])->name('cities_trashed');
    Route::get('cities_restore/{id}', [CityController::class, 'restore'])->name('cities_restore');
    Route::get('cities_force/{id}', [CityController::class, 'force'])->name('cities_force');
    Route::get('cities_forceAll', [CityController::class, 'forceAll'])->name('cities_forceAll');
    Route::get('cities-by-country/{id}', [CityController::class, 'byCountry'])->name('cities.byCountry');
    Route::resource('cities', CityController::class);

    // Categories
    Route::post('categories-update/{id}', [CategoryController::class, 'update'])->name('categories-update');
    Route::get('categories_trashed', [CategoryController::class, 'trashed'])->name('categories_trashed');
    Route::get('categories_restore/{id}', [CategoryController::class, 'restore'])->name('categories_restore');
    Route::get('categories_force/{id}', [CategoryController::class, 'force'])->name('categories_force');
    Route::get('categories_force_all', [CategoryController::class, 'forceAll'])->name('categories_forceAll');
    Route::resource('categories', CategoryController::class);

    // Customers
    Route::get('customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('customers/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::post('customers-update/{id}', [CustomerController::class, 'update'])->name('customers-update');
    Route::delete('customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    Route::get('customers_trashed', [CustomerController::class, 'trashed'])->name('customers_trashed');
    Route::get('customers_restore/{id}', [CustomerController::class, 'restore'])->name('customers_restore');
    Route::get('customers_force/{id}', [CustomerController::class, 'force'])->name('customers_force');
    Route::get('customers_force_all', [CustomerController::class, 'forceAll'])->name('customers_forceAll');

    // Addresses
    Route::post('addresses_update/{id}', [AddressController::class, 'update'])->name('addresses_update');
    Route::get('addresses_trashed', [AddressController::class, 'trashed'])->name('addresses_trashed');
    Route::get('addresses_restore/{id}', [AddressController::class, 'restore'])->name('addresses_restore');
    Route::get('addressesforce/{id}', [AddressController::class, 'force'])->name('addresses_force');
    Route::get('addresses_forceAll', [AddressController::class, 'forceAll'])->name('addresses_forceAll');
    Route::resource('addresses', AddressController::class);

    // Products
    Route::post('products_update/{id}', [ProductController::class, 'update'])->name('products_update');
    Route::get('products_trashed', [ProductController::class, 'trashed'])->name('products_trashed');
    Route::get('products_restore/{id}', [ProductController::class, 'restore'])->name('products_restore');
    Route::get('products_force/{id}', [ProductController::class, 'force'])->name('products_force');
    Route::get('products_forceAll', [ProductController::class, 'forceAll'])->name('products_forceAll');
    Route::resource('products', ProductController::class);

    // Orders
    Route::post('orders_update/{id}', [OrderController::class, 'update'])->name('orders_update');
    Route::get('orders_trashed', [OrderController::class, 'trashed'])->name('orders_trashed');
    Route::get('orders_restore/{id}', [OrderController::class, 'restore'])->name('orders_restore');
    Route::get('orders_force/{id}', [OrderController::class, 'force'])->name('orders_force');
    Route::get('orders_forceAll', [OrderController::class, 'forceAll'])->name('orders_forceAll');
    Route::resource('orders', OrderController::class);

    // Order Items
    Route::post('order-items_update/{id}', [OrderItemController::class, 'update'])->name('order-items_update');
    Route::get('order-items_trashed', [OrderItemController::class, 'trashed'])->name('order-items_trashed');
    Route::get('order-items_restore/{id}', [OrderItemController::class, 'restore'])->name('order-items_restore');
    Route::get('order-items_force/{id}', [OrderItemController::class, 'force'])->name('order-items_force');
    Route::get('order-items_forceAll', [OrderItemController::class, 'forceAll'])->name('order-items_forceAll');
    Route::resource('order-items', OrderItemController::class);

    // Notifications
    Route::post('notifications-update/{id}', [NotificationController::class, 'update'])->name('notifications-update');
    Route::get('notifications_trashed', [NotificationController::class, 'trashed'])->name('notifications_trashed');
    Route::get('notifications_restore/{id}', [NotificationController::class, 'restore'])->name('notifications_restore');
    Route::get('notifications_force/{id}', [NotificationController::class, 'force'])->name('notifications_force');
    Route::get('notifications_force_all', [NotificationController::class, 'forceAll'])->name('notifications_forceAll');
    Route::get('notifications-recipients/{type}', [NotificationController::class, 'recipients'])->name('notifications.recipients');
    Route::resource('notifications', NotificationController::class);

    // Product Images
    Route::post('product-images_update/{id}', [ProductImageController::class, 'update'])->name('product-images_update');
    Route::get('product-images_trashed', [ProductImageController::class, 'trashed'])->name('product-images_trashed');
    Route::get('product-images_restore/{id}', [ProductImageController::class, 'restore'])->name('product-images_restore');
    Route::get('product-images_force/{id}', [ProductImageController::class, 'force'])->name('product-images_force');
    Route::get('product-images_forceAll', [ProductImageController::class, 'forceAll'])->name('product-images_forceAll');
    Route::resource('product-images', ProductImageController::class);

    // Wishlists
    Route::post('wishlists-update/{id}', [WishlistController::class, 'update'])->name('wishlists-update');
    Route::get('wishlists_trashed', [WishlistController::class, 'trashed'])->name('wishlists_trashed');
    Route::get('wishlists_restore/{id}', [WishlistController::class, 'restore'])->name('wishlists_restore');
    Route::get('wishlists_force/{id}', [WishlistController::class, 'force'])->name('wishlists_force');
    Route::get('wishlists_force_all', [WishlistController::class, 'forceAll'])->name('wishlists_forceAll');
    Route::resource('wishlists', WishlistController::class);

    // Bookings
    Route::post('bookings_update/{id}', [BookingController::class, 'update'])->name('bookings_update');
    Route::get('bookings_trashed', [BookingController::class, 'trashed'])->name('bookings_trashed');
    Route::get('bookings_restore/{id}', [BookingController::class, 'restore'])->name('bookings_restore');
    Route::get('bookings_force/{id}', [BookingController::class, 'force'])->name('bookings_force');
    Route::get('bookings_forceAll', [BookingController::class, 'forceAll'])->name('bookings_forceAll');
    Route::resource('bookings', BookingController::class);

    // Reviews
    Route::get('reviews_trashed', [ReviewController::class, 'trashed'])->name('reviews_trashed');
    Route::get('reviews_restore/{id}', [ReviewController::class, 'restore'])->name('reviews_restore');
    Route::get('reviews_force/{id}', [ReviewController::class, 'force'])->name('reviews_force');
    Route::get('reviews_forceAll', [ReviewController::class, 'forceAll'])->name('reviews_forceAll');
    Route::resource('reviews', ReviewController::class);

    // Permissions & Roles
    Route::post('permissions_update/{id}', [PermissionController::class, 'update'])->name('permissions_update');
    Route::resource('permissions', PermissionController::class);

    Route::post('roles_update/{id}', [RoleController::class, 'update'])->name('roles_update');
    Route::resource('roles', RoleController::class);

    Route::resource('roles.permissions', RolePermissionController::class);
});

// ===========================
// CMS - Dashboard (All CMS Users)
// ===========================
Route::prefix('cms/{guard}')->middleware('auth:admin,artisan,team')->group(function () {
    Route::get('home', [DashboardController::class, 'index'])->name('cms.home');
    Route::get('artisans', [ArtisanController::class, 'index'])->name('artisans.index');
    Route::get('artisans/{id}', [ArtisanController::class, 'show'])->name('artisans.show');
    Route::get('teams', [TeamController::class, 'index'])->name('teams.index');
    Route::get('teams/{id}', [TeamController::class, 'show'])->name('teams.show');
    Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('customers/{id}', [CustomerController::class, 'show'])->name('customers.show');
});
