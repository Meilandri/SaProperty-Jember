<?php

namespace App\Models;

use App\Support\SiteData;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    protected $casts = [
        'highlights'   => 'array',
        'completed_at' => 'date',
        'is_published' => 'boolean',
    ];

    public function scopePublished($q)
    {
        return $q->where('is_published', true);
    }

    public function getCategoryLabelAttribute(): string
    {
        return SiteData::projectCategories()[$this->category] ?? $this->category;
    }
}