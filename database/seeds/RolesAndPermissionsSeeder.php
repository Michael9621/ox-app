<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create permissions
        Permission::create(['name' => 'post-photo']);
        Permission::create(['name' => 'view-photo']);
      
        
        $role = Role::create(['name' => 'Sender'])->givePermissionTo(['post-photo','view-photo']);

        $role2 = Role::create(['name' => 'Receiver']);

    
    }
}
