<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrdersController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//test
Route::get('/test', function () {
    return view('pawn.index');
});

//index
Route::get('/', [OrderController::class, 'index']);

//add order
Route::get('/orders/add', [OrderController::class, 'add']);
Route::post('/orders/add', [OrderController::class, 'create']);

//search by name
Route::post('orders/search', [OrderController::class, 'searchByName']);

//detail page
Route::get('/orders/detail', [OrderController::class, 'detail']);
