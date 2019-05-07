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

            'list-managers',
            'create-managers',
            'update-managers',
            'delete-managers',

            'list-categories',
            'create-categories',
            'update-categories',
            'delete-categories',

            'list-posts',
            'create-posts',
            'update-posts',
            'delete-posts',

            'list-comments',
            'create-comments',
            'update-comments',
            'delete-comments',

            'list-pages',
            'create-pages',
            'update-pages',
            'delete-pages',

            'list-profiles',
            'create-profiles',
            'update-profiles',
            'delete-profiles',

            'list-slides',
            'create-slides',
            'update-slides',
            'delete-slides',

            'list-campaigns',
            'create-campaigns',
            'update-campaigns',
            'delete-campaigns',

            'list-groups',
            'create-groups',
            'update-groups',
            'delete-groups',

            'list-locations',
            'create-locations',
            'update-locations',
            'delete-locations',

            'list-updates',
            'create-updates',
            'update-updates',
            'delete-updates',

            'list-donations',
            'create-donations',
            'update-donations',
            'delete-donations'
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
