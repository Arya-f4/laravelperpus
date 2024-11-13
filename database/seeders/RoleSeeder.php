<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $petugasRole = Role::create(['name' => 'petugas']);
        $userRole = Role::create(['name' => 'user']);

        // Create permissions
        $permissions = [
            'view books',
            'create books',
            'edit books',
            'delete books',
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
            'view peminjaman',
            'create peminjaman',
            'edit peminjaman',
            'delete peminjaman',
            'manage users',
            'manage roles',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign permissions to roles
        $adminRole->givePermissionTo(Permission::all());

        $petugasRole->givePermissionTo([
            'view books',
            'create books',
            'edit books',
            'view categories',
            'create categories',
            'edit categories',
            'view peminjaman',
            'create peminjaman',
            'edit peminjaman',
        ]);

        $userRole->givePermissionTo([
            'view books',
            'view categories',
            'view peminjaman',
            'create peminjaman',
        ]);
    }
}
