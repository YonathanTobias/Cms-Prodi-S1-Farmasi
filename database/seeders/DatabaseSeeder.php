<?php

namespace Database\Seeders;

use App\Models\Carousel;
use App\Models\Category;
use App\Models\Document;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\NavMenu;
use App\Models\Page;
use App\Models\Post;
use App\Models\Service;
use App\Models\Setting;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database for Program Studi S1 Farmasi.
     */
    public function run(): void
    {
        // 1. Akun Pengguna / Administrator
        // Super Admin khusus Orang IT (memiliki akses penuh & manajemen sistem)
        $itAdmin = User::updateOrCreate(
            ['email' => 'it@pantiwaluya.ac.id'],
            [
                'name' => 'Super Admin (Unit IT)',
                'role' => 'super_admin',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        $superAdmin = User::updateOrCreate(
            ['email' => 'admin@pantiwaluya.ac.id'],
            [
                'name' => 'Super Admin IT Utama',
                'role' => 'super_admin',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        // Akun Kaprodi sebagai Admin Prodi (mengelola konten & layanan akademik)
        $kaprodi = User::updateOrCreate(
            ['email' => 'farmasi@pantiwaluya.ac.id'],
            [
                'name' => 'Kaprodi S1 Farmasi',
                'role' => 'admin',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        // Akun Admin Berita / Humas Prodi
        $newsAdmin = User::updateOrCreate(
            ['email' => 'berita@pantiwaluya.ac.id'],
            [
                'name' => 'Admin Humas & Berita Prodi',
                'role' => 'admin',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Pengaturan Profil & Identitas Prodi S1 Farmasi
        $defaultSettings = [
            // Identitas Program Studi
            'division_name' => 'Program Studi S1 Farmasi',
            'division_short_name' => 'Prodi S1 Farmasi',
            'division_acronym' => 'S1 Farmasi',
            'division_type' => 'prodi',
            'prodi_degree' => 'Sarjana Farmasi (S.Farm)',
            'prodi_accreditation' => 'Terakreditasi Baik Sekali (LAM-PTKes)',
            'division_tagline' => 'Mencetak Sarjana Farmasi Unggul, Inovatif dalam Farmasi Bahan Alam dan Pelayanan Farmasi Komunitas Berkarakter Kasih',
            'division_icon' => 'fa-solid fa-prescription-bottle-medical',
            'parent_institution' => 'STIKES Panti Waluya Malang',
            
            // Visual & Branding (Kuning Cerah Terang yang Bagus & Enak Dipandang)
            'theme_primary_color' => '#eab308', // Yellow-500 (Kuning Cerah Terang & Hangat)
            'theme_secondary_color' => '#ca8a04', // Yellow-600 / Amber Gold
            'theme_accent_color' => '#16a34a', // Emerald-600 (Karakter Herbal & Bahan Alam)
            'logo_url' => '',
            'hero_banner_title' => 'Program Studi S1 Farmasi',
            'hero_banner_subtitle' => 'Mencetak Sarjana Farmasi yang unggul dalam sains farmasi modern, formulasi bahan alam, serta berdedikasi tinggi dalam pelayanan kefarmasian berkarakter kasih.',

            // Tentang & Visi Misi
            'about_title' => 'Tentang Prodi S1 Farmasi',
            'about_description' => "Program Studi S1 Farmasi STIKES Panti Waluya Malang menyelenggarakan pendidikan sarjana kefarmasian yang mengintegrasikan penguasaan sains farmasi modern, teknologi formulasi bahan alam nusantara, dan pelayanan farmasi klinis-komunitas yang berorientasi pada keselamatan pasien (patient safety).\n\nKurikulum kami dirancang berbasis Outcome-Based Education (OBE) dan Standar Kompetensi Apoteker Indonesia (SKAI), didukung oleh laboratorium farmasi terpadu (Kimia Farmasi, Farmakognosi-Fitokimia, Teknologi Farmasi, dan Mikrobiologi) serta wahana kemitraan praktikum di rumah sakit dan industri farmasi ternama.\n\nDidukung oleh tenaga pengajar berkualifikasi Magister dan Doktor Farmasi serta praktisi profesional, kami berkomitmen mencetak lulusan yang mandiri, adaptif, berjiwa wirausaha (technopreneur), dan berkarakter kasih dalam mengabdi bagi kesehatan masyarakat.",
            'vision' => 'Menjadi Program Studi S1 Farmasi yang Unggul, Inovatif, dan Terdepan dalam Pengembangan Farmasi Bahan Alam serta Pelayanan Kefarmasian Komunitas yang Berkarakter Kasih pada Tingkat Nasional Menuju Global pada Tahun 2035.',
            'mission' => "1. Menyelenggarakan pendidikan sarjana farmasi berkualitas tinggi berbasis kurikulum OBE (Outcome-Based Education) yang adaptif terhadap kemajuan sains dan teknologi kefarmasian.\n2. Mengembangkan penelitian inovatif di bidang formulasi herbal, standarisasi obat bahan alam (fitofarmaka), dan farmasi klinis berbasis bukti (Evidence-Based Pharmacy).\n3. Melaksanakan pengabdian kepada masyarakat yang aplikatif melalui edukasi DAGUSIBU (Dapatkan, Gunakan, Simpan, Buang) dan pembinaan kesehatan masyarakat mandiri.\n4. Membina pembentukan karakter lulusan yang berintegritas moral tinggi, mematuhi etika kefarmasian, disiplin, dan berjiwa cinta kasih dalam melayani sesama.\n5. Menjalin kerjasama strategis dengan industri farmasi, rumah sakit pendidikan, apotek jejaring, instansi regulator (BPOM/Dinkes), dan organisasi profesi (IAI).",
            'prodi_graduate_profile' => "Lulusan dipersiapkan sebagai Farmasis Pelayanan Klinis & Komunitas (Rumah Sakit, Puskesmas, Apotek), Formulator & Quality Assurance/Control (QA/QC) di Industri Farmasi, Obat Tradisional, Makanan & Kosmetik, Pengelola & Entrepreneur Fasilitas Kefarmasian, serta Peneliti Pemula bidang Sains Farmasi dan Bahan Alam.",
            
            // Kontak & Lokasi
            'contact_email' => 'farmasi@pantiwaluya.ac.id',
            'contact_phone' => '(0341) 569275',
            'contact_whatsapp' => '6281234567890',
            'enable_whatsapp_floating' => '1',
            'whatsapp_floating_message' => 'Halo Admin Prodi S1 Farmasi, saya ingin bertanya seputar informasi akademik.',
            'contact_room' => 'Gedung Laboratorium Terpadu Lt. 2, Ruang Prodi S1 Farmasi',
            'contact_address' => 'Jl. Yulius Usman No. 62, Kasin, Kec. Klojen, Kota Malang, Jawa Timur 65117',
            'operating_hours' => 'Senin - Jumat: 08.00 - 16.00 WIB',
            'google_maps_embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3951.213601444588!2d112.62473467499647!3d-7.976868692048386!2m3!1f0!2f0!3f0!3m2!1i1024!2f768!4f13.1!3m3!1m2!1s0x2dd62828b49e1a17%3A0xc3cb73f1d3c01fa9!2sSTIKes%20Panti%20Waluya%20Malang!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid',

            // Media Sosial
            'social_instagram' => 'https://instagram.com/stikespantiwaluya',
            'social_facebook' => 'https://facebook.com/stikespantiwaluyamalang',
            'social_youtube' => 'https://youtube.com/@stikespantiwaluya',
            'social_website' => 'https://pantiwaluya.ac.id',

            // Statistik Capaian di Beranda
            'stat_1_number' => '100%',
            'stat_1_label' => 'Akreditasi Baik Sekali',
            'stat_2_number' => '100%',
            'stat_2_label' => 'Dosen S2/S3 & Praktisi Farmasi',
            'stat_3_number' => '30+',
            'stat_3_label' => 'Industri & Wahana Praktik Mitra',
            'stat_4_number' => '50+',
            'stat_4_label' => 'Produk Inovasi Herbal Teruji',
        ];

        foreach ($defaultSettings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value, 'group' => 'general']);
        }

        // 3. Kategori Berita & Dokumen
        $cat1 = Category::updateOrCreate(['slug' => 'akademik-perkuliahan'], ['name' => 'Akademik & Perkuliahan', 'type' => 'post', 'description' => 'Informasi perkuliahan dan kurikulum farmasi']);
        $cat2 = Category::updateOrCreate(['slug' => 'praktikum-penelitian'], ['name' => 'Praktikum & Riset Laboratorium', 'type' => 'post', 'description' => 'Informasi kegiatan praktikum laboratorium dan riset formulasi obat']);
        $cat3 = Category::updateOrCreate(['slug' => 'pengumuman-prodi'], ['name' => 'Pengumuman Resmi', 'type' => 'post', 'description' => 'Edaran dan pengumuman resmi prodi']);
        $catDoc1 = Category::updateOrCreate(['slug' => 'pedoman-panduan-lab'], ['name' => 'Buku Panduan & SOP Laboratorium', 'type' => 'document', 'description' => 'Buku pedoman akademik dan tata tertib laboratorium farmasi']);
        $catDoc2 = Category::updateOrCreate(['slug' => 'format-skripsi-farmasi'], ['name' => 'Format Skripsi & Riset', 'type' => 'document', 'description' => 'Format penulisan proposal dan tugas akhir sarjana farmasi']);
        $catDoc3 = Category::updateOrCreate(['slug' => 'formulir-pkl-praktek'], ['name' => 'Formulir Praktik Kerja Lapangan', 'type' => 'document', 'description' => 'Logbook dan formulir administrasi PKL Apotek, RS, dan Industri']);

        // 4. Berita & Pengumuman Prodi
        Post::updateOrCreate(
            ['slug' => 'pelepasan-mahasiswa-praktik-kerja-lapangan-farmasi-terpadu'],
            [
                'title' => 'Pelepasan Mahasiswa Praktik Kerja Lapangan (PKL) Farmasi di RS & Industri Mitra',
                'category_id' => $cat2->id,
                'user_id' => $superAdmin->id,
                'type' => 'berita',
                'summary' => 'Prodi S1 Farmasi secara resmi memberangkatkan mahasiswa untuk menjalani rotasi PKL di Rumah Sakit, Apotek, dan Industri Farmasi.',
                'content' => '<p>Program Studi S1 Farmasi STIKES Panti Waluya Malang menyelenggarakan acara pembekalan dan pelepasan mahasiswa Praktik Kerja Lapangan (PKL) di berbagai fasilitas pelayanan kefarmasian dan industri mitra di Jawa Timur.</p><p>Kegiatan PKL ini bertujuan untuk memberikan pengalaman kerja nyata dalam pengelolaan sediaan farmasi, dispensing resep, evaluasi mutu produk sediaan, konseling obat (PIO), serta mematuhi etika kefarmasian yang mengutamakan keselamatan pasien (patient safety).</p>',
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now()->subDays(2),
                'views_count' => 210,
            ]
        );

        Post::updateOrCreate(
            ['slug' => 'workshop-formulasi-kosmetik-herbal-dan-ekstraksi-bahan-alam'],
            [
                'title' => 'Workshop Formulasi Kosmetik Herbal & Ekstraksi Bahan Alam Berstandar CPOTB',
                'category_id' => $cat1->id,
                'user_id' => $superAdmin->id,
                'type' => 'berita',
                'summary' => 'Mengasah keterampilan mahasiswa dalam teknologi formulasi sediaan farmasi berbahan herbal lokal bernilai ekonomis tinggi.',
                'content' => '<p>Dalam upaya memperkuat keunggulan riset farmasi bahan alam, Prodi S1 Farmasi menyelenggarakan Workshop Intensif Teknologi Formulasi Kosmetik Herbal. Mahasiswa mempraktikkan proses ekstraksi maserasi terstandar, pembuatan sediaan nano-serum, dan uji stabilitas fisik sesuai panduan BPOM.</p>',
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now()->subDays(5),
                'views_count' => 315,
            ]
        );

        Post::updateOrCreate(
            ['slug' => 'sosialisasi-alur-penyusunan-skripsi-sarjana-farmasi-2025'],
            [
                'title' => 'Sosialisasi Alur Penyusunan Skripsi & Uji Laboratorium Tugas Akhir 2025',
                'category_id' => $cat3->id,
                'user_id' => $superAdmin->id,
                'type' => 'pengumuman',
                'summary' => 'Pedoman pengajuan topik riset farmasi, alur bimbingan dosen pembimbing, hingga syarat kelayakan ujian sidang hasil.',
                'content' => '<p>Diberitahukan kepada seluruh mahasiswa tingkat akhir Program Studi S1 Farmasi mengenai jadwal pengusulan proposal skripsi dan perizinan laboratorium riset. Buku pedoman penulisan dan format lembar pengesahan terbaru telah dapat diunduh pada Pusat Unduhan website resmi prodi.</p>',
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now()->subDays(8),
                'views_count' => 178,
            ]
        );

        // 5. Layanan Mahasiswa & Akademik Prodi
        Service::updateOrCreate(
            ['slug' => 'layanan-praktik-kerja-lapangan-pkl-farmasi'],
            [
                'title' => 'Layanan Praktik Kerja Lapangan (PKL) Farmasi Komprehensif',
                'icon' => 'fa-solid fa-mortar-pestle',
                'summary' => 'Koordinasi penempatan, pembekalan, dan supervisi PKL mahasiswa di Rumah Sakit, Apotek, dan Industri Farmasi.',
                'description' => 'Program Studi memfasilitasi rotasi PKL mahasiswa di sarana pelayanan kefarmasian komunitas (Apotek, Puskesmas), farmasi klinis rumah sakit, serta industri obat tradisional dan kosmetik.',
                'requirements' => "1. Telah menyelesaikan beban minimal 100 SKS teori dan praktikum prasyarat\n2. Surat Keterangan Lulus Pembekalan & Responsi Laboratorium\n3. Surat Izin Orang Tua/Wali\n4. Bukti bebas administrasi akademik dan keuangan",
                'procedure' => "1. Mahasiswa melakukan pendaftaran wahana PKL melalui portal prodi.\n2. Mengikuti pembekalan teknis dan etika profesi kefarmasian.\n3. Penyerahan ke wahana mitra (RS/Apotek/Industri).\n4. Pelaksanaan PKL, bimbingan preseptor, dan ujian laporan akhir.",
                'order_index' => 1,
                'is_active' => true,
            ]
        );

        Service::updateOrCreate(
            ['slug' => 'bimbingan-skripsi-dan-riset-laboratorium-farmasi'],
            [
                'title' => 'Bimbingan Skripsi & Riset Laboratorium Farmasi',
                'icon' => 'fa-solid fa-microscope',
                'summary' => 'Pelayanan pengajuan topik riset, penetapan dosen pembimbing, seminar proposal, hingga sidang sarjana farmasi.',
                'description' => 'Layanan akademik bagi mahasiswa S1 Farmasi untuk penyusunan tugas akhir riset eksperimental maupun observasional di bidang Kimia Medisinal, Bahan Alam, Teknologi Sediaan, dan Farmasi Komunitas.',
                'requirements' => "1. KRS Skripsi telah disetujui Dosen Pembimbing Akademik (PA)\n2. Naskah Proposal Penelitian Kefarmasian\n3. Lembar Persetujuan Calon Dosen Pembimbing\n4. Bebas Administrasi Laboratorium & Keuangan",
                'procedure' => "1. Pengajuan proposal dan topik penelitian ke Koordinator Skripsi Prodi.\n2. Penetapan SK Dosen Pembimbing oleh Prodi.\n3. Proses riset laboratorium dan bimbingan minimal 8 kali pertemuan.\n4. Pendaftaran seminar proposal, seminar hasil, dan sidang sarjana.",
                'order_index' => 2,
                'is_active' => true,
            ]
        );

        Service::updateOrCreate(
            ['slug' => 'peminjaman-alat-laboratorium-farmasi-modern'],
            [
                'title' => 'Peminjaman Alat Laboratorium Farmasi & Penggunaan Reagen',
                'icon' => 'fa-solid fa-flask-vial',
                'summary' => 'Layanan peminjaman instrumen analitik canggih (Spektrofotometer UV-Vis, Dissolution Tester, Rotavapor) dan bahan praktikum.',
                'description' => 'Fasilitasi penggunaan fasilitas laboratorium terstandar untuk mendukung kelancaran riset skripsi dan praktikum mandiri mahasiswa dengan kepatuhan K3 laboratorium.',
                'requirements' => "1. Mahasiswa terdaftar aktif pada semester berjalan (menunjukkan KTM)\n2. Formulir peminjaman alat yang disetujui Dosen Pembimbing\n3. Telah mengikuti orientasi keselamatan kerja laboratorium (K3)\n4. Menyerahkan kartu kendali laboratorium",
                'procedure' => "1. Mengajukan formulir peminjaman ke Laboran Farmasi H-3 sebelum penggunaan.\n2. Pemeriksaan kesiapan alat dan bahan bersama staf laboran.\n3. Penggunaan instrumen dengan pendampingan teknisi/laboran.\n4. Pengembalian dan verifikasi kondisi fisik alat pasca penggunaan.",
                'order_index' => 3,
                'is_active' => true,
            ]
        );

        Service::updateOrCreate(
            ['slug' => 'pelayanan-administrasi-akademik-mahasiswa-farmasi'],
            [
                'title' => 'Layanan Administrasi Akademik & Surat Izin Penelitian',
                'icon' => 'fa-solid fa-file-signature',
                'summary' => 'Penerbitan surat izin penelitian herbal, uji laboratorium eksternal, rekomendasi beasiswa, dan legalisir ijazah.',
                'description' => 'Pusat pelayanan surat-menyurat akademik bagi mahasiswa yang memerlukan perizinan pengambilan sampel tanaman, uji laboratorium BPOM/eksternal, maupun izin PKL.',
                'requirements' => "1. Mengisi formulir permohonan surat secara online di loket prodi\n2. Melampirkan persetujuan Dosen Pembimbing / PA\n3. Menyertakan proposal / instrumen penelitian (bila untuk riset)",
                'procedure' => "1. Mengajukan surat permohonan melalui sistem / loket tata usaha prodi.\n2. Verifikasi berkas oleh staf tata usaha.\n3. Penandatanganan oleh Ketua Program Studi S1 Farmasi.\n4. Surat resmi terbit dalam waktu 1-2 hari kerja.",
                'order_index' => 4,
                'is_active' => true,
            ]
        );

        // 6. Dosen & Susunan Pengelola Prodi S1 Farmasi
        TeamMember::updateOrCreate(
            ['name' => 'apt. Maria Florentina, M.Farm.'],
            [
                'title_degree' => 'M.Farm.',
                'identifier' => 'NIDN. 0715068601',
                'position' => 'Ketua Program Studi S1 Farmasi',
                'type' => 'dosen',
                'expertise' => 'Teknologi Farmasi & Formulasi Herbal',
                'academic_rank' => 'Lektor',
                'bio' => 'Pakar teknologi formulasi sediaan farmasi dan kosmetik dengan fokus riset pengembangan nano-emulsi ekstrak tanaman obat lokal Indonesia.',
                'email' => 'maria.florentina@pantiwaluya.ac.id',
                'phone' => '081234567891',
                'order_index' => 1,
                'is_active' => true,
            ]
        );

        TeamMember::updateOrCreate(
            ['name' => 'apt. Andreas Setiawan, M.Clin.Pharm.'],
            [
                'title_degree' => 'M.Clin.Pharm.',
                'identifier' => 'NIDN. 0728098802',
                'position' => 'Sekretaris Prodi & Koordinator Akademik',
                'type' => 'dosen',
                'expertise' => 'Farmasi Klinis & Farmakoterapi',
                'academic_rank' => 'Lektor',
                'bio' => 'Dosen Farmasi Klinis dengan kepakaran interaksi obat, pelayanan informasi obat (PIO), dan evaluasi rasionalitas penggunaan obat di rumah sakit.',
                'email' => 'andreas.setiawan@pantiwaluya.ac.id',
                'phone' => '081234567892',
                'order_index' => 2,
                'is_active' => true,
            ]
        );

        TeamMember::updateOrCreate(
            ['name' => 'apt. Fransiska Kusuma, M.Sc.'],
            [
                'title_degree' => 'M.Sc.',
                'identifier' => 'NIDN. 0712049003',
                'position' => 'Koordinator Laboratorium Farmasi Terpadu',
                'type' => 'dosen',
                'expertise' => 'Kimia Farmasi & Analisis Bahan Alam',
                'academic_rank' => 'Asisten Ahli',
                'bio' => 'Dosen Kimia Medisinal dan Fitokimia dengan pengalaman riset standarisasi mutu ekstrak serta isolasi senyawa aktif tanaman obat.',
                'email' => 'fransiska.kusuma@pantiwaluya.ac.id',
                'phone' => '081234567893',
                'order_index' => 3,
                'is_active' => true,
            ]
        );

        TeamMember::updateOrCreate(
            ['name' => 'apt. Bernardus Hendra, M.Farm.'],
            [
                'title_degree' => 'M.Farm.',
                'identifier' => 'NIDN. 0705118704',
                'position' => 'Koordinator Kemahasiswaan & Praktik Lapangan',
                'type' => 'dosen',
                'expertise' => 'Farmakologi, Toksikologi & Farmasi Komunitas',
                'academic_rank' => 'Asisten Ahli',
                'bio' => 'Dosen Farmakologi dengan fokus penelitian skrining bioaktivitas antibakteri, antioksidan bahan alam, serta edukasi DAGUSIBU di masyarakat.',
                'email' => 'bernardus.hendra@pantiwaluya.ac.id',
                'phone' => '081234567894',
                'order_index' => 4,
                'is_active' => true,
            ]
        );

        TeamMember::updateOrCreate(
            ['name' => 'apt. Veronika Dewi, M.Biomed.'],
            [
                'title_degree' => 'M.Biomed.',
                'identifier' => 'NIDN. 0719039105',
                'position' => 'Dosen Biologi Farmasi & Mikrobiologi',
                'type' => 'dosen',
                'expertise' => 'Mikrobiologi Farmasi & Bioteknologi',
                'academic_rank' => 'Asisten Ahli',
                'bio' => 'Pengajar mikrobiologi farmasi dan biokimia dengan riset pemanfaatan fermentasi mikrobia untuk produksi metabolit sekunder farmasi.',
                'email' => 'veronika.dewi@pantiwaluya.ac.id',
                'phone' => '081234567895',
                'order_index' => 5,
                'is_active' => true,
            ]
        );

        TeamMember::updateOrCreate(
            ['name' => 'apt. Gregorius Wahyu, M.Farm.'],
            [
                'title_degree' => 'M.Farm.',
                'identifier' => 'NIDN. 0724089306',
                'position' => 'Dosen Manajemen Farmasi & Kewirausahaan',
                'type' => 'dosen',
                'expertise' => 'Farmasi Komunitas, Manajemen Apotek & Regulasi',
                'academic_rank' => 'Tenaga Pengajar',
                'bio' => 'Praktisi dan akademisi tata kelola apotek, regulasi perizinan kefarmasian, dan pengembangan kewirausahaan produk herbal kreatif.',
                'email' => 'gregorius.wahyu@pantiwaluya.ac.id',
                'phone' => '081234567896',
                'order_index' => 6,
                'is_active' => true,
            ]
        );

        TeamMember::updateOrCreate(
            ['name' => 'Albertus Danang, S.Kom.'],
            [
                'title_degree' => 'S.Kom.',
                'identifier' => 'NIP. 202109005',
                'position' => 'Staf Administrasi & Tata Usaha Prodi',
                'type' => 'tendik',
                'expertise' => 'Administrasi Akademik, Pengarsipan & Sistem Informasi',
                'academic_rank' => 'Pengadministrasi Akademik',
                'bio' => 'Pengelola layanan persuratan akademik, registrasi perkuliahan, dan pengoperasian sistem informasi akademik prodi S1 Farmasi.',
                'email' => 'albertus.danang@pantiwaluya.ac.id',
                'phone' => '081234567897',
                'order_index' => 7,
                'is_active' => true,
            ]
        );

        TeamMember::updateOrCreate(
            ['name' => 'Theresia Linda, A.Md.Farm.'],
            [
                'title_degree' => 'A.Md.Farm.',
                'identifier' => 'NIP. 202202015',
                'position' => 'Pranata Laboratorium Pendidikan (Laboran Farmasi)',
                'type' => 'tendik',
                'expertise' => 'Pengelolaan Alat Instrumentasi, Reagen Kimia & K3 Lab',
                'academic_rank' => 'Laboran Farmasi',
                'bio' => 'Pengelola teknis ketersediaan instrumen laboratorium farmasi, inventarisasi reagen kimia berstandar, kalibrasi alat, dan K3 praktikum.',
                'email' => 'theresia.linda@pantiwaluya.ac.id',
                'phone' => '081234567898',
                'order_index' => 8,
                'is_active' => true,
            ]
        );

        // 7. Agenda Kegiatan Prodi
        Event::updateOrCreate(
            ['slug' => 'seminar-nasional-farmasi-bahan-alam-dan-fitofarmaka-2025'],
            [
                'title' => 'Seminar Nasional Farmasi Bahan Alam & Inovasi Fitofarmaka 2025',
                'location' => 'Auditorium STIKES Panti Waluya Malang',
                'start_date' => now()->addDays(14)->setTime(8, 30),
                'end_date' => now()->addDays(14)->setTime(13, 0),
                'description' => 'Seminar ilmiah mengupas hilirisasi riset obat bahan alam menuju obat herbal terstandar (OHT) dan fitofarmaka bersama praktisi BPOM dan industri farmasi.',
                'registration_link' => '',
                'is_active' => true,
            ]
        );

        Event::updateOrCreate(
            ['slug' => 'workshop-formulasi-sediaan-kosmetik-dan-herbal-cpotb'],
            [
                'title' => 'Workshop Formulasi Sediaan Kosmetik & Herbal Berstandar CPOTB',
                'location' => 'Laboratorium Teknologi Farmasi STIKES Panti Waluya',
                'start_date' => now()->addDays(28)->setTime(9, 0),
                'end_date' => now()->addDays(28)->setTime(14, 30),
                'description' => 'Pelatihan teknik formulasi formularium herbal, pembuatan gel/krim kosmetik modern, dan pengujian mutu stabilitas sediaan.',
                'registration_link' => '',
                'is_active' => true,
            ]
        );

        // 8. Dokumen & Buku Panduan Prodi
        Document::updateOrCreate(
            ['title' => 'Buku Pedoman Praktik Kerja Lapangan (PKL) Farmasi Edisi 2025'],
            [
                'category_id' => $catDoc1->id,
                'file_path' => 'documents/buku_pedoman_pkl_farmasi_2025.pdf',
                'file_type' => 'PDF',
                'file_size' => '2.8 MB',
                'description' => 'Panduan lengkap capaian kompetensi, tata tertib, dan format evaluasi rotasi PKL Apotek, Rumah Sakit, dan Industri.',
                'downloads_count' => 380,
                'is_published' => true,
            ]
        );

        Document::updateOrCreate(
            ['title' => 'Buku Panduan Penulisan Skripsi & Riset Sarjana Farmasi'],
            [
                'category_id' => $catDoc2->id,
                'file_path' => 'documents/panduan_skripsi_farmasi.pdf',
                'file_type' => 'PDF',
                'file_size' => '2.4 MB',
                'description' => 'Petunjuk teknis penulisan karya ilmiah skripsi farmasi, tata cara sitasi ilmiah, dan protokol pengajuan seminar proposal/hasil.',
                'downloads_count' => 345,
                'is_published' => true,
            ]
        );

        Document::updateOrCreate(
            ['title' => 'Formulir Peminjaman Alat Laboratorium Farmasi & Penggunaan Reagen'],
            [
                'category_id' => $catDoc3->id,
                'file_path' => 'documents/formulir_peminjaman_alat_farmasi.docx',
                'file_type' => 'DOCX',
                'file_size' => '480 KB',
                'description' => 'Format resmi permohonan peminjaman instrumen analitik laboratorium, permintaan reagen praktikum, dan persetujuan K3.',
                'downloads_count' => 260,
                'is_published' => true,
            ]
        );

        // 9. Banner Carousel Beranda
        Carousel::updateOrCreate(
            ['title' => 'Program Studi S1 Farmasi'],
            [
                'subtitle' => 'Pusat Keunggulan Farmasi Bahan Alam, Formulasi Kosmetik & Herbal, serta Pelayanan Kefarmasian Komunitas Berkarakter Kasih.',
                'image_path' => 'https://images.unsplash.com/photo-1587854692152-cbe660dbde88?auto=format&fit=crop&w=1920&q=80',
                'button_text' => 'Profil Program Studi',
                'button_link' => '/profil',
                'order_index' => 1,
                'is_active' => true,
            ]
        );

        Carousel::updateOrCreate(
            ['title' => 'Laboratorium Farmasi Modern & Riset Terpadu'],
            [
                'subtitle' => 'Fasilitas instrumentasi canggih untuk mengasah keahlian analisis kimia obat, teknologi formulasi, dan mikrobiologi farmasi.',
                'image_path' => 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=1920&q=80',
                'button_text' => 'Jelajahi Layanan & Riset',
                'button_link' => '/layanan',
                'order_index' => 2,
                'is_active' => true,
            ]
        );

        // 10. Navigasi Menu Default
        $defaultMenus = [
            ['label' => 'Beranda', 'url' => '/', 'target' => '_self', 'order_index' => 1, 'is_active' => true],
            ['label' => 'Profil Prodi', 'url' => '/profil', 'target' => '_self', 'order_index' => 2, 'is_active' => true],
            ['label' => 'Dosen & Tendik', 'url' => '/dosen-tendik', 'target' => '_self', 'order_index' => 3, 'is_active' => true],
            ['label' => 'Layanan Akademik', 'url' => '/layanan', 'target' => '_self', 'order_index' => 4, 'is_active' => true],
            ['label' => 'Berita & Informasi', 'url' => '/berita', 'target' => '_self', 'order_index' => 5, 'is_active' => true],
            ['label' => 'Agenda Kegiatan', 'url' => '/agenda', 'target' => '_self', 'order_index' => 6, 'is_active' => true],
            ['label' => 'Pusat Unduhan', 'url' => '/unduhan', 'target' => '_self', 'order_index' => 7, 'is_active' => true],
            ['label' => 'Galeri Foto', 'url' => '/galeri', 'target' => '_self', 'order_index' => 8, 'is_active' => true],
            ['label' => 'Kontak Kami', 'url' => '/kontak', 'target' => '_self', 'order_index' => 9, 'is_active' => true],
        ];

        foreach ($defaultMenus as $menu) {
            NavMenu::updateOrCreate(['url' => $menu['url']], $menu);
        }
    }
}
