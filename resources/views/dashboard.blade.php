<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <form method="POST" action="{{ route('update-token') }}">
                            @csrf
                            <button type="submit"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Actualizar Token
                            </button>
                        </form>
                        <div>
                            <button id="toggleToken"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Mostrar Token
                            </button>
                            <button id="copyToken"
                                class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                Copiar Token
                            </button>
                        </div>
                    </div>
                    @if ($token)
                        <div id="tokenContainer" class="bg-gray-100 p-4 rounded shadow-md" style="display: none;">
                            <strong>Token:</strong> <span id="token">{{ $token->token }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('toggleToken').addEventListener('click', function() {
            var tokenContainer = document.getElementById('tokenContainer');
            if (tokenContainer.style.display === 'none') {
                tokenContainer.style.display = 'block';
                this.textContent = 'Ocultar Token';
            } else {
                tokenContainer.style.display = 'none';
                this.textContent = 'Mostrar Token';
            }
        });

        document.getElementById('copyToken').addEventListener('click', function() {
            var token = document.getElementById('token').textContent;
            if (navigator.clipboard) {
                navigator.clipboard.writeText(token).then(function() {
                    alert('Token copiado al portapapeles');
                }, function(err) {
                    console.error('Error al copiar el token: ', err);
                });
            } else {
                // Fallback for browsers that do not support the Clipboard API
                var textarea = document.createElement('textarea');
                textarea.value = token;
                document.body.appendChild(textarea);
                textarea.select();
                try {
                    document.execCommand('copy');
                    alert('Token copiado al portapapeles');
                } catch (err) {
                    console.error('Error al copiar el token: ', err);
                }
                document.body.removeChild(textarea);
            }
        });
    </script>
</x-app-layout>