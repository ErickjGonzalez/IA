<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mapa de Restaurantes</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-image: url('/images/ciudad-fondo.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            height: 100vh;
            margin: 0;
            overflow: hidden;
            font-family: 'Poppins', sans-serif;
            color: #f0c94c;
        }

        body::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.8);
            z-index: 0;
        }

        .info-panel {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: rgba(20, 20, 20, 0.85);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(255, 215, 0, 0.3);
            z-index: 1;
        }

        .info-panel h5,
        .info-panel p {
            color: #f0c94c;
            margin-bottom: 8px;
        }

        .restaurante {
            position: absolute;
            cursor: pointer;
            font-size: 2.2rem;
            z-index: 1;
            filter: drop-shadow(0 0 5px gold);
            transition: transform 0.3s ease, filter 0.3s ease;
        }

        .restaurante:hover {
            transform: scale(1.4);
            filter: drop-shadow(0 0 10px #f0c94c);
        }

        .modal-content {
            background-color: #1a1a1a;
            color: #f0c94c;
            border: 2px solid #f0c94c;
        }

        .modal-header {
            border-bottom: 1px solid #f0c94c;
        }

        .modal-footer {
            border-top: 1px solid #f0c94c;
        }

        .form-select {
            background-color: #2c2c2c;
            color: #f0c94c;
            border: 1px solid #f0c94c;
        }

        .btn-success {
            background-color: #f0c94c;
            border-color: #f0c94c;
            color: #1a1a1a;
            font-weight: bold;
        }

        .btn-success:disabled {
            background-color: #bca64c;
            border-color: #bca64c;
            color: #1a1a1a;
        }

        .estrella {
            font-size: 2rem;
            color: #f0c94c;
            cursor: pointer;
            transition: transform 0.2s ease, text-shadow 0.3s ease;
            text-shadow: 0 0 3px #f0c94c;
        }

        .estrella:hover {
            transform: scale(1.3);
            text-shadow: 0 0 8px #f0c94c;
        }

        .modal-title {
            font-weight: 700;
        }

        #imagenPlatillo {
            border: 2px solid #f0c94c;
        }
    </style>
