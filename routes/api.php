<?php

\Illuminate\Support\Facades\Route::middleware(['auth:sanctum'])->group(function () {
    \Illuminate\Support\Facades\Route::get('/me', [ \App\Http\Controllers\AuthController::class, 'me' ])->name('me');
});

\Illuminate\Support\Facades\Route::apiResource('aircraft', \App\Http\Controllers\API\AircraftController::class);
\Illuminate\Support\Facades\Route::apiResource('serviceRequest', \App\Http\Controllers\API\ServiceRequestController::class)
    ->names('service-request');
Route::post('/serviceRequest/{serviceRequest}/status', [ \App\Http\Controllers\API\ServiceRequestController::class, 'status' ])->name('serviceRequest.status');
\Illuminate\Support\Facades\Route::apiResource('maintenanceCompany', \App\Http\Controllers\API\MaintenanceCompanyController::class);
