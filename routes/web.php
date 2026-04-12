<?php
use App\Http\Controllers\CountryController;
use App\Http\Controllers\ArtisanController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('cms/Admin')->group(function(){



Route::view('temp','cms.temp');
Route::post('artisans-update/{id}',[ArtisanController::class , 'update'])->name('artisans-update');
Route::resource('artisans' , ArtisanController::class);

Route::post('countries_update/{id}', [CountryController::class,'update'])->name('countries_update');
Route::resource('countries', CountryController::class);


Route::post('cities_update/{id}', [CityController::class,'update'])->name('cities_update');
Route::resource('cities', CityController::class);

Route::post('categories-update/{id}',[CategoryController::class , 'update'])->name('categories-update');
Route::resource('categories' , CategoryController::class);


}

);
