<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]
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

            'ac-brands.view',
            'ac-brands.create',
            'ac-brands.edit',
            'ac-brands.delete',

            'ac-types.view',
            'ac-types.create',
            'ac-types.edit',
            'ac-types.delete',

            'ac-capacities.view',
            'ac-capacities.create',
            'ac-capacities.edit',
            'ac-capacities.delete',

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

            'schedules.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | OWNER
        |--------------------------------------------------------------------------
        */

        $owner = Role::firstOrCreate([
            'name' => 'Owner',
        ]);

        $owner->givePermissionTo(Permission::all());

        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */

        $admin = Role::firstOrCreate([
            'name' => 'Admin',
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

            'ac-brands.view',
            'ac-brands.create',
            'ac-brands.edit',
            'ac-brands.delete',

            'ac-types.view',
            'ac-types.create',
            'ac-types.edit',
            'ac-types.delete',

            'ac-capacities.view',
            'ac-capacities.create',
            'ac-capacities.edit',
            'ac-capacities.delete',

            'service-orders.view',
            'service-orders.create',
            'service-orders.edit',
            'service-orders.delete',

            'invoices.view',
            'invoices.create',
            'invoices.edit',
            'invoices.delete',

            'reports.view',

            'schedules.view',
        ]);

        /*
        |--------------------------------------------------------------------------
        | CUSTOMER SERVICE
        |--------------------------------------------------------------------------
        */

        $cs = Role::firstOrCreate([
            'name' => 'Customer Service',
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

            'schedules.view',
        ]);

        /*
        |--------------------------------------------------------------------------
        | TEKNISI
        |--------------------------------------------------------------------------
        */

        $teknisi = Role::firstOrCreate([
            'name' => 'Teknisi',
        ]);

        $teknisi->givePermissionTo([
            'dashboard.view',
            'service-orders.view',
        ]);

        /*
        |--------------------------------------------------------------------------
        | CUSTOMER
        |--------------------------------------------------------------------------
        */

        Role::firstOrCreate([
            'name' => 'Customer',
        ]);
    }
}
