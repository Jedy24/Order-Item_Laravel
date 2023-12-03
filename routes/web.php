<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AppController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AppController::class, 'index'])->name('index');

Route::resource('items', ItemController::class);

/**Group routing untuk order dan detail order */
Route::prefix('/orders')->group(function(){
    Route::get('/', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/list', [OrderController::class, 'list'])->name('orders.list');
    Route::get('/list/detail/{order}', [OrderController::class,'detail'])->name('orders.detail');
});
