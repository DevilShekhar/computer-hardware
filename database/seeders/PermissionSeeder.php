<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'dashboard-view',

            //Users
            'user-create',
            'user-index',
            'user-edit',
            'user-destroy',

            //Roles
            'roles-create',
            'roles-index',
            'roles-edit',
            'roles-destroy',
        ];

        foreach($permissions as $permission){
            Permission::firstOrCreate([
                'name'=>$permission,
                'guard_name' => 'web',
            ]);
        }
    }
}
