@extends('layouts.admin')

@section('title', 'Dosen & Tendik / Struktur Organisasi')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">Daftar Dosen & Tendik Prodi</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola data dosen tetap, dosen klinis/spesialis, tenaga kependidikan (tendik), dan bagan struktur organisasi.</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('dosen-tendik') }}" target="_blank" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition flex items-center">
                <i class="fa-solid fa-arrow-up-right-from-square mr-2"></i> Lihat di Web
            </a>
            <a href="{{ route('admin.team.create') }}" class="px-5 py-2.5 rounded-xl bg-theme-primary text-white font-bold text-xs uppercase tracking-wider shadow hover:opacity-90 transition flex items-center">
                <i class="fa-solid fa-plus mr-2"></i> Tambah Dosen / Tendik
            </a>
        </div>
    </div>

    <!-- Filter & Statistics Bar -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <a href="{{ route('admin.team.index') }}" class="p-4 rounded-2xl bg-white border {{ !request('type') ? 'border-sky-500 ring-2 ring-sky-500/20' : 'border-slate-200' }} shadow-sm hover:shadow transition flex items-center justify-between">
            <div>
                <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Personil</div>
                <div class="text-2xl font-black text-slate-800">{{ $totalMembers }}</div>
            </div>
            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-sm">
                <i class="fa-solid fa-users"></i>
            </div>
        </a>
        <a href="{{ route('admin.team.index', ['type' => 'dosen']) }}" class="p-4 rounded-2xl bg-white border {{ request('type') === 'dosen' ? 'border-sky-500 ring-2 ring-sky-500/20' : 'border-slate-200' }} shadow-sm hover:shadow transition flex items-center justify-between">
            <div>
                <div class="text-[11px] font-bold text-sky-600 uppercase tracking-wider">Dosen / Tenaga Pendidik</div>
                <div class="text-2xl font-black text-slate-800">{{ $totalDosen }}</div>
            </div>
            <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center font-bold text-sm">
                <i class="fa-solid fa-user-doctor"></i>
            </div>
        </a>
        <a href="{{ route('admin.team.index', ['type' => 'tendik']) }}" class="p-4 rounded-2xl bg-white border {{ request('type') === 'tendik' ? 'border-sky-500 ring-2 ring-sky-500/20' : 'border-slate-200' }} shadow-sm hover:shadow transition flex items-center justify-between">
            <div>
                <div class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider">Tenaga Kependidikan (Tendik)</div>
                <div class="text-2xl font-black text-slate-800">{{ $totalTendik }}</div>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-sm">
                <i class="fa-solid fa-user-gear"></i>
            </div>
        </a>
    </div>

    <!-- Bagan Struktur Organisasi Card (Collapsible / Compact) -->
    <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-slate-200 space-y-6" x-data="{ openChart: false }">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 cursor-pointer" @click="openChart = !openChart">
            <div>
                <h2 class="text-base font-bold text-slate-900 flex items-center">
                    <i class="fa-solid fa-sitemap mr-2 text-theme-primary"></i> Bagan Struktur Organisasi (Diagram Gambar)
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">Unggah gambar diagram hierarki organisasi prodi untuk ditampilkan di website.</p>
            </div>
            <div class="flex items-center space-x-2">
                <span class="text-xs font-semibold text-slate-400" x-text="openChart ? 'Sembunyikan Pengaturan' : 'Buka Pengaturan Bagan'"></span>
                <i class="fa-solid text-slate-400 transition transform" :class="openChart ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
            </div>
        </div>

        <div x-show="openChart" x-collapse class="border-t pt-6 space-y-6">
            @if(get_setting('organization_chart_image'))
                <div class="flex justify-end">
                    <form action="{{ route('admin.team.chart.remove') }}" method="POST" onsubmit="return confirm('Hapus gambar bagan struktur organisasi saat ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1.5 rounded-lg bg-rose-50 text-rose-700 hover:bg-rose-100 text-xs font-bold transition flex items-center border border-rose-200">
                            <i class="fa-regular fa-trash-can mr-1.5"></i> Hapus Gambar Bagan
                        </button>
                    </form>
                </div>
            @endif

            <form action="{{ route('admin.team.chart.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    <!-- Col 1: Preview Bagan saat ini (5 cols) -->
                    <div class="lg:col-span-5 bg-slate-50 p-4 rounded-xl border border-slate-200 text-center space-y-3">
                        <div class="text-xs font-bold text-slate-700 text-left">Preview Bagan Saat Ini:</div>
                        @if(get_setting('organization_chart_image'))
                            <div class="relative group rounded-lg overflow-hidden border border-slate-300 bg-white p-2">
                                <img src="{{ get_setting('organization_chart_image') }}" alt="Bagan Struktur" class="w-full h-44 object-contain mx-auto rounded">
                                <a href="{{ get_setting('organization_chart_image') }}" target="_blank" class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white font-bold text-xs gap-2">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Buka Gambar Penuh
                                </a>
                            </div>
                        @else
                            <div class="py-10 border-2 border-dashed border-slate-300 rounded-lg text-slate-400 space-y-2">
                                <i class="fa-solid fa-diagram-project text-3xl"></i>
                                <p class="text-xs">Belum ada gambar bagan yang diunggah.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Col 2: Upload & Mode Display (7 cols) -->
                    <div class="lg:col-span-7 space-y-4">
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-slate-700">Pilih Berkas Gambar Bagan (JPG, PNG, WebP, SVG, Maks 5MB)</label>
                            <input type="file" name="organization_chart" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                        </div>

                        <div class="space-y-1 pt-2">
                            <label class="text-xs font-bold text-slate-700">Mode Tampilan di Halaman Website</label>
                            <select name="organization_display_mode" class="w-full px-4 py-2.5 rounded-xl text-xs font-semibold bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:bg-white">
                                <option value="both" {{ get_setting('organization_display_mode', 'both') == 'both' ? 'selected' : '' }}>📊 Tampilkan Keduanya (Gambar Bagan + Kartu Personil)</option>
                                <option value="tab" {{ get_setting('organization_display_mode', 'both') == 'tab' ? 'selected' : '' }}>📑 Mode Tab Switch (Pengunjung bisa pilih Tab Bagan atau Tab Personil)</option>
                                <option value="chart_only" {{ get_setting('organization_display_mode', 'both') == 'chart_only' ? 'selected' : '' }}>🖼️ Hanya Tampilkan Gambar Bagan</option>
                                <option value="members_only" {{ get_setting('organization_display_mode', 'both') == 'members_only' ? 'selected' : '' }}>👥 Hanya Tampilkan Kartu Personil</option>
                            </select>
                        </div>

                        <div class="pt-3">
                            <button type="submit" class="px-5 py-2.5 rounded-xl bg-theme-primary text-white font-bold text-xs uppercase tracking-wider shadow hover:opacity-90 transition">
                                Simpan Pengaturan Bagan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200 flex flex-col sm:flex-row justify-between items-center gap-3">
        <div class="flex items-center space-x-2 w-full sm:w-auto">
            <span class="text-xs font-bold text-slate-500">Filter Kategori:</span>
            <div class="inline-flex rounded-xl bg-slate-100 p-1 text-xs">
                <a href="{{ route('admin.team.index') }}" class="px-3 py-1.5 rounded-lg font-bold transition {{ !request('type') ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">Semua ({{ $totalMembers }})</a>
                <a href="{{ route('admin.team.index', ['type' => 'dosen']) }}" class="px-3 py-1.5 rounded-lg font-bold transition {{ request('type') === 'dosen' ? 'bg-white text-sky-700 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">Dosen ({{ $totalDosen }})</a>
                <a href="{{ route('admin.team.index', ['type' => 'tendik']) }}" class="px-3 py-1.5 rounded-lg font-bold transition {{ request('type') === 'tendik' ? 'bg-white text-emerald-700 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">Tendik ({{ $totalTendik }})</a>
            </div>
        </div>

        <form action="{{ route('admin.team.index') }}" method="GET" class="flex items-center space-x-2 w-full sm:w-auto">
            @if(request('type'))
                <input type="hidden" name="type" value="{{ request('type') }}">
            @endif
            <div class="relative w-full sm:w-64">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIDN, kepakaran..." class="w-full pl-9 pr-4 py-2 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:bg-white">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400 text-xs"></i>
            </div>
            <button type="submit" class="px-3 py-2 rounded-xl bg-slate-800 text-white text-xs font-bold hover:bg-slate-700 transition">Cari</button>
            @if(request('search') || request('type'))
                <a href="{{ route('admin.team.index') }}" class="p-2 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 text-xs transition" title="Reset Filter"><i class="fa-solid fa-rotate-right"></i></a>
            @endif
        </form>
    </div>

    <!-- Team Members Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-bold uppercase text-[10px] tracking-wider">
                    <tr>
                        <th class="p-4 w-16">Urutan</th>
                        <th class="p-4">Foto & Nama</th>
                        <th class="p-4">Kategori</th>
                        <th class="p-4">Jabatan & Kepakaran</th>
                        <th class="p-4">NIDN / NIP</th>
                        <th class="p-4">Kontak</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($members as $tm)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="p-4 font-bold text-slate-400">#{{ $tm->order_index }}</td>
                        <td class="p-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-11 h-11 rounded-full bg-slate-200 overflow-hidden flex-shrink-0 border-2 border-slate-300">
                                    @if($tm->photo)
                                        <img src="{{ $tm->photo }}" alt="{{ $tm->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-400 bg-slate-100"><i class="fa-solid fa-user"></i></div>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900">{{ $tm->name }}</div>
                                    @if($tm->title_degree)
                                        <div class="text-[11px] text-slate-500">{{ $tm->title_degree }}</div>
                                    @endif
                                    @if($tm->academic_rank)
                                        <div class="text-[10px] font-medium text-sky-700 mt-0.5">Jafung: {{ $tm->academic_rank }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            @if($tm->type === 'tendik')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <i class="fa-solid fa-user-gear mr-1 text-[9px]"></i> Tendik
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-sky-50 text-sky-700 border border-sky-200">
                                    <i class="fa-solid fa-user-doctor mr-1 text-[9px]"></i> Dosen
                                </span>
                            @endif
                        </td>
                        <td class="p-4 space-y-1">
                            <div class="font-bold text-slate-800">{{ $tm->position }}</div>
                            @if($tm->expertise)
                                <div class="text-[11px] text-slate-500 flex items-center">
                                    <i class="fa-solid fa-award text-amber-500 mr-1.5 text-[10px]"></i>
                                    <span>{{ $tm->expertise }}</span>
                                </div>
                            @endif
                        </td>
                        <td class="p-4 font-mono text-[11px] font-semibold text-slate-700">
                            {{ $tm->identifier ?: '-' }}
                        </td>
                        <td class="p-4 text-[11px]">
                            @if($tm->email)<div><i class="fa-regular fa-envelope text-slate-400 mr-1"></i> {{ $tm->email }}</div>@endif
                            @if($tm->phone)<div><i class="fa-solid fa-phone text-slate-400 mr-1"></i> {{ $tm->phone }}</div>@endif
                        </td>
                        <td class="p-4 text-center">
                            @if($tm->is_active ?? true)
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">Aktif</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-200 text-slate-600">Non-Aktif</span>
                            @endif
                        </td>
                        <td class="p-4 text-right space-x-2 whitespace-nowrap">
                            <a href="{{ route('admin.team.edit', $tm->id) }}" class="p-1.5 rounded-lg text-sky-600 hover:bg-sky-50 transition" title="Edit Data"><i class="fa-regular fa-pen-to-square"></i></a>
                            <form action="{{ route('admin.team.destroy', $tm->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data personil ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-lg text-rose-600 hover:bg-rose-50 transition" title="Hapus"><i class="fa-regular fa-trash-can"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="p-8 text-center text-slate-400">Belum ada data Dosen atau Tendik yang sesuai dengan filter.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
