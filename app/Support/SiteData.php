<?php

namespace App\Support;

use App\Models\Category;
use Illuminate\Support\Collection;

class SiteData
{
    private static array $catCache = [];

    private static function categoriesFor(string $type, array $fallback): array
    {
        if (! isset(self::$catCache[$type])) {
            try {
                $rows = Category::where('type', $type)
                    ->orderBy('sort_order')->orderBy('id')
                    ->pluck('name', 'key')->all();
            } catch (\Throwable $e) {
                $rows = [];
            }
            self::$catCache[$type] = $rows ?: $fallback;
        }

        return self::$catCache[$type];
    }

    public static function catalogCategories(): array
    {
        return self::categoriesFor('catalog', [
            'bangun'   => 'Pembangunan Rumah',
            'renovasi' => 'Renovasi Properti',
            'tanah'    => 'Jual Beli Tanah',
            'surat'    => 'Pengurusan Surat & PBG',
        ]);
    }

    public static function projectCategories(): array
    {
        return self::categoriesFor('project', [
            'rumah'     => 'Pembangunan Rumah',
            'renovasi'  => 'Renovasi Properti',
            'komersial' => 'Komersial & Kost',
            'pbg'       => 'Jual Beli Tanah & PBG',
        ]);
    }

    public static function catalog(): Collection
    {
        return collect([
            [
                'slug' => 'tipe-naraya-120', 'category' => 'bangun',
                'title' => 'Tipe Naraya 120 (Modern Tropical)', 'size' => 'Lahan 7×15m',
                'desc' => 'Desain siap bangun 2 lantai berfasad tropis modern, kisi kayu elegan, struktur kokoh, dan bergaransi konstruksi.',
                'long' => 'Tipe Naraya 120 adalah desain rumah dua lantai dengan sirkulasi udara silang dan pencahayaan alami. Cocok untuk lahan 7×15 m dan dapat disesuaikan dengan kebutuhan keluarga Anda.',
                'features' => ['Fasad tropis modern dengan kisi kayu', 'Void dan bukaan untuk cahaya alami', 'Struktur beton bertulang', 'Garansi konstruksi 12 bulan'],
                'specs' => [['LT', '105 m²'], ['LB', '120 m²'], ['KT', '3 Bed'], ['KM', '2 Bath']],
                'price_note' => 'Estimasi Bangun (Rp 4,5 Jt/m²):', 'price_text' => 'Rp 540 Jt', 'price' => 540,
                'popular' => 1, 'image' => 'images/katalog-1.jpg',
            ],
            [
                'slug' => 'paket-renovasi-total', 'category' => 'renovasi',
                'title' => 'Paket Renovasi Total & Tambah Lantai', 'size' => 'Semua ukuran',
                'desc' => 'Renovasi menyeluruh mulai dari struktur, fasad, hingga interior dengan RAB transparan dan jadwal pengerjaan jelas.',
                'long' => 'Paket renovasi untuk rumah lama yang ingin dirombak total atau ditambah lantai. Dimulai dari survei, gambar kerja, RAB, hingga serah terima.',
                'features' => ['Survei lokasi gratis', 'RAB rinci tanpa biaya tersembunyi', 'Laporan progres mingguan', 'Garansi pemeliharaan 12 bulan'],
                'specs' => [['Mulai', '36 m²'], ['Durasi', '2-4 Bln'], ['Survey', 'Gratis'], ['Garansi', '12 Bln']],
                'price_note' => 'Estimasi Mulai (per m²):', 'price_text' => 'Rp 2,5 Jt', 'price' => 2.5,
                'popular' => 2, 'image' => 'images/katalog-2.jpg',
            ],
            [
                'slug' => 'kavling-siap-bangun-serpong', 'category' => 'tanah',
                'title' => 'Kavling Tanah Siap Bangun', 'size' => 'Serpong & sekitarnya',
                'desc' => 'Kavling dengan legalitas jelas, akses jalan memadai, dan bisa langsung dilanjutkan paket desain serta bangun.',
                'long' => 'Kavling siap bangun dengan legalitas SHM dan akses jalan 6 meter. Setelah transaksi, Anda dapat langsung melanjutkan ke desain dan pembangunan bersama SA Properti.',
                'features' => ['Legalitas SHM', 'Akses jalan lebar 6 meter', 'Lingkungan sudah berkembang', 'Bisa dilanjutkan paket desain & bangun'],
                'specs' => [['Luas', '84 m²'], ['Legalitas', 'SHM'], ['Akses', 'Jalan 6m'], ['Status', 'Ready']],
                'price_note' => 'Harga Mulai:', 'price_text' => 'Rp 450 Jt', 'price' => 450,
                'popular' => 3, 'image' => 'images/katalog-3.jpg',
                // Jika item punya 'location', halaman detail otomatis menampilkan peta.
                'location' => [
                    'name'    => 'Kavling Siap Bangun Serpong',
                    'address' => 'Serpong, Tangerang Selatan, Banten',
                    'query'   => 'Serpong, Tangerang Selatan',
                ],
            ],
            [
                'slug' => 'pengurusan-pbg-slf-sertifikat', 'category' => 'surat',
                'title' => 'Pengurusan PBG, SLF & Sertifikat', 'size' => 'Seluruh Jabodetabek',
                'desc' => 'Pendampingan penuh pengurusan PBG, SLF, dan sertifikat resmi, termasuk gambar DED yang dibutuhkan.',
                'long' => 'Kami mendampingi pengurusan dokumen legalitas bangunan Anda dari awal sampai terbit, termasuk penyusunan gambar DED.',
                'features' => ['Pendampingan PBG & SLF', 'Gambar DED disiapkan tim', 'Tim berlisensi', 'Estimasi PBG 30-45 hari'],
                'specs' => [['PBG', '30-45 Hr'], ['SLF', 'Ya'], ['DED', 'Ya'], ['Tim', 'Berlisensi']],
                'price_note' => 'Biaya Mulai:', 'price_text' => 'Rp 15 Jt', 'price' => 15,
                'popular' => 4, 'image' => 'images/katalog-4.jpg',
            ],
        ]);
    }

