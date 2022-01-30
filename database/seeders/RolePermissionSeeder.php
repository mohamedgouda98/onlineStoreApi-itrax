<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create([
            'name' => 'admin',
        ]);
        $user = Role::create([
            'name' => 'user',
        ]);
        $supplier = Role::create([
            'name' => 'supplier',
        ]);

        $cProduct = Permission::create([
            'name' => 'c-product',
        ]);
        $uProduct = Permission::create([
            'name' => 'u-product',
        ]);
        $dProduct = Permission::create([
            'name' => 'd-product',
        ]);

        $admin->attachPermissions([
            $cProduct,
            $uProduct,
            $dProduct
        ]);

        $supplier->attachPermissions([
            $cProduct,
            $uProduct,
        ]);

        $user1 = User::find(1);
        $user2 = User::find(2);
        $user3 = User::find(3);

        $user1->attachRole($admin);
        $user2->attachRole($supplier);
        $user3->attachRole($user);


    }
}
