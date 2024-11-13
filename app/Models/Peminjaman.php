<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $fillable = [
        'users_id', 'buku_id', 'kode_pinjam', 'tanggal_pinjam',
        'tanggal_kembali', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    public function denda()
    {
        return $this->hasOne(Denda::class);
    }
}
