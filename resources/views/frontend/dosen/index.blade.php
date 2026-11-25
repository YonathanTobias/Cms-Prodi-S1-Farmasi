@extends('layouts.frontend')

@section('title', 'Dosen & Tenaga Kependidikan (Tendik) - ' . get_setting('division_name', 'Prodi S1 Farmasi'))
@section('meta_description', 'Daftar dosen tetap, pakar sains farmasi & klinis, serta tenaga kependidikan ' . get_setting('division_name', 'Program Studi S1 Farmasi') . ' ' . get_setting('parent_institution', 'STIKES Panti Waluya Malang') . '.')

@section('content')
<!-- Header Hero Banner -->
<section class="relative bg-slate-900 text-white py-16 sm:py-20 overflow-hidden">
    <div class="absolute inset-0 opacity-20 pointer-events-none bg-[radial-gradient(#38bdf8_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl space-y-4">
            <!-- Breadcrumbs -->
            <nav class="flex items-center space-x-2 text-xs text-slate-400 font-medium">
                <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                <a href="{{ route('profile') }}" class="hover:text-white transition">Profil</a>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                <span class="text-theme-primary font-bold">Dosen & Tendik</span>
            </nav>

            <div class="inline-flex items-center space-x-2 text-xs font-bold uppercase tracking-wider px-3.5 py-1.5 rounded-full text-amber-400 bg-amber-950/80 border border-amber-800/60">
                <i class="fa-solid fa-users-line"></i>
                <span>Sumber Daya Manusia Unggul</span>
            </div>

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white leading-tight">
                Dosen & Tenaga Kependidikan
            </h1>

            <p class="text-sm sm:text-base text-slate-300 leading-relaxed">
                Profil tenaga pendidik profesional, pakar kefarmasian, dan tenaga kependidikan berdedikasi yang membimbing mahasiswa menjadi sarjana farmasi yang unggul, beretika, dan berkarakter kasih.
            </p>
        </div>
    </div>
</section>

