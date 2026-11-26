<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $guarded = [];

    protected $casts = ['is_published' => 'boolean'];

    public function getInitialAttribute(): string
    {
        $words = collect(preg_split('/\s+/', trim($this->name)))
            ->reject(fn ($w) => in_array(mb_strtolower($w), ['bapak', 'ibu', 'pak', 'bu']))
            ->take(2);

        return $words->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))->implode('') ?: '?';
    }
}