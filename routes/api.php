<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::apiResource('projects', \App\Http\Controllers\ProjectController::class);
Route::apiResource('projects.tutorials', \App\Http\Controllers\TutorialsController::class)->shallow();
Route::apiResource('tutorials.steps', \App\Http\Controllers\StepsController::class)->shallow();
Route::apiResource('projects.articles', \App\Http\Controllers\ArticleController::class)->shallow();

Route::post('tutorials/{tutorial}/steps-many', [\App\Http\Controllers\StepsController::class, 'stepsMany']);
