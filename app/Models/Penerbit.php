<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penerbit extends Model
{
    protected $table = 'penerbit';
    protected $fillable = ['nama', 'slug'];

    public function buku()
    {
        return $this->hasMany(Buku::class);
    }
}
