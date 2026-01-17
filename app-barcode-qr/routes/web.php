<?php

use App\Http\Controllers\PrintJobController;
use App\Http\Controllers\Api\PrintJobApiController;
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

Route::get('/', [PrintJobController::class, 'create']);
Route::post('/upload', [PrintJobController::class, 'store'])->name('print.upload');
