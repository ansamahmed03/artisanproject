<?php

use App\Http\Controllers\ArtisanController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::prefix('cms/Admin')->group(function(){

Route::view('temp','cms.temp');
Route::post('artisans-update/{id}',[ArtisanController::class , 'update'])->name('artisans-update');
Route::resource('artisans' , ArtisanController::class);


Route::post('categories-update/{id}',[CategoryController::class , 'update'])->name('categories-update');
Route::resource('categories' , CategoryController::class);


}

);
