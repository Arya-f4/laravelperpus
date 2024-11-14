<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    public function boot()
    {
        $this->registerPolicies();

        Gate::define('manage-books', function (User $user) {
            return in_array($user->role, ['admin', 'petugas']);
        });

        Gate::define('manage-peminjaman', function (User $user) {
            return in_array($user->role, ['admin', 'petugas']);
        });

        Gate::define('borrow-books', function (User $user) {
            return $user->role === 'peminjaman';
        });
    }
}
