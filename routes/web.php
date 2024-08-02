<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/tickets/create', [CustomerController::class, 'create'])->name('customers.create');
Route::post('/tickets', [CustomerController::class, 'store'])->name('customers.store');
Route::get('/tickets/overview', [CustomerController::class, 'tickets'])->middleware(['auth', 'verified'])->name('customers.tickets');

Route::post('/tickets/update', [CustomerController::class, 'update'])->middleware(['auth', 'verified'])->name('customers.update');

Route::get('/images/tickets/{image}', [CustomerController::class, 'images'])->name('images');
Route::get('/images/tickets2/{image}', [CustomerController::class, 'images2']);

require __DIR__.'/auth.php';
