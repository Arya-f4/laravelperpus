<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    protected $table = 'rak';
    protected $fillable = ['rak', 'baris', 'slug', 'kategori_id'];

    public function buku()
    {
        return $this->hasMany(Buku::class);
    }
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
