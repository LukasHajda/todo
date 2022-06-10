<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ItemsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware(['auth'])->namespace('Users')->group(function() {
    Route::get('/', [ItemsController::class, 'index'])->name('index');

    Route::middleware(['admin'])->group(function() {
        Route::post('/items', [ItemsController::class, 'store'])->name('items.store');
        Route::get('/items/create', [ItemsController::class, 'create'])->name('items.create');
        Route::get('/items/edit/{id}', [ItemsController::class, 'edit'])->name('items.edit');

    });

});

Auth::routes([
    'reset' => false,
    'confirm' => false,
    'verify' => false
]);
