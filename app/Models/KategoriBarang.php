<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBarang extends Model
{
    use HasFactory;

    protected $table = 'kategori_barangs';
    protected $primaryKey = 'kategori_id';
    protected $fillable = [
        'nama_kategori',
        'deskripsi'
    ];

    public function barangs()
    {
        return $this->hasMany(Barang::class, 'kategori_id', 'kategori_id');
    }
}