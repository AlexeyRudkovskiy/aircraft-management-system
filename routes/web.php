<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $a = new \App\Models\ServiceRequest();
    $a->priority = \App\Enums\ServiceRequest\Priority::HIGH;
    $a->due_date = today()->addDays(5);
    $a->aircraft_id = 1;
    $a->description = 'Testing';
    $a->save();
    return view('welcome');
});
