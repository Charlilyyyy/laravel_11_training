<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::middleware('auth')->group(function () {
    Route::get('/home/{type?}', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/post/create/{id?}', [App\Http\Controllers\HomeController::class, 'postCreate'])->name('postCreate');
    Route::get('/post/{id}/detail', [App\Http\Controllers\HomeController::class, 'postDetail'])->name('postDetail');
    Route::patch('/post/{id}/update', [App\Http\Controllers\HomeController::class, 'postUpdate'])->name('postUpdate');
    Route::delete('/post/{id}/delete', [App\Http\Controllers\HomeController::class, 'postDelete'])->name('postDelete');
    Route::get('/post/{id}/interact', [App\Http\Controllers\HomeController::class, 'postInteract'])->name('postInteract');
});
