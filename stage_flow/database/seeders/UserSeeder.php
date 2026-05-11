<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        $admin = User::firstOrCreate(
            ['email' => 'admin@stageflow.ma'],
            [
                'prenom' => 'Admin',
                'nom' => 'StageFlow',
                'password' => Hash::make('admin123'),
            ]
        );

        $admin->assignRole($adminRole);
        $this->command->info('Compte Admin créé avec succès : admin@stageflow.ma / admin123');
    }
}
