<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SimuladorController extends Controller
{
    public function inicio()
    {
        return view('welcome');
    }

    public function iniciarSimulacion(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'ciudad' => 'required|string',
            'dias' => 'required|integer|min:1',
        ]);

        session([
            'usuario_nombre' => $request->nombre,
            'ciudad' => $request->ciudad,
            'dias_totales' => $request->dias,
            'dia_actual' => 1,
            'historial' => [],
        ]);

        return redirect()->route('mapa');
    }

    public function mostrarMapa()
    {
        if (session('dia_actual') > session('dias_totales')) {
            return redirect()->route('reporte');
        }

        return view('mapa');
    }

    public function guardarDia(Request $request)
    {
        $request->validate([
            'restaurante' => 'required|string',
            'platillo' => 'required|string',
            'calificacion' => 'required|integer|min:1|max:5',
        ]);

        $historial = session('historial', []);

        $historial[] = [
            'dia' => session('dia_actual'),
            'restaurante' => $request->restaurante,
            'platillo' => $request->platillo,
            'calificacion' => $request->calificacion,
        ];

        session(['historial' => $historial]);
session(['dia_actual' => session('dia_actual') + 1]);

return redirect()->route('resume');

    }

    public function mostrarReporte()
    {
        $historial = session('historial', []);
    
        $restCount = [];
        foreach ($historial as $h) {
            $restCount[$h['restaurante']] = ($restCount[$h['restaurante']] ?? 0) + 1;
        }
        $restauranteFavorito = array_search(max($restCount), $restCount);
    
        $platillos = [];
        foreach ($historial as $h) {
            $platillos[$h['platillo']]['suma'] = ($platillos[$h['platillo']]['suma'] ?? 0) + $h['calificacion'];
            $platillos[$h['platillo']]['veces'] = ($platillos[$h['platillo']]['veces'] ?? 0) + 1;
        }
        $mejorPuntaje = 0;
        $platilloFavorito = '';
        foreach ($platillos as $platillo => $data) {
            $prom = $data['suma'] / $data['veces'];
            if ($prom > $mejorPuntaje) {
                $mejorPuntaje = $prom;
                $platilloFavorito = $platillo;
            }
        }
    
        return view('reporte', compact('historial', 'restauranteFavorito', 'platilloFavorito'));
    }

    private function calcularUCB($historial)
{
    $estadisticas = [];
    $total_visitas = 0;

    foreach ($historial as $dia) {
        $restaurante = $dia['restaurante'];
        $calificacion = $dia['calificacion'];

        if (!isset($estadisticas[$restaurante])) {
            $estadisticas[$restaurante] = [
                'total_calificacion' => 0,
                'visitas' => 0,
            ];
        }

        $estadisticas[$restaurante]['total_calificacion'] += $calificacion;
        $estadisticas[$restaurante]['visitas'] += 1;
        $total_visitas++;
    }

    $ucbs = [];
    foreach ($estadisticas as $nombre => $datos) {
        $promedio = $datos['total_calificacion'] / $datos['visitas'];
        $ucb = $promedio + sqrt((2 * log($total_visitas)) / $datos['visitas']);
        $ucbs[$nombre] = [
            'promedio' => $promedio,
            'visitas' => $datos['visitas'],
            'ucb' => $ucb,
        ];
    }

    return $ucbs;
}

public function siguienteDia()
{
    $dia = session('dia_actual', 1);
    $historial = session('historial', []);

    $ucbs = $this->calcularUCB($historial); 

    $restaurante_recomendado = null;
    $mensaje_recomendacion = null;

    if (!empty($ucbs)) {
        uasort($ucbs, fn($a, $b) => $b['ucb'] <=> $a['ucb']);
        $restaurante_recomendado = array_key_first($ucbs);

        $mensaje_recomendacion = "Te sugerimos visitar <strong>$restaurante_recomendado</strong> hoy. Tiene un buen equilibrio entre satisfacción y potencial.";
    }

    return view('resume', [
        'dia' => $dia,
        'ucbs' => $ucbs,
        'recomendacion' => $mensaje_recomendacion,
        'anterior' => end($historial) ?: null
    ]);    
}

}
