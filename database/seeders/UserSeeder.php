<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create roles if they don't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $petugasRole = Role::firstOrCreate(['name' => 'petugas']);
        $peminjamRole = Role::firstOrCreate(['name' => 'peminjam']);

        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123123123'),
            'role_id' => 1, // admin
            'email_verified_at' => now()
        ]);
        $admin->assignRole($adminRole);

        $petugas = User::create([
            'name' => 'petugas',
            'email' => 'petugas@gmail.com',
            'password' => bcrypt('123123123'),
            'role_id' => 2, // petugas
            'email_verified_at' => now()
        ]);
        $petugas->assignRole($petugasRole);

        $peminjam1 = User::create([
            'name' => 'peminjam',
            'email' => 'peminjam@gmail.com',
            'password' => bcrypt('123123123'),
            'role_id' => 3,
            'email_verified_at' => now()
        ]);
        $peminjam1->assignRole($peminjamRole);

        $peminjam2 = User::create([
            'name' => 'musyahya',
            'email' => 'musyahya@gmail.com',
            'password' => bcrypt('123123123'),
            'role_id' => 3,
            'email_verified_at' => now()
        ]);
        $peminjam2->assignRole($peminjamRole);

        $peminjam3 = User::create([
            'name' => 'yahya',
            'email' => 'yahya@gmail.com',
            'password' => bcrypt('123123123'),
            'role_id' => 3,
            'email_verified_at' => now()
        ]);
        $peminjam3->assignRole($peminjamRole);
    }
}
