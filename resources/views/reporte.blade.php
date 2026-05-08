<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Final</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #000000;
            color: #FFD700; /* Dorado */
        }
        h1, h4 {
            color: #FFD700;
        }
        .list-group-item {
            background-color: #1a1a1a;
            color: #ffffff;
            border-color: #333;
        }
        .alert-info {
            background-color: #FFD700;
            color: #000;
        }
        .btn-primary {
            background-color: #FFD700;
            border-color: #FFD700;
            color: #000;
        }
        .btn-primary:hover {
            background-color: #e6c200;
            border-color: #e6c200;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">¡Tu experiencia en {{ session('ciudad') }} ha terminado!</h1>
        
        <h4>Resumen del viaje de {{ session('usuario_nombre') }}:</h4>
        <ul class="list-group mb-4">
            <li class="list-group-item"><strong>Días de estancia:</strong> {{ session('dias_totales') }}</li>
            <li class="list-group-item"><strong>Restaurante más visitado:</strong> {{ $restauranteFavorito }}</li>
            <li class="list-group-item"><strong>Platillo favorito:</strong> {{ $platilloFavorito }}</li>
        </ul>

        <h4>Evolución de satisfacción</h4>
        <canvas id="grafica" height="100"></canvas>

        <div class="mt-5 alert alert-info">
            <strong>Recomendación final:</strong> UCB te ayudó a descubrir que <b>{{ $restauranteFavorito }}</b> fue la mejor opción.
        </div>

        <a href="{{ route('inicio') }}" class="btn btn-primary">Volver al inicio</a>
    </div>

    <script>
        const ctx = document.getElementById('grafica');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_column($historial, 'dia')) !!},
                datasets: [{
                    label: 'Satisfacción',
                    data: {!! json_encode(array_column($historial, 'calificacion')) !!},
                    fill: false,
                    borderColor: '#FFD700', // dorado
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    x: {
                        ticks: { color: '#FFD700' },
                        grid: { color: '#333' }
                    },
                    y: {
                        ticks: { color: '#FFD700' },
                        grid: { color: '#333' }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: '#FFD700'
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
