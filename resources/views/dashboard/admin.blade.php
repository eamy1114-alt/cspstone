<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Admin - Rekam Medis Digital</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(120deg, #e0f2f1, #b2dfdb);
            color: #004d40;
            min-height: 100vh;
        }
        
        /* Header */
        header {
            background: linear-gradient(90deg, #009688, #4db6ac);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            flex-wrap: wrap;
        }
        
        /* Container */
        .dashboard-container {
            display: flex;
            min-height: calc(100vh - 80px);
        }
        
        /* Sidebar */
        .sidebar {
            width: 280px;
            background: white;
            padding: 20px;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        .profile-sidebar {
            text-align: center;
            border-bottom: 2px solid #b2dfdb;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .profile-sidebar img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            border: 3px solid #009688;
            object-fit: cover;
        }
        .profile-sidebar h4 { margin: 10px 0 5px; color: #00796b; }
        .profile-sidebar p { color: #666; font-size: 14px; }
        
        .sidebar-menu { list-style: none; }
        .sidebar-menu li { margin-bottom: 8px; }
        .sidebar-menu a {
            display: block;
            padding: 12px 15px;
            text-decoration: none;
            color: #004d40;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: #b2dfdb;
        }
        .logout-btn {
            width: 100%;
            background: #e57373;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 20px;
            font-weight: 600;
        }
        .logout-btn:hover { background: #c62828; }
        
        /* Content */
        .content {
            flex: 1;
            padding: 25px;
        }
        
        /* Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .stat-card .icon { font-size: 40px; margin-bottom: 10px; }
        .stat-card .value { font-size: 28px; font-weight: bold; color: #00796b; }
        .stat-card .label { color: #666; font-size: 14px; }
        
        /* Tables */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            overflow: hidden;
        }
        .data-table th, .data-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        .data-table th {
            background: #009688;
            color: white;
        }
        .data-table tr:hover { background: #f5f5f5; }
        
        /* Buttons */
        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s;
        }
        .btn-primary { background: #00796b; color: white; }
        .btn-primary:hover { background: #004d40; }
        .btn-edit { background: #ffb74d; color: white; }
        .btn-edit:hover { background: #f57c00; }
        .btn-delete { background: #e57373; color: white; }
        .btn-delete:hover { background: #c62828; }
        .btn-success { background: #4caf50; color: white; }
        
        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background: white;
            width: 500px;
            max-width: 90%;
            padding: 25px;
            border-radius: 12px;
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #b2dfdb;
        }
        .modal-header h3 { color: #00796b; }
        .close-modal {
            font-size: 24px;
            cursor: pointer;
            color: #999;
        }
        .form-group { margin-bottom: 15px; }
        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
            color: #004d40;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #b2dfdb;
            border-radius: 6px;
            font-size: 14px;
        }
        
        /* Tabs */
        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            border-bottom: 2px solid #b2dfdb;
        }
        .tab-btn {
            padding: 10px 20px;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
            color: #666;
        }
        .tab-btn.active {
            color: #00796b;
            border-bottom: 2px solid #00796b;
        }
        .tab-pane { display: none; }
        .tab-pane.active { display: block; }
        
        /* Search & Filter */
        .search-bar {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .search-bar input, .search-bar select {
            padding: 10px;
            border: 1px solid #b2dfdb;
            border-radius: 6px;
            font-size: 14px;
        }
        .search-bar input { flex: 1; }
        
        /* Pagination */
        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .pagination a, .pagination span {
            padding: 8px 12px;
            border: 1px solid #b2dfdb;
            border-radius: 6px;
            text-decoration: none;
            color: #00796b;
        }
        .pagination .active {
            background: #00796b;
            color: white;
        }
        
        @media (max-width: 768px) {
            .dashboard-container { flex-direction: column; }
            .sidebar { width: 100%; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .data-table { font-size: 12px; }
            .data-table th, .data-table td { padding: 8px; }
        }
    </style>
</head>
<body>
    <header>
        <h2>🏥 Dashboard Admin</h2>
        <div>👑 {{ auth()->user()->name ?? 'Administrator' }}</div>
    </header>

    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="profile-sidebar">
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png">
                <h4>{{ auth()->user()->name ?? 'Administrator' }}</h4>
                <p>Super Admin</p>
            </div>
            <ul class="sidebar-menu">
                <li><a href="#" onclick="showTab('dashboard')" class="active" id="tab-dashboard">📊 Dashboard</a></li>
                <li><a href="#" onclick="showTab('data-vk')" id="tab-data-vk">📋 Data VK</a></li>
                <li><a href="#" onclick="showTab('users')" id="tab-users">👥 Manajemen User</a></li>
                <li><a href="#" onclick="showTab('logs')" id="tab-logs">📝 Log Aktivitas</a></li>
            </ul>
            <form method="POST" action="{{ url('/logout') }}">
                @csrf
                <button type="submit" class="logout-btn">🚪 Logout</button>
            </form>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Tab Dashboard -->
            <div id="dashboard-tab" class="tab-pane active">
                <h2 style="margin-bottom: 20px;">📊 Dashboard Statistik</h2>
                
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="icon">👥</div>
                        <div class="value">{{ $totalUsers ?? 0 }}</div>
                        <div class="label">Total User</div>
                    </div>
                    <div class="stat-card">
                        <div class="icon">👨‍⚕️</div>
                        <div class="value">{{ $totalDokter ?? 0 }}</div>
                        <div class="label">Dokter</div>
                    </div>
                    <div class="stat-card">
                        <div class="icon">👩‍⚕️</div>
                        <div class="value">{{ $totalPerawat ?? 0 }}</div>
                        <div class="label">Perawat</div>
                    </div>
                    <div class="stat-card">
                        <div class="icon">👤</div>
                        <div class="value">{{ $totalPasien ?? 0 }}</div>
                        <div class="label">Pasien</div>
                    </div>
                    <div class="stat-card">
                        <div class="icon">📋</div>
                        <div class="value">{{ $totalPasiens ?? 0 }}</div>
                        <div class="label">Data Pasien</div>
                    </div>
                    <div class="stat-card">
                        <div class="icon">📝</div>
                        <div class="value">{{ $totalRekamMedis ?? 0 }}</div>
                        <div class="label">Rekam Medis</div>
                    </div>
                    <div class="stat-card">
                        <div class="icon">🤰</div>
                        <div class="value">{{ $totalDataVK ?? 0 }}</div>
                        <div class="label">Data VK</div>
                    </div>
                    <div class="stat-card">
                        <div class="icon">📊</div>
                        <div class="value">{{ $totalLogs ?? 0 }}</div>
                        <div class="label">Log Aktivitas</div>
                    </div>
                </div>

                <!-- Data VK Terbaru -->
                <div style="background: white; border-radius: 12px; padding: 20px; margin-top: 20px;">
                    <h3 style="margin-bottom: 15px;">📋 Data VK Terbaru</h3>
                    <div style="overflow-x: auto;">
                        <table class="data-table">
                            <thead>
                                <tr><th>Tanggal</th><th>Nama Pasien</th><th>Diagnosa</th><th>Tindakan</th><th>Dokter</th></tr>
                            </thead>
                            <tbody>
                                @forelse($recentDataVK ?? [] as $data)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d/m/Y') }}</td>
                                    <td>{{ $data->nama_pasien }}</td>
                                    <td>{{ Str::limit($data->diagnosa, 40) }}</td>
                                    <td>{{ $data->tindakan }}</td>
                                    <td>{{ $data->nama_dokter }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="5" style="text-align:center;">Belum ada data VK</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Tab Data VK (CRUD) -->
            <div id="data-vk-tab" class="tab-pane">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h2>📋 Manajemen Data VK</h2>
                    <button class="btn btn-primary" onclick="openModal('addVKModal')">+ Tambah Data VK</button>
                </div>

                <!-- Search & Filter -->
                <div class="search-bar">
                    <input type="text" id="searchVK" placeholder="Cari nama pasien..." onkeyup="filterVK()">
                    <select id="filterBulan" onchange="filterVK()">
                        <option value="">Semua Bulan</option>
                        @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $b)
                        <option value="{{ $i+1 }}">{{ $b }}</option>
                        @endforeach
                    </select>
                    <select id="filterTahun" onchange="filterVK()">
                        <option value="">Semua Tahun</option>
                        @for($t=2024; $t<=2026; $t++)
                        <option value="{{ $t }}">{{ $t }}</option>
                        @endfor
                    </select>
                </div>

                <!-- Table Data VK -->
                <div style="background: white; border-radius: 12px; overflow-x: auto;">
                    <table class="data-table" id="vkTable">
                        <thead>
                            <tr>
                                <th>No</th><th>Tanggal</th><th>Nama Pasien</th><th>No. RM</th><th>Diagnosa</th>
                                <th>Tindakan</th><th>Dokter</th><th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dataVK ?? [] as $index => $data)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d/m/Y') }}</td>
                                <td>{{ $data->nama_pasien }}</td>
                                <td>{{ $data->no_rm }}</td>
                                <td>{{ Str::limit($data->diagnosa, 40) }}</td>
                                <td>{{ $data->tindakan }}</td>
                                <td>{{ $data->nama_dokter }}</td>
                                <td>
                                    <button class="btn btn-edit" onclick="editVK({{ $data->id }})">Edit</button>
                                    <button class="btn btn-delete" onclick="deleteVK({{ $data->id }})">Hapus</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="pagination">
                    {{ $dataVK->links() ?? '' }}
                </div>
            </div>

            <!-- Tab Manajemen User -->
            <div id="users-tab" class="tab-pane">
                <h2 style="margin-bottom: 20px;">👥 Manajemen User</h2>
                
                <div class="search-bar">
                    <input type="text" id="searchUser" placeholder="Cari username atau nama..." onkeyup="filterUser()">
                    <select id="filterRole" onchange="filterUser()">
                        <option value="">Semua Role</option>
                        <option value="admin">Admin</option>
                        <option value="dokter">Dokter</option>
                        <option value="perawat">Perawat</option>
                        <option value="pasien">Pasien</option>
                    </select>
                </div>

                <div style="background: white; border-radius: 12px; overflow-x: auto;">
                    <table class="data-table" id="userTable">
                        <thead>
                            <tr><th>No</th><th>Nama</th><th>Username</th><th>Email</th><th>Role</th><th>ID Dokter</th><th>Poli</th><th>Aksi</th></tr>
                        </thead>
                        <tbody>
                            @foreach($users ?? [] as $index => $user)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td><span style="background: #e0f2f1; padding: 4px 8px; border-radius: 20px;">{{ $user->role }}</span></td>
                                <td>{{ $user->id_dokter ?? '-' }}</td>
                                <td>{{ $user->poli ?? '-' }}</td>
                                <td>
                                    <button class="btn btn-delete" onclick="deleteUser({{ $user->id }})">Hapus</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tab Log Aktivitas -->
            <div id="logs-tab" class="tab-pane">
                <h2 style="margin-bottom: 20px;">📝 Log Aktivitas</h2>
                
                <div class="search-bar">
                    <input type="text" id="searchLog" placeholder="Cari aktivitas..." onkeyup="filterLog()">
                    <input type="date" id="filterDate" onchange="filterLog()">
                </div>

                <div style="background: white; border-radius: 12px; overflow-x: auto;">
                    <table class="data-table" id="logTable">
                        <thead>
                            <tr><th>No</th><th>Waktu</th><th>User</th><th>Aktivitas</th><th>IP Address</th><th>Detail</th></tr>
                        </thead>
                        <tbody>
                            @foreach($logs ?? [] as $index => $log)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i:s') }}</td>
                                <td>{{ $log->user->name ?? '-' }}</td>
                                <td>{{ $log->aktivitas }}</td>
                                <td>{{ $log->ip_address }}</td>
                                <td>{{ Str::limit($log->detail, 50) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="pagination">
                    {{ $logs->links() ?? '' }}
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL TAMBAH DATA VK -->
    <div id="addVKModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>➕ Tambah Data VK</h3>
                <span class="close-modal" onclick="closeModal('addVKModal')">&times;</span>
            </div>
            <form id="addVKForm" method="POST" action="{{ url('/data-vk') }}">
                @csrf
                <div class="form-group">
                    <label>Tanggal *</label>
                    <input type="date" name="tanggal" required>
                </div>
                <div class="form-group">
                    <label>Nama Pasien *</label>
                    <input type="text" name="nama_pasien" required>
                </div>
                <div class="form-group">
                    <label>No. RM</label>
                    <input type="text" name="no_rm">
                </div>
                <div class="form-group">
                    <label>Status Rawat & Kelas</label>
                    <input type="text" name="status_rawat">
                </div>
                <div class="form-group">
                    <label>Diagnosa *</label>
                    <textarea name="diagnosa" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label>Tindakan *</label>
                    <select name="tindakan" required>
                        <option value="">Pilih Tindakan</option>
                        <option value="SPONTAN">Persalinan Spontan</option>
                        <option value="KURET">Kuretase</option>
                        <option value="SEKSIO SESAREA">Seksio Sesarea</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Nama Dokter</label>
                    <input type="text" name="nama_dokter">
                </div>
                <div class="form-group">
                    <label>Dokter Anestesi</label>
                    <input type="text" name="dokter_anestesi">
                </div>
                <div class="form-group">
                    <label>Asisten Tindakan</label>
                    <input type="text" name="asisten_tindakan">
                </div>
                <div class="form-group">
                    <label>Penolong Persalinan</label>
                    <input type="text" name="penolong_persalinan">
                </div>
                <div style="display: flex; gap: 10px; justify-content: flex-end;">
                    <button type="button" class="btn btn-delete" onclick="closeModal('addVKModal')">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT DATA VK -->
    <div id="editVKModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>✏️ Edit Data VK</h3>
                <span class="close-modal" onclick="closeModal('editVKModal')">&times;</span>
            </div>
            <form id="editVKForm" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Tanggal *</label>
                    <input type="date" name="tanggal" id="edit_tanggal" required>
                </div>
                <div class="form-group">
                    <label>Nama Pasien *</label>
                    <input type="text" name="nama_pasien" id="edit_nama_pasien" required>
                </div>
                <div class="form-group">
                    <label>No. RM</label>
                    <input type="text" name="no_rm" id="edit_no_rm">
                </div>
                <div class="form-group">
                    <label>Status Rawat & Kelas</label>
                    <input type="text" name="status_rawat" id="edit_status_rawat">
                </div>
                <div class="form-group">
                    <label>Diagnosa *</label>
                    <textarea name="diagnosa" id="edit_diagnosa" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label>Tindakan *</label>
                    <select name="tindakan" id="edit_tindakan" required>
                        <option value="SPONTAN">Persalinan Spontan</option>
                        <option value="KURET">Kuretase</option>
                        <option value="SEKSIO SESAREA">Seksio Sesarea</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Nama Dokter</label>
                    <input type="text" name="nama_dokter" id="edit_nama_dokter">
                </div>
                <div class="form-group">
                    <label>Dokter Anestesi</label>
                    <input type="text" name="dokter_anestesi" id="edit_dokter_anestesi">
                </div>
                <div class="form-group">
                    <label>Asisten Tindakan</label>
                    <input type="text" name="asisten_tindakan" id="edit_asisten_tindakan">
                </div>
                <div class="form-group">
                    <label>Penolong Persalinan</label>
                    <input type="text" name="penolong_persalinan" id="edit_penolong_persalinan">
                </div>
                <div style="display: flex; gap: 10px; justify-content: flex-end;">
                    <button type="button" class="btn btn-delete" onclick="closeModal('editVKModal')">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Tab Navigation
        function showTab(tabName) {
            document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('active'));
            document.getElementById(`${tabName}-tab`).classList.add('active');
            
            document.querySelectorAll('.sidebar-menu a').forEach(link => link.classList.remove('active'));
            document.getElementById(`tab-${tabName}`).classList.add('active');
        }
        
        // Modal Functions
        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'flex';
        }
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }
        
        // Edit VK
        function editVK(id) {
            fetch(`/data-vk/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit_tanggal').value = data.tanggal;
                    document.getElementById('edit_nama_pasien').value = data.nama_pasien;
                    document.getElementById('edit_no_rm').value = data.no_rm;
                    document.getElementById('edit_status_rawat').value = data.status_rawat;
                    document.getElementById('edit_diagnosa').value = data.diagnosa;
                    document.getElementById('edit_tindakan').value = data.tindakan;
                    document.getElementById('edit_nama_dokter').value = data.nama_dokter;
                    document.getElementById('edit_dokter_anestesi').value = data.dokter_anestesi;
                    document.getElementById('edit_asisten_tindakan').value = data.asisten_tindakan;
                    document.getElementById('edit_penolong_persalinan').value = data.penolong_persalinan;
                    
                    document.getElementById('editVKForm').action = `/data-vk/${id}`;
                    openModal('editVKModal');
                });
        }
        
        // Delete VK
        function deleteVK(id) {
            if (confirm('Yakin ingin menghapus data ini?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/data-vk/${id}`;
                form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }
        
        // Delete User
        function deleteUser(id) {
            if (confirm('Yakin ingin menghapus user ini?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/users/${id}`;
                form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }
        
        // Filter Functions
        function filterVK() {
            const search = document.getElementById('searchVK').value.toLowerCase();
            const bulan = document.getElementById('filterBulan').value;
            const tahun = document.getElementById('filterTahun').value;
            const rows = document.querySelectorAll('#vkTable tbody tr');
            
            rows.forEach(row => {
                const nama = row.cells[2]?.innerText.toLowerCase() || '';
                let show = nama.includes(search);
                if (show && bulan) {
                    const tgl = row.cells[1]?.innerText || '';
                    const tglBulan = tgl.split('/')[1];
                    show = tglBulan === bulan;
                }
                row.style.display = show ? '' : 'none';
            });
        }
        
        function filterUser() {
            const search = document.getElementById('searchUser').value.toLowerCase();
            const role = document.getElementById('filterRole').value;
            const rows = document.querySelectorAll('#userTable tbody tr');
            
            rows.forEach(row => {
                const nama = row.cells[1]?.innerText.toLowerCase() || '';
                const userRole = row.cells[4]?.innerText.toLowerCase() || '';
                let show = nama.includes(search);
                if (show && role) show = userRole === role;
                row.style.display = show ? '' : 'none';
            });
        }
        
        function filterLog() {
            const search = document.getElementById('searchLog').value.toLowerCase();
            const date = document.getElementById('filterDate').value;
            const rows = document.querySelectorAll('#logTable tbody tr');
            
            rows.forEach(row => {
                const aktivitas = row.cells[3]?.innerText.toLowerCase() || '';
                const tgl = row.cells[1]?.innerText || '';
                let show = aktivitas.includes(search);
                if (show && date) show = tgl.includes(date);
                row.style.display = show ? '' : 'none';
            });
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        }
    </script>
</body>
</html>