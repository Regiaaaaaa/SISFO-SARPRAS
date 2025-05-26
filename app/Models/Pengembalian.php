<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    protected $table = 'pengembalians';
    protected $primaryKey = 'pengembalian_id';
    protected $fillable = [
        'peminjaman_id',  
        'tanggal_kembali', 
        'deskripsi_pengembalian',
        'status',
        'bukti_foto'
    ];

    public function user() 
    {
        return $this->belongsTo(User::class,'user_id');
    }

public function peminjaman() {
    return $this->belongsTo(Peminjaman::class,'peminjaman_id', 'peminjaman_id');
}

}

