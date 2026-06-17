<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $guarded = [];
    protected $casts = ['durum' => 'boolean'];

    public function scopeActive($q)
    {
        return $q->where('durum', true);
    }
}
