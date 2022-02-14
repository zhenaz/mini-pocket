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
})->middleware('auth');

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


// Admin 
Route::get('user', [App\Http\Controllers\UserController::class, 'index'])->name('user')->middleware('role_check');
Route::post('user/add', [App\Http\Controllers\UserController::class, 'create'])->name('user.add')->middleware('role_check');
Route::get('user/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit')->middleware('role_check');
Route::post('user/update', [App\Http\Controllers\UserController::class, 'update'])->name('user.update')->middleware('role_check');
Route::delete('user/delete/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('user.delete')->middleware('role_check');

//admin -> user transaction
Route::get('user/transaction/{id}', [App\Http\Controllers\UserController::class, 'transaction'])->name('user.transaction')->middleware('role_check');
Route::get('user/transaction/edit/{id}', [App\Http\Controllers\UserController::class, 'edit_transaction'])->name('user.transaction.edit');
Route::post('user/transaction/update', [App\Http\Controllers\UserController::class, 'update_transaction'])->name('user.transaction.update')->middleware('role_check');
Route::delete('user/transaction/delete/{id}', [App\Http\Controllers\UserController::class, 'delete_transaction'])->name('user.transaction.delete')->middleware('role_check');

Route::post('user/transaction/deposit', [App\Http\Controllers\UserController::class, 'deposit_transaction'])->name('user.transaction.deposit');
Route::post('user/transaction/withdrawal', [App\Http\Controllers\UserController::class, 'withdrawal_transaction'])->name('user.transaction.withdraw');
