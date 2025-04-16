<?php

use App\Http\Controllers\MatchController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MatchController::class, 'showForm']);
Route::post('/buscar', [MatchController::class, 'findMatches'])->name('buscar');