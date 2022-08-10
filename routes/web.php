<?php

use App\Http\Controllers\BackupController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HtetYuController;
use App\Http\Controllers\InterestController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\SummaryController;
use App\Http\Controllers\UserController;
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

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => ['auth']], function () {
    //index
    Route::get('/', [OrderController::class, 'index'])->name('root');
    Route::get('/home', [OrderController::class, 'index'])->name('home');
    Route::get('/orders/index', [OrderController::class, 'index']);

    //detail page
    Route::get('/orders/detail/{id}', [OrderController::class, 'detail']);

    Route::group(['middleware' => ['role:Super-Admin|admin']], function () {

        //test
        Route::get('/test/{id}', [OrderController::class, 'test']);


        //add order
        Route::get('/orders/add', [OrderController::class, 'add']);
        Route::post('/orders/add', [OrderController::class, 'create']);

        //search by name
        Route::get('/orders/search', [OrderController::class, 'searchByName']);
        Route::get('/orders/filter', [OrderController::class, 'filter']);
        // Route::post('orders/search', [OrderController::class, 'searchByName']);


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
        Route::get('/villages/edit/{id}', [VillageController::class, 'edit']);
        Route::post('/villages/update', [VillageController::class, 'update']);

        //user profile
        Route::get('/user_info/edit', [UserController::class, 'infoEdit'])->name('user_info.edit');
        Route::post('/user_info/update', [UserController::class, 'infoUpdate'])->name('user_info.update');

        //user
        Route::get('/users', [UserController::class, 'index'])->name('user.index');
        Route::get('/users/add', [UserController::class, 'add'])->name('user.add');
        Route::post('/users/store', [UserController::class, 'store'])->name(('user.store'));
        Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::post('/users/update', [UserController::class, 'update'])->name('user.update');
    });
});
