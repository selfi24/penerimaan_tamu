<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tamu extends Model
{
    use HasFactory;
    
    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }


    protected $fillable = [
        'nama',
        'alamat',
        'opd_id',
        'keperluan',
        'webcamImage',
    ];
}
