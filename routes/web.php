<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionController;

Route::get('/questions/byId/{param}', [QuestionController::class, 'lookup']);
Route::post('/questions/byUrl', [QuestionController::class, 'lookup']);