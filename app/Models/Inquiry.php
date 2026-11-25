<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $fillable = ['name', 'phone', 'email', 'service', 'message', 'read_at'];

    protected $casts = ['read_at' => 'datetime'];

    // Link WhatsApp dari nomor telepon (0812... menjadi 62812...)
    public function getWaLinkAttribute(): string
    {
        $d = preg_replace('/\D/', '', $this->phone);
        if (str_starts_with($d, '0')) {
            $d = '62' . substr($d, 1);
        }
        return 'https://wa.me/' . $d;
    }
}