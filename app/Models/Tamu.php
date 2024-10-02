<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tamu extends Model
{
    use HasFactory;
    
    public function opd()
    {
        return $this->belongsTo(Opd::class, 'opd_id');
    }


    protected $fillable = [
        'nama',
        'alamat',
        'dinas',
        'opd_id',
        'keperluan',
        'webcamImage',
    ];
}
