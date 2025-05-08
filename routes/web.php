<?php

use App\Http\Controllers\Api\CategoryController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// Route::apiResource('category', CategoryController::class);
