<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArtisanController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserAuthController;
use Illuminate\Support\Facades\Route;


//Route::get('/', function () {
  ///  return view('welcome');
//});
Route::get('/', [FrontController::class, 'home'])->name('front.home');
Route::get('/', [FrontController::class, 'home'])->name('front.home');
Route::get('/products', [FrontController::class, 'products'])->name('front.products');
Route::get('/products/{id}', [FrontController::class, 'productShow'])->name('front.product.show');

Route::prefix('cms/')->middleware('guest:admin,artisan,team,customer')->group(function(){
   Route::get('login', [UserAuthController::class, 'showLogin'])->name('view.login');

   Route::post('login', [UserAuthController::class, 'login'])->name('cms.login');


});



Route::prefix('cms/Admin')->middleware('auth:admin,artisan,team,customer')->group(function(){

// Route::get('home', [DashboardController::class, 'index'])->name('cms.home');
Route::get('artisans/create', [ArtisanController::class, 'create'])->name('artisans.create');
    Route::post('artisans', [ArtisanController::class, 'store'])->name('artisans.store');

    // 2. مسارات سلة المحذوفات: لازم تكون قبل مسارات الـ ID
    Route::get('artisans_trashed', [ArtisanController::class, 'trashed'])->name('artisans_trashed');
    Route::get('artisans_restore/{id}', [ArtisanController::class, 'restore'])->name('artisans_restore');
    Route::get('artisans_force/{id}', [ArtisanController::class, 'force'])->name('artisans_force');
    Route::get('artisans_force_all', [ArtisanController::class, 'forceAll'])->name('artisans_forceAll');

    // 3. مسارات التعديل والحذف: خليها في الآخر لأن فيها {id}
    Route::get('artisans/{id}/edit', [ArtisanController::class, 'edit'])->name('artisans.edit');
    Route::post('artisans-update/{id}', [ArtisanController::class, 'update'])->name('artisans-update');
    Route::delete('artisans/{id}', [ArtisanController::class, 'destroy'])->name('artisans.destroy');

    Route::view('temp','cms.temp');

Route::post('admins-update/{id}',[AdminController::class , 'update'])->name('admins-update');
Route::get('admins_trashed', [AdminController::class, 'trashed'])->name('admins_trashed');
Route::get('admins_restore/{id}', [AdminController::class, 'restore'])->name('admins_restore');
Route::get('admins_force/{id}', [AdminController::class, 'force'])->name('admins_force');
Route::get('admins_force_all', [AdminController::class, 'forceAll'])->name('admins_forceAll');
Route::resource('admins' , AdminController::class);


Route::post('teams-update/{id}',[TeamController::class , 'update'])->name('teams-update');
Route::get('teams_trashed', [TeamController::class, 'trashed'])->name('teams_trashed');
Route::get('teams_restore/{id}', [TeamController::class, 'restore'])->name('teams_restore');
Route::get('teams_force/{id}', [TeamController::class, 'force'])->name('teams_force');
Route::get('teams_force_all', [TeamController::class, 'forceAll'])->name('teams_forceAll');
Route::resource('teams' , TeamController::class);







Route::post('countries_update/{id}', [CountryController::class,'update'])->name('countries_update');
Route::get('countries_trashed', [CountryController::class,'trashed'])->name('countries_trashed');
Route::get('countries_restore/{id}', [CountryController::class,'restore'])->name('countries_restore');
Route::get('countries_force/{id}', [CountryController::class,'force'])->name('countries_force');
Route::get('countries_forceAll', [CountryController::class, 'forceAll'])->name('countries_forceAll');
Route::resource('countries', CountryController::class);


Route::post('cities_update/{id}', [CityController::class,'update'])->name('cities_update');
Route::get('cities_trashed', [CityController::class,'trashed'])->name('cities_trashed');
Route::get('cities_restore/{id}', [CityController::class,'restore'])->name('cities_restore');
Route::get('cities_force/{id}', [CityController::class,'force'])->name('cities_force');
Route::get('cities_forceAll', [CityController::class,'forceAll'])->name('cities_forceAll');
Route::resource('cities', CityController::class);


Route::post('categories-update/{id}',[CategoryController::class , 'update'])->name('categories-update');
Route::get('categories_trashed', [CategoryController::class, 'trashed'])->name('categories_trashed');
Route::get('categories_restore/{id}', [CategoryController::class, 'restore'])->name('categories_restore');
Route::get('categories_force/{id}', [CategoryController::class, 'force'])->name('categories_force');
Route::get('categories_force_all', [CategoryController::class, 'forceAll'])->name('categories_forceAll');
Route::resource('categories' , CategoryController::class);




Route::get('customers/create', [CustomerController::class, 'create'])->name('customers.create');
Route::post('customers', [CustomerController::class, 'store'])->name('customers.store');
Route::get('customers/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
Route::post('customers-update/{id}', [CustomerController::class, 'update'])->name('customers-update');
Route::delete('customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
Route::get('customers_trashed', [CustomerController::class, 'trashed'])->name('customers_trashed');
Route::get('customers_force_all', [CustomerController::class, 'forceAll'])->name('customers_forceAll');
 Route::get('customers_trashed', [CustomerController::class, 'trashed'])->name('customers_trashed');
    Route::get('customers_restore/{id}', [CustomerController::class, 'restore'])->name('customers_restore');
    Route::get('customers_force/{id}', [CustomerController::class, 'force'])->name('customers_force');

Route::resource('addresses', AddressController::class);
Route::post('addresses_update/{id}', [AddressController::class,'update'])->name('addresses_update');
Route::get('addresses_trashed',          [AddressController::class, 'trashed'])->name('addresses_trashed');
Route::get('addresses_restore/{id}',     [AddressController::class, 'restore'])->name('addresses_restore');
Route::get('addressesforce/{id}',       [AddressController::class, 'force'])->name('addresses_force');
Route::get('addresses_forceAll',         [AddressController::class, 'forceAll'])->name('addresses_forceAll');
Route::get('cities-by-country/{id}', [CityController::class, 'byCountry'])->name('cities.byCountry');


Route::post('products_update/{id}', [ProductController::class,'update'])->name('products_update');
Route::get('products_trashed', [ProductController::class,'trashed'])->name('products_trashed');
Route::get('products_restore/{id}', [ProductController::class,'restore'])->name('products_restore');
Route::get('products_force/{id}', [ProductController::class,'force'])->name('products_force');
Route::get('products_forceAll', [ProductController::class,'forceAll'])->name('products_forceAll');
Route::resource('products', ProductController::class);




Route::post('wishlists-update/{id}',[WishlistController::class , 'update'])->name('wishlists-update');

Route::get('wishlists_trashed', [WishlistController::class, 'trashed'])->name('wishlists_trashed');
Route::get('wishlists_restore/{id}', [WishlistController::class, 'restore'])->name('wishlists_restore');
Route::get('wishlists_force/{id}', [WishlistController::class, 'force'])->name('wishlists_force');
Route::get('wishlists_force_all', [WishlistController::class, 'forceAll'])->name('wishlists_forceAll');
Route::resource('wishlists' , WishlistController::class);

Route::resource('reviews', ReviewController::class);
Route::get('reviews_trashed',      [ReviewController::class, 'trashed'])->name('reviews_trashed');
Route::get('reviews_restore/{id}', [ReviewController::class, 'restore'])->name('reviews_restore');
Route::get('reviews_force/{id}',   [ReviewController::class, 'force'])->name('reviews_force');
Route::get('reviews_forceAll',     [ReviewController::class, 'forceAll'])->name('reviews_forceAll');



Route::resource('orders', OrderController::class);
Route::post('orders_update/{id}', [OrderController::class,'update'])->name('products_update');
Route::get('orders_trashed',          [OrderController::class, 'trashed'])->name('orders_trashed');
Route::get('orders_restore/{id}',     [OrderController::class, 'restore'])->name('orders_restore');
Route::get('orders_force/{id}',       [OrderController::class, 'force'])->name('orders_force');
Route::get('orders_forceAll',         [OrderController::class, 'forceAll'])->name('orders_forceAll');



  Route::resource('order-items', OrderItemController::class);
  Route::post('order-items_update/{id}', [OrderItemController::class,'update'])->name('order-items_update');
  Route::get('order-items_trashed',          [OrderItemController::class, 'trashed'])->name('order-items_trashed');
  Route::get('order-items_restore/{id}',     [OrderItemController::class, 'restore'])->name('order-items_restore');
  Route::get('order-items_force/{id}',       [OrderItemController::class, 'force'])->name('order-items_force');
  Route::get('order-items_forceAll',         [OrderItemController::class, 'forceAll'])->name('order-items_forceAll');

Route::resource('bookings', BookingController::class);

  Route::post('bookings_update/{id}', [BookingController::class,'update'])->name('bookings_update');
Route::get('bookings_trashed',      [BookingController::class, 'trashed'])->name('bookings_trashed');
Route::get('bookings_restore/{id}', [BookingController::class, 'restore'])->name('bookings_restore');
Route::get('bookings_force/{id}',   [BookingController::class, 'force'])->name('bookings_force');
Route::get('bookings_forceAll',     [BookingController::class, 'forceAll'])->name('bookings_forceAll');




///////////////



     Route::resource('permissions', PermissionController::class);
     Route::post('permissions_update/{id}', [PermissionController::class,'update'])->name('permissions_update');

     Route::resource('roles', RoleController::class);
     Route::post('roles_update/{id}', [RoleController::class,'update'])->name('roless_update');

     Route::resource('roles', RoleController::class);
     Route::post('roles_update/{id}', [RoleController::class,'update'])->name('roless_update');

     // لعرض الصفحة
       Route::resource('roles.permissions', RolePermissionController::class);
// لحفظ الصلاحية (Request من نوع Post للـ Checkbox)
    //    Route::post('role-permissions', [RoleController::class, 'updateRolePermission']);



}




);
Route::prefix('cms/{guard}')->middleware('auth:admin,team,customer,artisan')->group(function() {
    Route::get('home', [DashboardController::class, 'index'])->name('cms.home');

    // مسارات العرض مسموحة للجميع
    Route::get('artisans', [ArtisanController::class, 'index'])->name('artisans.index');
    Route::get('artisans/{id}', [ArtisanController::class, 'show'])->name('artisans.show');
    Route::get('teams', [TeamController::class, 'index'])->name('teams.index');
    Route::get('teams/{id}', [TeamController::class, 'show'])->name('teams.show');
    Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('customers/{id}', [CustomerController::class, 'show'])->name('customers.show');
});
Route::get('cms/logout', [UserAuthController::class, 'logout'])->name('logout');
