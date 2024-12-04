<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Generador QR para Eventos Estudiantiles</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Figtree', sans-serif;
        }

        .hero-section {
            background: linear-gradient(135deg, #6a11cb, #ff6f91);
            /* Azul a rosado como en login y register */
            padding: 50px 0;
            color: white;
        }

        .hero-section h1 {
            font-size: 3rem;
            font-weight: 600;
        }

        .hero-section p {
            font-size: 1.2rem;
        }

        .container {
            margin-top: 30px;
        }

        .auth-links {
            margin-top: 30px;
        }

        .auth-links a {
            margin: 0 15px;
            font-size: 1.1rem;
            color: #fff;
            /* Color blanco para texto */
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            border: 2px solid #fff;
            /* Borde blanco por defecto */
            background-color: #6a11cb;
            /* Fondo morado cuando no se pasa el mouse */
            transition: background-color 0.3s, border-color 0.3s;
        }

        .auth-links a:hover {
            background-color: #ff6f91;
            /* Rosado al hacer hover */
            border-color: #ff6f91;
        }

        .auth-links a:active {
            background-color: #ff3b72;
            /* Un rosado más intenso al hacer clic */
            border-color: #ff3b72;
        }

        /* Sección de descripción */
        .description-section {
            background-color: #ffffff;
            padding: 50px 0;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .description-section .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .description-section img {
            max-width: 100%;
            height: auto;
            width: 460px;
            /* Tamaño de la imagen, puedes ajustarlo según lo que necesites */
            border-radius: 8px;
        }

        .description-section .text-description {
            max-width: 600px;
        }

        .description-section h2 {
            font-size: 2rem;
            font-weight: 600;
            color: #6a11cb;
        }

        .description-section p {
            font-size: 1.1rem;
            color: #333;
            line-height: 1.6;
        }
    </style>
</head>

<body class="antialiased">

    <!-- Hero Section -->
    <div class="hero-section text-center">
        <h1>Bienvenidos al Generador QR para Eventos Estudiantiles</h1>
        <p>Genera códigos QR personalizados para tus eventos de manera fácil y rápida.</p>
    </div>

    <!-- Descripción de la API -->
    <div class="description-section">
        <div class="container">
            <!-- Imagen -->
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRg-QBZ54jd14FMfio4oeCjtdFhvoZ4nl7lDA&s"
                alt="Imagen de la API">

            <!-- Descripción -->
            <div class="text-description">
                <h2>¿Qué es el Generador QR?</h2>
                <p>
                    El Generador QR para Eventos Estudiantiles es una herramienta fácil y rápida que permite crear
                    códigos QR personalizados para tus eventos. Puedes generar códigos QR para entradas, enlaces
                    a información importante o cualquier recurso que necesite ser accesible a través de un escaneo
                    rápido y sencillo.
                </p>

            </div>
        </div>
    </div>

    <!-- Authentication Links -->
    @if (Route::has('login'))
        <div class="auth-links text-center">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-outline-light">Ir al Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-light">Iniciar Sesión</a>
            @endauth
        </div>
    @endif

    <!-- Footer -->
    <footer class="text-center mt-5 py-4" style="background-color: #f8f9fa;">
        <p>&copy; 2024 Generador QR para Eventos Estudiantiles. Todos los derechos reservados.</p>
    </footer>

</body>

</html>
