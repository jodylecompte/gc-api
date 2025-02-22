<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionController;

Route::get('/questions/byId/{param}', [QuestionController::class, 'lookup'])
    ->header('Access-Control-Allow-Origin', '*')
    ->header('Access-Control-Allow-Methods', 'POST, GET')
    ->header('Access-Control-Allow-Headers', 'Content-Type');
Route::post('/questions/byUrl', [QuestionController::class, 'lookup'])
    ->header('Access-Control-Allow-Origin', '*')
    ->header('Access-Control-Allow-Methods', 'POST, GET')
    ->header('Access-Control-Allow-Headers', 'Content-Type');
;