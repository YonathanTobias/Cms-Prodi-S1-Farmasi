@extends('layouts.admin')

@section('title', 'Tambah Dosen / Tendik')

@section('content')
<div class="max-w-4xl space-y-6">
    <div class="flex items-center space-x-3">
        <a href="{{ route('admin.team.index') }}" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition text-xs">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">Tambah Dosen / Tendik Baru</h1>
            <p class="text-xs text-slate-500">Input data dosen tetap, dosen spesialis, koordinator, atau staf tenaga kependidikan prodi.</p>
        </div>
    </div>

    <form action="{{ route('admin.team.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-slate-200 space-y-6">
            
            <!-- Kategori Personil (Dosen vs Tendik) -->
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                <label class="text-xs font-bold text-slate-800">Kategori Personil <span class="text-rose-500">*</span></label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <label class="flex items-center p-3 rounded-xl border bg-white cursor-pointer hover:border-sky-500 transition">
                        <input type="radio" name="type" value="dosen" {{ old('type', 'dosen') === 'dosen' ? 'checked' : '' }} class="text-sky-600 focus:ring-sky-500 mr-3">
                        <div>
                            <div class="text-xs font-bold text-slate-800 flex items-center">
                                <i class="fa-solid fa-user-doctor text-sky-600 mr-1.5"></i> Dosen / Tenaga Pendidik
                            </div>
                            <div class="text-[11px] text-slate-500">Dosen pengampu mata kuliah, pembimbing klinis, atau pimpinan akademik.</div>
                        </div>
                    </label>
                    <label class="flex items-center p-3 rounded-xl border bg-white cursor-pointer hover:border-emerald-500 transition">
                        <input type="radio" name="type" value="tendik" {{ old('type') === 'tendik' ? 'checked' : '' }} class="text-emerald-600 focus:ring-emerald-500 mr-3">
                        <div>
                            <div class="text-xs font-bold text-slate-800 flex items-center">
                                <i class="fa-solid fa-user-gear text-emerald-600 mr-1.5"></i> Tenaga Kependidikan (Tendik)
                            </div>
                            <div class="text-[11px] text-slate-500">Staf tata usaha, administrasi prodi, laboran, atau pustakawan.</div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Nama & Gelar -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-700">Nama Lengkap <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:bg-white" placeholder="Contoh: Ns. Maria Magdalena">
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-700">Gelar / Kualifikasi</label>
                    <input type="text" name="title_degree" value="{{ old('title_degree') }}" class="w-full px-4 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:bg-white" placeholder="Contoh: M.Kep., Sp.Kep.MB">
                </div>
            </div>

            <!-- Jabatan, NIDN/NIP, Jafung, Kepakaran -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-700">Jabatan / Posisi di Prodi <span class="text-rose-500">*</span></label>
                    <input type="text" name="position" value="{{ old('position') }}" required class="w-full px-4 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:bg-white" placeholder="Contoh: Ketua Program Studi / Dosen Keperawatan Jiwa">
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-700">Nomor Induk (NIDN / NIP / NUP)</label>
                    <input type="text" name="identifier" value="{{ old('identifier') }}" class="w-full px-4 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:bg-white" placeholder="Contoh: NIDN. 0712058501 / NIP. 1985...">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-700">Bidang Keahlian / Kepakaran</label>
                    <input type="text" name="expertise" value="{{ old('expertise') }}" class="w-full px-4 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:bg-white" placeholder="Contoh: Keperawatan Medikal Bedah, Paliatif & Geriatri">
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-700">Jabatan Fungsional Akademik (Jafung)</label>
                    <input type="text" name="academic_rank" value="{{ old('academic_rank') }}" class="w-full px-4 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:bg-white" placeholder="Contoh: Asisten Ahli, Lektor, Lektor Kepala, Guru Besar">
                </div>
            </div>

            <!-- Kontak -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-700">Email Resmi</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200" placeholder="nama@pantiwaluya.ac.id">
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-700">No. Telepon / WhatsApp</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200" placeholder="08123456789">
                </div>
            </div>

            <!-- Bio / Profil -->
            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-700">Profil Singkat / Bidang Riset / Pengajaran</label>
                <textarea name="bio" rows="3" class="w-full px-4 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:bg-white" placeholder="Rangkuman kompetensi pengajaran, riset keperawatan unggulan, atau sertifikasi keahlian...">{{ old('bio') }}</textarea>
            </div>

            <!-- Foto & Urutan & Status Aktif -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4 border-t border-slate-100 items-end">
                <div class="space-y-1 sm:col-span-1">
                    <label class="text-xs font-bold text-slate-700">Foto Profil Resmi</label>
                    <input type="file" name="photo" accept="image/*" class="text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-700">Urutan Tampil (#)</label>
                    <input type="number" name="order_index" value="{{ old('order_index', 0) }}" class="w-full px-4 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200">
                </div>

                <div class="pb-2">
                    <label class="flex items-center space-x-2 text-xs font-bold text-slate-700 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded text-sky-600 focus:ring-sky-500 w-4 h-4">
                        <span>Tampilkan di Website (Aktif)</span>
                    </label>
                </div>
            </div>

            <div class="pt-4 border-t flex justify-end space-x-3">
                <a href="{{ route('admin.team.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs hover:bg-slate-200 transition">Batal</a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-theme-primary text-white font-bold text-xs uppercase tracking-wider shadow hover:opacity-90 transition">
                    Simpan Data Personil
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
