<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Static Pages
Route::get('/', function () {
    return view('crud-index');
});
Route::get('/crud-quest/step-1-migration', function () {
    return view('crud-step-1-migration');
});

// Step 2: Create (Show the form)
Route::get('/crud-quest/step-2-create', [ProductController::class, 'step2'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

// Step 3: Read (Show list + search)
Route::get('/crud-quest/step-3-read', [ProductController::class, 'step3'])->name('products.read');

// Step 4: Update (Show list + edit form)
Route::get('/crud-quest/step-4-update', [ProductController::class, 'step4'])->name('products.edit');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');


// Step 5: Delete (We'll add this next!)
Route::get('/crud-quest/step-5-delete', [ProductController::class, 'step5'])->name('products.delete_page');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');


// The Master Page
Route::get('/crud-quest/step-6-complete', [ProductController::class, 'masterIndex'])->name('products.master');

// Actions (These all redirect back to 'products.master' after finishing)
Route::post('/master/store', [ProductController::class, 'store'])->name('master.store');
Route::put('/master/update/{id}', [ProductController::class, 'update'])->name('master.update');
Route::delete('/master/destroy/{id}', [ProductController::class, 'destroy'])->name('master.destroy');
