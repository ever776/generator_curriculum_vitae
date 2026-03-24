<?php

use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExperienciaLaboralController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PdfCombineController;
use App\Http\Controllers\TituloController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/files/{path}', [FileController::class, 'serve'])
        ->where('path', '.*')
        ->name('files.serve');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/curriculum/generate', [CurriculumController::class, 'generate'])->name('curriculum.generate');

    Route::get('/download/titulos-pdfs', [PdfCombineController::class, 'downloadTitulos'])->name('download.titulos');
    Route::get('/download/certificados-pdfs', [PdfCombineController::class, 'downloadCertificados'])->name('download.certificados');
    Route::get('/download/experiencias-pdfs', [PdfCombineController::class, 'downloadExperiencias'])->name('download.experiencias');

    Route::resource('certificados', CertificadoController::class)->names('certificados');
    Route::resource('titulos', TituloController::class)->names('titulos');
    Route::resource('experiencias-laborales', ExperienciaLaboralController::class)->names('experiencias-laborales');
});

require __DIR__.'/settings.php';
