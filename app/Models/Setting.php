<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    protected static ?array $cache = null;

    /** Ambil nilai; jika kosong, pakai nilai bawaan. */
    public static function get(string $key, $default = null)
    {
        if (static::$cache === null) {
            try {
                static::$cache = static::query()->pluck('value', 'key')->all();
            } catch (\Throwable $e) {
                static::$cache = [];
            }
        }

        $v = static::$cache[$key] ?? null;
        if ($v !== null && $v !== '') {
            return $v;
        }

        return $default ?? (static::defaults()[$key] ?? null);
    }

    public static function put(string $key, ?string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        static::$cache = null;
    }

    /** Pecah teks per baris menjadi array. */
    public static function lines(string $key): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\R/', (string) static::get($key)))));
    }

    public static function defaults(): array
    {
        $out = [];
        foreach (static::groups() as $g) {
            foreach ($g['fields'] as $key => $f) {
                $out[$key] = $f[2];
            }
        }
        return $out;
    }

    /** Format field: 'key' => [label, tipe (text|textarea|image), nilai bawaan, petunjuk] */
    public static function groups(): array
    {
        return [
            'beranda' => [
                'label' => 'Beranda (Hero)', 'icon' => 'fa-house',
                'fields' => [
                    'hero_image'    => ['Gambar Hero', 'image', 'images/hero.jpg', 'Disarankan lebar 1600px ke atas, maksimal 4 MB.'],
                    'hero_title'    => ['Judul Hero', 'text', 'Wujudkan Hunian & Investasi Properti Terbaik Anda'],
                    'hero_subtitle' => ['Deskripsi Hero', 'textarea', 'Kemitraan terpercaya untuk jasa arsitektur, konstruksi bergaransi, dan renovasi modern dengan transparansi biaya 100% dan pengerjaan tepat waktu.'],
                ],
            ],
            'tentang' => [
                'label' => 'Tentang Kami', 'icon' => 'fa-circle-info',
                'fields' => [
                    'about_title'   => ['Judul Halaman', 'text', 'Mitra Terpercaya untuk Hunian dan Investasi Properti Anda'],
                    'about_intro'   => ['Pengantar', 'textarea', 'SA Properti memadukan estetika, kekuatan struktur, dan efisiensi anggaran dalam setiap proyek rancang bangun, renovasi, dan pengurusan legalitas.'],
                    'about_image'   => ['Foto Tim / Perusahaan', 'image', 'images/tentang.jpg'],
                    'about_story_1' => ['Cerita Perusahaan (paragraf 1)', 'textarea', 'PT SA Karya Properti Indonesia adalah perusahaan kontraktor arsitektur dan konsultan properti yang melayani Jabodetabek dan sekitarnya. Kami mendampingi klien dari tahap konsep, gambar kerja, perizinan, hingga serah terima kunci.'],
                    'about_story_2' => ['Cerita Perusahaan (paragraf 2)', 'textarea', 'Setiap proyek dikerjakan dengan RAB transparan, laporan progres rutin, dan garansi pemeliharaan setelah serah terima.'],
                    'about_stats'   => ['Angka Pencapaian', 'textarea', "50+|Proyek Selesai\n5+|Tahun Pengalaman\n12 Bln|Garansi Pemeliharaan\n100%|RAB Transparan", 'Satu baris satu angka, format: ANGKA|KETERANGAN (maksimal 4 baris).'],
                    'about_vision'  => ['Visi', 'textarea', 'Menjadi perusahaan rancang bangun dan konsultan properti yang paling dipercaya di Indonesia.'],
                    'about_mission' => ['Misi', 'textarea', "Memberikan biaya yang transparan dan terukur.\nMengutamakan kualitas struktur dan ketepatan waktu.\nMendampingi klien sampai legalitas selesai.", 'Satu baris satu poin misi.'],
                ],
            ],
            'kontak' => [
                'label' => 'Kontak & Sosial Media', 'icon' => 'fa-phone',
                'fields' => [
                    'whatsapp'      => ['Nomor WhatsApp (untuk tautan)', 'text', '6281234567890', 'Format internasional tanpa + dan spasi. Contoh: 6281234567890'],
                    'phone_display' => ['Nomor Telepon (tampilan)', 'text', '+62 812-3456-7890'],
                    'email'         => ['Email', 'text', 'info@saproperti.com'],
                    'address'       => ['Alamat', 'textarea', 'Grand Serpong Estate & Cilandak, Jakarta Selatan'],
                    'hours'         => ['Jam Operasional', 'textarea', "Senin - Jumat: 08.30 - 17.30 WIB\nSabtu: 09.00 - 15.00 WIB"],
                    'map_point'     => ['Titik Lokasi Kantor di Peta', 'map', ''],
                    'instagram'     => ['Link Instagram', 'text', '#'],
                    'facebook'      => ['Link Facebook', 'text', '#'],
                    'tiktok'        => ['Link TikTok', 'text', '#'],
                    'copyright'    => ['Teks Copyright', 'text', '© {year} SA Properti. Hak cipta dilindungi undang-undang.', '{year} otomatis menjadi tahun berjalan.'],
                    'footer_about' => ['Deskripsi Singkat di Footer', 'textarea', 'SA Properti melayani jasa konstruksi, renovasi, jual beli tanah dan rumah, serta pengurusan sertifikat properti.'],
                ],
            ],

            'chatbot' => [
                'label' => 'Chatbot AI', 'icon' => 'fa-robot',
                'fields' => [
                    'ai_greeting'  => ['Sapaan Awal', 'textarea', 'Halo! Saya asisten AI SA Properti. Pilih pertanyaan cepat di bawah atau tulis pertanyaan Anda.'],
                    'ai_knowledge' => ['Informasi untuk AI', 'textarea',
                    "Layanan: renovasi (kamar mandi, keran, pengecatan, dan lainnya), pembangunan rumah dan kos dari nol, jual beli tanah dan rumah, pengurusan sertifikat properti.\nRenovasi adalah layanan yang paling banyak dicari.\nSetiap pesanan mendapat bonus desain layout (blueprint) dan gambar visual hasil akhir.\nKonsultasi dan negosiasi dilakukan lewat WhatsApp.\nMedia sosial: TikTok SA Properti Official, Facebook.",
                     'Tulis fakta yang boleh dijawab AI, satu poin per baris. AI dilarang mengarang di luar ini.'],
             ],
            ],
        ];
    }
}