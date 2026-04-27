@extends('layouts.app')

@section('title', 'Data VK')

@section('content')
<div class="py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-teal-700">📊 Data Tindakan & Persalinan VK</h2>
            <a href="{{ route('data-vk.create') }}" class="btn-teal">+ Tambah Data</a>
        </div>

        <!-- Filter -->
        <div class="card-custom mb-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <select name="bulan" class="border border-gray-300 rounded-lg p-2">
                    <option value="">Semua Bulan</option>
                    @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $b)
                    <option value="{{ $i+1 }}" {{ request('bulan') == $i+1 ? 'selected' : '' }}>{{ $b }}</option>
                    @endforeach
                </select>
                <select name="tahun" class="border border-gray-300 rounded-lg p-2">
                    <option value="">Semua Tahun</option>
                    @for($t=2024; $t<=2026; $t++)
                    <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endfor
                </select>
                <select name="jenis_tindakan" class="border border-gray-300 rounded-lg p-2">
                    <option value="">Semua Tindakan</option>
                    <option value="Persalinan Spontan" {{ request('jenis_tindakan') == 'Persalinan Spontan' ? 'selected' : '' }}>Persalinan Spontan</option>
                    <option value="Kuretase" {{ request('jenis_tindakan') == 'Kuretase' ? 'selected' : '' }}>Kuretase</option>
                </select>
                <button type="submit" class="btn-teal">Filter</button>
            </form>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="card-custom text-center"><div class="text-3xl font-bold text-teal-700">{{ $statistik['total'] }}</div><div>Total Tindakan</div></div>
            <div class="card-custom text-center"><div class="text-3xl font-bold text-teal-700">{{ $statistik['spontan'] }}</div><div>Persalinan Spontan</div></div>
            <div class="card-custom text-center"><div class="text-3xl font-bold text-teal-700">{{ $statistik['kuretase'] }}</div><div>Kuretase</div></div>
        </div>

        <!-- Table -->
        <div class="card-custom">
            <div class="overflow-x-auto">
                <table class="table-custom">
                    <thead>
                        <tr><th>Tanggal</th><th>Nama Pasien</th><th>No. RM</th><th>Diagnosa</th><th>Tindakan</th><th>Dokter</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                        @forelse($dataVK as $data)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d/m/Y') }}</td>
                            <td>{{ $data->nama_pasien }}</td>
                            <td>{{ $data->no_rm }}</td>
                            <td>{{ Str::limit($data->diagnosa, 50) }}</td>
                            <td>{{ $data->tindakan }}</td>
                            <td>{{ $data->nama_dokter }}</td>
                            <td>
                                <a href="{{ route('data-vk.edit', $data->id) }}" class="text-blue-600 hover:text-blue-800 mr-2">Edit</a>
                                <form action="{{ route('data-vk.destroy', $data->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center">Belum ada data VK</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $dataVK->links() }}
        </div>
    </div>
</div>
@endsection