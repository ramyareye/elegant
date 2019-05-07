<?php

use \App\Entities\User;

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Entities\Role::class)->create([
            'name' => 'Admin',
            'guard_name' => 'api'
        ]);

        factory(\App\Entities\Role::class)->create([
            'name' => 'User',
            'guard_name' => 'api'
        ]);

        factory(\App\Entities\User::class)->create([
            'name' => 'Some User',
            'email' => 'user@site.com',
            'password' => bcrypt('secrets')
        ]);

        $user = User::where('email', 'user@site.com')->first();

        $user->assignRole('Admin');
    }
}
