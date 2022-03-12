<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        Schema::enableForeignKeyConstraints();

        $superRole = Role::updateOrCreate(['name' => 'superAdmin','guard_name' => 'web']);
        $admin = Admin::where('email','admin@gmail.com')->first();

        if(!$admin){
            $admin = Admin::updateOrCreate([ 'username'=>'Admin', 'email'=>'admin@gmail.com'],[
                'name'=>'Admin',
                'username'=>'Admin',
                'email'=>'admin@gmail.com',
                'password'=>123456,
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);
        }

        if($superRole)
            $admin->syncRoles('superAdmin');


        /**
         *  get database tables
         */
        $dbTables = adminDbTablesPermissions();

        /**
         *  give permission on every database table
         */
        foreach ($dbTables as $table){

            $readPermission = Permission::create(['name' => 'read '.$table,'guard_name' => 'web']);
            $createPermission = Permission::create(['name' => 'create '.$table,'guard_name' => 'web']);
            $updatePermission = Permission::create(['name' => 'update '.$table,'guard_name' => 'web']);
            $deletePermission = Permission::create(['name' => 'delete '.$table,'guard_name' => 'web']);
            /**
             * assign permission to role
             */
            $superRole->givePermissionTo($readPermission,$createPermission, $updatePermission, $deletePermission);
            /**
             * assign permission to user
             */
            if($admin)
                $admin->givePermissionTo($readPermission,$createPermission,$updatePermission,$deletePermission);
        }

    }
}
