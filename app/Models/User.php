<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'users_id');
    }


protected static function booted()
{
    // Automatically set the default role_id on user creation
    static::creating(function ($user) {
        if (!$user->role_id) {
            $defaultRole = \Spatie\Permission\Models\Role::where('name', 'peminjam')->first();

            // Ensure the default role exists in your database
            if ($defaultRole) {
                $user->role_id = $defaultRole->id; // Assign role_id from the database
            }
        }
    });

    // Assign Spatie role after the user is created
    static::created(function ($user) {
        $role = \Spatie\Permission\Models\Role::find($user->role_id);

        // Assign the role using Spatie's method
        if ($role) {
            $user->assignRole($role->name);
        }
    });
}

}
