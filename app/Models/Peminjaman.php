<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'peminjam_id');
    }

    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class, 'buku_id', 'id');
    }

    public function denda(): HasOne
    {
        return $this->hasOne(Denda::class, 'peminjaman_id');
    }

    public function bukus(): BelongsToMany
    {
        return $this->belongsToMany(Buku::class, 'detail_peminjaman', 'peminjaman_id', 'buku_id');
    }

    public function detailPeminjaman(): HasMany
    {
        return $this->hasMany(DetailPeminjaman::class, 'peminjaman_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($peminjaman) {
            $peminjaman->denda()->delete();
            $peminjaman->detailPeminjaman()->delete();
        });
    }
}

