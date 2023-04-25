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

        Permission::create(['name' => 'delete any user']);
        Permission::create(['name' => 'delete any post']);
        Permission::create(['name' => 'delete any community']);
        Permission::create(['name' => 'delete any comment']);

        Permission::create(['name' => 'edit own post']);
        Permission::create(['name' => 'delete own post']);

        Permission::create(['name' => 'edit own community']);
        Permission::create(['name' => 'delete own community']);

        Permission::create(['name' => 'edit own comment']);
        Permission::create(['name' => 'delete own comment']);

        Role::create(['name' => 'user'])->givePermissionTo([
            'edit own post',
            'delete own post',
            'edit own community',
            'delete own community',
            'edit own comment',
            'delete own comment',
        ]);

        Role::create(['name' => 'moderator'])->givePermissionTo([
            'delete any post',
            'delete any community',
            'delete any comment',
        ]);
        Role::create(['name' => 'admin'])->givePermissionTo(Permission::all());
    }
}