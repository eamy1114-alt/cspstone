<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Patient Health Record Platform</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: url('https://images.unsplash.com/photo-1588776814546-84e7c43b0a8a?auto=format&fit=crop&w=1600&q=80') no-repeat center;
            background-size: cover;
            color: #0a3d62;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        header {
            background: linear-gradient(90deg, #009688, #4db6ac);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            flex-wrap: wrap;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }
        .logo h2 {
            color: #ffffff;
            font-size: 18px;
            margin: 0;
        }
        .navbar {
            display: flex;
            gap: 20px;
            align-items: center;
        }
        .navbar a, .dropbtn {
            color: white;
            text-decoration: none;
            font-size: 14px;
            background: none;
            border: none;
            cursor: pointer;
        }
        .dropdown { position: relative; }
        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background: white;
            min-width: 180px;
            border-radius: 8px;
            overflow: hidden;
            z-index: 1000;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }
        .dropdown-content a {
            display: block;
            padding: 10px;
            color: #00796b;
            text-decoration: none;
        }
        .dropdown-content a:hover { background: #e0f2f1; }
        .menu-toggle {
            display: none;
            font-size: 24px;
            background: none;
            border: none;
            color: white;
            cursor: pointer;
        }
        .hero {
            text-align: center;
            margin: auto;
            background: rgba(255,255,255,0.9);
            padding: 30px;
            border-radius: 15px;
            width: 90%;
            max-width: 600px;
        }
        .hero h1 {
            font-size: clamp(22px, 5vw, 36px);
            color: #00796b;
        }
        .hero h2 { font-size: clamp(18px, 4vw, 22px); }
        .hero p { font-size: 14px; }
        footer {
            background: linear-gradient(90deg, #009688, #4db6ac);
            color: white;
            text-align: center;
            padding: 10px;
            margin-top: auto;
        }
        @media (max-width: 768px) {
            .menu-toggle { display: block; }
            .navbar {
                display: none;
                flex-direction: column;
                width: 100%;
                background: #009688;
                margin-top: 10px;
                padding: 10px;
                border-radius: 10px;
            }
            .navbar.show { display: flex; }
            .dropdown-content { position: relative; background: #e0f2f1; }
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <h2>Rekam Medis Digital</h2>
        </div>
        <button class="menu-toggle" onclick="toggleMenu()">☰</button>
        <nav class="navbar" id="navbar">
            <div class="dropdown">
                <button class="dropbtn" onclick="toggleDropdown(this)">Registrasi ▼</button>
                <div class="dropdown-content">
                    <a href="{{ url('/register/pasien') }}">Pasien</a>
                    <a href="{{ url('/register/dokter') }}">Dokter</a>
                    <a href="{{ url('/register/perawat') }}">Perawat</a>
                    <a href="{{ url('/register/admin') }}">Admin</a>
                </div>
            </div>
            <div class="dropdown">
                <button class="dropbtn" onclick="toggleDropdown(this)">Login ▼</button>
                <div class="dropdown-content">
                    <a href="{{ url('/login/pasien') }}">Pasien</a>
                    <a href="{{ url('/login/dokter') }}">Dokter</a>
                    <a href="{{ url('/login/perawat') }}">Perawat</a>
                    <a href="{{ url('/login/admin') }}">Admin</a>
                </div>
            </div>
        </nav>
    </header>

    <div class="hero">
        <h2>Selamat Datang di Platform Kesehatan Digital</h2>
        <h1>Patient-Centered Health Record</h1>
        <p>Kendalikan dan kelola data kesehatan Anda secara aman, mudah, dan terpercaya.</p>
    </div>

    <footer>
        Patient-Centered Digital Health Medical Platform
    </footer>

    <script>
        function toggleMenu() {
            document.getElementById('navbar').classList.toggle('show');
        }
        function toggleDropdown(el) {
            let content = el.nextElementSibling;
            document.querySelectorAll('.dropdown-content').forEach(item => {
                if (item !== content) item.style.display = 'none';
            });
            content.style.display = content.style.display === "block" ? "none" : "block";
        }
        window.onclick = function(e) {
            if (!e.target.closest('.dropdown')) {
                document.querySelectorAll('.dropdown-content').forEach(el => el.style.display = 'none');
            }
        }
    </script>
</body>
</html>