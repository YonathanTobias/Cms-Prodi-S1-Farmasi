# CMS Program Studi S1 Farmasi - STIKES Panti Waluya Malang

Sistem Manajemen Konten (CMS) terpadu berbasis Laravel untuk **Program Studi S1 Farmasi STIKES Panti Waluya Malang**.

---

## 📌 Identitas Program Studi
- **Nama Program Studi**: Program Studi S1 Farmasi
- **Akronim / Singkatan**: S1 Farmasi
- **Jenjang & Gelar**: Sarjana | Sarjana Farmasi (S.Farm)
- **Akreditasi**: Terakreditasi Baik Sekali (LAM-PTKes)
- **Institusi Induk**: STIKES Panti Waluya Malang
- **Palet Warna Tema**: Kuning Cerah & Amber Gold (`#eab308` & `#ca8a04`)

---

## 🎯 Visi & Misi
### Visi
> *"Menjadi Program Studi S1 Farmasi yang Unggul, Inovatif, dan Terdepan dalam Pengembangan Farmasi Bahan Alam serta Pelayanan Kefarmasian Komunitas yang Berkarakter Kasih pada Tingkat Nasional Menuju Global pada Tahun 2035."*

### Misi
1. Menyelenggarakan pendidikan sarjana farmasi berkualitas tinggi berbasis kurikulum OBE (*Outcome-Based Education*) yang adaptif terhadap kemajuan sains dan teknologi kefarmasian.
2. Mengembangkan penelitian inovatif di bidang formulasi herbal, standarisasi obat bahan alam (fitofarmaka), dan farmasi klinis berbasis bukti (*Evidence-Based Pharmacy*).
3. Melaksanakan pengabdian kepada masyarakat yang aplikatif melalui edukasi DAGUSIBU (Dapatkan, Gunakan, Simpan, Buang) dan pembinaan kesehatan masyarakat mandiri.
4. Membina pembentukan karakter lulusan yang berintegritas moral tinggi, mematuhi etika kefarmasian, disiplin, dan berjiwa cinta kasih dalam melayani sesama.
5. Menjalin kerjasama strategis dengan industri farmasi, rumah sakit pendidikan, apotek jejaring, instansi regulator (BPOM/Dinkes), dan organisasi profesi (IAI).

---

## 🚀 Fitur Unggulan Sistem
- **Portal Publik Modern**: Responsif, ramah seluler, mendukung dark mode, dan palet warna kuning cerah bergradien yang elegan.
- **Halaman Dosen & Tendik (`/dosen-tendik`)**: Menampilkan daftar akademisi farmasi, bidang keahlian, jabatan, dan laboran farmasi lengkap dengan fitur pencarian & tab filter.
- **Layanan Akademik & Modul On/Off (`/layanan`)**: Fitur layanan mahasiswa (PKL, Skripsi, Peminjaman Alat Lab Farmasi) yang dapat diaktifkan/dinonaktifkan secara dinamis dari dashboard admin.
- **Pusat Unduhan (`/unduhan`)**: Repositori berkas SOP, pedoman PKL, panduan skripsi, logbook, dan formulir laboratorium terpadu dengan counter unduhan.
- **Kelola Visi & Misi (`/admin/visi-misi`)**: Form khusus untuk memperbarui visi, misi Tri Dharma, serta profil prodi secara mandiri dan cepat.
- **Autentikasi Aman**: Panel login admin aman tanpa hardcode kredensial pada template form.

---

## 🛠️ Panduan Instalasi Lokal

1. **Clone Repositori**:
   ```bash
   git clone https://github.com/YonathanTobias/Cms-Prodi-S1-Farmasi.git
   cd Cms-Prodi-S1-Farmasi
   ```

2. **Pasang Dependensi PHP & Frontend**:
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Migrasi Database & Seeding Data Awal**:
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Jalankan Server Lokal**:
   ```bash
   php artisan serve
   ```
   Akses website melalui `http://localhost:8000` di peramban Anda.

---

&copy; {{ date('Y') }} Program Studi S1 Farmasi - STIKES Panti Waluya Malang.
