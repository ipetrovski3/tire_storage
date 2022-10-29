<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\InvoicesController;
use App\Http\Controllers\Dashboard\TiresController;
use Illuminate\Support\Facades\Route;

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



Auth::routes();

Route::prefix('dashboard')->middleware('auth')->group(function() {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/stock', [HomeController::class, 'stock'])->name('stock');
    Route::post('/stock-import', [HomeController::class, 'import_stock'])->name('import.stock');
    Route::get('search', [HomeController::class, 'search'])->name('search.product');


    Route::resource('categories', CategoriesController::class);
    Route::resource('categories.tires', TiresController::class);
    Route::post('/get_patterns', [CategoriesController::class, 'get_patterns'])->name('get.patterns');

    Route::prefix('invoices')->group(function () {
        Route::get('/', [InvoicesController::class, 'index'])->name('invoices.index');
        Route::get('/create', [InvoicesController::class, 'create'])->name('invoices.create');
        Route::post('add_product', [InvoicesController::class, 'add_product'])->name('add.product');
        Route::post('find_product', [InvoicesController::class, 'find_product'])->name('find.product');
        Route::post('remove_product', [InvoicesController::class, 'remove_product'])->name('remove.product');
        Route::post('store_invoice', [InvoicesController::class, 'store'])->name('store.invoice');
    });
});
