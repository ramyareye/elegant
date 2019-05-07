<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$permissions = [
    		'dashboard',
            'file-manager',

    		'list-roles',
            'update-roles',

    		'list-permissions',
    		'create-permissions',
    		'update-permissions',
    		'delete-permissions',

            'list-users',
            'create-users',
    		'update-users',
    		'delete-users',

            'list-admins',
            'create-admins',
            'update-admins',
            'delete-admins',

            'list-supports',
            'create-supports',
            'update-supports',
            'delete-supports',

            'list-categories',
            'create-categories',
            'update-categories',
            'delete-categories',

            'list-posts',
            'create-posts',
            'update-posts',
            'delete-posts',

            'list-pages',
            'create-pages',
            'update-pages',
            'delete-pages'
    	];

    	foreach ($permissions as $permission) {
    		factory(\App\Entities\Permission::class)->create([
                'name' => $permission,
                'guard_name' => 'api'
            ]);
    	}

        $role = \App\Entities\Role::where('name', 'Admin')->first();

        $permissions = \App\Entities\Permission::all()->pluck('uuid');

        $role->syncpermissions($permissions);
    }
}
