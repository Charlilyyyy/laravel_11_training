<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Taufik\TaufikController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    }
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home/{type?}', [HomeController::class, 'index'])->name('home');
    Route::post('/post/create/{id?}', [HomeController::class, 'postCreate'])->name('postCreate');
    Route::get('/post/{id}/detail', [HomeController::class, 'postDetail'])->name('postDetail');
    Route::patch('/post/{id}/update', [HomeController::class, 'postUpdate'])->name('postUpdate');
    Route::delete('/post/{id}/delete', [HomeController::class, 'postDelete'])->name('postDelete');
    Route::get('/post/{id}/interact', [HomeController::class, 'postInteract'])->name('postInteract');
});

// practice
Route::get('/taufik', [TaufikController::class, 'index'])->name('taufik.index');
Route::post('/taufik/createUser', [TaufikController::class, 'createUsers'])->name('createUser');



// php artisan make:controller Taufik/TaufikController

