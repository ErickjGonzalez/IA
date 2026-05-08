<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Simulador de Viaje</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Montserrat:wght@300;500&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(135deg, #000000, #1a1a1a);
            color: #f5f5f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at center, rgba(255,215,0,0.15), transparent 70%);
            animation: pulse 6s infinite ease-in-out;
            z-index: 0;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.6; }
            50% { transform: scale(1.1); opacity: 1; }
        }

        .container {
            position: relative;
            z-index: 1;
            background: rgba(30, 30, 30, 0.95);
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 0 30px rgba(255, 215, 0, 0.15);
            max-width: 500px;
            width: 90%;
            text-align: center;
            animation: fadeIn 1.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            margin-bottom: 2rem;
            color: #FFD700;
            text-shadow: 0 0 10px #FFD70044;
        }

        label {
            display: block;
            text-align: left;
            margin-top: 1.5rem;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #f5f5f5;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 0.8rem;
            border: none;
            border-radius: 10px;
            background-color: #222;
            color: #f5f5f5;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        input:focus {
            outline: none;
            box-shadow: 0 0 8px #FFD70088;
            background-color: #2c2c2c;
        }

        button {
            margin-top: 2rem;
            background: linear-gradient(145deg, #FFD700, #bfa300);
            color: #000;
            padding: 0.9rem 2rem;
            font-size: 1.1rem;
            font-weight: bold;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(255, 215, 0, 0.3);
            transition: transform 0.2s ease, box-shadow 0.3s ease;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 215, 0, 0.5);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🍽 Bienvenido al simulador SIRRA</h1>
        <form action="{{ route('simulador.iniciar') }}" method="POST">
            @csrf
            <label for="nombre">Tu nombre:</label>
            <input type="text" name="nombre" required>

            <label for="ciudad">Ciudad a visitar:</label>
            <input type="text" name="ciudad" required>

            <label for="dias">Cantidad de días:</label>
            <input type="number" name="dias" min="1" required>

            <button type="submit">✨ Comenzar mi viaje</button>
        </form>
    </div>
</body>
</html>
