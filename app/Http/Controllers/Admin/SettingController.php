<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display settings page
     */
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        $presets = $this->getAvailablePresets();

        return view('admin.settings.index', compact('settings', 'presets'));
    }

    /**
     * Dedicated Visi & Misi edit form
     */
    public function visionMission()
    {
        $vision = Setting::get('vision', '');
        $mission = Setting::get('mission', '');
        $aboutTitle = Setting::get('about_title', 'Profil & Visi Misi');
        $aboutDescription = Setting::get('about_description', '');

        return view('admin.settings.vision_mission', compact('vision', 'mission', 'aboutTitle', 'aboutDescription'));
    }

    /**
     * Update Visi & Misi
     */
    public function updateVisionMission(Request $request)
    {
        $request->validate([
            'vision' => 'required|string',
            'mission' => 'required|string',
            'about_title' => 'nullable|string|max:150',
            'about_description' => 'nullable|string',
        ]);

        Setting::set('vision', $request->vision);
        Setting::set('mission', $request->mission);
        if ($request->filled('about_title')) {
            Setting::set('about_title', $request->about_title);
        }
        if ($request->has('about_description')) {
            Setting::set('about_description', $request->about_description ?? '');
        }

        Setting::clearCache();

        return back()->with('success', 'Visi, Misi, dan Profil Program Studi berhasil diperbarui!');
    }

    /**
     * Update settings
     */
    public function update(Request $request)
    {
        $data = $request->except(['_token', 'logo', 'hero_image']);

        // Handle file uploads (Logo & Hero Image) with Auto-Compression
        if ($request->hasFile('logo')) {
            $logoPath = \App\Services\ImageService::uploadAndOptimize($request->file('logo'), 'branding', 600, 90);
            Setting::set('logo_url', $logoPath);
        }

        if ($request->hasFile('hero_image')) {
            $heroPath = \App\Services\ImageService::uploadAndOptimize($request->file('hero_image'), 'branding', 1920, 85);
            Setting::set('hero_image_url', $heroPath);
        }

        // Save all text settings
        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        Setting::clearCache();

        return back()->with('success', 'Pengaturan identitas divisi dan tampilan berhasil disimpan.');
    }

    /**
     * Apply Preset to instantly change the website to another division
     */
    public function applyPreset(Request $request)
    {
        $request->validate(['preset_key' => 'required|string']);
        $presets = $this->getAvailablePresets();

        if (!isset($presets[$request->preset_key])) {
            return back()->with('error', 'Preset divisi tidak ditemukan.');
        }

        $selectedPreset = $presets[$request->preset_key]['settings'];

        foreach ($selectedPreset as $key => $value) {
            Setting::set($key, $value);
        }

        Setting::clearCache();

        return back()->with('success', 'Berhasil menerapkan preset divisi: ' . $presets[$request->preset_key]['name'] . '. Seluruh identitas website telah diperbarui.');
    }

    /**
     * Definition of available division presets for STIKES Panti Waluya
     */
    private function getAvailablePresets(): array
    {
        return [
            'lpmi' => [
                'name' => 'Lembaga Penjaminan Mutu Internal (LPMI)',
                'badge' => 'Mutu & SPMI',
                'color' => '#0f766e',
                'icon' => 'fa-solid fa-award',
                'description' => 'Preset untuk Lembaga Penjaminan Mutu Internal (LPMI) STIKES Panti Waluya.',
                'settings' => [
                    'division_type' => 'lembaga',
                    'division_name' => 'Lembaga Penjaminan Mutu Internal (LPMI)',
                    'division_short_name' => 'LPMI STIKES Panti Waluya',
                    'division_acronym' => 'LPMI',
                    'division_icon' => 'fa-solid fa-award',
                    'division_tagline' => 'Mengawal Mutu Pendidikan Tinggi Kesehatan Menuju Akreditasi Unggul',
                    'theme_primary_color' => '#0f766e', // Teal 700
                    'theme_secondary_color' => '#115e59',
                    'hero_banner_title' => 'Sistem Penjaminan Mutu Internal (SPMI) Terpadu',
                    'hero_banner_subtitle' => 'Melaksanakan siklus PPEPP (Penetapan, Pelaksanaan, Evaluasi, Pengendalian, Peningkatan) secara berkelanjutan.',
                    'about_title' => 'Tentang Lembaga Penjaminan Mutu Internal',
                    'about_description' => 'LPMI bertanggung jawab dalam perumusan standar mutu, pelaksanaan Audit Mutu Internal (AMI), monitoring kepuasan pemangku kepentingan, dan pendampingan akreditasi LAM-PTKes.',
                    'vision' => 'Menjadi pengawal penjaminan mutu yang kredibel dan terpercaya untuk mewujudkan budaya mutu berkarakter kasih di STIKES Panti Waluya pada tahun 2030.',
                    'mission' => "1. Merumuskan dan memutakhirkan Standar SPMI berbasis SN-Dikti.\n2. Melaksanakan Audit Mutu Internal (AMI) secara berkala dan konsisten.\n3. Mengukur kepuasan mahasiswa, dosen, tenaga kependidikan, dan mitra pengguna lulusan.\n4. Mengawal tindak lanjut temuan audit melalui Rapat Tinjauan Manajemen (RTM).",
                    'contact_email' => 'lpmi@pantiwaluya.ac.id',
                    'contact_phone' => '(0341) 569275 ext. 105',
                    'contact_room' => 'Gedung Rektorat Lt. 2',
                    'stat_1_number' => '48',
                    'stat_1_label' => 'Standar Mutu SPMI',
                    'stat_2_number' => '2x / Thn',
                    'stat_2_label' => 'Siklus Audit Mutu (AMI)',
                    'stat_3_number' => '20',
                    'stat_3_label' => 'Auditor Bersertifikat',
                    'stat_4_number' => '97%',
                    'stat_4_label' => 'Indeks Kepuasan Layanan',
                ],
            ],
            'lppm' => [
                'name' => 'Lembaga Penelitian dan Pengabdian kepada Masyarakat (LPPM)',
                'badge' => 'Riset & Pengmas',
                'color' => '#0e7490',
                'icon' => 'fa-solid fa-microscope',
                'description' => 'Preset untuk Lembaga Penelitian dan Pengabdian kepada Masyarakat STIKES Panti Waluya.',
                'settings' => [
                    'division_type' => 'lembaga',
                    'division_name' => 'Lembaga Penelitian dan Pengabdian kepada Masyarakat (LPPM)',
                    'division_short_name' => 'LPPM STIKES Panti Waluya',
                    'division_acronym' => 'LPPM',
                    'division_icon' => 'fa-solid fa-microscope',
                    'division_tagline' => 'Mendorong Riset Klinis Kesehatan & Pengabdian Masyarakat Berkarakter Kasih',
                    'theme_primary_color' => '#0e7490', // Cyan 700
                    'theme_secondary_color' => '#0369a1',
                    'hero_banner_title' => 'Pusat Riset Kesehatan & Pengabdian Masyarakat Unggul',
                    'hero_banner_subtitle' => 'Mengembangkan riset klinis kesehatan, inovasi herbal, komisi etik (KEPK), dan sentra HKI berdaya saing.',
                    'about_title' => 'Tentang LPPM STIKES Panti Waluya',
                    'about_description' => 'LPPM mengoordinasikan, memfasilitasi, dan meningkatkan kualitas riset ilmiah dosen-mahasiswa, hilirisasi produk inovasi, pengabdian masyarakat, sentra HKI, serta Komite Etik Penelitian Kesehatan (KEPK).',
                    'vision' => 'Menjadi pusat penelitian kesehatan dan pengabdian masyarakat unggul, inovatif, dan berkarakter kasih pada tahun 2030.',
                    'mission' => "1. Menumbuhkan iklim riset kesehatan holistik yang berkualitas.\n2. Melaksanakan pengabdian masyarakat berbasis bukti ilmiah (evidence-based).\n3. Memfasilitasi publikasi jurnal nasional terakreditasi Sinta, internasional Scopus, dan perolehan HKI.\n4. Memperluas jejaring riset dengan rumah sakit dan institusi mitra nasional & global.",
                    'contact_email' => 'lppm@pantiwaluya.ac.id',
                    'contact_phone' => '(0341) 569275 ext. 104',
                    'contact_room' => 'Gedung Rektorat Lt. 2',
                    'stat_1_number' => '135+',
                    'stat_1_label' => 'Publikasi Ilmiah',
                    'stat_2_number' => '50+',
                    'stat_2_label' => 'Pengmas Terlaksana',
                    'stat_3_number' => '30+',
                    'stat_3_label' => 'HKI & Paten',
                    'stat_4_number' => '22',
                    'stat_4_label' => 'Mitra Kerjasama Riset',
                ],
            ],
            'cdc' => [
                'name' => 'Career Development Center (CDC)',
                'badge' => 'Pusat Karir',
                'color' => '#ea580c',
                'icon' => 'fa-solid fa-briefcase',
                'description' => 'Preset untuk Career Development Center & Pusat Karir Alumni.',
                'settings' => [
                    'division_type' => 'unit',
                    'division_name' => 'Career Development Center & Pusat Karir Alumni (CDC)',
                    'division_short_name' => 'CDC STIKES Panti Waluya',
                    'division_acronym' => 'CDC',
                    'division_icon' => 'fa-solid fa-briefcase',
                    'division_tagline' => 'Jembatan Emas Menuju Karir Tenaga Kesehatan Profesional & Global',
                    'theme_primary_color' => '#ea580c', // Orange 600
                    'theme_secondary_color' => '#c2410c',
                    'hero_banner_title' => 'Pusat Bimbingan Karir & Bursa Kerja Tenaga Kesehatan',
                    'hero_banner_subtitle' => 'Menghubungkan lulusan dengan ratusan rumah sakit mitra, klinik, industri farmasi, dan peluang karir internasional.',
                    'about_title' => 'Tentang Career Development Center (CDC)',
                    'about_description' => 'CDC STIKES Panti Waluya berfokus pada kesiapan kerja lulusan, pembekalan sertifikasi kompetensi, job fair kampus, tracer study alumni, dan bimbingan karir keperawatan, farmasi, serta manajemen rekam medis.',
                    'vision' => 'Menjadi pusat pengembangan karir dan penelusuran alumni yang unggul dan terpercaya dalam menyalurkan tenaga kesehatan berkarakter kasih.',
                    'mission' => "1. Menyelenggarakan pelatihan kesiapan kerja, interview, dan sertifikasi profesi kesehatan.\n2. Mengadakan Campus Hiring dan Job Fair bersama Rumah Sakit mitra.\n3. Melaksanakan Tracer Study berkala untuk mengukur relevansi kurikulum dan serapan kerja lulusan.\n4. Memperluas peluang penempatan kerja di luar negeri (Jepang, Jerman, Timur Tengah).",
                    'contact_email' => 'cdc@pantiwaluya.ac.id',
                    'contact_phone' => '(0341) 569275 ext. 106',
                    'contact_room' => 'Gedung Student Center Lt. 1',
                    'stat_1_number' => '96%',
                    'stat_1_label' => 'Terserap Kerja < 3 Bulan',
                    'stat_2_number' => '45+',
                    'stat_2_label' => 'RS & Faskes Mitra',
                    'stat_3_number' => '1.200+',
                    'stat_3_label' => 'Alumni Terhubung',
                    'stat_4_number' => '25+',
                    'stat_4_label' => 'Alumni Berkarir Luar Negeri',
                ],
            ],
            'belmawa' => [
                'name' => 'Belmawa / Kemahasiswaan',
                'badge' => 'Kemahasiswaan',
                'color' => '#1d4ed8',
                'icon' => 'fa-solid fa-graduation-cap',
                'description' => 'Preset untuk Biro Pembelajaran & Kemahasiswaan (Belmawa).',
                'settings' => [
                    'division_type' => 'biro',
                    'division_name' => 'Biro Pembelajaran & Kemahasiswaan (Belmawa)',
                    'division_short_name' => 'Belmawa STIKES Panti Waluya',
                    'division_acronym' => 'BELMAWA',
                    'division_icon' => 'fa-solid fa-graduation-cap',
                    'division_tagline' => 'Wadah Pengembangan Prestasi, Karakter Kasih, dan Kreativitas Mahasiswa',
                    'theme_primary_color' => '#1d4ed8', // Blue 700
                    'theme_secondary_color' => '#1e40af',
                    'hero_banner_title' => 'Membina Mahasiswa Berprestasi & Berintegritas',
                    'hero_banner_subtitle' => 'Mendukung organisasi kemahasiswaan (BEM/DPM/HIMA/UKM), beasiswa, kompetisi nasional (PKM/NUDC/ONMIPA), dan konseling mahasiswa.',
                    'about_title' => 'Tentang Biro Belmawa & Kemahasiswaan',
                    'about_description' => 'Belmawa bertanggung jawab memfasilitasi pembinaan penalaran, minat, bakat, organisasi kemahasiswaan, beasiswa pemerintah & yayasan, serta layanan bimbingan konseling mahasiswa.',
                    'vision' => 'Mewujudkan insan mahasiswa kesehatan yang cerdas, berprestasi, berjiwa kepemimpinan, dan berkarakter kasih.',
                    'mission' => "1. Meningkatkan pembinaan minat, bakat, dan prestasi mahasiswa tingkat nasional.\n2. Mengoptimalkan penyaluran beasiswa KIP-Kuliah, beasiswa prestasi, dan yayasan.\n3. Memfasilitasi tata kelola ormawa dan UKM yang kreatif dan akuntabel.\n4. Memberikan layanan konseling dan kesehatan mental bagi mahasiswa.",
                    'contact_email' => 'kemahasiswaan@pantiwaluya.ac.id',
                    'contact_phone' => '(0341) 569275 ext. 102',
                    'contact_room' => 'Gedung Student Center Lt. 1',
                    'stat_1_number' => '850+',
                    'stat_1_label' => 'Mahasiswa Aktif',
                    'stat_2_number' => '35+',
                    'stat_2_label' => 'Prestasi Nasional',
                    'stat_3_number' => '12',
                    'stat_3_label' => 'Organisasi & UKM',
                    'stat_4_number' => '9',
                    'stat_4_label' => 'Program Beasiswa',
                ],
            ],
            'keperawatan_ners' => [
                'name' => 'PRODI S1 Keperawatan & Profesi Ners',
                'badge' => 'Program Studi',
                'color' => '#ca8a04',
                'icon' => 'fa-solid fa-user-nurse',
                'description' => 'Preset untuk Program Studi S1 Keperawatan dan Pendidikan Profesi Ners (1 Web Terpadu).',
                'settings' => [
                    'division_type' => 'prodi',
                    'division_name' => 'Program Studi S1 Keperawatan & Pendidikan Profesi Ners',
                    'division_short_name' => 'Prodi Keperawatan & Ners Panti Waluya',
                    'division_acronym' => 'KEP-NERS',
                    'division_icon' => 'fa-solid fa-user-nurse',
                    'division_tagline' => 'Mencetak Perawat Profesional Beretika, Unggul dalam Asuhan Geriatri & Gawat Darurat',
                    'theme_primary_color' => '#ca8a04', // Golden Yellow
                    'theme_secondary_color' => '#a16207',
                    'hero_banner_title' => 'Pendidikan Sarjana Keperawatan & Profesi Ners Terpadu',
                    'hero_banner_subtitle' => 'Pendidikan terintegrasi tahap akademik (S1) dan profesi (Ners) dengan laboratorium OSCE/RS simulasi modern.',
                    'about_title' => 'Profil Program Studi S1 Keperawatan & Profesi Ners',
                    'about_description' => 'Prodi S1 Keperawatan & Profesi Ners STIKES Panti Waluya menyelenggarakan pendidikan berkesinambungan untuk mencetak perawat berdaya saing global, menguasai asuhan keperawatan paliatif, geriatri, dan emergency.',
                    'vision' => 'Menjadi Program Studi S1 Keperawatan dan Profesi Ners terkemuka berkeunggulan keperawatan geriatri dan gawat darurat berkarakter kasih pada tahun 2030.',
                    'mission' => "1. Menyelenggarakan pendidikan S1 Keperawatan dan Profesi Ners berkualitas berbasis Outcome-Based Education (OBE).\n2. Melaksanakan riset klinis dan komunitas yang aplikatif serta terpublikasi bereputasi.\n3. Melaksanakan pengabdian asuhan keperawatan komunitas berkarakter kasih.\n4. Menjalin kerjasama rotasi klinik di Rumah Sakit Tipe A/B dan fasilitas kesehatan internasional.",
                    'prodi_degree' => 'Sarjana Keperawatan (S.Kep) & Ners (Ns.)',
                    'prodi_accreditation' => 'Terakreditasi Baik Sekali (LAM-PTKes)',
                    'prodi_graduate_profile' => 'Care Provider (Perawat Klinis RS & Komunitas), Communicator, Manager/Leader Keperawatan, Researcher Pemula, dan Educator Kesehatan',
                    'contact_email' => 'keperawatan@pantiwaluya.ac.id',
                    'contact_phone' => '(0341) 569275 ext. 201',
                    'contact_room' => 'Gedung Laboratorium Terpadu Lt. 3',
                    'stat_1_number' => '99%',
                    'stat_1_label' => 'Kelulusan Uji Kompetensi Ners',
                    'stat_2_number' => '15',
                    'stat_2_label' => 'RS Mitra Praktik Klinik',
                    'stat_3_number' => '28',
                    'stat_3_label' => 'Dosen Spesialis & Ners',
                    'stat_4_number' => '8',
                    'stat_4_label' => 'Laboratorium Simulasi RS',
                ],
            ],
            'farmasi' => [
                'name' => 'Prodi S1 Farmasi',
                'badge' => 'Program Studi',
                'color' => '#eab308',
                'icon' => 'fa-solid fa-prescription-bottle-medical',
                'description' => 'Preset untuk Program Studi S1 Farmasi.',
                'settings' => [
                    'division_type' => 'prodi',
                    'division_name' => 'Program Studi S1 Farmasi',
                    'division_short_name' => 'Prodi S1 Farmasi',
                    'division_acronym' => 'S1 Farmasi',
                    'division_icon' => 'fa-solid fa-prescription-bottle-medical',
                    'division_tagline' => 'Mencetak Sarjana Farmasi Unggul, Inovatif dalam Farmasi Bahan Alam dan Pelayanan Farmasi Komunitas Berkarakter Kasih',
                    'theme_primary_color' => '#eab308', // Yellow-500 (Kuning Cerah Terang)
                    'theme_secondary_color' => '#ca8a04', // Yellow-600 (Golden Amber)
                    'theme_accent_color' => '#16a34a', // Emerald-600
                    'hero_banner_title' => 'Program Studi S1 Farmasi',
                    'hero_banner_subtitle' => 'Mencetak Sarjana Farmasi yang unggul dalam sains farmasi modern, formulasi bahan alam, serta berdedikasi tinggi dalam pelayanan kefarmasian berkarakter kasih.',
                    'about_title' => 'Tentang Prodi S1 Farmasi',
                    'about_description' => "Program Studi S1 Farmasi STIKES Panti Waluya Malang menyelenggarakan pendidikan sarjana kefarmasian yang mengintegrasikan penguasaan sains farmasi modern, teknologi formulasi bahan alam nusantara, dan pelayanan farmasi klinis-komunitas yang berorientasi pada keselamatan pasien (patient safety).\n\nKurikulum kami dirancang berbasis Outcome-Based Education (OBE) dan Standar Kompetensi Apoteker Indonesia (SKAI), didukung oleh laboratorium farmasi terpadu (Kimia Farmasi, Farmakognosi-Fitokimia, Teknologi Farmasi, dan Mikrobiologi) serta wahana kemitraan praktikum di rumah sakit dan industri farmasi ternama.\n\nDidukung oleh tenaga pengajar berkualifikasi Magister dan Doktor Farmasi serta praktisi profesional, kami berkomitmen mencetak lulusan yang mandiri, adaptif, berjiwa wirausaha (technopreneur), dan berkarakter kasih dalam mengabdi bagi kesehatan masyarakat.",
                    'vision' => 'Menjadi Program Studi S1 Farmasi yang Unggul, Inovatif, dan Terdepan dalam Pengembangan Farmasi Bahan Alam serta Pelayanan Kefarmasian Komunitas yang Berkarakter Kasih pada Tingkat Nasional Menuju Global pada Tahun 2035.',
                    'mission' => "1. Menyelenggarakan pendidikan sarjana farmasi berkualitas tinggi berbasis kurikulum OBE (Outcome-Based Education) yang adaptif terhadap kemajuan sains dan teknologi kefarmasian.\n2. Mengembangkan penelitian inovatif di bidang formulasi herbal, standarisasi obat bahan alam (fitofarmaka), dan farmasi klinis berbasis bukti (Evidence-Based Pharmacy).\n3. Melaksanakan pengabdian kepada masyarakat yang aplikatif melalui edukasi DAGUSIBU (Dapatkan, Gunakan, Simpan, Buang) dan pembinaan kesehatan masyarakat mandiri.\n4. Membina pembentukan karakter lulusan yang berintegritas moral tinggi, mematuhi etika kefarmasian, disiplin, dan berjiwa cinta kasih dalam melayani sesama.\n5. Menjalin kerjasama strategis dengan industri farmasi, rumah sakit pendidikan, apotek jejaring, instansi regulator (BPOM/Dinkes), dan organisasi profesi (IAI).",
                    'prodi_degree' => 'Sarjana Farmasi (S.Farm)',
                    'prodi_accreditation' => 'Terakreditasi Baik Sekali (LAM-PTKes)',
                    'prodi_graduate_profile' => 'Farmasis Pelayanan Klinis & Komunitas (Rumah Sakit, Puskesmas, Apotek), Formulator & Quality Assurance/Control (QA/QC) di Industri Farmasi, Obat Tradisional, Makanan & Kosmetik, Pengelola & Entrepreneur Fasilitas Kefarmasian, serta Peneliti Pemula bidang Sains Farmasi dan Bahan Alam.',
                    'contact_email' => 'farmasi@pantiwaluya.ac.id',
                    'contact_phone' => '(0341) 569275',
                    'contact_room' => 'Gedung Laboratorium Terpadu Lt. 2, Ruang Prodi S1 Farmasi',
                    'stat_1_number' => '100%',
                    'stat_1_label' => 'Akreditasi Baik Sekali',
                    'stat_2_number' => '100%',
                    'stat_2_label' => 'Dosen S2/S3 & Praktisi Farmasi',
                    'stat_3_number' => '30+',
                    'stat_3_label' => 'Industri & Wahana Praktik Mitra',
                    'stat_4_number' => '50+',
                    'stat_4_label' => 'Produk Inovasi Herbal Teruji',
                ],
            ],
            'mik' => [
                'name' => 'Prodi D4 Manajemen Informasi Kesehatan',
                'badge' => 'Program Studi',
                'color' => '#7c3aed',
                'icon' => 'fa-solid fa-laptop-medical',
                'description' => 'Preset untuk Program Studi Sarjana Terapan Manajemen Informasi Kesehatan (D4 MIK).',
                'settings' => [
                    'division_type' => 'prodi',
                    'division_name' => 'Program Studi Sarjana Terapan Manajemen Informasi Kesehatan (D4 MIK)',
                    'division_short_name' => 'Prodi D4 MIK Panti Waluya',
                    'division_acronym' => 'D4-MIK',
                    'division_icon' => 'fa-solid fa-laptop-medical',
                    'division_tagline' => 'Pelopor Transformasi Rekam Medis Elektronik (RME) & Analitika Data Kesehatan Digital',
                    'theme_primary_color' => '#7c3aed', // Purple / Ungu
                    'theme_secondary_color' => '#5b21b6', // Deep Purple
                    'hero_banner_title' => 'Pusat Unggulan Rekam Medis Digital & Health Informatics',
                    'hero_banner_subtitle' => 'Mencetak Sarjana Terapan MIK yang ahli dalam koding klinis (ICD-10/ICD-9-CM), SIMRS, audit rekam medis, dan keamanan data kesehatan.',
                    'about_title' => 'Profil Program Studi D4 Manajemen Informasi Kesehatan',
                    'about_description' => 'Prodi D4 MIK STIKES Panti Waluya menghasilkan profesional rekam medis dan informasi kesehatan yang siap memimpin digitalisasi fasilitas pelayanan kesehatan di era SATUSEHAT Kemenkes.',
                    'vision' => 'Menjadi Program Studi Sarjana Terapan Manajemen Informasi Kesehatan yang unggul dalam sistem informasi kesehatan digital dan koding klinis berkarakter kasih pada tahun 2030.',
                    'mission' => "1. Menyelenggarakan pendidikan Sarjana Terapan MIK berstandar kurikulum digital health terkini.\n2. Mengembangkan penelitian terapan di bidang Rekam Medis Elektronik (RME), casemix, dan analitika data kesehatan.\n3. Melaksanakan pengabdian masyarakat berupa literasi informasi kesehatan digital di faskes primer.\n4. Menjalin kemitraan dengan RS, Dinas Kesehatan, BPJS Kesehatan, dan vendor SIMRS nasional.",
                    'prodi_degree' => 'Sarjana Terapan Manajemen Informasi Kesehatan (S.Tr.Kes)',
                    'prodi_accreditation' => 'Terakreditasi Baik Sekali (LAM-PTKes)',
                    'prodi_graduate_profile' => 'Manajer Rekam Medis & RME Rumah Sakit, Clinical Coder & Casemix Specialist BPJS, Health Data Analyst, dan Konsultan SIMRS',
                    'contact_email' => 'mik@pantiwaluya.ac.id',
                    'contact_phone' => '(0341) 569275 ext. 208',
                    'contact_room' => 'Gedung Laboratorium Komputer Terpadu Lt. 2',
                    'stat_1_number' => '98%',
                    'stat_1_label' => 'Kelulusan UKOM MIK',
                    'stat_2_number' => '100%',
                    'stat_2_label' => 'Kebutuhan Kerja RME Tinggi',
                    'stat_3_number' => '16',
                    'stat_3_label' => 'RS Praktik RME & Casemix',
                    'stat_4_number' => '4',
                    'stat_4_label' => 'Lab SIMRS & Koding Medis',
                ],
            ],
            'rpl' => [
                'name' => 'Rekognisi Pembelajaran Lampau (RPL)',
                'badge' => 'Pusat Layanan',
                'color' => '#b91c1c',
                'icon' => 'fa-solid fa-id-card-clip',
                'description' => 'Preset untuk Pusat Layanan Rekognisi Pembelajaran Lampau (RPL Tipe A).',
                'settings' => [
                    'division_type' => 'unit',
                    'division_name' => 'Pusat Layanan Rekognisi Pembelajaran Lampau (RPL)',
                    'division_short_name' => 'Pusat RPL STIKES Panti Waluya',
                    'division_acronym' => 'RPL',
                    'division_icon' => 'fa-solid fa-id-card-clip',
                    'division_tagline' => 'Konversi Pengalaman Kerja & Pendidikan Non-Formal Menjadi SKS Gelar Sarjana Kesehatan',
                    'theme_primary_color' => '#b91c1c', // Red 700
                    'theme_secondary_color' => '#991b1b',
                    'hero_banner_title' => 'Kuliah Cepat Jalur Pengalaman Kerja (RPL Tipe A)',
                    'hero_banner_subtitle' => 'Pengakuan capaian pembelajaran dari pengalaman kerja praktisi perawat, tenaga farmasi, dan perekam medis untuk melanjutkan ke jenjang S1/D4.',
                    'about_title' => 'Tentang Layanan Rekognisi Pembelajaran Lampau (RPL)',
                    'about_description' => 'Pusat RPL STIKES Panti Waluya memfasilitasi tenaga kesehatan yang telah bekerja untuk memperoleh pengakuan SKS akademik melalui asesmen portofolio dan asesmen mandiri sesuai regulasi Kemendikbudristek & Kemenkes.',
                    'vision' => 'Menjadi unit penyelenggara RPL yang akuntabel, transparan, dan inklusif dalam memperluas akses pendidikan tinggi tenaga kesehatan.',
                    'mission' => "1. Melaksanakan asesmen dan rekognisi capaian pembelajaran secara objektif dan terstandar.\n2. Memberikan layanan konsultasi dan pendampingan penyusunan portofolio RPL bagi calon mahasiswa.\n3. Mempercepat masa studi tenaga kesehatan aktif tanpa mengorbankan kualitas kompetensi lulusan.\n4. Menjalin kemitraan dengan organisasi profesi (PPNI, IAI, PORMIKI) dan institusi faskes.",
                    'contact_email' => 'rpl@pantiwaluya.ac.id',
                    'contact_phone' => '(0341) 569275 ext. 110',
                    'contact_room' => 'Gedung Rektorat Lt. 1 (Front Office RPL)',
                    'stat_1_number' => 'Hingga 50%',
                    'stat_1_label' => 'Pengakuan Beban SKS',
                    'stat_2_number' => '2 - 3 Smt',
                    'stat_2_label' => 'Masa Tempuh Studi',
                    'stat_3_number' => '100%',
                    'stat_3_label' => 'Resmi Kemendikbudristek',
                    'stat_4_number' => '15',
                    'stat_4_label' => 'Asesor RPL Tersertifikasi',
                ],
            ],
            'perpustakaan' => [
                'name' => 'Unit Perpustakaan Terpadu',
                'badge' => 'Perpustakaan',
                'color' => '#0891b2',
                'icon' => 'fa-solid fa-book-open-reader',
                'description' => 'Preset untuk Unit Pelaksana Teknis (UPT) Perpustakaan & E-Library.',
                'settings' => [
                    'division_type' => 'unit',
                    'division_name' => 'Unit Perpustakaan & E-Library Terpadu',
                    'division_short_name' => 'Perpustakaan STIKES Panti Waluya',
                    'division_acronym' => 'PERPUS',
                    'division_icon' => 'fa-solid fa-book-open-reader',
                    'division_tagline' => 'Jendela Referensi Ilmiah Kesehatan Digital & Sumber Belajar Modern',
                    'theme_primary_color' => '#0891b2',
                    'theme_secondary_color' => '#0e7490',
                    'hero_banner_title' => 'Pusat Sumber Belajar & Koleksi Jurnal Kesehatan',
                    'hero_banner_subtitle' => 'Menyediakan ribuan buku teks medis, e-journal nasional/internasional, repositori skripsi, dan ruang baca nyaman.',
                    'about_title' => 'Tentang Perpustakaan STIKES Panti Waluya',
                    'about_description' => 'UPT Perpustakaan melayani peminjaman buku, akses database e-journal kesehatan, bimbingan literasi informasi ilmiah, cek similarity Turnitin, dan repository karya ilmiah.',
                    'vision' => 'Menjadi pusat rujukan informasi ilmiah kesehatan yang modern, terdigitalisasi, dan berorientasi pada kepuasan sivitas akademika.',
                    'mission' => "1. Menyediakan koleksi pustaka cetak dan digital bidang keperawatan, farmasi, dan rekam medis yang mutakhir.\n2. Mengembangkan sistem automasi perpustakaan (SLiMS) dan repositori institusi terintegrasi.\n3. Memberikan layanan penelusuran referensi dan uji kesamaan karya ilmiah (Turnitin).\n4. Menciptakan suasana ruang belajar yang inklusif, tenang, dan inspiratif.",
                    'contact_email' => 'perpustakaan@pantiwaluya.ac.id',
                    'contact_phone' => '(0341) 569275 ext. 108',
                    'contact_room' => 'Gedung Perpustakaan Pusat Lt. 1 & 2',
                    'stat_1_number' => '12.000+',
                    'stat_1_label' => 'Judul Koleksi Buku',
                    'stat_2_number' => '8.500+',
                    'stat_2_label' => 'E-Journal Terlanggan',
                    'stat_3_number' => '100%',
                    'stat_3_label' => 'Katalog Online (OPAC)',
                    'stat_4_number' => '150',
                    'stat_4_label' => 'Kapasitas Ruang Baca',
                ],
            ],
            'it_puskom' => [
                'name' => 'Pusat Komputer & Sistem Informasi (Puskom / IT)',
                'badge' => 'Pusat TI',
                'color' => '#2563eb',
                'icon' => 'fa-solid fa-server',
                'description' => 'Preset untuk Unit Pengelola Sistem Informasi, Jaringan & Layanan IT Kampus.',
                'settings' => [
                    'division_type' => 'unit',
                    'division_name' => 'Pusat Komputer & Sistem Informasi (Puskom / IT)',
                    'division_short_name' => 'Puskom STIKES Panti Waluya',
                    'division_acronym' => 'PUSKOM-IT',
                    'division_icon' => 'fa-solid fa-server',
                    'division_tagline' => 'Membangun Infrastruktur Digital, Keamanan Siber & Layanan TI Kampus Terpadu',
                    'theme_primary_color' => '#2563eb',
                    'theme_secondary_color' => '#1d4ed8',
                    'hero_banner_title' => 'Layanan Infrastruktur TI & Smart Campus',
                    'hero_banner_subtitle' => 'Mengelola sistem akademik (SIAKAD), e-learning LMS, jaringan internet fiber optic kampus, dan keamanan server.',
                    'about_title' => 'Tentang Pusat Komputer & Sistem Informasi',
                    'about_description' => 'Puskom IT bertanggung jawab atas pemeliharaan server, integrasi aplikasi portal kampus, akun email institusi, hotspot Wi-Fi, dan helpdesk teknis sivitas akademika.',
                    'vision' => 'Menjadi motor penggerak transformasi digital kampus yang andal, aman, dan berkesinambungan.',
                    'mission' => "1. Membangun dan memelihara sistem informasi akademik dan manajemen kampus yang terintegrasi.\n2. Menjamin ketersediaan infrastruktur jaringan internet berkecepatan tinggi dan keamanan data.\n3. Memberikan layanan helpdesk dan dukungan teknis yang responsif bagi dosen, mahasiswa, dan staf.\n4. Mengembangkan platform digital modern untuk mendukung akreditasi dan tata kelola perguruan tinggi.",
                    'contact_email' => 'it@pantiwaluya.ac.id',
                    'contact_phone' => '(0341) 569275 ext. 101',
                    'contact_room' => 'Gedung Server & Data Center Lt. 1',
                    'stat_1_number' => '99.9%',
                    'stat_1_label' => 'Uptime Server',
                    'stat_2_number' => '1 Gbps',
                    'stat_2_label' => 'Bandwidth Internet',
                    'stat_3_number' => '15+',
                    'stat_3_label' => 'Sistem Informasi Aktif',
                    'stat_4_number' => '24/7',
                    'stat_4_label' => 'Monitoring Server',
                ],
            ],
        ];
    }
}
