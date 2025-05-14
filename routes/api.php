<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AssetController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\HoldingController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\SnapshotController;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// PORTFOLIO API
Route::get('/assets', [AssetController::class, 'index']);
Route::post('/assets', [AssetController::class, 'store']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/budgets', [BudgetController::class, 'store']);
    Route::post('/budgets/{budget}/envelopes', [BudgetController::class, 'storeEnvelopes']);
    Route::patch('/budgets/{budget}/activate', [BudgetController::class, 'activate']);
});
Route::post('/holdings', [HoldingController::class, 'store']);
Route::post('/portfolios', [PortfolioController::class, 'store']);
Route::get("/portfolios", [PortfolioController::class, 'index']);
Route::get('/portfolios/{portfolio}', [PortfolioController::class, 'show']);
Route::get('/portfolios/{portfolio}/snapshots', [SnapshotController::class, 'index']);
Route::post('/portfolios/{portfolio}/snapshots', [SnapshotController::class, 'store']);
Route::post('/portfolios/{portfolio}/transactions/batch', [TransactionController::class, 'storeBatch']);
Route::get('/snapshots/{snapshot}', [SnapshotController::class, 'show']);
Route::get('/page/{slug?}', [PageController::class, 'show']);
