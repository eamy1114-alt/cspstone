<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Buat Keluhan - Rekam Medis Digital</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(120deg, #e0f2f1, #b2dfdb);
            min-height: 100vh;
        }
        header {
            background: linear-gradient(90deg, #009688, #4db6ac);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            flex-wrap: wrap;
        }
        .container { max-width: 800px; margin: 40px auto; padding: 20px; }
        .card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h2 { color: #00796b; margin-bottom: 10px; border-left: 4px solid #00796b; padding-left: 15px; }
        .subtitle { color: #666; margin-bottom: 25px; font-size: 14px; margin-left: 19px; }
        .section-title {
            background: #e0f2f1;
            padding: 10px 15px;
            border-radius: 8px;
            margin: 20px 0 15px 0;
            color: #004d40;
            font-weight: 600;
        }
        .form-group { margin-bottom: 20px; }
        label { display: block; font-weight: 600; margin-bottom: 8px; color: #004d40; }
        input, textarea, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #b2dfdb;
            border-radius: 8px;
            font-size: 14px;
        }
        textarea { resize: vertical; }
        .form-row { display: flex; gap: 20px; }
        .form-row .form-group { flex: 1; }
        .radio-group {
            display: flex;
            gap: 20px;
            align-items: center;
            margin-top: 8px;
        }
        .radio-group label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: normal;
            cursor: pointer;
        }
        .radio-group input {
            width: auto;
            margin: 0;
        }
        button {
            background: #00796b;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }
        button:hover { background: #004d40; }
        .btn-back {
            background: #e0e0e0;
            color: #333;
            margin-top: 10px;
        }
        .btn-back:hover { background: #ccc; }
        .alert {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .alert-success { background: #c8e6c9; color: #2e7d32; }
        .alert-error { background: #ffcdd2; color: #c62828; }
        footer {
            background: linear-gradient(90deg, #009688, #4db6ac);
            color: white;
            text-align: center;
            padding: 12px;
            margin-top: 40px;
        }
        @media (max-width: 768px) {
            .form-row { flex-direction: column; gap: 0; }
            .container { margin: 20px auto; }
        }
    </style>
</head>
<body>

<header>
    <h2>🏥 Rekam Medis Digital</h2>
    <div>
        {{ auth()->user()->name }}
        <form method="POST" action="{{ url('/logout') }}" style="display:inline;">
            @csrf
            <button type="submit" style="background:none; border:none; color:white; cursor:pointer; margin-left:15px;">Logout</button>
        </form>
    </div>
</header>

<div class="container">
    <div class="card">
        <h2>📝 Form Konsultasi Online</h2>
        <p class="subtitle">Isi form di bawah untuk konsultasi dengan dokter. Data Anda akan kami jaga kerahasiaannya.</p>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ url('/keluhan') }}">
            @csrf

            <!-- === DATA DIRI === -->
            <div class="section-title">📋 Data Diri</div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Nama Lengkap *</label>
                    <input type="text" name="nama_lengkap" value="{{ auth()->user()->name }}" readonly style="background:#f5f5f5;">
                </div>
                <div class="form-group">
                    <label>Usia (Tahun) *</label>
                    <input type="number" name="usia" placeholder="Contoh: 25" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Jenis Kelamin *</label>
                    <select name="jenis_kelamin" required>
                        <option value="">-- Pilih --</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>No. Telepon / WhatsApp</label>
                    <input type="tel" name="no_telp" placeholder="Contoh: 081234567890">
                </div>
            </div>

            <div class="form-group">
                <label>Alamat Tempat Tinggal</label>
                <textarea name="alamat" rows="2" placeholder="Masukkan alamat lengkap Anda"></textarea>
            </div>

            <!-- === RIWAYAT KESEHATAN === -->
            <div class="section-title">🫀 Riwayat Kesehatan</div>

            <div class="form-group">
                <label>Apakah Anda pernah memiliki riwayat penyakit jantung?</label>
                <div class="radio-group">
                    <label><input type="radio" name="riwayat_jantung" value="ya"> Ya</label>
                    <label><input type="radio" name="riwayat_jantung" value="tidak" checked> Tidak</label>
                    <label><input type="radio" name="riwayat_jantung" value="tidak_tahu"> Tidak Tahu</label>
                </div>
            </div>

            <div class="form-group">
                <label>Apakah Anda memiliki tekanan darah tinggi (hipertensi)?</label>
                <div class="radio-group">
                    <label><input type="radio" name="hipertensi" value="ya"> Ya</label>
                    <label><input type="radio" name="hipertensi" value="tidak" checked> Tidak</label>
                    <label><input type="radio" name="hipertensi" value="tidak_tahu"> Tidak Tahu</label>
                </div>
            </div>

            <div class="form-group">
                <label>Apakah Anda memiliki diabetes (gula darah tinggi)?</label>
                <div class="radio-group">
                    <label><input type="radio" name="diabetes" value="ya"> Ya</label>
                    <label><input type="radio" name="diabetes" value="tidak" checked> Tidak</label>
                    <label><input type="radio" name="diabetes" value="tidak_tahu"> Tidak Tahu</label>
                </div>
            </div>

            <div class="form-group">
                <label>Apakah Anda memiliki riwayat alergi terhadap obat tertentu?</label>
                <div class="radio-group">
                    <label><input type="radio" name="alergi_obat" value="ya"> Ya</label>
                    <label><input type="radio" name="alergi_obat" value="tidak" checked> Tidak</label>
                </div>
            </div>

            <div class="form-group">
                <label>Jika Ya, alergi terhadap obat apa?</label>
                <input type="text" name="alergi_obat_detail" placeholder="Contoh: Penisilin, Amoxicillin, dll">
            </div>

            <div class="form-group">
                <label>Apakah Anda pernah menjalani operasi sebelumnya?</label>
                <div class="radio-group">
                    <label><input type="radio" name="riwayat_operasi" value="ya"> Ya</label>
                    <label><input type="radio" name="riwayat_operasi" value="tidak" checked> Tidak</label>
                </div>
            </div>

            <div class="form-group">
                <label>Jika Ya, jenis operasi apa dan kapan?</label>
                <textarea name="operasi_detail" rows="2" placeholder="Contoh: Operasi usus buntu, 2020"></textarea>
            </div>

            <!-- === KELUHAN UTAMA === -->
            <div class="section-title">🩺 Keluhan Utama</div>

            <div class="form-group">
                <label>Keluhan yang dirasakan *</label>
                <textarea name="keluhan" rows="4" placeholder="Jelaskan keluhan Anda secara detail...&#10;Contoh: Demam, batuk, sesak napas, nyeri dada, dll" required></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Sudah berapa lama keluhan ini dirasakan?</label>
                    <input type="text" name="lama_keluhan" placeholder="Contoh: 3 hari, 1 minggu">
                </div>
                <div class="form-group">
                    <label>Apakah keluhan memberat atau mereda?</label>
                    <select name="perkembangan_keluhan">
                        <option value="">-- Pilih --</option>
                        <option value="memberat">Memberat / Semakin Parah</option>
                        <option value="mereda">Mereda / Semakin Baik</option>
                        <option value="tetap">Tetap Saja</option>
                        <option value="naik_turun">Naik Turun</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Apakah sudah minum obat untuk mengatasi keluhan?</label>
                <div class="radio-group">
                    <label><input type="radio" name="sudah_minum_obat" value="ya"> Ya</label>
                    <label><input type="radio" name="sudah_minum_obat" value="tidak" checked> Tidak</label>
                </div>
            </div>

            <div class="form-group">
                <label>Jika Ya, obat apa yang sudah diminum?</label>
                <input type="text" name="obat_diminum" placeholder="Contoh: Paracetamol, Amoxicillin">
            </div>

            <button type="submit">Kirim Konsultasi</button>
            <a href="{{ url('/dashboard/pasien') }}">
                <button type="button" class="btn-back" style="margin-top: 10px;">← Kembali ke Dashboard</button>
            </a>
        </form>
    </div>
</div>

<footer>
    © 2025 Rekam Medis Digital | Data Kesehatan Anda Aman & Terlindungi | Konsultasi Online
</footer>

</body>
</html>