<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Factory;
class Buku extends Model
{

    protected $table = 'buku';
    protected $fillable = [
        'judul', 'slug', 'penerbit_id', 'kategori_id',
        'rak_id', 'stok', 'sampul', 'penulis'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function penerbit()
    {
        return $this->belongsTo(Penerbit::class);
    }

    public function rak()
    {
        return $this->belongsTo(Rak::class);
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
