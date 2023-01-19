<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrainController;
use App\Http\Controllers\PublicController;

// welcome 
Route::get('/', [PublicController::class, 'welcome'])->name('welcome');




