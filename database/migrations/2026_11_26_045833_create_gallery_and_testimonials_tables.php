<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gallery_images', function (Blueprint $table) {
            $table->id();
            $table->morphs('imageable'); // dipakai bersama oleh proyek dan katalog
            $table->string('path');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role')->nullable();
            $table->text('text');
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        $now = now();
        DB::table('testimonials')->insert([
            ['name' => 'Bapak Budi Wijaya', 'role' => 'Pemilik Rumah, BSD City', 'is_published' => true, 'created_at' => $now, 'updated_at' => $now,
             'text' => 'RAB sangat transparan sejak awal, tidak ada biaya siluman di tengah jalan. Renovasi rumah kami di BSD selesai tepat 3,5 bulan dengan finishing marmer yang sangat rapi.'],
            ['name' => 'Ibu Dewi Rahmawati', 'role' => 'Pemilik Hunian, Cilandak', 'is_published' => true, 'created_at' => $now, 'updated_at' => $now,
             'text' => 'Tim arsitek dan sipil SA Properti sangat komunikatif. Laporan progres mingguan selalu lengkap dengan foto, jadi kami tenang meski jarang memantau langsung.'],
            ['name' => 'Bapak Hendra Santoso', 'role' => 'Investor Properti, Serpong', 'is_published' => true, 'created_at' => $now, 'updated_at' => $now,
             'text' => 'Dari pengurusan PBG hingga pembangunan kost 18 kamar di Serpong berjalan mulus. Desain fasadnya modern dan langsung penuh terisi penyewa begitu serah terima.'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('gallery_images');
    }
};