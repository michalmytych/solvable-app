<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            'student' => [
                'users.view',
                'tests.view',
                'posts.view',
                'groups.view',
                'courses.view',
                'problems.view',
                'code_languages.view',
                'solutions.create,view',
                'executions.create,view',
            ],
            'teacher' => [
                'posts.*',
                'tests.*',
                'groups.*',
                'courses.*',
                'problems.*',
                'users.view',
                'code_languages.view',
                'solutions.create,view',
                'executions.create,view',
            ],
            'admin' => [
                'users.*',
                'roles.*',
                'posts.*',
                'tests.*',
                'groups.*',
                'courses.*',
                'problems.*',
                'solutions.*',
                'executions.*',
                'permissions.*',
                'code_languages.*',
            ]
        ];

        foreach ($roles as $roleName => $permissions) {
            $role = Role::create([
                'name' => $roleName,
                'guard_name' => 'api'
            ]);

            foreach ($permissions as $permission) {
                $role->givePermissionTo($permission);
            }
        }
    }
}
