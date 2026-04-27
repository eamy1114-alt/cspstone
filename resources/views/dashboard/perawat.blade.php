<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Perawat - Rekam Medis Digital</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e0f2f1 0%, #b2dfdb 100%);
            color: #004d40;
            min-height: 100vh;
        }

        /* Header */
        .header {
            background: linear-gradient(135deg, #009688 0%, #4db6ac 100%);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .header h2 {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .header-right {
            display: flex;
            gap: 15px;
        }

        .header-right a, .header-right button {
            color: white;
            text-decoration: none;
            background: rgba(255,255,255,0.15);
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .header-right a:hover, .header-right button:hover {
            background: rgba(255,255,255,0.3);
        }

        /* Container */
        .container {
            display: flex;
            min-height: calc(100vh - 80px);
        }

        /* Sidebar */
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

        .profile h4 {
            color: #00796b;
            font-size: 1.1rem;
        }

        .profile p {
            color: #666;
            font-size: 0.85rem;
        }

        .nav-menu {
            list-style: none;
        }

        .nav-menu li {
            margin-bottom: 8px;
        }

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

        .nav-menu a:hover {
            background: #e0f2f1;
        }

        /* Content */
        .content {
            flex: 1;
            padding: 30px;
        }

        /* Welcome Card */
        .welcome-card {
            background: linear-gradient(135deg, #ffffff 0%, #f5f5f5 100%);
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .welcome-card h2 {
            color: #00796b;
            margin-bottom: 5px;
        }

        .welcome-card p {
            color: #666;
        }

        /* Stats Grid */
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
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
        }

        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #00796b;
        }

        .stat-label {
            color: #666;
            font-size: 14px;
            margin-top: 5px;
        }

        /* Table */
        .table-container {
            background: white;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            overflow-x: auto;
        }

        .table-container h3 {
            color: #00796b;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e0f2f1;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eef2f0;
        }

        th {
            background: #f5f8f7;
            color: #004d40;
            font-weight: 600;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .status-menunggu {
            background: #fff3e0;
            color: #e65100;
        }

        .status-diproses {
            background: #e3f2fd;
            color: #1565c0;
        }

        .status-selesai {
            background: #e8f5e9;
            color: #2e7d32;
        }

        /* Buttons */
        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-primary {
            background: #009688;
            color: white;
        }

        .btn-primary:hover {
            background: #00796b;
        }

        .btn-warning {
            background: #ff9800;
            color: white;
        }

        .btn-warning:hover {
            background: #f57c00;
        }

        .btn-info {
            background: #2196f3;
            color: white;
        }

        .btn-info:hover {
            background: #1976d2;
        }

        .btn-purple {
            background: #9c27b0;
            color: white;
        }

        .btn-purple:hover {
            background: #7b1fa2;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .btn-sm {
            padding: 4px 10px;
            font-size: 11px;
        }

        /* Action Buttons Group */
        .action-buttons {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        /* Form Card */
        .form-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .form-card h2 {
            color: #00796b;
            margin-bottom: 5px;
        }

        .form-card .subtitle {
            color: #666;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
        }

        .form-group {
            flex: 1;
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #004d40;
            font-size: 14px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #009688;
            box-shadow: 0 0 0 3px rgba(0,150,136,0.1);
        }

        /* Modal */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: white;
            border-radius: 20px;
            width: 90%;
            max-width: 650px;
            max-height: 85vh;
            overflow-y: auto;
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

        .modal-header h3 {
            color: #00796b;
        }

        .close-modal {
            font-size: 24px;
            cursor: pointer;
            color: #999;
        }

        .section-title {
            background: #e0f2f1;
            padding: 10px 15px;
            border-radius: 10px;
            margin: 20px 0 15px;
            font-weight: 600;
            color: #004d40;
        }

        .info-row {
            display: flex;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }

        .info-label {
            width: 130px;
            font-weight: 600;
            color: #004d40;
        }

        .info-value {
            flex: 1;
            color: #555;
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, #009688 0%, #4db6ac 100%);
            color: white;
            text-align: center;
            padding: 12px;
            font-size: 12px;
        }

        /* Hidden */
        .hidden {
            display: none;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .action-buttons {
                flex-direction: column;
            }

            .info-row {
                flex-direction: column;
            }

            .info-label {
                width: 100%;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <h2>🏥 Dashboard Perawat</h2>
        <div class="header-right">
            <a href="#">🔔 Notifikasi</a>
            <form method="POST" action="{{ url('/logout') }}" style="display: inline;">
                @csrf
                <button type="submit">🚪 Logout</button>
            </form>
        </div>
    </div>

    <!-- Container -->
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="profile">
                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="Profile">
                <h4>{{ auth()->user()->name ?? 'Perawat' }}</h4>
                <p>{{ auth()->user()->id_dokter ?? '-' }}</p>
            </div>
            <ul class="nav-menu">
                <li><a onclick="showDashboard()" id="menuDashboard">📊 Dashboard</a></li>
                <li><a onclick="showFormPasien()" id="menuForm">➕ Pasien Baru</a></li>
            </ul>
        </div>

        <!-- Content -->
        <div class="content" id="contentArea">
            <div style="text-align: center; padding: 50px;">Memuat data...</div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        © 2025 Rekam Medis Digital | Data Kesehatan Anda Aman & Terlindungi | Enkripsi AES-256
    </div>

    <script>
        let pasienData = [];
        let currentEditId = null;

        // Data dokter untuk dropdown (diambil dari server)
        let daftarDokter = [];

        function escapeHtml(text) {
            if (!text) return '';
            return String(text).replace(/[&<>]/g, function(m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }

        function loadData() {
            fetch('{{ url("/api/pasiens") }}', {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                pasienData = data;
                showDashboard();
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById("contentArea").innerHTML = '<div class="form-card" style="text-align:center;"><h3>Gagal memuat data</h3><button onclick="loadData()" class="btn btn-primary">Coba Lagi</button></div>';
            });
        }

        function loadDokter() {
            fetch('/api/dokters', {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                daftarDokter = data;
            })
            .catch(error => {
                console.error('Error loading dokter:', error);
            });
        }

        function showDashboard() {
            const total = pasienData.length;
            const waiting = pasienData.filter(p => p.status === 'menunggu').length;
            const proses = pasienData.filter(p => p.status === 'diproses').length;
            const selesai = pasienData.filter(p => p.status === 'selesai').length;

            let html = `
                <div class="welcome-card">
                    <h2>Selamat Datang, {{ auth()->user()->name }}! 👋</h2>
                    <p>Silakan mulai bekerja dan cek antrian pasien hari ini.</p>
                </div>

                <div class="stats-grid">
                    <div class="stat-card"><div class="stat-number">${total}</div><div class="stat-label">Total Pasien</div></div>
                    <div class="stat-card"><div class="stat-number">${waiting}</div><div class="stat-label">Menunggu</div></div>
                    <div class="stat-card"><div class="stat-number">${proses}</div><div class="stat-label">Diproses</div></div>
                    <div class="stat-card"><div class="stat-number">${selesai}</div><div class="stat-label">Selesai</div></div>
                </div>

                <div class="table-container">
                    <h3>📋 Daftar Pasien & Keluhan</h3>
            `;

            if (pasienData.length === 0) {
                html += `<p style="text-align:center; padding:40px;">Belum ada data pasien. Pasien akan muncul setelah mengisi form konsultasi.</p>`;
            } else {
                html += `
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama Pasien</th>
                                <th>Usia</th>
                                <th>Keluhan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                `;

                pasienData.forEach(p => {
                    let statusClass = p.status === 'menunggu' ? 'status-menunggu' : (p.status === 'diproses' ? 'status-diproses' : 'status-selesai');
                    let statusText = p.status === 'menunggu' ? 'Menunggu' : (p.status === 'diproses' ? 'Diproses' : 'Selesai');
                    let tanggal = new Date(p.created_at).toLocaleDateString('id-ID');
                    let waktu = new Date(p.created_at).toLocaleTimeString('id-ID', {hour:'2-digit', minute:'2-digit'});
                    
                    html += `
                        <tr>
                            <td>${tanggal}<br><small>${waktu}</small></td>
                            <td><strong>${escapeHtml(p.nama_lengkap)}</strong><br><small>${p.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'}</small></td>
                            <td>${p.usia} tahun</td>
                            <td title="${escapeHtml(p.keluhan || '')}">${escapeHtml(p.keluhan ? p.keluhan.substring(0, 60) + '...' : '-')}</td>
                            <td><span class="status-badge ${statusClass}">${statusText}</span></td>
                            <td class="action-buttons">
                                <button class="btn btn-warning btn-sm" onclick="updateStatus(${p.id}, '${p.status}')">Proses</button>
                                <button class="btn btn-info btn-sm" onclick="editDataMedis(${p.id})">Edit Medis</button>
                                <a href="/pasien/${p.id}/edit-keluhan" class="btn btn-purple btn-sm">Edit Keluhan</a>
                                <button class="btn btn-primary btn-sm" onclick="lihatDetail(${p.id})">Detail</button>
                    `;
                    
                    if (p.status === 'menunggu') {
                        html += `<button class="btn btn-secondary btn-sm" onclick="kirimKeDokter(${p.id})">Kirim ke Dokter</button>`;
                    }
                    
                    html += `</td></tr>`;
                });

                html += `</tbody></table>`;
            }

            html += `</div>`;
            document.getElementById("contentArea").innerHTML = html;
            highlightMenu('dashboard');
        }

        function updateStatus(id, currentStatus) {
            let newStatus = currentStatus === 'menunggu' ? 'diproses' : (currentStatus === 'diproses' ? 'selesai' : null);
            if (!newStatus) return;
            
            if (confirm(`Ubah status pasien menjadi "${newStatus === 'diproses' ? 'Diproses' : 'Selesai'}"?`)) {
                fetch(`/pasien/${id}/status`, {
                    method: 'PATCH',
                    headers: { 
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content 
                    },
                    body: JSON.stringify({ status: newStatus })
                })
                .then(response => response.json())
                .then(data => { if (data.success) loadData(); });
            }
        }

        function kirimKeDokter(id) {
            if (confirm('Kirim data pasien ini ke dokter? Periksa kembali data medis pasien sebelum mengirim.')) {
                fetch(`/pasien/${id}/kirim-ke-dokter`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Data berhasil dikirim ke dokter!');
                        loadData();
                    } else {
                        alert('Gagal mengirim data ke dokter.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengirim data.');
                });
            }
        }

        function editDataMedis(id) {
            fetch(`/pasien/${id}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) throw new Error(data.message || 'Gagal memuat data');
                currentEditId = id;
                
                let modalHtml = `
                    <div class="modal" id="editMedisModal">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3>✏️ Edit Data Medis Pasien</h3>
                                <span class="close-modal" onclick="closeModal('editMedisModal')">&times;</span>
                            </div>
                            <div class="section-title">📋 Data Pasien: ${escapeHtml(data.nama_lengkap)}</div>
                            <div class="section-title">📝 Keluhan: ${escapeHtml(data.keluhan ? data.keluhan.substring(0, 100) + '...' : '-')}</div>
                            <div class="section-title">🩺 Data Pemeriksaan</div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Tekanan Darah (Tensi)</label>
                                    <input type="text" id="edit_tekanan_darah" value="${escapeHtml(data.tekanan_darah || '')}" placeholder="120/80">
                                </div>
                                <div class="form-group">
                                    <label>Suhu Tubuh (°C)</label>
                                    <input type="number" id="edit_suhu" step="0.1" value="${data.suhu || ''}" placeholder="36.5">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Berat Badan (kg)</label>
                                    <input type="number" id="edit_berat_badan" step="0.1" value="${data.berat_badan || ''}" placeholder="65">
                                </div>
                                <div class="form-group">
                                    <label>Tinggi Badan (cm)</label>
                                    <input type="number" id="edit_tinggi_badan" value="${data.tinggi_badan || ''}" placeholder="165">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Catatan Perawat</label>
                                <textarea id="edit_catatan_perawat" rows="3">${escapeHtml(data.catatan_perawat || '')}</textarea>
                            </div>
                            <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px;">
                                <button class="btn btn-secondary" onclick="closeModal('editMedisModal')">Batal</button>
                                <button class="btn btn-primary" onclick="saveDataMedis()">💾 Simpan Perubahan</button>
                            </div>
                        </div>
                    </div>
                `;
                document.body.insertAdjacentHTML('beforeend', modalHtml);
                document.getElementById('editMedisModal').style.display = 'flex';
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal memuat data pasien. Silakan refresh halaman.');
            });
        }

        function saveDataMedis() {
            const data = {
                tekanan_darah: document.getElementById('edit_tekanan_darah')?.value || null,
                suhu: document.getElementById('edit_suhu')?.value || null,
                berat_badan: document.getElementById('edit_berat_badan')?.value || null,
                tinggi_badan: document.getElementById('edit_tinggi_badan')?.value || null,
                catatan_perawat: document.getElementById('edit_catatan_perawat')?.value || null
            };

            fetch(`/pasien/${currentEditId}/update-medis`, {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content 
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    alert('Data medis berhasil diperbarui!');
                    closeModal('editMedisModal');
                    loadData();
                } else {
                    alert('Gagal memperbarui data.');
                }
            })
            .catch(error => { 
                console.error('Error:', error); 
                alert('Terjadi kesalahan saat menyimpan data.');
            });
        }

        function lihatDetail(id) {
            fetch(`/pasien/${id}`)
                .then(response => response.json())
                .then(data => {
                    let modalHtml = `
                        <div class="modal" id="detailModal">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3>📋 Detail Pasien</h3>
                                    <span class="close-modal" onclick="closeModal('detailModal')">&times;</span>
                                </div>
                                <div class="section-title">📋 Data Diri</div>
                                <div class="info-row"><div class="info-label">Nama:</div><div class="info-value">${escapeHtml(data.nama_lengkap)}</div></div>
                                <div class="info-row"><div class="info-label">Jenis Kelamin:</div><div class="info-value">${data.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'}</div></div>
                                <div class="info-row"><div class="info-label">Usia:</div><div class="info-value">${data.usia} tahun</div></div>
                                <div class="info-row"><div class="info-label">No. Telepon:</div><div class="info-value">${data.no_telp || '-'}</div></div>
                                <div class="info-row"><div class="info-label">Alamat:</div><div class="info-value">${escapeHtml(data.alamat || '-')}</div></div>
                                <div class="section-title">🩺 Data Pemeriksaan</div>
                                <div class="info-row"><div class="info-label">Tekanan Darah:</div><div class="info-value">${data.tekanan_darah || '-'}</div></div>
                                <div class="info-row"><div class="info-label">Suhu:</div><div class="info-value">${data.suhu || '-'} °C</div></div>
                                <div class="info-row"><div class="info-label">Berat Badan:</div><div class="info-value">${data.berat_badan || '-'} kg</div></div>
                                <div class="info-row"><div class="info-label">Tinggi Badan:</div><div class="info-value">${data.tinggi_badan || '-'} cm</div></div>
                                <div class="section-title">📝 Keluhan & Catatan</div>
                                <div class="info-row"><div class="info-label">Keluhan:</div><div class="info-value"><pre style="white-space:pre-wrap; margin:0;">${escapeHtml(data.keluhan || '-')}</pre></div></div>
                                <div class="info-row"><div class="info-label">Catatan Perawat:</div><div class="info-value">${escapeHtml(data.catatan_perawat || '-')}</div></div>
                                <div class="info-row"><div class="info-label">Status:</div><div class="info-value">${data.status}</div></div>
                                <div class="info-row"><div class="info-label">Dokter:</div><div class="info-value">${data.dokter || '-'}</div></div>
                                <div style="margin-top:20px; text-align:right;">
                                    <button class="btn btn-secondary" onclick="closeModal('detailModal')">Tutup</button>
                                </div>
                            </div>
                        </div>
                    `;
                    document.body.insertAdjacentHTML('beforeend', modalHtml);
                    document.getElementById('detailModal').style.display = 'flex';
                })
                .catch(error => console.error('Error:', error));
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) modal.remove();
        }

        function showFormPasien() {
            // Buat dropdown dokter
            let dokterOptions = '<option value="">-- Pilih Dokter Tujuan --</option>';
            
            // Data dokter dari server (hardcoded sementara, nanti dari API)
            dokterOptions += `
                <option value="3">dr. Baladewi (Umum)</option>
                <option value="2">dr. Eka (Anak)</option>
            `;
            
            document.getElementById("contentArea").innerHTML = `
                <div class="form-card">
                    <h2>➕ Form Input Data Pasien</h2>
                    <p class="subtitle">Isi data pasien dan pemeriksaan awal, lalu pilih dokter tujuan</p>
                    <form method="POST" action="{{ url('/pasien') }}">
                        @csrf
                        <div style="background:#e0f2f1; padding:15px; border-radius:12px; margin-bottom:20px;">
                            <h3 style="margin-bottom:15px;">📋 Data Pasien</h3>
                            <div class="form-row">
                                <div class="form-group"><label>Nama Lengkap Pasien *</label><input type="text" name="nama_lengkap" required></div>
                                <div class="form-group"><label>Jenis Kelamin *</label><select name="jenis_kelamin" required><option value="">-- Pilih --</option><option value="L">Laki-laki</option><option value="P">Perempuan</option></select></div>
                            </div>
                            <div class="form-row">
                                <div class="form-group"><label>Usia (Tahun) *</label><input type="number" name="usia" required></div>
                                <div class="form-group"><label>No. Telepon</label><input type="text" name="no_telp" placeholder="081234567890"></div>
                            </div>
                            <div class="form-group"><label>Alamat</label><textarea name="alamat" rows="2"></textarea></div>
                            <div class="form-group"><label>Keluhan Utama *</label><textarea name="keluhan" rows="3" required></textarea></div>
                        </div>
                        <div style="background:#e0f2f1; padding:15px; border-radius:12px; margin-bottom:20px;">
                            <h3 style="margin-bottom:15px;">🩺 Data Pemeriksaan Awal</h3>
                            <div class="form-row">
                                <div class="form-group"><label>Tensi Darah</label><input type="text" name="tekanan_darah" placeholder="120/80"></div>
                                <div class="form-group"><label>Suhu Tubuh (°C)</label><input type="number" name="suhu" step="0.1" placeholder="36.5"></div>
                            </div>
                            <div class="form-row">
                                <div class="form-group"><label>Berat Badan (kg)</label><input type="number" name="berat_badan" step="0.1" placeholder="65"></div>
                                <div class="form-group"><label>Tinggi Badan (cm)</label><input type="number" name="tinggi_badan" placeholder="165"></div>
                            </div>
                            <div class="form-group"><label>Catatan Perawat</label><textarea name="catatan_perawat" rows="2"></textarea></div>
                        </div>
                        <!-- 🔥 TAMBAHAN: Pilih Dokter -->
                        <div style="background:#e0f2f1; padding:15px; border-radius:12px; margin-bottom:20px;">
                            <h3 style="margin-bottom:15px;">👨‍⚕️ Tujuan Dokter</h3>
                            <div class="form-group">
                                <label>Pilih Dokter Tujuan *</label>
                                <select name="dokter_id" required>
                                    <option value="">-- Pilih Dokter --</option>
                                    <option value="3">dr. Baladewi (Poli Umum)</option>
                                    <option value="2">dr. Eka (Poli Anak)</option>
                                </select>
                            </div>
                        </div>
                        <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 25px;">
                            <button type="button" class="btn btn-secondary" onclick="showDashboard()">Batal</button>
                            <button type="submit" class="btn btn-primary">💾 Simpan Data Pasien</button>
                        </div>
                    </form>
                </div>
            `;
            highlightMenu('form');
        }

        function highlightMenu(active) {
            document.querySelectorAll('.nav-menu a').forEach(a => a.style.background = '');
            if (active === 'dashboard') document.getElementById('menuDashboard').style.background = '#e0f2f1';
            else if (active === 'form') document.getElementById('menuForm').style.background = '#e0f2f1';
        }

        loadData();
        loadDokter();
    </script>
</body>
</html>