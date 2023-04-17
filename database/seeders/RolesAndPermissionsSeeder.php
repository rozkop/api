<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'delete user']);
        Permission::create(['name' => 'delete community']);
        Permission::create(['name' => 'delete post']);

        Role::create(['name' => 'moderator'])->givePermissionTo(['delete post', 'delete community']);
        Role::create(['name' => 'admin'])->givePermissionTo(Permission::all());
    }
}
