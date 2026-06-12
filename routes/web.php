<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SimuladorController;

Route::get('/', [SimuladorController::class, 'inicio'])->name('inicio');

Route::post('/iniciar', [SimuladorController::class, 'iniciarSimulacion'])->name('simulador.iniciar');

Route::get('/mapa', [SimuladorController::class, 'mostrarMapa'])->name('mapa');

Route::post('/guardar-dia', [SimuladorController::class, 'guardarDia'])->name('guardar.dia');

Route::get('/reporte', [SimuladorController::class, 'mostrarReporte'])->name('reporte');

Route::get('/siguiente', [SimuladorController::class, 'siguienteDia'])->name('siguiente');

Route::get('/resume', [SimuladorController::class, 'siguienteDia'])->name('resume');
