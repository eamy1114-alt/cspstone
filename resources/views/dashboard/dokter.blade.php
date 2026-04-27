<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Dokter - Rekam Medis Digital</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e0f2f1 0%, #b2dfdb 100%);
            color: #004d40;
            min-height: 100vh;
        }

        .header {
            background: linear-gradient(135deg, #009688 0%, #4db6ac 100%);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .header h2 { font-size: 1.5rem; font-weight: 600; }

        .container { display: flex; min-height: calc(100vh - 80px); }

        .sidebar {
            width: 280px;
            background: white;
            padding: 25px 20px;
            box-shadow: 2px 0 15px rgba(0,0,0,0.08);
        }

        .profile {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #e0f2f1;
            margin-bottom: 20px;
        }

        .profile img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            border: 3px solid #009688;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .profile h4 { color: #00796b; font-size: 1.1rem; }
        .profile p { color: #666; font-size: 0.85rem; }

        .nav-menu { list-style: none; }
        .nav-menu li { margin-bottom: 8px; }
        .nav-menu a {
            display: block;
            padding: 12px 15px;
            text-decoration: none;
            color: #004d40;
            border-radius: 10px;
            transition: all 0.3s;
            font-weight: 500;
        }
        .nav-menu a:hover { background: #e0f2f1; }

        .content { flex: 1; padding: 30px; }

        .welcome-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .welcome-card h2 { color: #00796b; margin-bottom: 5px; }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .stat-number { font-size: 32px; font-weight: bold; color: #00796b; }
        .stat-label { color: #666; font-size: 14px; margin-top: 5px; }

        /* 🔥 CARD PASIEN YANG DIRAPIHKAN 🔥 */
        .patient-card {
            background: white;
            border-radius: 16px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .patient-header {
            background: linear-gradient(135deg, #009688 0%, #4db6ac 100%);
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .patient-name {
            font-size: 1.3rem;
            font-weight: 600;
        }

        .patient-badges {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .badge-status {
            background: rgba(255,255,255,0.2);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
        }

        .badge-timer {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .patient-body {
            padding: 20px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        .info-item {
            font-size: 14px;
            color: #555;
        }
        .info-item strong {
            color: #004d40;
            min-width: 100px;
            display: inline-block;
        }

        .keluhan-box {
            background: #f5f8f7;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
        }
        .keluhan-box h4 {
            color: #00796b;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .keluhan-box p {
            font-size: 13px;
            color: #555;
            line-height: 1.5;
            white-space: pre-wrap;
        }

        .riwayat-box {
            background: #e0f2f1;
            padding: 10px 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 12px;
            color: #555;
        }
        .riwayat-box h4 {
            color: #00796b;
            margin-bottom: 8px;
            font-size: 13px;
        }

        .action-buttons {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .btn {
            padding: 8px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-primary { background: #009688; color: white; }
        .btn-primary:hover { background: #004d40; }
        .btn-green { background: #4caf50; color: white; }
        .btn-green:hover { background: #388e3c; }
        .btn-warning { background: #ff9800; color: white; }
        .btn-warning:hover { background: #f57c00; }
        .btn-blue { background: #2196f3; color: white; }
        .btn-blue:hover { background: #1976d2; }
        .btn-secondary { background: #6c757d; color: white; }

        .badge-pending {
            background: #fff3e0;
            color: #e65100;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            display: inline-block;
        }

        .divider {
            height: 1px;
            background: #e0e0e0;
            margin: 15px 0;
        }

        .footer {
            background: linear-gradient(135deg, #009688 0%, #4db6ac 100%);
            color: white;
            text-align: center;
            padding: 12px;
            font-size: 12px;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .modal-content {
            background: white;
            width: 1000px;
            max-width: 95%;
            padding: 25px;
            border-radius: 16px;
            max-height: 80vh;
            overflow-y: auto;
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 15px;
            border-bottom: 2px solid #e0f2f1;
            margin-bottom: 20px;
        }
        .modal-header h3 { color: #00796b; }
        .close-modal { font-size: 24px; cursor: pointer; color: #999; }

        .rekam-table {
            width: 100%;
            border-collapse: collapse;
        }
        .rekam-table th, .rekam-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        .rekam-table th {
            background: #e0f2f1;
            color: #004d40;
        }
        .btn-link {
            background: #2196f3;
            color: white;
            padding: 4px 8px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 11px;
            display: inline-block;
        }
        .btn-link:hover { background: #1976d2; }

        @media (max-width: 768px) {
            .container { flex-direction: column; }
            .sidebar { width: 100%; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .patient-header { flex-direction: column; align-items: flex-start; }
            .info-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>🏥 Dashboard Dokter</h2>
        <div>👨‍⚕️ dr. {{ auth()->user()->name ?? 'Baladewi' }}</div>
    </div>

    <div class="container">
        <div class="sidebar">
            <div class="profile">
                <img src="https://cdn-icons-png.flaticon.com/512/387/387561.png" alt="Profile">
                <h4>dr. {{ auth()->user()->name ?? 'Baladewi' }}</h4>
                <p>ID: {{ auth()->user()->id_dokter ?? 'DKT001' }}</p>
                <p>Poli: {{ auth()->user()->poli ?? 'Umum' }}</p>
            </div>
            <ul class="nav-menu">
                <li><a href="{{ url('/dashboard/dokter') }}" class="active">🏠 Dashboard</a></li>
                <li><a href="{{ url('/akses/approved') }}">🔑 Akses Disetujui</a></li>
                <li><a href="{{ url('/rekam-medis/saya') }}">📋 Rekam Medis Saya</a></li>
            </ul>
            <form method="POST" action="{{ url('/logout') }}" style="margin-top: 20px;">
                @csrf
                <button type="submit" class="btn btn-secondary" style="width: 100%;">🚪 Logout</button>
            </form>
        </div>

        <div class="content">
            <div class="welcome-card">
                <h2>Selamat Datang, dr. {{ auth()->user()->name ?? 'Baladewi' }}! 👋</h2>
                <p>Poli: {{ auth()->user()->poli ?? 'Umum' }}</p>
            </div>

            <div class="stats-grid">
                <div class="stat-card"><div class="stat-number">{{ $totalPasien ?? 0 }}</div><div class="stat-label">Total Pasien</div></div>
                <div class="stat-card"><div class="stat-number">{{ $totalRekamMedis ?? 0 }}</div><div class="stat-label">Rekam Medis Dibuat</div></div>
            </div>

            <div class="welcome-card">
                <h3>📋 Daftar Pasien Antrian</h3>
                
                @forelse($antrianPasien ?? [] as $pasien)
                @php
                    $akses = \App\Models\AksesRekamMedis::where('dokter_id', auth()->id())
                        ->where('pasien_id', $pasien->id)
                        ->first();
                    $isExpired = $akses && $akses->expired_at && \Carbon\Carbon::now()->greaterThan($akses->expired_at);
                    $hasActiveAccess = $akses && $akses->status == 'approved' && !$isExpired;
                    
                    $sisaWaktu = '';
                    if ($hasActiveAccess && $akses->expired_at) {
                        $diff = \Carbon\Carbon::now()->diff($akses->expired_at);
                        if ($diff->h > 0) {
                            $sisaWaktu = $diff->h . ' jam ' . $diff->i . ' menit';
                        } else {
                            $sisaWaktu = $diff->i . ' menit';
                        }
                    }
                @endphp

                <div class="patient-card">
                    <div class="patient-header">
                        <span class="patient-name">{{ $pasien->nama_lengkap }}</span>
                        <div class="patient-badges">
                            <span class="badge-status">
                                {{ $pasien->status == 'menunggu' ? 'Menunggu' : ($pasien->status == 'diproses' ? 'Diproses' : 'Selesai') }}
                            </span>
                            @if($hasActiveAccess && $sisaWaktu)
                                <span class="badge-timer">⏱️ Sisa Akses: {{ $sisaWaktu }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="patient-body">
                        <!-- Data Pasien -->
                        <div class="info-grid">
                            <div class="info-item"><strong>👤 Usia:</strong> {{ $pasien->usia }} tahun</div>
                            <div class="info-item"><strong>📅 Tanggal Kirim:</strong> {{ $pasien->created_at->format('d/m/Y H:i') }}</div>
                            @if($pasien->tekanan_darah)
                            <div class="info-item"><strong>🩺 Tensi:</strong> {{ $pasien->tekanan_darah }} | <strong>🌡️ Suhu:</strong> {{ $pasien->suhu }}°C</div>
                            @endif
                        </div>

                        <!-- Keluhan -->
                        <div class="keluhan-box">
                            <h4>📝 Keluhan Pasien</h4>
                            <p>{{ $pasien->keluhan }}</p>
                        </div>

                        <!-- Riwayat Kesehatan (Ringkasan) -->
                        <div class="riwayat-box">
                            <h4>🫀 Riwayat Kesehatan</h4>
                            @php
                                $riwayat = explode("\n", $pasien->keluhan);
                                $riwayatKesehatan = array_slice($riwayat, -5);
                            @endphp
                            <ul style="margin-left: 20px;">
                                @foreach($riwayatKesehatan as $rk)
                                    @if(trim($rk))
                                        <li>{{ $rk }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="action-buttons">
                            @if($hasActiveAccess)
                                <a href="{{ route('rekam-medis.create', $pasien->id) }}" class="btn btn-green">📝 Buat Rekam Medis</a>
                                <button class="btn btn-primary" onclick="lihatSemuaRekamMedis({{ $pasien->id }}, '{{ $pasien->nama_lengkap }}')">
                                    📋 Lihat Semua Rekam Medis
                                </button>
                            @elseif($akses && $akses->status == 'pending')
                                <span class="badge-pending">⏳ Menunggu Persetujuan Pasien</span>
                            @elseif($isExpired)
                                <button class="btn btn-warning" onclick="mintaAkses({{ $pasien->id }}, '{{ $pasien->nama_lengkap }}')">
                                    🔑 Minta Akses Lagi (Kedaluwarsa)
                                </button>
                            @else
                                <button class="btn btn-blue" onclick="mintaAkses({{ $pasien->id }}, '{{ $pasien->nama_lengkap }}')">
                                    🔑 Minta Akses Rekam Medis
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <p style="text-align: center; padding: 40px; color: #999;">Tidak ada pasien dalam antrian.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Modal untuk Lihat Semua Rekam Medis -->
    <div id="semuaRekamModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="semuaModalTitle">📋 Semua Riwayat Rekam Medis Pasien</h3>
                <span class="close-modal" onclick="closeSemuaModal()">&times;</span>
            </div>
            <div id="semuaModalBody"><p>Memuat data...</p></div>
        </div>
    </div>

    <div class="footer">
        © 2025 Rekam Medis Digital | Data Kesehatan Anda Aman & Terlindungi | Enkripsi AES-256
    </div>

    <script>
        function mintaAkses(pasienId, namaPasien) {
            if (!pasienId) {
                alert('Data pasien tidak valid.');
                return;
            }
            if (confirm(`Kirim permintaan akses ke rekam medis pasien "${namaPasien}"?`)) {
                fetch('{{ url("/akses/request") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ pasien_id: pasienId })
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message || 'Permintaan akses telah dikirim ke pasien.');
                    location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal mengirim permintaan akses.');
                });
            }
        }

        function lihatSemuaRekamMedis(pasienId, namaPasien) {
            const modal = document.getElementById('semuaRekamModal');
            const modalTitle = document.getElementById('semuaModalTitle');
            const modalBody = document.getElementById('semuaModalBody');
            
            modalTitle.innerHTML = `📋 Semua Riwayat Rekam Medis - ${namaPasien}`;
            modal.style.display = 'flex';
            modalBody.innerHTML = '<p style="text-align:center; padding:20px;">⏳ Memuat data...</p>';
            
            fetch(`/api/rekam-medis/semua/${pasienId}`)
                .then(response => response.json())
                .then(data => {
                    if (!data || data.length === 0) {
                        modalBody.innerHTML = '<p style="text-align:center; padding:20px;">📭 Belum ada rekam medis untuk pasien ini.</p>';
                        return;
                    }
                    
                    let html = `
                        <div style="overflow-x: auto;">
                            <table class="rekam-table">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Diagnosa</th>
                                        <th>Obat</th>
                                        <th>Rumah Sakit</th>
                                        <th>Dokter</th>
                                        <th>Foto Rontgen</th>
                                        <th>Hasil Lab</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;
                    
                    data.forEach(rm => {
                        let tanggal = new Date(rm.tanggal_pemeriksaan).toLocaleDateString('id-ID');
                        
                        let fotoRontgen = '-';
                        if (rm.foto_rontgen) {
                            fotoRontgen = `<a href="/storage/${rm.foto_rontgen}" target="_blank" class="btn-link">📷 Lihat</a>`;
                        }
                        
                        let hasilLab = '-';
                        if (rm.hasil_lab) {
                            hasilLab = `<a href="/storage/${rm.hasil_lab}" target="_blank" class="btn-link">📄 Download</a>`;
                        }
                        
                        html += `
                            <tr>
                                <td>${tanggal}</td>
                                <td>${rm.diagnosa || '-'}</td>
                                <td>${rm.obat || '-'}</td>
                                <td>${rm.rumah_sakit || '-'}</td>
                                <td>${rm.dokter || '-'}</td>
                                <td>${fotoRontgen}</td>
                                <td>${hasilLab}</td>
                            </tr>
                        `;
                    });
                    
                    html += `
                                </tbody>
                            </table>
                        </div>
                        <div style="margin-top:20px; text-align:right;">
                            <button class="btn btn-secondary" onclick="closeSemuaModal()">Tutup</button>
                        </div>
                    `;
                    modalBody.innerHTML = html;
                })
                .catch(error => {
                    console.error('Error:', error);
                    modalBody.innerHTML = `<p style="text-align:center; padding:20px;">❌ Gagal memuat data.</p>`;
                });
        }

        function closeSemuaModal() {
            document.getElementById('semuaRekamModal').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('semuaRekamModal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>