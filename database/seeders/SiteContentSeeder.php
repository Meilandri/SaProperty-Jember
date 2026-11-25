<?php

namespace Database\Seeders;

use App\Models\CatalogItem;
use App\Models\Project;
use App\Support\SiteData;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class SiteContentSeeder extends Seeder
{
    public function run(): void
    {
        foreach (SiteData::catalog() as $i) {
            CatalogItem::updateOrCreate(['slug' => $i['slug']], Arr::except($i, ['slug']));
        }

        foreach (SiteData::projects() as $i) {
            $i['completed_at'] = $i['date'];
            Project::updateOrCreate(
                ['slug' => $i['slug']],
                Arr::except($i, ['slug', 'date', 'category_label'])
            );
        }
    }
}