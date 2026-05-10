<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::firstOrCreate(['name' => 'gerer-utilisateurs']);
        Permission::firstOrCreate(['name' => 'gerer-feedbacks']);

        
        // Admin : a tous les droits
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo(['gerer-utilisateurs', 'gerer-feedbacks']);

        // Modérateur : peut juste gérer les feedbacks
        $moderateurRole = Role::firstOrCreate(['name' => 'moderateur']);
        $moderateurRole->givePermissionTo('gerer-feedbacks');

        // Rôles simples
        Role::firstOrCreate(['name' => 'etudiant']);
        Role::firstOrCreate(['name' => 'entreprise']);

        $moderateur = User::firstOrCreate(
            ['email' => 'mod@stageflow.com'],
            [
                'prenom' => 'Ahmed',
                'nom' => 'Modérateur',
                'password' => Hash::make('password'),
            ]
        );
        $moderateur->assignRole('moderateur');

        foreach (User::all() as $user) {
            if ($user->email === 'mod@stageflow.com') continue;
            
            if ($user->etudiant()->exists()) {
                $user->assignRole('etudiant');
            } elseif ($user->entreprise()->exists()) {
                $user->assignRole('entreprise');
            } else {
                $user->assignRole('admin');
            }
        }
    }
}
