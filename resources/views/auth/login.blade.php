<x-guest-layout>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* Fondo degradado */
        body {
            background: linear-gradient(to bottom, #1d2b64, #f8cdda);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .custom-login-container {
            max-width: 400px;
            margin: auto;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
        }

        .custom-login-header {
            display: flex;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .custom-login-header img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
        }

        .custom-label {
            color: #6B7280;
            font-weight: bold;
        }

        .custom-input {
            background-color: #fff;
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 10px;
            margin-top: 8px;
            margin-bottom: 16px;
            width: 100%;
            color: #333;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .custom-input:focus {
            border-color: #6c63ff;
            box-shadow: 0 2px 8px rgba(108, 99, 255, 0.4);
            outline: none;
        }

        .custom-button {
            background-color: #ff4081;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 20px;
            cursor: pointer;
            width: 100%;
            margin-top: 1rem;
            font-weight: bold;
            font-size: 1em;
        }

        .custom-button:hover {
            background-color: #ff1053;
        }

        .remember-forgot {
            margin-top: 1rem;
            font-size: 0.9rem;
            display: flex;
            flex-direction: column;
            /* Cambia la orientación a vertical */
            align-items: flex-start;
            /* Alinea los elementos hacia la izquierda */
            gap: 0.5rem;
            /* Añade un pequeño espacio entre los elementos */
        }

        .remember-forgot label {
            color: #6B7280;
            display: flex;
            align-items: center;
        }

        .remember-forgot a {
            color: #6B7280;
            text-decoration: none;
        }

        .remember-forgot a:hover {
            color: #ff4081;
        }
    </style>

    <div class="custom-login-container">
        <div class="custom-login-header">
            <img src="https://cdn1.iconfinder.com/data/icons/chunk/16/User-512.png" alt="User Icon">
        </div>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="custom-label" />
                <input id="email" class="custom-input" type="email" name="email" :value="old('email')" required
                    autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" class="custom-label" />
                <input id="password" class="custom-input" type="password" name="password" required
                    autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me and Forgot Password -->
            <div class="remember-forgot">
                <label for="remember_me">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ml-2">{{ __('Remember me') }}</span>
                </label>
            </div>

            <button type="submit" class="custom-button">
                {{ __('Log in') }}
            </button>
        </form>
    </div>
</x-guest-layout>
