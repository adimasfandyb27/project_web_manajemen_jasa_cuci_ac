<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]
            ->forgetCachedPermissions();

        $permissions = [

            'dashboard.view',

            'customers.view',
            'customers.create',
            'customers.edit',
            'customers.delete',

            'technicians.view',
            'technicians.create',
            'technicians.edit',
            'technicians.delete',

            'services.view',
            'services.create',
            'services.edit',
            'services.delete',

            'service-orders.view',
            'service-orders.create',
            'service-orders.edit',
            'service-orders.delete',

            'invoices.view',
            'invoices.create',
            'invoices.edit',
            'invoices.delete',

            'reports.view',

            'users.view',
            'users.create',
            'users.edit',
            'users.delete',

            'roles.view',
            'roles.create',
            'roles.edit',
            'roles.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | OWNER
        |--------------------------------------------------------------------------
        */

        $owner = Role::firstOrCreate([
            'name' => 'Owner'
        ]);

        $owner->givePermissionTo(Permission::all());

        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */

        $admin = Role::firstOrCreate([
            'name' => 'Admin'
        ]);

        $admin->givePermissionTo([
            'dashboard.view',

            'customers.view',
            'customers.create',
            'customers.edit',
            'customers.delete',

            'technicians.view',
            'technicians.create',
            'technicians.edit',
            'technicians.delete',

            'services.view',
            'services.create',
            'services.edit',
            'services.delete',

            'service-orders.view',
            'service-orders.create',
            'service-orders.edit',
            'service-orders.delete',

            'invoices.view',
            'invoices.create',
            'invoices.edit',
            'invoices.delete',

            'reports.view',
        ]);

        /*
        |--------------------------------------------------------------------------
        | CUSTOMER SERVICE
        |--------------------------------------------------------------------------
        */

        $cs = Role::firstOrCreate([
            'name' => 'Customer Service'
        ]);

        $cs->givePermissionTo([
            'dashboard.view',

            'customers.view',
            'customers.create',
            'customers.edit',

            'service-orders.view',
            'service-orders.create',
            'service-orders.edit',

            'invoices.view',
            'invoices.create',
        ]);

        /*
        |--------------------------------------------------------------------------
        | TEKNISI
        |--------------------------------------------------------------------------
        */

        $teknisi = Role::firstOrCreate([
            'name' => 'Teknisi'
        ]);

        $teknisi->givePermissionTo([
            'dashboard.view',
            'service-orders.view',
        ]);
    }
}
