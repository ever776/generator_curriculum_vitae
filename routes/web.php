<?php

use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\ExperienciaLaboralController;
use App\Http\Controllers\TituloController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');

    Route::resource('certificados', CertificadoController::class)->names('certificados');
    Route::resource('titulos', TituloController::class)->names('titulos');
    Route::resource('experiencias-laborales', ExperienciaLaboralController::class)->names('experiencias-laborales');
});

require __DIR__.'/settings.php';
