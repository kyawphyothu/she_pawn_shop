<?php

use App\Http\Controllers\HtetYuController;
use App\Http\Controllers\InterestController;
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
Route::post('/', [OrderController::class, 'filter']);

//add order
Route::get('/orders/add', [OrderController::class, 'add']);
Route::post('/orders/add', [OrderController::class, 'create']);

//search by name
Route::post('orders/search', [OrderController::class, 'searchByName']);

//detail page
Route::get('/orders/detail/{id}', [OrderController::class, 'detail']);

//htet yu
Route::get('/orders/htetyu/{id}', [OrderController::class, 'htetyu']);
Route::post('/orders/htetyu/{id}', [OrderController::class, 'htetyuCreate']);

//pay interest
Route::get('/orders/payinterest/{id}', [OrderController::class, 'payInterest']);
Route::post('/orders/payinterest/{id}', [OrderController::class, 'paidInterest']);

//edit page
Route::get('/orders/edit/{id}', [OrderController::class, 'edit']);
Route::post('/orders/edit/{id}', [OrderController::class, 'update']);

//eduction page
Route::get('/orders/eduction/{id}', [OrderController::class, 'eduction']);

//htetyu delete
Route::get('/htetyus/delete/{id}', [HtetYuController::class, 'delete']);

//interest delete
Route::get('/interests/delete/{id}', [InterestController::class, 'delete']);
