<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    // 'status' bilerek dışarıda: yalnızca admin forceFill ile günceller.
    protected $fillable = ['name', 'phone', 'email', 'date', 'time', 'note'];
    protected $casts = ['date' => 'date'];
}
