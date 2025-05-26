<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barangs';
    protected $primaryKey = 'barang_id';
    protected $fillable = [
        'kategori_id',
        'nama_barang',
        'stok',
        'code_barang',
        'merek',
        'kondisi_barang',
        'foto_barang'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'kategori_id', 'kategori_id');
    }
}