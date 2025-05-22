<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $permissions = [
            [
                'name' => 'voir_approvisionnements',
                'display_name' => 'voir approvisionnements',
                'description' => 'Permission de voir les approvisionnements'
            ],
            [
                'name' => 'voir_produits',
                'display_name' => 'voir produits',
                'description' => 'Permission de voir les produits'
            ],
            [
                'name' => 'voir_categories',
                'display_name' => 'voir categories',
                'description' => 'Permission de voir les categories'
            ],
            [
                'name' => 'voir_matiere_premieres',
                'display_name' => 'voir matiere premieres',
                'description' => 'Permission de voir les matiere premieres'
            ],
            [
                'name' => 'voir_fournisseurs',
                'display_name' => 'voir fournisseurs',
                'description' => 'Permission de voir les fournisseurs'
            ],
            [
                'name' => 'voir_clients',
                'display_name' => 'voir clients',
                'description' => 'Permission de voir les clients'
            ],

        ];


        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission['name']], $permission);
        }
    }
}
