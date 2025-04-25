<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Institut Teknologi Del</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
        .input-field {
            background-color: #e6f0fa;
            border: 1px solid #d1d5db;
            border-radius: 0;
        }
        .input-field:focus {
            outline: none;
            border-color: #3b82f6;
        }
        .sign-in-btn {
            background-color: #1e90ff;
            border-radius: 4px;
        }
        .sign-in-btn:hover {
            background-color: #1c86ee;
        }
    </style>
</head>
<body class="flex items-center justify-center h-screen bg-cover bg-center"
    style="background-image: url('{{ asset('img/background.png') }}'); font-family: 'Arial', sans-serif;">
    
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md bg-opacity-90">
        <!-- Logo and Header -->
        <div class="text-center mb-6">
            <img src="{{ asset('img/partners (1).png') }}" alt="DEL Logo" class="mx-auto mb-2 w-12 h-12">
            <h1 class="text-lg font-bold text-gray-800">Institut Teknologi Del</h1>
        </div>

        <!-- Error Notification -->
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-600 rounded-lg">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Form Start -->
        <form method="POST" action="{{ url('/login') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-600 text-sm font-semibold mb-1" for="username">USERNAME</label>
                <input type="text" id="username" name="username" required
                    class="w-full px-3 py-2 input-field focus:ring-0">
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-600 text-sm font-semibold mb-1" for="password">PASSWORD</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-3 py-2 input-field focus:ring-0">
            </div>

            <!-- Remember Me + Submit -->
            <div class="flex items-center justify-between mb-4">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="mr-2">
                    <span class="text-gray-600 text-sm">Remember Me</span>
                </label>
                <button type="submit"
                    class="px-4 py-2 text-white font-semibold sign-in-btn focus:outline-none">
                    Login
                </button>
            </div>
        </form>
        <!-- Form End -->
    </div>
</body>
</html>
