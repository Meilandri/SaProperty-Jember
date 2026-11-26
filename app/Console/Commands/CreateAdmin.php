<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    protected $signature = 'admin:create {email} {name=Admin}';

    protected $description = 'Buat akun admin baru, atau reset password akun yang sudah ada';

    public function handle(): int
    {
        $password = $this->secret('Password (minimal 8 karakter, ketikan tidak terlihat)');

        if (strlen((string) $password) < 8) {
            $this->error('Password minimal 8 karakter.');
            return self::FAILURE;
        }

        User::updateOrCreate(
            ['email' => $this->argument('email')],
            ['name' => $this->argument('name'), 'password' => Hash::make($password)]
        );

        $this->info('Akun admin siap: ' . $this->argument('email'));
        return self::SUCCESS;
    }
}