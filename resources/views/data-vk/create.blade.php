@extends('layouts.app')

@section('title', 'Tambah Data VK')

@section('content')
<div class="py-8 px-4">
    <div class="max-w-3xl mx-auto">
        <div class="card-custom">
            <h2 class="text-2xl font-bold text-teal-700 mb-6">➕ Tambah Data VK</h2>
            
            <form method="POST" action="{{ route('data-vk.store') }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><label class="font-semibold">Tanggal *</label><input type="date" name="tanggal" required class="w-full border rounded-lg p-2"></div>
                    <div><label class="font-semibold">Nama Pasien *</label><input type="text" name="nama_pasien" required class="w-full border rounded-lg p-2"></div>
                    <div><label class="font-semibold">No. RM</label><input type="text" name="no_rm" class="w-full border rounded-lg p-2"></div>
                    <div><label class="font-semibold">Status Rawat</label><input type="text" name="status_rawat" class="w-full border rounded-lg p-2"></div>
                    <div class="md:col-span-2"><label class="font-semibold">Diagnosa *</label><textarea name="diagnosa" rows="3" required class="w-full border rounded-lg p-2"></textarea></div>
                    <div><label class="font-semibold">Tindakan *</label><select name="tindakan" required class="w-full border rounded-lg p-2"><option value="">Pilih</option><option>SPONTAN</option><option>KURET</option><option>SEKSIO SESAREA</option></select></div>
                    <div><label class="font-semibold">Nama Dokter</label><input type="text" name="nama_dokter" class="w-full border rounded-lg p-2"></div>
                    <div><label class="font-semibold">Dokter Anestesi</label><input type="text" name="dokter_anestesi" class="w-full border rounded-lg p-2"></div>
                    <div><label class="font-semibold">Asisten Tindakan</label><input type="text" name="asisten_tindakan" class="w-full border rounded-lg p-2"></div>
                    <div><label class="font-semibold">Penolong Persalinan</label><input type="text" name="penolong_persalinan" class="w-full border rounded-lg p-2"></div>
                </div>
                <div class="flex gap-3 mt-6">
                    <button type="submit" class="btn-teal">💾 Simpan</button>
                    <a href="{{ route('data-vk.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection