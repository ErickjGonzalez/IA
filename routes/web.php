<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SimuladorController;

// 🏠 Pantalla de bienvenida
Route::get('/', [SimuladorController::class, 'inicio'])->name('inicio');

// ▶️ Inicio de simulación (formulario POST)
Route::post('/iniciar', [SimuladorController::class, 'iniciarSimulacion'])->name('simulador.iniciar');

// 🗺️ Pantalla de mapa con restaurantes
Route::get('/mapa', [SimuladorController::class, 'mostrarMapa'])->name('mapa');

// 💾 Guardar elección del día
Route::post('/guardar-dia', [SimuladorController::class, 'guardarDia'])->name('guardar.dia');

// 📊 Mostrar reporte final
Route::get('/reporte', [SimuladorController::class, 'mostrarReporte'])->name('reporte');

// 📌 Mostrar resumen diario y recomendación UCB
Route::get('/siguiente', [SimuladorController::class, 'siguienteDia'])->name('siguiente');

Route::get('/resume', [SimuladorController::class, 'siguienteDia'])->name('resume');
