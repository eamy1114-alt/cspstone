<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Dokter - Rekam Medis Digital</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(120deg, #b2dfdb, #e0f2f1);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-box {
            background: white;
            padding: 35px 40px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            width: 380px;
            text-align: center;
        }
        h2 { color: #00796b; margin-bottom: 10px; }
        label { display: block; text-align: left; margin-top: 15px; font-weight: 600; color: #004d40; }
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
            padding: 10px;
            border-radius: 8px;
            margin-top: 20px;
            font-weight: 600;
            cursor: pointer;
        }
        button:hover { background-color: #004d40; }
        .link { margin-top: 15px; }
        a { color: #00796b; text-decoration: none; }
        .error {
            background: #ffcdd2;
            color: #c62828;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Login Dokter</h2>
        
        @if($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif
        
        <form method="POST" action="{{ url('/login/dokter') }}">
            @csrf
            <label>ID Dokter</label>
            <input type="text" name="id_dokter" placeholder="Masukkan ID Dokter" required>
            <label>Password</label>
            <input type="password" name="password" placeholder="Masukkan password" required>
            <button type="submit">Masuk</button>
        </form>
        <div class="link">
            <a href="{{ url('/home') }}">← Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>