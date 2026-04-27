<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Pasien - Rekam Medis Digital</title>
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
        .header-right { display: flex; gap: 15px; }
        .header-right a, .header-right button {
            color: white;
            text-decoration: none;
            background: rgba(255,255,255,0.15);
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }
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
        .profile h4 { color: #00796b; }
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
            cursor: pointer;
        }
        .nav-menu a:hover { background: #e0f2f1; }
        .content { flex: 1; padding: 30px; }
        .card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .card h2 {
            color: #00796b;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e0f2f1;
        }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eef2f0; }
        th { background: #f5f8f7; color: #004d40; font-weight: 600; }
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 500;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-primary { background: #009688; color: white; }
        .btn-primary:hover { background: #00796b; }
        .btn-approve { background: #4caf50; color: white; }
        .btn-approve:hover { background: #388e3c; }
        .btn-deny { background: #e57373; color: white; }
        .btn-deny:hover { background: #c62828; }
        .badge { background: red; color: white; border-radius: 50%; padding: 2px 6px; font-size: 10px; margin-left: 5px; }
        .info-durasi {
            background: #e3f2fd;
            color: #1565c0;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 12px;
            margin-bottom: 15px;
            display: inline-block;
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
            border-radius: 20px;
            width: 90%;
            max-width: 450px;
            padding: 25px;
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
        .request-item { border-bottom: 1px solid #eee; padding: 15px 0; }
        .request-item:last-child { border-bottom: none; }
        .footer {
            background: linear-gradient(135deg, #009688 0%, #4db6ac 100%);
            color: white;
            text-align: center;
            padding: 12px;
            font-size: 12px;
        }
        @media (max-width: 768px) {
            .container { flex-direction: column; }
            .sidebar { width: 100%; }
            .content { padding: 20px; }
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>🏥 Dashboard Pasien</h2>
        <div class="header-right">
            <a href="#" id="notifBtn">🔔 Notifikasi</a>
            <form method="POST" action="{{ url('/logout') }}" style="display: inline;">
                @csrf
                <button type="submit">🚪 Logout</button>
            </form>
        </div>
    </div>

    <div class="container">
        <div class="sidebar">
            <div class="profile">
                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="Profile">
                <h4>{{ auth()->user()->name ?? 'Pasien' }}</h4>
                <p>{{ auth()->user()->email ?? '' }}</p>
            </div>
            <ul class="nav-menu">
                <li><a href="{{ url('/rekam-medis-saya') }}">📂 Rekam Medis Saya</a></li>
                <li><a href="{{ url('/keluhan/create') }}">📝 Buat Keluhan Baru</a></li>
                <li><a href="{{ url('/keluhan/riwayat') }}">📋 Riwayat Keluhan</a></li>
                <li><a href="#" onclick="openPopup()" id="aksesBtn">🔔 Akses</a></li>
            </ul>
        </div>

        <div class="content">
            <div class="card">
                <h2>📋 Daftar Kunjungan</h2>
                <div style="overflow-x: auto;">
                    <table>
                        <thead><tr><th>Tanggal Pemeriksaan</th><th>Rumah Sakit</th><th>Dokter</th><th>Aksi</th></tr></thead>
                        <tbody>
                            @forelse($rekamMedis ?? [] as $rm)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($rm->tanggal_pemeriksaan)->format('d F Y') }}</td>
                                <td>{{ $rm->rumah_sakit }}</td>
                                <td>{{ $rm->dokter->name ?? '-' }}</td>
                                <td><a href="{{ url('/rekam-medis/'.$rm->id) }}" class="btn btn-primary">Detail</a></td>
                            </tr>
                            @empty
                            <tr><td colspan="4" style="text-align:center;">Belum ada riwayat kunjungan</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <h2>📋 Riwayat Keluhan Terbaru</h2>
                <div style="overflow-x: auto;">
                    <table>
                        <thead><tr><th>Tanggal</th><th>Keluhan</th><th>Status</th></tr></thead>
                        <tbody>
                            @forelse(($riwayatKeluhan ?? collect())->take(5) as $keluhan)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($keluhan->created_at)->format('d/m/Y H:i') }}</td>
                                <td>{{ Str::limit($keluhan->keluhan, 50) }}</td>
                                <td><span class="status-badge">{{ $keluhan->status == 'menunggu' ? 'Menunggu' : ($keluhan->status == 'diproses' ? 'Diproses' : 'Selesai') }}</span></td>
                            </tr>
                            @empty
                            <tr><td colspan="3" style="text-align:center;">Belum ada riwayat keluhan</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- POPUP AKSES -->
    <div id="popupAkses" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>🔔 Permintaan Akses dari Dokter</h3>
                <span class="close-modal" onclick="closePopup()">&times;</span>
            </div>
            <p class="info-durasi">⏱️ Catatan: Akses yang Anda setujui akan aktif selama 30 menit</p>
            <div id="popupAksesContent">
                <p style="text-align:center; padding:20px;">Memuat...</p>
            </div>
        </div>
    </div>

    <div class="footer">
        © 2025 Rekam Medis Digital | Data Kesehatan Anda Aman & Terlindungi | Enkripsi AES-256
    </div>

    <script>
        function loadAksesRequests() {
            fetch('/api/akses-requests', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                updatePopupContent(data);
                updateBadges(data.length);
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('popupAksesContent').innerHTML = '<p style="text-align:center; padding:20px;">Gagal memuat permintaan akses.<br>Silakan refresh halaman.</p>';
            });
        }

        function updatePopupContent(requests) {
            const popupContent = document.getElementById('popupAksesContent');
            if (!popupContent) return;
            
            if (!requests || requests.length === 0) {
                popupContent.innerHTML = '<p style="text-align:center; padding:20px;">Tidak ada permintaan akses</p>';
                return;
            }
            
            let html = '';
            requests.forEach(req => {
                html += `
                    <div class="request-item">
                        <p><strong>Dokter:</strong> ${req.dokter?.name || '-'}</p>
                        <p><strong>Poli:</strong> ${req.dokter?.poli || 'Umum'}</p>
                        <p><strong>Keluhan:</strong> ${req.pasien?.keluhan?.substring(0, 50) || '-'}...</p>
                        <p><strong>Tanggal:</strong> ${new Date(req.created_at).toLocaleString('id-ID')}</p>
                        <p><strong>Durasi Akses:</strong> 30 menit</p>
                        <div style="margin-top: 10px; display: flex; gap: 10px;">
                            <form method="POST" action="/akses/approve/${req.id}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-approve" onclick="return confirm('Setujui akses ini? Akses akan aktif selama 30 menit.')">✅ Setujui (30 menit)</button>
                            </form>
                            <form method="POST" action="/akses/deny/${req.id}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-deny" onclick="return confirm('Tolak akses ini?')">❌ Tolak</button>
                            </form>
                        </div>
                    </div>
                `;
            });
            popupContent.innerHTML = html;
        }

        function updateBadges(count) {
            const notifBtn = document.getElementById('notifBtn');
            const aksesBtn = document.getElementById('aksesBtn');
            
            if (count > 0) {
                if (notifBtn) notifBtn.innerHTML = `🔔 Notifikasi <span class="badge">${count}</span>`;
                if (aksesBtn) aksesBtn.innerHTML = `🔔 Akses <span class="badge">${count}</span>`;
            } else {
                if (notifBtn) notifBtn.innerHTML = '🔔 Notifikasi';
                if (aksesBtn) aksesBtn.innerHTML = '🔔 Akses';
            }
        }

        function openPopup() {
            document.getElementById('popupAkses').style.display = 'flex';
            loadAksesRequests();
        }

        function closePopup() {
            document.getElementById('popupAkses').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('popupAkses');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            loadAksesRequests();
        });
    </script>
</body>
</html>