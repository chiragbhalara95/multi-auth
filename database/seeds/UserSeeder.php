<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $allUserRole = User::ALL_USER_ROLE;
        $allModules  = ['user'];
        $AllAction   = ['create', 'read', 'update', 'delete'];

        foreach ($allModules as $module) {
            foreach ($AllAction as $permissionValue) {
                Permission::firstOrCreate([
                    'name'         => $module . '-' . $permissionValue,
                    'slug'         => ucfirst($permissionValue) . ' ' . ucfirst($module),
                ]);
            }
        }

        $allPermission = Permission::get();
        foreach ($allUserRole as $roleName) {
            $roleObj = Role::firstOrCreate([
                'name' => $roleName,
                'slug' => ucwords(str_replace('_', ' ', $roleName)),
            ]);
            foreach ($allPermission as $permissionDetail) {
                $roleObj->permissions()->attach($permissionDetail);
            }
        }

        $users = [
            [
                'name'     => 'superAdmin',
                'email'    => 'superAdmin@gmail.com',
                'password' => '12345678',
                'role'     => 'superAdmin'
            ],
            [
                'name'     => 'admin',
                'email'    => 'admin@gmail.com',
                'password' => '12345678',
                'role'     => 'admin'
            ]
        ];

        foreach ($users as $userDetail) {
            $user = User::create([
                'name'     => ucwords(str_replace('_', ' ', $userDetail['name'])),
                'email'    => $userDetail['email'],
                'password' => bcrypt($userDetail['password'])
            ]);
            $userRole = Role::where('slug', $userDetail['role'])->first();
            $user->roles()->attach($userRole);
            if ($userDetail['role'] != 'superAdmin') {
                foreach ($allPermission as $permissionDetail) {
                    $user->permissions()->attach($permissionDetail);
                }
            }
        }

    }

}
