<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@saproperti.com'],
            ['name' => 'Admin SA Properti', 'password' => '12345678']
        );
    }
}