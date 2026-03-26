<?php

use App\Http\Controllers\ArtisanController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::prefix('cms/Admin')->name('cms.admin.')->group(function(){

Route::view('temp','cms.temp');
Route::resource('artisans' , ArtisanController::class);
}

);
