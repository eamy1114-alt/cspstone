<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Log Aktivitas - Rekam Medis Digital</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(120deg, #e0f2f1, #b2dfdb);
            padding: 20px;
            min-height: 100vh;
        }
        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 { color: #00796b; margin-bottom: 10px; }
        .subtitle { color: #666; margin-bottom: 20px; font-size: 14px; }
        
        /* Header Actions */
        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
        }
        .btn-primary { background: #00796b; color: white; }
        .btn-primary:hover { background: #004d40; }
        .btn-danger { background: #e57373; color: white; }
        .btn-danger:hover { background: #c62828; }
        .btn-warning { background: #ffb74d; color: white; }
        .btn-warning:hover { background: #f57c00; }
        
        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }
        .stat-card {
            background: #e0f2f1;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
        }
        .stat-card .value { font-size: 28px; font-weight: bold; color: #00796b; }
        .stat-card .label { color: #666; font-size: 13px; }
        
        /* Filter Bar */
        .filter-bar {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 25px;
            padding: 15px;
            background: #f5f5f5;
            border-radius: 10px;
            align-items: flex-end;
        }
        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .filter-group label {
            font-size: 12px;
            color: #666;
        }
        .filter-bar input, .filter-bar select {
            padding: 8px 12px;
            border: 1px solid #b2dfdb;
            border-radius: 6px;
            min-width: 150px;
        }
        
        /* Table */
        .table-wrapper { overflow-x: auto; }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #009688;
            color: white;
            position: sticky;
            top: 0;
        }
        tr:hover { background: #f5f5f5; }
        .badge {
            background: #e0f2f1;
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 11px;
        }
        .detail-preview {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            cursor: pointer;
            color: #00796b;
        }
        .detail-preview:hover { color: #004d40; text-decoration: underline; }
        
        /* Pagination */
        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 8px;
            flex-wrap: wrap;
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
            border-color: #00796b;
        }
        
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
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #b2dfdb;
        }
        .modal-header h3 { color: #00796b; }
        .close-modal {
            font-size: 24px;
            cursor: pointer;
            color: #999;
        }
        
        /* Alert */
        .alert {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .alert-success { background: #c8e6c9; color: #2e7d32; }
        .alert-error { background: #ffcdd2; color: #c62828; }
        
        @media (max-width: 768px) {
            .filter-bar { flex-direction: column; }
            .filter-group { width: 100%; }
            .filter-group input, .filter-group select { width: 100%; }
            th, td { font-size: 12px; padding: 8px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-actions">
            <div>
                <h2>📝 Log Aktivitas</h2>
                <p class="subtitle">Catatan semua aktivitas user dalam sistem</p>
            </div>
            <div style="display: flex; gap: 10px;">
                <a href="{{ url('/dashboard/admin') }}" class="btn btn-primary">← Kembali ke Dashboard</a>
                <button onclick="openClearModal()" class="btn btn-danger">🗑️ Hapus Semua</button>
                <button onclick="openDateModal()" class="btn btn-warning">📅 Hapus by Tanggal</button>
                <button onclick="openUserModal()" class="btn btn-warning">👤 Hapus by User</button>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Statistik -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="value">{{ $statistik['total'] }}</div>
                <div class="label">Total Log</div>
            </div>
            <div class="stat-card">
                <div class="value">{{ $statistik['hari_ini'] }}</div>
                <div class="label">Hari Ini</div>
            </div>
            <div class="stat-card">
                <div class="value">{{ $statistik['minggu_ini'] }}</div>
                <div class="label">Minggu Ini</div>
            </div>
            <div class="stat-card">
                <div class="value">{{ $statistik['bulan_ini'] }}</div>
                <div class="label">Bulan Ini</div>
            </div>
        </div>

        <!-- Filter -->
        <form method="GET" class="filter-bar">
            <div class="filter-group">
                <label>Cari Aktivitas</label>
                <input type="text" name="aktivitas" placeholder="Cari aktivitas..." value="{{ request('aktivitas') }}">
            </div>
            <div class="filter-group">
                <label>Tanggal</label>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}">
            </div>
            <div class="filter-group">
                <label>User</label>
                <select name="user_id">
                    <option value="">Semua User</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->role }})
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group" style="justify-content: flex-end;">
                <button type="submit" class="btn btn-primary">🔍 Filter</button>
                <a href="{{ url('/logs') }}" class="btn btn-warning">↺ Reset</a>
            </div>
        </form>

        <!-- Tabel Log -->
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Waktu</th>
                        <th>User</th>
                        <th>Role</th>
                        <th>Aktivitas</th>
                        <th>IP Address</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $index => $log)
                    <tr>
                        <td>{{ $index + $logs->firstItem() }}</td>
                        <td>{{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i:s') }}</td>
                        <td>{{ $log->user->name ?? 'User Terhapus' }}</td>
                        <td><span class="badge">{{ $log->user->role ?? '-' }}</span></td>
                        <td>{{ $log->aktivitas }}</td>
                        <td>{{ $log->ip_address ?? '-' }}</td>
                        <td>
                            @if($log->detail)
                            <div class="detail-preview" onclick="showDetail('{{ addslashes($log->detail) }}')">
                                {{ Str::limit($log->detail, 40) }}
                            </div>
                            @else
                            -
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px;">
                            📭 Belum ada log aktivitas
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $logs->appends(request()->query())->links() }}
        </div>
    </div>

    <!-- Modal Hapus Semua -->
    <div id="clearModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>🗑️ Hapus Semua Log</h3>
                <span class="close-modal" onclick="closeModal('clearModal')">&times;</span>
            </div>
            <p>Yakin ingin menghapus <strong>SEMUA</strong> log aktivitas?</p>
            <p style="color: red; font-size: 12px;">Tindakan ini tidak dapat dibatalkan!</p>
            <form method="POST" action="{{ url('/logs/clear') }}" style="margin-top: 20px;">
                @csrf
                <div style="display: flex; gap: 10px; justify-content: flex-end;">
                    <button type="button" class="btn btn-warning" onclick="closeModal('clearModal')">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus Semua</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Hapus by Tanggal -->
    <div id="dateModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>📅 Hapus Log by Tanggal</h3>
                <span class="close-modal" onclick="closeModal('dateModal')">&times;</span>
            </div>
            <form method="POST" action="{{ url('/logs/delete-by-date') }}">
                @csrf
                <div style="margin-bottom: 15px;">
                    <label>Pilih Tanggal:</label>
                    <input type="date" name="tanggal" required style="width: 100%; padding: 10px; margin-top: 5px; border-radius: 6px; border: 1px solid #ddd;">
                </div>
                <div style="display: flex; gap: 10px; justify-content: flex-end;">
                    <button type="button" class="btn btn-warning" onclick="closeModal('dateModal')">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Hapus by User -->
    <div id="userModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>👤 Hapus Log by User</h3>
                <span class="close-modal" onclick="closeModal('userModal')">&times;</span>
            </div>
            <form method="POST" action="{{ url('/logs/delete-by-user') }}">
                @csrf
                <div style="margin-bottom: 15px;">
                    <label>Pilih User:</label>
                    <select name="user_id" required style="width: 100%; padding: 10px; margin-top: 5px; border-radius: 6px; border: 1px solid #ddd;">
                        <option value="">-- Pilih User --</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role }})</option>
                        @endforeach
                    </select>
                </div>
                <div style="display: flex; gap: 10px; justify-content: flex-end;">
                    <button type="button" class="btn btn-warning" onclick="closeModal('userModal')">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Detail -->
    <div id="detailModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>📋 Detail Log</h3>
                <span class="close-modal" onclick="closeModal('detailModal')">&times;</span>
            </div>
            <pre id="detailContent" style="white-space: pre-wrap; word-wrap: break-word; background: #f5f5f5; padding: 15px; border-radius: 8px; max-height: 400px; overflow: auto;"></pre>
        </div>
    </div>

    <script>
        function openClearModal() { document.getElementById('clearModal').style.display = 'flex'; }
        function openDateModal() { document.getElementById('dateModal').style.display = 'flex'; }
        function openUserModal() { document.getElementById('userModal').style.display = 'flex'; }
        function closeModal(modalId) { document.getElementById(modalId).style.display = 'none'; }
        
        function showDetail(detail) {
            try {
                let parsed = JSON.parse(detail);
                document.getElementById('detailContent').innerHTML = JSON.stringify(parsed, null, 2);
            } catch(e) {
                document.getElementById('detailContent').innerHTML = detail;
            }
            document.getElementById('detailModal').style.display = 'flex';
        }
        
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        }
    </script>
</body>
</html>