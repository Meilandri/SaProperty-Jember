<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('type', 20); // catalog | project
            $table->string('key');
            $table->string('name');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['type', 'key']);
        });

        $defaults = [
            'catalog' => [
                'bangun'   => 'Pembangunan Rumah',
                'renovasi' => 'Renovasi Properti',
                'tanah'    => 'Jual Beli Tanah',
                'surat'    => 'Pengurusan Surat & PBG',
            ],
            'project' => [
                'rumah'     => 'Pembangunan Rumah',
                'renovasi'  => 'Renovasi Properti',
                'komersial' => 'Komersial & Kost',
                'pbg'       => 'Jual Beli Tanah & PBG',
            ],
        ];

        foreach ($defaults as $type => $rows) {
            $i = 1;
            foreach ($rows as $key => $name) {
                DB::table('categories')->insert([
                    'type' => $type, 'key' => $key, 'name' => $name,
                    'sort_order' => $i++, 'created_at' => now(), 'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};