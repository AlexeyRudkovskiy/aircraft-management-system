<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

\Illuminate\Support\Facades\Route::post('/login', [ \App\Http\Controllers\AuthController::class, 'login' ])->name('login');

Route::get('{all}', function () {
    return view('welcome');
})->where(['all' => '.*']);

