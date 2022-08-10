<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'order']);
        Permission::create(['name' => 'history']);
        Permission::create(['name' => 'summary']);
        Permission::create(['name' => 'users']);
        Permission::create(['name' => 'village']);
        Permission::create(['name' => 'database backup']);
        Permission::create(['name' => 'customer']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'customer']);
        $role1->givePermissionTo('customer');

        $role2 = Role::create(['name' => 'admin']);
        $role2->givePermissionTo('order');
        $role2->givePermissionTo('history');
        $role2->givePermissionTo('summary');
        $role2->givePermissionTo('users');
        $role2->givePermissionTo('village');
        $role2->givePermissionTo('database backup');

        $role3 = Role::create(['name' => 'Super-Admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $user = \App\Models\User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'kyawphyothukpt256@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $user->assignRole($role3);

        $user = \App\Models\User::factory()->create([
            'name' => 'Aung Kyaw Nyunt',
            'email' => 'aung@gmail.com',
            'password' => Hash::make("password"),
        ]);
        $user->assignRole($role2);
        $user = \App\Models\User::factory()->create([
            'name' => 'Ohmar Win',
            'email' => 'ohmar@gmail.com',
            'password' => Hash::make("password"),
        ]);
        $user->assignRole($role2);
        $user = \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'Chan Nyein Thu@gmail.com',
            'password' => Hash::make("password"),
        ]);
        $user->assignRole($role2);

        $user = \App\Models\User::factory()->create([
            'name' => 'Customer',
            'email' => 'customer@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $user->assignRole($role1);
    }
}