</head>
<body>

    <div class="info-panel">
        <h5>Ciudad: <strong>{{ session('ciudad') }}</strong></h5>
        <h5>Día {{ session('dia_actual') }} de {{ session('dias_totales') }}</h5>
        <p><strong>{{ session('usuario_nombre') }}</strong>, elige dónde comer hoy:</p>
    </div>

    {{-- Marcadores de restaurantes --}}
    <div class="restaurante" style="top: 200px; left: 300px;" onclick="abrirModal('Restaurante A')">🍽️</div>
    <div class="restaurante" style="top: 400px; left: 520px;" onclick="abrirModal('Restaurante B')">🍕</div>
    <div class="restaurante" style="top: 160px; left: 600px;" onclick="abrirModal('Restaurante C')">🍣</div>
    <div class="restaurante" style="top: 300px; left: 150px;" onclick="abrirModal('Restaurante D')">🍜</div>
    <div class="restaurante" style="top: 500px; left: 400px;" onclick="abrirModal('Restaurante E')">🌮</div>
    <div class="restaurante" style="top: 250px; left: 700px;" onclick="abrirModal('Restaurante F')">🥗</div>

    <!-- Modal -->
    <div class="modal fade" id="modalRestaurante" tabindex="-1" aria-labelledby="modalRestauranteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('guardar.dia') }}" onsubmit="return validarCalificacion()">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalRestauranteLabel">Restaurante</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="restaurante" id="restauranteInput">

                        <img id="imagenPlatillo" src="/images/platillo-demo.jpg" alt="Platillo" class="img-fluid mb-3 rounded shadow">

                        <label for="platillo">Platillo:</label>
                        <select name="platillo" id="platillo" class="form-select mb-3" onchange="actualizarImagenPlatillo()">
                            {{-- Se carga con JavaScript --}}
                        </select>

                        <label>Calificación:</label>
                        <div class="mb-3">
                            <input type="hidden" name="calificacion" id="calificacionInput" value="0">
                            <span class="estrella" onclick="seleccionarEstrellas(1)">☆</span>
                            <span class="estrella" onclick="seleccionarEstrellas(2)">☆</span>
                            <span class="estrella" onclick="seleccionarEstrellas(3)">☆</span>
                            <span class="estrella" onclick="seleccionarEstrellas(4)">☆</span>
                            <span class="estrella" onclick="seleccionarEstrellas(5)">☆</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="btnContinuar" type="submit" class="btn btn-success" disabled>Continuar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        const platillosPorRestaurante = {
            "Restaurante A": ["Tacos al Pastor", "Quesadillas", "Pozole", "Tamales", "Chilaquiles"],
            "Restaurante B": ["Pizza Margarita", "Calzone", "Lasaña", "Espagueti", "Panini"],
            "Restaurante C": ["Sushi Roll", "Ramen", "Tempura", "Udon", "Yakitori"],
            "Restaurante D": ["Pho", "Banh Mi", "Spring Rolls", "Bun Cha", "Curry Vietnamita"],
            "Restaurante E": ["Taco de Birria", "Sope", "Tostada", "Flauta", "Gordita"],
            "Restaurante F": ["Ensalada César", "Wrap de Pollo", "Bowl Vegano", "Smoothie", "Hummus con pan pita"]
        };

        const imagenesPlatillos = {
            "Tacos al Pastor": "/images/platillos/tacos-al-pastor.jpg",
            "Quesadillas": "/images/platillos/quesadillas.jpg",
            "Pozole": "/images/platillos/pozole.jpg",
            "Tamales": "/images/platillos/tamales.jpg",
            "Chilaquiles": "/images/platillos/chilaquiles.jpg",
            "Pizza Margarita": "/images/platillos/pizza-margarita.jpg",
            "Calzone": "/images/platillos/calzone.jpg",
            "Lasaña": "/images/platillos/lasaña.jpg",
            "Espagueti": "/images/platillos/espagueti.jpg",
            "Panini": "/images/platillos/panini.jpg",
            "Sushi Roll": "/images/platillos/sushi-roll.jpg",
            "Ramen": "/images/platillos/ramen.jpg",
            "Tempura": "/images/platillos/tempura.jpg",
            "Udon": "/images/platillos/udon.jpg",
            "Yakitori": "/images/platillos/yakitori.jpg",
            "Pho": "/images/platillos/pho.jpg",
            "Banh Mi": "/images/platillos/banh-mi.jpg",
            "Spring Rolls": "/images/platillos/spring-rolls.jpg",
            "Bun Cha": "/images/platillos/bun-cha.jpg",
            "Curry Vietnamita": "/images/platillos/curry-vietnamita.jpg",
            "Taco de Birria": "/images/platillos/tacos-de-birria.jpg",
            "Sope": "/images/platillos/sope.jpg",
            "Tostada": "/images/platillos/tostada.jpg",
            "Flauta": "/images/platillos/flauta.jpg",
            "Gordita": "/images/platillos/gordita.jpg",
            "Ensalada César": "/images/platillos/ensalada-césar.jpg",
            "Wrap de Pollo": "/images/platillos/wrap-de-pollo.jpg",
            "Bowl Vegano": "/images/platillos/bowl-vegano.jpg",
            "Smoothie": "/images/platillos/smoothie.jpg",
            "Hummus con pan pita": "/images/platillos/hummus-con-pan-pita.jpg"
        };

        function abrirModal(nombreRestaurante) {
            document.getElementById('modalRestauranteLabel').innerText = nombreRestaurante;
            document.getElementById('restauranteInput').value = nombreRestaurante;

            const platilloSelect = document.getElementById('platillo');
            platilloSelect.innerHTML = "";

            platillosPorRestaurante[nombreRestaurante].forEach(platillo => {
                const option = document.createElement("option");
                option.value = platillo;
                option.textContent = platillo;
                platilloSelect.appendChild(option);
            });

            actualizarImagenPlatillo();
            seleccionarEstrellas(0);
            new bootstrap.Modal(document.getElementById('modalRestaurante')).show();
        }

        function actualizarImagenPlatillo() {
            const platillo = document.getElementById('platillo').value;
            const img = document.getElementById('imagenPlatillo');
            img.src = imagenesPlatillos[platillo] || "/images/platillo-demo.jpg";

            img.onerror = function() {
                img.src = "/images/platillo-demo.jpg";
            };
        }

        function seleccionarEstrellas(cantidad) {
            document.getElementById('calificacionInput').value = cantidad;
            document.querySelectorAll('.estrella').forEach((estrella, index) => {
                estrella.textContent = index < cantidad ? "★" : "☆";
            });
            document.getElementById('btnContinuar').disabled = cantidad === 0;
        }

        function validarCalificacion() {
            return document.getElementById('calificacionInput').value > 0;
        }
    </script>
</body>
</html>
