<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $fillable = ['nama', 'slug'];

    public function buku()
    {
        return $this->hasMany(Buku::class);
    }
    public function rak()
    {
        return $this->hasMany(Rak::class);
    }
}
