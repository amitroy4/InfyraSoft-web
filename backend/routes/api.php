<?php

use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\SiteDataController;
use Illuminate\Support\Facades\Route;

Route::get('/site-data', SiteDataController::class);
Route::post('/leads', [LeadController::class, 'store']);
