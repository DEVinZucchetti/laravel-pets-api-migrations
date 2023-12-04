<?php

use App\Http\Controllers\ClientsController;
use App\Http\Controllers\PeoplesController;
use Illuminate\Support\Facades\Route;

Route::resource('peoples', PeoplesController::class)->only(
  ['index', 'show', 'store', 'update', 'destroy']
);

Route::resource('pets', PetController::class)->only(
  ['index', 'show', 'store', 'update', 'destroy']
);

Route::resource('clients', ClientsController::class)->except(['create', 'edit']);

Route::prefix('races')->group(function () {
  Route::get('', [RaceController::class, 'index']);
  Route::post('', [RaceController::class, 'store']);
});
