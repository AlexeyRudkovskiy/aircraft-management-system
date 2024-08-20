<?php

\Illuminate\Support\Facades\Route::apiResource('aircraft', \App\Http\Controllers\API\AircraftController::class);
\Illuminate\Support\Facades\Route::apiResource('serviceRequest', \App\Http\Controllers\API\ServiceRequestController::class)
    ->names('service-request');
