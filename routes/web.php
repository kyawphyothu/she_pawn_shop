<?php

use App\Http\Controllers\BackupController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HtetYuController;
use App\Http\Controllers\InterestController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\SummaryController;
use App\Http\Controllers\VillageController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();
Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//test
Route::get('/test/{id}', [OrderController::class, 'test']);

//index
Route::get('/', [OrderController::class, 'index']);
Route::get('/orders/index', [OrderController::class, 'index']);

//add order
Route::get('/orders/add', [OrderController::class, 'add']);
Route::post('/orders/add', [OrderController::class, 'create']);

//search by name
Route::get('/orders/search', [OrderController::class, 'searchByName']);
Route::get('/orders/filter', [OrderController::class, 'filter']);
// Route::post('orders/search', [OrderController::class, 'searchByName']);

//detail page
Route::get('/orders/detail/{id}', [OrderController::class, 'detail']);

//htet yu
Route::get('/orders/htetyu/{id}', [OrderController::class, 'htetyu']);
Route::post('/orders/htetyu/{id}', [OrderController::class, 'htetyuCreate']);

//pay interest
Route::get('/orders/payinterest/{id}', [OrderController::class, 'payInterest']);
Route::post('/orders/payinterest/{id}', [OrderController::class, 'paidInterest']);

//order edit page
Route::get('/orders/edit/{id}', [OrderController::class, 'edit']);
Route::post('/orders/edit/{id}', [OrderController::class, 'update']);

//eduction page
Route::get('/orders/eduction/{id}', [OrderController::class, 'eduction']);
Route::post('/orders/eduction/{id}', [OrderController::class, 'educt']);

//htetyu delete
Route::get('/htetyus/delete/{id}', [HtetYuController::class, 'delete']);

//interest delete
Route::get('/interests/delete/{id}', [InterestController::class, 'delete']);

//rate
Route::get('/rates/update', [RateController::class, 'index']);
Route::post('/rates/update', [RateController::class, 'change']);

//history
Route::get('/histories', [HistoryController::class, 'index']);

///////////////////////////////summary
//daily summary
Route::get('/summaries/daily', [SummaryController::class, 'daily']);
Route::post('/summaries/daily', [SummaryController::class, 'dailyCreate']);

//monthly summary
Route::get('/summaries/monthly', [SummaryController::class, 'monthly']);
Route::post('/summaries/monthly', [SummaryController::class, 'monthlyCreate']);

//yearly summary
Route::get('/summaries/yearly', [SummaryController::class, 'yearly']);
Route::post('/summaries/yearly', [SummaryController::class, 'yearlyCreate']);


//Backup
Route::get('/backups', [BackupController::class, 'index']);
Route::post('/backups', [BackupController::class, 'store']);
Route::get('/backups/delete/{id}', [BackupController::class, 'destory']);

//village
Route::get('/villages', [VillageController::class, 'index']);
Route::post('/villages', [VillageController::class, 'store']);
Route::get('/villages/destory/{id}', [VillageController::class, 'destory']);
