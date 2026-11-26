<?php

namespace App\Models;

use App\Support\SiteData;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\HasGallery;

class CatalogItem extends Model
{
    use HasGallery;
    protected $guarded = [];

    protected $casts = [
        'features'     => 'array',
        'specs'        => 'array',
        'location'     => 'array',
        'price'        => 'float',
        'is_published' => 'boolean',
    ];

    public function scopePublished($q)
    {
        return $q->where('is_published', true);
    }

    public function getCategoryLabelAttribute(): string
    {
        return SiteData::catalogCategories()[$this->category] ?? $this->category;
    }
}