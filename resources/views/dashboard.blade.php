<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $pageTitle ?? 'Generador QR para Eventos Estudiantiles' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="antialiased bg-gradient-to-br from-indigo-200 via-purple-100 to-pink-100">

    <!-- Botón Logout en la esquina superior derecha -->
    @auth
    <div class="absolute top-4 right-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-6 rounded">
                Logout
            </button>
        </form>
    </div>
    @endauth

    <!-- Header con fondo degradado -->
    <header class="w-full bg-gradient-to-r from-purple-600 via-pink-500 to-red-500 py-8 text-center text-white">
        <h1 class="text-4xl font-semibold">
            {{ $pageTitle ?? 'Generador QR para Eventos Estudiantiles' }}
        </h1>
        <p class="text-lg mt-2">
            {{ $heroSubtitle ?? 'Genera códigos QR personalizados para tus eventos de manera fácil y rápida.' }}
        </p>
    </header>

    <!-- Contenedor principal -->
    <div class="min-h-screen flex justify-center items-center py-12">

        <!-- Contenedor rectangular más grande con bordes y sombra -->
        <div class="bg-white rounded-lg shadow-2xl w-full max-w-7xl p-16" style="min-height: 57vh;">
            <!-- Botones de Acción -->
            <div class="flex justify-center mt-6 space-x-4">
                <form method="POST" action="{{ route('update-token') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-6 rounded">
                        Actualizar Token
                    </button>
                </form>
                <button id="toggleToken" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                    Mostrar Token
                </button>
                <button id="copyToken" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-6 rounded">
                    Copiar Token
                </button>
            </div>

            <!-- Contenedor del Token -->
            @if ($token)
                <div id="tokenContainer" class="bg-gray-100 text-gray-800 p-6 rounded mt-4 shadow-md hidden">
                    <strong>Token:</strong> <span id="token">{{ $token->token }}</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Pie de página -->
    <footer class="text-center py-6">
        <p class="text-gray-700">&copy; 2024 Generador QR para Eventos Estudiantiles. Todos los derechos reservados.</p>
    </footer>

    <!-- JavaScript -->
    <script>
        // Función para alternar la visibilidad del token
        document.getElementById('toggleToken').addEventListener('click', function() {
            var tokenContainer = document.getElementById('tokenContainer');
            if (tokenContainer.classList.contains('hidden')) {
                tokenContainer.classList.remove('hidden');
                this.textContent = 'Ocultar Token';
            } else {
                tokenContainer.classList.add('hidden');
                this.textContent = 'Mostrar Token';
            }
        });

        // Función para copiar el token
        document.getElementById('copyToken').addEventListener('click', function() {
            var token = document.getElementById('token').textContent;
            copyToClipboard(token, 'Token copiado al portapapeles');
        });

        // Función para copiar al portapapeles
        function copyToClipboard(content, successMessage) {
            if (navigator.clipboard) {
                navigator.clipboard.writeText(content).then(function() {
                    alert(successMessage);
                }, function(err) {
                    console.error('Error al copiar: ', err);
                });
            } else {
                var textarea = document.createElement('textarea');
                textarea.value = content;
                document.body.appendChild(textarea);
                textarea.select();
                try {
                    document.execCommand('copy');
                    alert(successMessage);
                } catch (err) {
                    console.error('Error al copiar: ', err);
                }
                document.body.removeChild(textarea);
            }
        }
    </script>
</body>

</html>