    public static function projects(): Collection
    {
        $cats = self::projectCategories();

        return collect([
            [
                'slug' => 'hunian-tropis-modern-cilandak', 'category' => 'rumah', 'location' => 'Cilandak, Jakarta Selatan',
                'title' => 'Hunian Tropis Modern 2 Lantai — Cilandak, Jakarta Selatan',
                'lt' => '180 m²', 'lb' => '220 m²', 'duration' => '6 Bulan',
                'badge' => 'Serah Terima 2025', 'badge_style' => 'green', 'date' => '2025-03-10', 'popular' => 1,
                'image' => 'images/proyek-1.jpg',
                'desc' => 'Rumah dua lantai dengan fasad kaca lapang, pencahayaan alami, dan lanskap asri yang memberikan privasi dan kenyamanan.',
                'highlights' => ['Desain dan bangun satu paket', 'Fasad kaca dan kisi kayu', 'Laporan progres mingguan'],
            ],
            [
                'slug' => 'renovasi-total-bsd-city', 'category' => 'renovasi', 'location' => 'BSD City, Tangerang',
                'title' => 'Renovasi Total & Makeover Interior — BSD City, Tangerang',
                'lt' => '120 m²', 'lb' => '145 m²', 'duration' => '3,5 Bulan',
                'badge' => 'Serah Terima 2025', 'badge_style' => 'green', 'date' => '2025-02-08', 'popular' => 2,
                'image' => 'images/proyek-2.jpg',
                'desc' => 'Rumah lama dirombak menjadi hunian lega dengan skylight, void alami, dan finishing marmer.',
                'highlights' => ['Skylight dan void alami', 'Finishing marmer', 'Selesai tepat waktu'],
            ],
            [
                'slug' => 'kost-eksklusif-serpong', 'category' => 'komersial', 'location' => 'Serpong, Tangerang',
                'title' => 'Kost Eksklusif 3 Lantai (18 Kamar) — Serpong, Tangerang',
                'lt' => '200 m²', 'lb' => '380 m²', 'duration' => '8 Bulan',
                'badge' => 'Serah Terima 2024', 'badge_style' => 'dark', 'date' => '2024-11-20', 'popular' => 3,
                'image' => 'images/proyek-3.jpg',
                'desc' => 'Kost komersial tiga lantai dengan ventilasi silang dan tata ruang efisien untuk imbal hasil sewa yang optimal.',
                'highlights' => ['18 kamar', 'Ventilasi silang tropis', 'Pengurusan PBG termasuk'],
            ],
            [
                'slug' => 'ded-3d-pbg-kemang', 'category' => 'pbg', 'location' => 'Kemang, Jakarta Selatan',
                'title' => 'Perencanaan DED, 3D & Pengurusan PBG — Kemang, Jakarta Selatan',
                'lt' => '250 m²', 'lb' => '310 m²', 'duration' => '45 Hari',
                'badge' => 'Izin Terbit', 'badge_style' => 'red', 'date' => '2025-01-15', 'popular' => 5,
                'image' => 'images/proyek-4.jpg',
                'desc' => 'Perencanaan gambar DED, visualisasi 3D, dan pendampingan penuh hingga PBG terbit.',
                'highlights' => ['Gambar DED lengkap', 'Visualisasi 3D', 'PBG terbit'],
            ],
            [
                'slug' => 'rumah-industrial-bintaro', 'category' => 'rumah', 'location' => 'Bintaro Jaya, Tangerang Selatan',
                'title' => 'Rumah Minimalis Industrial — Bintaro Jaya, Tangerang Selatan',
                'lt' => '105 m²', 'lb' => '120 m²', 'duration' => '5 Bulan',
                'badge' => 'Serah Terima 2024', 'badge_style' => 'dark', 'date' => '2024-09-05', 'popular' => 4,
                'image' => 'images/proyek-5.jpg',
                'desc' => 'Rumah minimalis bergaya industrial dengan material ekspos dan tata ruang efisien.',
                'highlights' => ['Gaya industrial minimalis', 'Material ekspos', 'Efisien untuk lahan terbatas'],
            ],
            [
                'slug' => 'perluasan-ruang-keluarga-sentul', 'category' => 'renovasi', 'location' => 'Sentul City, Bogor',
                'title' => 'Perluasan Ruang Keluarga & Fasad — Sentul City, Bogor',
                'lt' => '150 m²', 'lb' => '170 m²', 'duration' => '3 Bulan',
                'badge' => 'Serah Terima 2024', 'badge_style' => 'dark', 'date' => '2024-07-18', 'popular' => 6,
                'image' => 'images/proyek-6.jpg',
                'desc' => 'Perluasan ruang keluarga dan penyegaran fasad tanpa mengganggu struktur utama.',
                'highlights' => ['Perluasan ruang keluarga', 'Fasad baru', 'Pengerjaan 3 bulan'],
            ],
        ])->map(fn ($i) => $i + ['category_label' => $cats[$i['category']]]);
    }
}