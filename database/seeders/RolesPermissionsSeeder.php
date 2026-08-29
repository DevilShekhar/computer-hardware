<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = Role::query()->where('name', 'SuperAdmin')
            ->where('guard_name', 'web')
            ->first();

        if ($superAdmin) {
            $superAdmin->syncPermissions(
                Permission::where('guard_name', 'web')->get()
            );
        }
    }
}
