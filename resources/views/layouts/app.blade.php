<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Rekam Medis Digital')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Flowbite CSS -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(120deg, #e0f2f1, #b2dfdb);
            color: #004d40;
            min-height: 100vh;
        }
        .gradient-bg {
            background: linear-gradient(90deg, #009688, #4db6ac);
        }
        .btn-teal {
            background: #00796b;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-teal:hover {
            background: #004d40;
        }
        .card-custom {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        .sidebar-custom {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .sidebar-custom a {
            display: block;
            padding: 10px 15px;
            margin-bottom: 8px;
            border-radius: 8px;
            color: #004d40;
            text-decoration: none;
            transition: all 0.3s;
        }
        .sidebar-custom a:hover, .sidebar-custom a.active {
            background: #b2dfdb;
        }
        .profile-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #009688;
        }
        .alert-success {
            background: #c8e6c9;
            color: #2e7d32;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        .alert-error {
            background: #ffcdd2;
            color: #c62828;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        .table-custom {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            overflow: hidden;
        }
        .table-custom th, .table-custom td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        .table-custom th {
            background: #009688;
            color: white;
        }
        @media (max-width: 768px) {
            .sidebar-custom {
                width: 100%;
                margin-bottom: 20px;
            }
            .flex-container {
                flex-direction: column;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="gradient-bg shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="text-white font-bold text-xl">
                        🏥 Rekam Medis Digital
                    </a>
                </div>
                
                @auth
                <div class="flex items-center space-x-4">
                    <span class="text-white">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ url('/logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-white hover:text-teal-200">
                            🚪 Logout
                        </button>
                    </form>
                </div>
                @else
                <div class="flex items-center space-x-4">
                    <a href="{{ url('/login/pasien') }}" class="text-white hover:text-teal-200">Login Pasien</a>
                    <a href="{{ url('/login/dokter') }}" class="text-white hover:text-teal-200">Login Dokter</a>
                    <a href="{{ url('/login/admin') }}" class="text-white hover:text-teal-200">Login Admin</a>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto mt-4 px-4">
            <div class="alert-success">{{ session('success') }}</div>
        </div>
    @endif
    
    @if(session('error'))
        <div class="max-w-7xl mx-auto mt-4 px-4">
            <div class="alert-error">{{ session('error') }}</div>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    @stack('scripts')
</body>
</html>