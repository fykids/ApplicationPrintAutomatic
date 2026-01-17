<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

use App\Http\Controllers\PrintJobController;

Route::get('/print-jobs/next', [PrintJobController::class, 'next']);
Route::post('/print-jobs/{token}/printing', [PrintJobController::class, 'markPrinting']);
Route::post('/print-jobs/{token}/done', [PrintJobController::class, 'markDone']);
Route::post('/jobs/{token}/failed', [PrintJobController::class, 'failed']);

Route::get('/system/url', function () {
    return response()->json([
        'url' => config('app.public_url') ?? request()->getSchemeAndHttpHost()
    ]);
});

