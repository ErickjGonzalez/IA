<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resumen - Día {{ $dia - 1 }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Montserrat:wght@300;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(135deg, #0d0d0d, #1c1c1c);
            color: #f0f0f0;
            min-height: 100vh;
            padding-bottom: 50px;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at center, rgba(255,215,0,0.08), transparent 70%);
            animation: pulse 6s infinite ease-in-out;
            z-index: 0;
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.4; }
            50% { opacity: 0.7; }
        }

        .container {
            position: relative;
            z-index: 1;
        }

        h1 {
            font-family: 'Playfair Display', serif;
            color: #FFD700;
            font-size: 2.8rem;
            text-shadow: 0 0 10px rgba(255, 215, 0, 0.4);
            margin-bottom: 2rem;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            font-size: 1.5rem;
            color: #FFD700;
            margin-bottom: 1rem;
        }

        .card {
            background-color: #1f1f1f;
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0 15px rgba(255, 215, 0, 0.08);
            color: #fff;
        }

        .card-body p {
            font-size: 1rem;
            margin-bottom: 0.4rem;
        }

        .table {
            background-color: #2a2a2a;
            color: #fff;
            border-radius: 0.75rem;
            overflow: hidden;
        }

        .table th {
            background-color: #000;
            color: #FFD700;
        }

        .table td {
            background-color: #1e1e1e;
        }

        .badge.bg-primary {
            background-color: #FFD700 !important;
            color: #000;
            font-weight: bold;
        }

        .ucb-highlight {
            background: rgba(255, 215, 0, 0.08);
            border-left: 4px solid #FFD700;
            padding: 1rem 1.5rem;
            border-radius: 0.75rem;
            font-size: 1rem;
        }

        .icon {
            font-size: 1.2rem;
            color: #FFD700;
            margin-right: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(145deg, #FFD700, #bfa300);
            border: none;
            color: #000;
            font-weight: 600;
            font-size: 1.1rem;
            padding: 0.75rem 1.8rem;
            border-radius: 2rem;
            box-shadow: 0 4px 12px rgba(255, 215, 0, 0.3);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 215, 0, 0.5);
        }

        .table tbody tr td {
        color: white !important;
    }
    </style>
</head>
<body>

<div class="container py-5">
    <h1 class="text-center">📊 Resumen del Día {{ $dia - 1 }}</h1>

    @if ($anterior)
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="section-title">📝 Tu elección anterior</h5>
                <p><strong>🍽 Restaurante:</strong> {{ $anterior['restaurante'] }}</p>
                <p><strong>🍛 Platillo:</strong> {{ $anterior['platillo'] }}</p>
                <p><strong>⭐ Calificación:</strong> {{ $anterior['calificacion'] }}</p>
            </div>
        </div>
    @endif

    <div class="mb-4">
        <h5 class="section-title">📈 Estadísticas hasta ahora</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Restaurante</th>
                        <th>Visitas</th>
                        <th>Promedio</th>
                        <th>UCB</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ucbs as $nombre => $datos)
                        <tr>
                            <td>{{ $nombre }}</td>
                            <td>{{ $datos['visitas'] }}</td>
                            <td>{{ number_format($datos['promedio'], 2) }}</td>
                            <td><span class="badge bg-primary">{{ number_format($datos['ucb'], 2) }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if ($recomendacion)
        <div class="ucb-highlight mb-4">
            <h5 class="mb-2"><i class="bi bi-lightbulb icon"></i>Recomendación del Sistema</h5>
            <p class="mb-0">{!! $recomendacion !!}</p>
        </div>
    @endif

    <div class="text-center">
        <a href="{{ route('mapa') }}" class="btn btn-primary">
            Continuar al Día {{ $dia }} &raquo;
        </a>
    </div>
</div>

</body>
</html>
