@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="space-y-6" x-data="{
    editModal: false,
    editId: null,
    editName: '',
    editType: 'document',
    editDesc: '',
    editAction: ''
}">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-900">Kategori Konten & Dokumen</h1>
        <p class="text-xs text-slate-500 mt-1">Kelola pengelompokan untuk artikel berita, pengumuman, dan repository berkas.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Form Tambah Kategori (4 cols) -->
        <div class="lg:col-span-4">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 space-y-4">
                <h3 class="font-bold text-sm text-slate-900 border-b pb-2">Tambah Kategori Baru</h3>
                <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-700">Nama Kategori <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" required class="w-full px-4 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:bg-white" placeholder="Contoh: Buku Pedoman & SOP">
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-700">Peruntukan Tipe <span class="text-rose-500">*</span></label>
                        <select name="type" required class="w-full px-4 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:bg-white">
                            <option value="document">Dokumen / Unduhan</option>
                            <option value="post">Berita & Pengumuman</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-700">Deskripsi Singkat</label>
                        <textarea name="description" rows="2" class="w-full px-4 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:bg-white" placeholder="Keterangan singkat pengelompokan berkas..."></textarea>
                    </div>

                    <button type="submit" class="w-full py-2.5 rounded-xl bg-theme-primary text-white font-bold text-xs uppercase tracking-wider shadow hover:opacity-90 transition">
                        Simpan Kategori
                    </button>
                </form>
            </div>
        </div>

        <!-- Tabel Daftar Kategori (8 cols) -->
        <div class="lg:col-span-8">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-600">
                        <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-bold uppercase text-[10px] tracking-wider">
                            <tr>
                                <th class="p-4">Nama Kategori</th>
                                <th class="p-4">Tipe</th>
                                <th class="p-4">Total Item</th>
                                <th class="p-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($categories as $cat)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-4">
                                    <div class="font-bold text-slate-900">{{ $cat->name }}</div>
                                    <div class="text-[11px] text-slate-400 font-mono">/{{ $cat->slug }}</div>
                                    @if($cat->description)
                                        <div class="text-[11px] text-slate-500 mt-0.5">{{ $cat->description }}</div>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase {{ $cat->type == 'post' ? 'bg-sky-50 text-sky-700 border border-sky-200' : 'bg-emerald-50 text-emerald-700 border border-emerald-200' }}">
                                        {{ $cat->type == 'post' ? 'Artikel / Berita' : 'Dokumen / Unduhan' }}
                                    </span>
                                </td>
                                <td class="p-4 font-semibold">
                                    {{ $cat->type == 'post' ? $cat->posts_count . ' artikel' : $cat->documents_count . ' berkas' }}
                                </td>
                                <td class="p-4 text-right space-x-1.5 whitespace-nowrap">
                                    <!-- Tombol Edit -->
                                    <button type="button" 
                                            @click="editModal = true; 
                                                    editId = {{ $cat->id }}; 
                                                    editName = '{{ addslashes($cat->name) }}'; 
                                                    editType = '{{ $cat->type }}'; 
                                                    editDesc = '{{ addslashes($cat->description ?? '') }}'; 
                                                    editAction = '{{ route('admin.categories.update', $cat->id) }}'" 
                                            class="p-1.5 rounded-lg text-sky-600 hover:bg-sky-50 transition" 
                                            title="Edit Kategori">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </button>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kategori ini? Dokumen dalam kategori ini tidak akan terhapus.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-rose-600 hover:bg-rose-50 transition" title="Hapus">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="p-8 text-center text-slate-400">Belum ada kategori yang dibuat.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Kategori -->
    <div x-show="editModal" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4" 
         style="display: none;"
         @keydown.escape.window="editModal = false">
        
        <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl border border-slate-200 space-y-5"
             @click.away="editModal = false">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="font-bold text-base text-slate-900 flex items-center">
                    <i class="fa-regular fa-pen-to-square mr-2 text-theme-primary"></i> Edit Kategori
                </h3>
                <button type="button" @click="editModal = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form :action="editAction" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-700">Nama Kategori <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" x-model="editName" required class="w-full px-4 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:bg-white">
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-700">Peruntukan Tipe <span class="text-rose-500">*</span></label>
                    <select name="type" x-model="editType" required class="w-full px-4 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:bg-white">
                        <option value="document">Dokumen / Unduhan</option>
                        <option value="post">Berita & Pengumuman</option>
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-700">Deskripsi Singkat</label>
                    <textarea name="description" x-model="editDesc" rows="2" class="w-full px-4 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:bg-white" placeholder="Keterangan singkat..."></textarea>
                </div>

                <div class="pt-3 border-t flex justify-end space-x-2">
                    <button type="button" @click="editModal = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-600 text-xs font-bold hover:bg-slate-200 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-theme-primary text-white text-xs font-bold uppercase tracking-wider shadow hover:opacity-90 transition">
                        Perbarui Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
