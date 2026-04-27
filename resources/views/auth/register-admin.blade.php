<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Admin - Rekam Medis Digital</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(120deg, #e0f2f1, #b2dfdb);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .register-box {
            background: white;
            padding: 35px 40px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            width: 450px;
            text-align: center;
        }
        h2 {
            color: #00796b;
            margin-bottom: 15px;
            font-weight: 600;
        }
        label {
            display: block;
            text-align: left;
            margin-top: 15px;
            font-weight: 600;
            color: #004d40;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid #b2dfdb;
            border-radius: 6px;
            font-size: 15px;
        }
        button {
            background-color: #00796b;
            color: white;
            border: none;
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            margin-top: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background-color: #004d40;
        }
        .link {
            margin-top: 15px;
            font-size: 14px;
        }
        a {
            color: #00796b;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .alert-error {
            background: #ffcdd2;
            color: #c62828;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 14px;
        }
        .alert-success {
            background: #c8e6c9;
            color: #2e7d32;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 14px;
        }
        .captcha-container {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-top: 5px;
            flex-wrap: wrap;
        }
        .captcha-img {
            border-radius: 8px;
            border: 1px solid #b2dfdb;
        }
        .refresh-btn {
            background: #e0f2f1;
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="register-box">
        <h2>Formulir Registrasi Admin</h2>

        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert-error">
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ url('/register/admin') }}">
            @csrf
            <label>Nama Lengkap</label>
            <input type="text" name="name" placeholder="Masukkan nama lengkap" required>

            <label>Email</label>
            <input type="email" name="email" placeholder="Masukkan email aktif" required>

            <label>Username</label>
            <input type="text" name="username" placeholder="Buat username" required>

            <label>Password</label>
            <input type="password" name="password" placeholder="Buat password" required>

            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" placeholder="Konfirmasi password" required>

            <!-- CAPTCHA -->
            <label>Kode Captcha *</label>
            <div class="captcha-container">
                <img src="{{ url('/captcha') }}" alt="Captcha" id="captcha-img" class="captcha-img">
                <button type="button" class="refresh-btn" onclick="refreshCaptcha()">🔄 Refresh</button>
            </div>
            <input type="text" name="captcha" placeholder="Masukkan kode di atas" required style="margin-top: 10px;">
            @error('captcha')
                <span style="color: red; font-size: 12px;">{{ $message }}</span>
            @enderror

            <button type="submit">Daftar Sekarang</button>
        </form>

        <div class="link">
            <a href="{{ url('/home') }}">← Kembali ke Beranda</a>
        </div>
    </div>

    <script>
        function refreshCaptcha() {
            document.getElementById('captcha-img').src = "{{ url('/captcha') }}?" + Math.random();
        }
    </script>
</body>
</html>