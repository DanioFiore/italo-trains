<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrainController;
use App\Http\Controllers\TrainSavedController;

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

Route::group(['middleware' => ['web']], function () {
    // trains on the road
    Route::get('/trains-on-the-road', [TrainController::class, 'onTheRoad'])->name('on-the-road');

    // trains saved
    Route::get('/trains-saved', [TrainSavedController::class, 'trainsSaved'])->name('trains-saved');

    // filter train by date
    Route::get('/filter-train', [TrainSavedController::class, 'filterTrain'])->name('filter-train');

    // save a single train
    Route::post('/save-train', [TrainSavedController::class, 'saveTrain'])->name('save-train');

    // delete a saved train
    Route::delete('/delete-train', [TrainSavedController::class, 'deleteSavedTrain'])->name('delete-train');

    // show train details
    Route::get('/show-details', [TrainSavedController::class, 'showDetails'])->name('show-details');

});

