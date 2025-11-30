<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $guarded = []; // Izinkan semua kolom diisi

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
