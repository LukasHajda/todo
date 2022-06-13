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
        Route::get('/deleted-items', [ItemsController::class, 'deleted_items'])->name('items.deleted_items');
        Route::post('/items/restore/{id}', [ItemsController::class, 'restore'])->name('items.restore');
        Route::post('/items/delete/{id}', [ItemsController::class, 'delete'])->name('items.delete');
        Route::post('/items/{id}', [ItemsController::class, 'update'])->name('items.update');

    });

    Route::get('/items/done/{id}/{option}', [ItemsController::class, 'make_deleted_finished'])->name('items.done');
    Route::get('/items/show/{id}', [ItemsController::class, 'show'])->name('items.show');

});

Auth::routes([
    'reset' => false,
    'confirm' => false,
    'verify' => false
]);
