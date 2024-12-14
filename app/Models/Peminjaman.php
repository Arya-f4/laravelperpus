<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');  // assuming 'buku_id' is the foreign key
    }

    public function denda()
    {
        return $this->hasOne(Denda::class);
    }

    public function bukus()
    {
        return $this->belongsToMany(Buku::class, 'detail_peminjaman', 'peminjaman_id', 'buku_id');
    }
}
