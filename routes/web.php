<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::get('admin/home', [App\Http\Controllers\HomeController::class, 'adminHome'])->name('admin.home')->middleware('role_check');
Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
Route::post('profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');

Route::post('home/create', [App\Http\Controllers\WalletController::class, 'create'])->name('wallet.create');

Route::post('home/deposit', [App\Http\Controllers\TransactionController::class, 'deposit'])->name('transaction.deposit');
Route::post('home/withdraw', [App\Http\Controllers\TransactionController::class, 'withdraw'])->name('transaction.withdraw');

Route::get('transaction', [App\Http\Controllers\TransactionController::class, 'index'])->name('transaction');
Route::get('transaction/{id}', [App\Http\Controllers\TransactionController::class, 'edit'])->name('transaction.edit');
Route::post('transaction/update', [App\Http\Controllers\TransactionController::class, 'update'])->name('transaction.update');
