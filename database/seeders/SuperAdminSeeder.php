<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        // Créer le rôle super-admin
        $role = Role::firstOrCreate([
            'name' => 'super-admin',
            'guard_name' => 'web'
        ]);

        // Créer le compte administrateur
        $user = User::firstOrCreate(
            [
                'email' => 'admin@school.com'
            ],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('Isma 78@@')
            ]
        );

        // Attribuer le rôle
        if (!$user->hasRole('super-admin')) {
            $user->assignRole($role);
        }
    }
}