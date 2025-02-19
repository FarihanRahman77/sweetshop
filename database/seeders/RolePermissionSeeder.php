<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $roleSuperAdmin =   Role::create(['name' => 'Super Admin','guard_name'=>'web','deleted'=>'No','status'=>'Active']);
        $roleManager =      Role::create(['name' => 'Manager','guard_name'=>'web','deleted'=>'No','status'=>'Active']);
        $roleSalesMan =     Role::create(['name' => 'Sales Man','guard_name'=>'web','deleted'=>'No','status'=>'Active']);

        //Create Permissions
        $permissions = [

            'dashboard',
            'dashboard.view',

            'user',
            'user.create',
            'user.view',
            'user.edit',
            'user.store',
            'user.delete',
            'user.changePassword',

            'role',
            'role.create',
            'role.view',
            'role.edit',
            'role.store',
            'role.delete',

            'permission',
            'permission.create',
            'permission.view',
            'permission.edit',
            'permission.update',
            'permission.store',
            'permission.delete',

            'permissionToRole',
            'permissionToRole.create',
            'permissionToRole.view',
            'permissionToRole.store',
            'permissionToRole.delete',

            'Setting',

            'companySetting',
            'companySetting.view',
            'companySetting.edit',
            'companySetting.update',

            'categories',
            'categories.view',
            'categories.store',
            'categories.edit',
            'categories.update',
            'categories.delete',

            'brands',
            'brands.view',
            'brands.store',
            'brands.edit',
            'brands.update',
            'brands.delete',

            'units',
            'units.view',
            'units.store',
            'units.edit',
            'units.update',
            'units.delete',

            'warehouse',
            'warehouse.view',
            'warehouse.store',
            'warehouse.edit',
            'warehouse.update',
            'warehouse.delete',

            'products',
            'products.view',
            'products.store',
            'products.edit',
            'products.update',
            'products.delete',

            'purchase',
            'purchase.view',
            'purchase.add',
            'purchase.delete',

            'sale',
            'sale.view',
            'sale.add',
            'sale.delete',

            'damage',
            'damage.view',
            'damage.store',
            'damage.delete',

            'transport',
            'transport.view',
            'transport.store',
            'transport.edit',
            'transport.update',
            'transport.delete',
            
            'PaymentVoucher',
            'PaymentVoucher.view',
            'PaymentVoucher.store',
            'PaymentVoucher.edit',
            'PaymentVoucher.update',
            'PaymentVoucher.delete',

            'PaymentReceiveVoucher',
            'PaymentReceiveVoucher.view',
            'PaymentReceiveVoucher.store',
            'PaymentReceiveVoucher.edit',
            'PaymentReceiveVoucher.update',
            'PaymentReceiveVoucher.delete',

            'DiscountVoucher',
            'DiscountVoucher.view',
            'DiscountVoucher.store',
            'DiscountVoucher.edit',
            'DiscountVoucher.update',
            'DiscountVoucher.delete',
            

            'saleService',
            'saleService.view',
            'saleService.add',
            'saleService.edit',
            'saleService.statusComplete',
            'saleService.createOrderToWalkinSale',
        ];



        //Create Permissions
        $countLen = count($permissions);
        for ($i = 0; $i < $countLen; $i++) {
            $permission = Permission::create(['name' =>$permissions[$i],'deleted'=>'No','status'=>'Active']);
            $roleSuperAdmin->givePermissionTo($permission);
            $permission->assignRole($roleSuperAdmin);
        }
    }


    
}
