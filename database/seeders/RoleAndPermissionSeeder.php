<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Permissions\Permission as Permissions;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => Permissions::LIST_USERS]);
        Permission::create(['name' => Permissions::CREATE_USERS]);
        Permission::create(['name' => Permissions::EDIT_USERS]);
        Permission::create(['name' => Permissions::DELETE_USERS]);

        Permission::create(['name' => Permissions::LIST_PROJECTS]);
        Permission::create(['name' => Permissions::CREATE_PROJECTS]);
        Permission::create(['name' => Permissions::EDIT_PROJECTS]);
        Permission::create(['name' => Permissions::DELETE_PROJECTS]);
        Permission::create(['name' => Permissions::ADD_TIME_TO_PROJECTS]);

        Permission::create(['name' => Permissions::LIST_REQUESTS]);
        Permission::create(['name' => Permissions::CREATE_REQUESTS]);
        Permission::create(['name' => Permissions::EDIT_REQUESTS]);
        Permission::create(['name' => Permissions::DELETE_REQUESTS]);
        Permission::create(['name' => Permissions::CHANGE_STATUS_REQUESTS]);

        $adminRole = Role::create(['name' => 'Admin']);
        $employeeRole = Role::create(['name' => 'Employee']);
        $customerRole = Role::create(['name' => 'Customer']);

        $adminRole->givePermissionTo([
            Permissions::LIST_USERS,
            Permissions::CREATE_USERS,
            Permissions::EDIT_USERS,
            Permissions::DELETE_USERS,
            Permissions::LIST_PROJECTS,
            Permissions::CREATE_PROJECTS,
            Permissions::EDIT_PROJECTS,
            Permissions::DELETE_PROJECTS,
            Permissions::LIST_REQUESTS,
            Permissions::CREATE_REQUESTS,
            Permissions::EDIT_REQUESTS,
            Permissions::DELETE_REQUESTS,
            Permissions::CHANGE_STATUS_REQUESTS
        ]);

        $employeeRole->givePermissionTo([
            Permissions::LIST_PROJECTS,
            Permissions::LIST_REQUESTS,
            Permissions::ADD_TIME_TO_PROJECTS,
            Permissions::CHANGE_STATUS_REQUESTS
        ]);

        $customerRole->givePermissionTo([
            Permissions::LIST_PROJECTS,
            Permissions::LIST_REQUESTS,
            Permissions::CREATE_REQUESTS,
            Permissions::EDIT_REQUESTS
        ]);
    }
}
