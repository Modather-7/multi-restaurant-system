<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'product.view',
            'product.create',
            'product.update',
            'product.delete',
            'product.trash',
            'product.restore',
            'product.forceDelete',

            'category.view',
            'category.create',
            'category.update',
            'category.delete',
            'category.trash',
            'category.restore',
            'category.forceDelete',

            'order.view',
            'order.create',
            'order.update',
            'order.delete',
            'order.change-status',

            'customer.view',
            'customer.create',
            'customer.update',
            'customer.delete',

            'admin.view',
            'admin.create',
            'admin.update',
            'admin.delete',

            'role.view',
            'role.create',
            'role.update',
            'role.delete',

            'permission.view',
            'permission.create',
            'permission.update',
            'permission.delete',

            'restaurant.view',
            'restaurant.update',

            'report.view',
            'notification.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'admin',
            ]);
        }
    }
}
