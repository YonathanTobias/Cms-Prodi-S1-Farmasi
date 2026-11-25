@extends('layouts.admin')

@section('title', 'Kelola Visi & Misi Prodi')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">Kelola Visi & Misi Program Studi</h1>
            <p class="text-xs text-slate-500 mt-1">Perbarui rumusan visi keunggulan, butir-butir misi Tri Dharma, dan profil program studi yang tampil di website publik.</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('home') }}#visi-misi" target="_blank" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition flex items-center">
                <i class="fa-solid fa-arrow-up-right-from-square mr-2"></i> Lihat di Beranda
            </a>
            <a href="{{ route('profile') }}" target="_blank" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition flex items-center">
                <i class="fa-solid fa-compass mr-2"></i> Halaman Profil
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-800 text-xs font-semibold flex items-center shadow-sm">
            <i class="fa-solid fa-circle-check mr-2 text-emerald-500 text-base"></i> {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- Form Utama (8 Cols) -->
        <div class="lg:col-span-8 space-y-6">
            <form action="{{ route('admin.settings.vision-mission.update') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Card Visi & Misi -->
                <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-slate-200 space-y-6">
                    <div class="border-b pb-4 flex items-center justify-between">
                        <div>
                            <h2 class="text-base font-bold text-slate-900 flex items-center">
                                <i class="fa-solid fa-bullseye mr-2 text-theme-primary"></i> Visi & Misi Program Studi
                            </h2>
                            <p class="text-xs text-slate-500 mt-0.5">Teks ini tampil di kartu utama beranda dan halaman profil institusi.</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-sky-50 text-sky-700 border border-sky-200">
                            Wajib Diisi
                        </span>
                    </div>

                    <!-- Visi -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-800 flex items-center">
                            <i class="fa-solid fa-eye text-sky-600 mr-1.5"></i> Visi Program Studi <span class="text-rose-500 ml-1">*</span>
                        </label>
                        <textarea name="vision" rows="4" required class="w-full px-4 py-3 rounded-xl text-xs sm:text-sm bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-theme-primary focus:bg-white transition leading-relaxed" placeholder="Contoh: Menjadi Program Studi ... yang Unggul, Berdaya Saing Global, dan Berkarakter Kasih...">{{ old('vision', $vision) }}</textarea>
                        <p class="text-[11px] text-slate-400">Tuliskan cita-cita masa depan atau target keunggulan prodi secara singkat, padat, dan inspiratif.</p>
                    </div>

                    <!-- Misi -->
                    <div class="space-y-2 pt-2 border-t border-slate-100">
                        <div class="flex items-center justify-between">
                            <label class="text-xs font-bold text-slate-800 flex items-center">
                                <i class="fa-solid fa-list-check text-emerald-600 mr-1.5"></i> Misi Program Studi <span class="text-rose-500 ml-1">*</span>
                            </label>
                            <span class="text-[11px] font-semibold text-slate-400">1 baris = 1 butir poin</span>
                        </div>
                        <textarea name="mission" rows="8" required class="w-full px-4 py-3 rounded-xl text-xs sm:text-sm font-mono bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-theme-primary focus:bg-white transition leading-relaxed" placeholder="1. Menyelenggarakan pendidikan sarjana dan profesi bermutu tinggi...&#10;2. Mengembangkan penelitian inovatif berbasis bukti...&#10;3. Melaksanakan pengabdian kepada masyarakat...">{{ old('mission', $mission) }}</textarea>
                        
                        <div class="p-3 bg-amber-50 border border-amber-200 rounded-xl text-[11px] text-amber-900 space-y-1">
                            <div class="font-bold flex items-center">
                                <i class="fa-solid fa-lightbulb text-amber-600 mr-1.5"></i> Tips Format Penulisan:
                            </div>
                            <p class="leading-relaxed">
                                Pisahkan setiap butir misi dengan menekan <strong>Enter (baris baru)</strong>. Di halaman website, sistem otomatis merendernya menjadi kartu butir berikon centang secara rapi.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Card Profil & Sejarah Singkat -->
                <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-slate-200 space-y-6">
                    <div class="border-b pb-4">
                        <h2 class="text-base font-bold text-slate-900 flex items-center">
                            <i class="fa-solid fa-landmark mr-2 text-theme-primary"></i> Profil & Sejarah Singkat Prodi
                        </h2>
                        <p class="text-xs text-slate-500 mt-0.5">Teks pengantar tentang profil program studi di halaman Profil (`/profil`).</p>
                    </div>

                    <div class="space-y-4">
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-slate-800">Judul Bagian Tentang Kami</label>
                            <input type="text" name="about_title" value="{{ old('about_title', $aboutTitle) }}" class="w-full px-4 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-theme-primary focus:bg-white" placeholder="Contoh: Profil Program Studi / Tentang Kami">
                        </div>

                        <div class="space-y-1">
                            <label class="text-xs font-bold text-slate-800">Deskripsi Lengkap / Kilas Sejarah</label>
                            <textarea name="about_description" rows="5" class="w-full px-4 py-3 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-theme-primary focus:bg-white leading-relaxed" placeholder="Jelaskan latar belakang berdirinya program studi, izin operasional, dedikasi pelayanan kesehatan, dan komitmen mutu...">{{ old('about_description', $aboutDescription) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-600 text-xs font-bold hover:bg-slate-200 transition">
                        Kembali ke Dashboard
                    </a>
                    <button type="submit" class="px-6 py-3 rounded-xl bg-theme-primary text-white font-bold text-xs uppercase tracking-wider shadow-lg hover:opacity-90 transition flex items-center">
                        <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan Perubahan Visi & Misi
                    </button>
                </div>
            </form>
        </div>

        <!-- Sidebar Panduan & Live Preview (4 Cols) -->
        <div class="lg:col-span-4 space-y-6">
            <!-- Box Preview Visi Saat Ini -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 space-y-4">
                <div class="flex items-center justify-between border-b pb-3">
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center">
                        <i class="fa-solid fa-circle-info mr-1.5 text-sky-600"></i> Ringkasan Visi Aktif
                    </h3>
                    <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">Live Web</span>
                </div>

                <div class="p-4 rounded-xl bg-slate-900 text-white space-y-2">
                    <div class="text-[10px] uppercase font-bold tracking-wider text-sky-400">Visi Unggulan</div>
                    <p class="text-xs leading-relaxed italic text-slate-200">
                        "{{ $vision ?: 'Belum ada visi yang ditetapkan.' }}"
                    </p>
                </div>

                <div class="space-y-2">
                    <div class="text-xs font-bold text-slate-700">Misi Aktif:</div>
                    @php
                        $lines = array_filter(array_map('trim', explode("\n", $mission)));
                    @endphp
                    @if(count($lines) > 0)
                        <ul class="space-y-2 text-xs text-slate-600">
                            @foreach(array_slice($lines, 0, 4) as $m)
                                <li class="flex items-start space-x-2">
                                    <i class="fa-solid fa-check text-emerald-500 mt-0.5 text-[10px] flex-shrink-0"></i>
                                    <span class="line-clamp-2">{{ $m }}</span>
                                </li>
                            @endforeach
                            @if(count($lines) > 4)
                                <li class="text-[11px] text-slate-400 italic pl-4">+ {{ count($lines) - 4 }} butir misi lainnya...</li>
                            @endif
                        </ul>
                    @else
                        <p class="text-xs text-slate-400 italic">Belum ada butir misi.</p>
                    @endif
                </div>
            </div>

            <!-- Petunjuk Pengisian -->
            <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200 space-y-3 text-xs text-slate-600">
                <div class="font-bold text-slate-800 flex items-center">
                    <i class="fa-solid fa-graduation-cap text-theme-primary mr-2 text-sm"></i> Standar Akreditasi LAM-PTKes
                </div>
                <p class="leading-relaxed text-[11px]">
                    Pastikan rumusan Visi & Misi selaras dengan Renstra institusi STIKES Panti Waluya Malang, mencantumkan keunggulan spesifik prodi, dan mencerminkan nilai etika serta karakter kasih.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
