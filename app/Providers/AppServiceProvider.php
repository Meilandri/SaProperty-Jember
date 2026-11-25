<?php

namespace App\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        AliasLoader::getInstance()->alias('Setting', \App\Models\Setting::class);
    }

    public function boot(): void
    {
        //
    }
}