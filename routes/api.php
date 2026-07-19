<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestController;

Route::get('/quests/best', [QuestController::class, 'best']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/materials/{item}/quests', [QuestController::class, 'ranking']);

Route::get('/materials', [QuestController::class, 'materials']);
