<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\UserHasRoles;
use Spatie\Permission\PermissionRegistrar;

class RolesandPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

            // notes permissions
       Permission::firstOrCreate(['name' => 'view_any_permissions']);
       Permission::firstOrCreate(['name' => 'view_permissions']);
       Permission::firstOrCreate(['name' => 'create_permissions']);
       Permission::firstOrCreate(['name' => 'update_permissions']);
       Permission::firstOrCreate(['name' => 'delete_permissions']);
     
         // notes permissions
       Permission::firstOrCreate(['name' => 'view_any_notes']);
       Permission::firstOrCreate(['name' => 'view_notes']);
       Permission::firstOrCreate(['name' => 'create_notes']);
       Permission::firstOrCreate(['name' => 'update_notes']);
       Permission::firstOrCreate(['name' => 'delete_notes']);

        // user permissions
       Permission::firstOrCreate(['name' => 'view_any_users']);
       Permission::firstOrCreate(['name' => 'view_users']);
       Permission::firstOrCreate(['name' => 'create_users']);
       Permission::firstOrCreate(['name' => 'update_users']);
       Permission::firstOrCreate(['name' => 'delete_users']);

       // role permissions
       Permission::firstOrCreate(['name' => 'view_any_roles']);
       Permission::firstOrCreate(['name' => 'view_roles']);
       Permission::firstOrCreate(['name' => 'create_roles']);
       Permission::firstOrCreate(['name' => 'update_roles']);
       Permission::firstOrCreate(['name' => 'delete_roles']);

          // Eleve permissions
       Permission::firstOrCreate(['name' => 'view_any_eleves']);
       Permission::firstOrCreate(['name' => 'view_eleves']);
       Permission::firstOrCreate(['name' => 'create_eleves']);
       Permission::firstOrCreate(['name' => 'update_eleves']);
       Permission::firstOrCreate(['name' => 'delete_eleves']);

        // Eleve permissions
       Permission::firstOrCreate(['name' => 'view_any_classes']);
       Permission::firstOrCreate(['name' => 'view_classes']);
       Permission::firstOrCreate(['name' => 'create_classes']);
       Permission::firstOrCreate(['name' => 'update_classes']);
       Permission::firstOrCreate(['name' => 'delete_classes']);

       Permission::firstOrCreate(['name' => 'view_any_niveaux']);
       Permission::firstOrCreate(['name' => 'view_niveaux']);
       Permission::firstOrCreate(['name' => 'create_niveaux']);
       Permission::firstOrCreate(['name' => 'update_niveaux']);
       Permission::firstOrCreate(['name' => 'delete_niveaux']);

       Permission::firstOrCreate(['name' => 'view_any_bulletins']);
       Permission::firstOrCreate(['name' => 'view_bulletins']);
       Permission::firstOrCreate(['name' => 'create_bulletins']);
       Permission::firstOrCreate(['name' => 'update_bulletins']);
       Permission::firstOrCreate(['name' => 'delete_bulletins']);

       Permission::firstOrCreate(['name' => 'view_any_charts']);
       Permission::firstOrCreate(['name' => 'view_charts']);
       Permission::firstOrCreate(['name' => 'create_charts']);
       Permission::firstOrCreate(['name' => 'update_charts']);
       Permission::firstOrCreate(['name' => 'delete_charts']);

       Permission::firstOrCreate(['name' => 'view_any_annee_scolaire']);
       Permission::firstOrCreate(['name' => 'view_annee_scolaire']);
       Permission::firstOrCreate(['name' => 'create_annee_scolaire']);
       Permission::firstOrCreate(['name' => 'update_annee_scolaire']);
       Permission::firstOrCreate(['name' => 'delete_annee_scolaire']);

       Permission::firstOrCreate(['name' => 'view_any_paiements']);
       Permission::firstOrCreate(['name' => 'view_paiements']);
       Permission::firstOrCreate(['name' => 'create_paiements']);
       Permission::firstOrCreate(['name' => 'update_paiements']);
       Permission::firstOrCreate(['name' => 'delete_paiements']);

       Permission::firstOrCreate(['name' => 'view_any_matieres']);
       Permission::firstOrCreate(['name' => 'view_matieres']);
       Permission::firstOrCreate(['name' => 'create_matieres']);
       Permission::firstOrCreate(['name' => 'update_matieres']);
       Permission::firstOrCreate(['name' => 'delete_matieres']);

       Permission::firstOrCreate(['name' => 'view_any_inscriptions']);
       Permission::firstOrCreate(['name' => 'view_inscriptions']);
       Permission::firstOrCreate(['name' => 'create_inscriptions']);
       Permission::firstOrCreate(['name' => 'update_inscriptions']);
       Permission::firstOrCreate(['name' => 'delete_inscriptions']);
       Permission::firstOrCreate(['name' => 'scolarite_inscriptions']);
       Permission::firstOrCreate(['name' => 'detail_inscriptions']);

       Permission::firstOrCreate(['name' => 'view_any_contacts']);
       Permission::firstOrCreate(['name' => 'view_contacts']);
       Permission::firstOrCreate(['name' => 'create_contacts']);
       Permission::firstOrCreate(['name' => 'update_contacts']);
       Permission::firstOrCreate(['name' => 'delete_contacts']);

       Permission::firstOrCreate(['name' => 'view_any_etablissements']);
       Permission::firstOrCreate(['name' => 'view_etablissements']);
       Permission::firstOrCreate(['name' => 'create_etablissements']);
       Permission::firstOrCreate(['name' => 'update_etablissements']);
       Permission::firstOrCreate(['name' => 'delete_etablissements']);
    
    
       app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        // create roles and assign existing permissions

       Role::firstOrCreate(['name' => 'super-admin'])->givePermissionTo([
            'view_any_users',
            'view_users',
            'create_users',
            'update_users',
            'delete_users',
            'view_any_roles',
            'view_roles',
            'create_roles',
            'update_roles',
            'delete_roles',
            'view_any_notes',
            'view_notes',
            'create_notes',
            'update_notes',
            'delete_notes',
            'view_any_permissions',
            'view_permissions',
            'create_permissions',
            'update_permissions',
            'delete_permissions',  
            'view_any_eleves',
            'view_eleves',
            'create_eleves',
            'update_eleves',
            'delete_eleves',
            'view_any_classes',
            'view_classes',
            'create_classes',
            'update_classes',
            'delete_classes',
            'view_any_niveaux',
            'view_niveaux',
            'create_niveaux',
            'update_niveaux',
            'delete_niveaux',
            'view_any_bulletins',
            'view_bulletins',
            'create_bulletins',
            'update_bulletins',
            'delete_bulletins',
            'view_any_charts',
            'view_charts',
            'create_charts',
            'update_charts',
            'delete_charts',
            'view_any_annee_scolaire',
            'view_annee_scolaire',
            'create_annee_scolaire',
            'update_annee_scolaire',
            'delete_annee_scolaire',
            'view_any_paiements',
            'view_paiements',
            'create_paiements',
            'update_paiements',
            'delete_paiements',
            'view_any_matieres',
            'view_matieres',
            'create_matieres',
            'update_matieres',
            'delete_matieres',
            'view_any_inscriptions',
            'view_inscriptions',
            'create_inscriptions',
            'update_inscriptions',
            'delete_inscriptions',
            'scolarite_inscriptions',
            'detail_inscriptions',
            'view_any_contacts',
            'view_contacts',
            'create_contacts',
            'update_contacts',
            'delete_contacts',
            'view_any_etablissements',
            'view_etablissements',
            'create_etablissements',
            'update_etablissements',
            'delete_etablissements',

            ]);
    }
}