<!-- Content Area -->
<section class="py-12 lg:py-16 bg-slate-50 dark:bg-slate-950 min-h-[60vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Filter Tabs & Search Bar -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-4 sm:p-6 shadow-sm border border-slate-200/80 dark:border-slate-800 flex flex-col lg:flex-row justify-between items-stretch lg:items-center gap-4">
            <!-- Category Tabs -->
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('dosen-tendik', array_merge(request()->except('type', 'page'), ['type' => 'all'])) }}"
                   class="px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center {{ ($type === 'all' || !$type) ? 'bg-theme-primary text-white shadow-sm' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                    <i class="fa-solid fa-users mr-2"></i>
                    <span>Semua Personil</span>
                    <span class="ml-2 px-2 py-0.5 rounded-full text-[10px] {{ ($type === 'all' || !$type) ? 'bg-white/20 text-white' : 'bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300' }}">{{ $totalAll }}</span>
                </a>

                <a href="{{ route('dosen-tendik', array_merge(request()->except('type', 'page'), ['type' => 'dosen'])) }}"
                   class="px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center {{ $type === 'dosen' ? 'bg-sky-600 text-white shadow-sm' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                    <i class="fa-solid fa-user-doctor mr-2"></i>
                    <span>Dosen / Tenaga Pendidik</span>
                    <span class="ml-2 px-2 py-0.5 rounded-full text-[10px] {{ $type === 'dosen' ? 'bg-white/20 text-white' : 'bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300' }}">{{ $totalDosen }}</span>
                </a>

                <a href="{{ route('dosen-tendik', array_merge(request()->except('type', 'page'), ['type' => 'tendik'])) }}"
                   class="px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center {{ $type === 'tendik' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                    <i class="fa-solid fa-user-gear mr-2"></i>
                    <span>Tenaga Kependidikan</span>
                    <span class="ml-2 px-2 py-0.5 rounded-full text-[10px] {{ $type === 'tendik' ? 'bg-white/20 text-white' : 'bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300' }}">{{ $totalTendik }}</span>
                </a>
            </div>

            <!-- Search Form -->
            <form action="{{ route('dosen-tendik') }}" method="GET" class="flex items-center space-x-2">
                @if(request('type') && request('type') !== 'all')
                    <input type="hidden" name="type" value="{{ request('type') }}">
                @endif
                <div class="relative flex-1 lg:w-72">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, NIDN, atau kepakaran..." 
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl text-xs bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-theme-primary focus:bg-white dark:focus:bg-slate-800 transition">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                </div>
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 dark:bg-slate-700 dark:hover:bg-slate-600 text-white text-xs font-bold transition shadow-sm">
                    Cari
                </button>
                @if(request('q'))
                    <a href="{{ route('dosen-tendik', ['type' => request('type', 'all')]) }}" class="p-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500 hover:text-slate-800 dark:hover:text-white text-xs transition" title="Reset Pencarian">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif
            </form>
        </div>

        @if(request('q'))
            <div class="text-xs text-slate-500 dark:text-slate-400 flex items-center">
                <span>Menampilkan hasil pencarian untuk: <strong class="text-slate-900 dark:text-white">"{{ request('q') }}"</strong> ({{ $members->count() }} orang ditemukan)</span>
            </div>
        @endif

        <!-- Grid Dosen & Tendik -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @forelse($members as $tm)
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800/80 overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col justify-between group">
                
                <!-- Card Header with Photo & Badges -->
                <div class="p-6 pb-4 space-y-4">
                    <div class="flex items-start justify-between gap-3">
                        <!-- Photo Avatar -->
                        <div class="relative">
                            <div class="w-20 h-20 rounded-2xl overflow-hidden bg-slate-100 dark:bg-slate-800 border-2 {{ $tm->type === 'tendik' ? 'border-emerald-500/40' : 'border-sky-500/40' }} shadow-sm group-hover:scale-105 transition-transform duration-300">
                                @if($tm->photo)
                                    <img src="{{ $tm->photo }}" alt="{{ $tm->name }}" class="w-full h-full object-cover" loading="lazy" decoding="async">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-400 dark:text-slate-500 text-3xl">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full flex items-center justify-center text-[11px] text-white shadow {{ $tm->type === 'tendik' ? 'bg-emerald-600' : 'bg-sky-600' }}">
                                <i class="fa-solid {{ $tm->type === 'tendik' ? 'fa-user-gear' : 'fa-stethoscope' }}"></i>
                            </div>
                        </div>

                        <!-- Badges -->
                        <div class="flex flex-col items-end gap-1.5">
                            @if($tm->type === 'tendik')
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                                    Tendik
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-sky-50 text-sky-700 dark:bg-sky-950/60 dark:text-sky-400 border border-sky-200 dark:border-sky-800">
                                    Dosen
                                </span>
                            @endif

                            @if($tm->academic_rank)
                                <span class="text-[10px] font-semibold text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded-md">
                                    {{ $tm->academic_rank }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Name & Position -->
                    <div class="space-y-1">
                        <h2 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white leading-snug group-hover:text-theme-primary transition">
                            {{ $tm->name }}
                        </h2>
                        <div class="text-xs font-semibold text-theme-primary">
                            {{ $tm->position }}
                        </div>
                        @if($tm->identifier)
                            <div class="text-[11px] font-mono text-slate-400 dark:text-slate-500">
                                {{ $tm->identifier }}
                            </div>
                        @endif
                    </div>

                    <!-- Bidang Kepakaran / Keahlian -->
                    @if($tm->expertise)
                        <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/70 border border-slate-100 dark:border-slate-800 text-[11px] text-slate-700 dark:text-slate-300 flex items-start space-x-2">
                            <i class="fa-solid fa-award text-amber-500 mt-0.5 text-xs flex-shrink-0"></i>
                            <div>
                                <span class="font-bold text-slate-900 dark:text-slate-200 block text-[10px] uppercase tracking-wider text-slate-400">Bidang Keahlian:</span>
                                <span>{{ $tm->expertise }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Bio / Profil -->
                    @if($tm->bio)
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed line-clamp-3">
                            {{ $tm->bio }}
                        </p>
                    @endif
                </div>

                <!-- Card Footer / Contacts -->
                <div class="p-4 px-6 bg-slate-50/60 dark:bg-slate-900/60 border-t border-slate-100 dark:border-slate-800 flex flex-wrap items-center justify-between gap-2 text-xs">
                    @if($tm->email)
                        <a href="mailto:{{ $tm->email }}" class="text-slate-600 dark:text-slate-400 hover:text-theme-primary dark:hover:text-sky-400 transition flex items-center truncate max-w-[190px]" title="{{ $tm->email }}">
                            <i class="fa-regular fa-envelope mr-1.5 text-sky-600 text-xs"></i>
                            <span class="truncate">{{ $tm->email }}</span>
                        </a>
                    @else
                        <span class="text-[11px] text-slate-400 italic">Kontak via Prodi</span>
                    @endif

                    @if($tm->phone)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $tm->phone) }}" target="_blank" class="text-emerald-600 dark:text-emerald-400 hover:underline transition flex items-center font-medium text-[11px]" title="Hubungi WhatsApp">
                            <i class="fa-brands fa-whatsapp mr-1 text-xs"></i> Hubungi
                        </a>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-full py-16 text-center space-y-4 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-8">
                <div class="w-16 h-16 mx-auto rounded-full bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center text-2xl">
                    <i class="fa-solid fa-user-slash"></i>
                </div>
                <div class="space-y-1">
                    <h3 class="text-base font-bold text-slate-800 dark:text-white">Tidak ada data personil</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Tidak ada personil yang sesuai dengan kata kunci pencarian atau filter yang dipilih.</p>
                </div>
                <a href="{{ route('dosen-tendik') }}" class="inline-flex items-center px-4 py-2 rounded-xl bg-theme-primary text-white text-xs font-bold hover:opacity-90 transition">
                    Lihat Semua Personil
                </a>
            </div>
            @endforelse
        </div>

        <!-- Banner Diagram Struktur Organisasi (Call to Action) -->
        <div class="mt-12 bg-gradient-to-r from-slate-900 to-slate-800 rounded-3xl p-6 sm:p-10 text-white flex flex-col md:flex-row items-center justify-between gap-6 shadow-xl border border-slate-700/60">
            <div class="space-y-2 text-center md:text-left">
                <div class="inline-flex items-center space-x-2 text-[11px] font-bold uppercase tracking-wider px-3 py-1 rounded-full text-amber-400 bg-amber-950/80 border border-amber-800/60">
                    <i class="fa-solid fa-sitemap"></i>
                    <span>Hierarki Organisasi</span>
                </div>
                <h3 class="text-xl sm:text-2xl font-bold text-white">Lihat Bagan Struktur Organisasi Lengkap</h3>
                <p class="text-xs sm:text-sm text-slate-300 max-w-xl">
                    Ketahui tata kelola kepemimpinan, unit koordinasi akademik, serta laboratorium pendidikan di {{ get_setting('division_name', 'Program Studi S1 Farmasi') }}.
                </p>
            </div>
            <a href="{{ route('profile') }}#struktur" class="px-6 py-3.5 rounded-2xl bg-white text-slate-900 hover:bg-slate-100 font-extrabold text-xs uppercase tracking-wider shadow-lg transition flex items-center whitespace-nowrap flex-shrink-0">
                <i class="fa-solid fa-diagram-project mr-2 text-amber-600"></i> Buka Bagan Struktur Organisasi
            </a>
        </div>

    </div>
</section>
@endsection
