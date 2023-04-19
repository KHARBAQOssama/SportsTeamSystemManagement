<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesAndPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $admin = Role::create(['name' => 'admin']);
        $subAdmin = Role::create(['name' => 'sub-admin']);
        $teamMember = Role::create(['name' => 'team_member']);
        $fan = Role::create(['name' => 'fan']);

        // Create permissions
        $permissions = [
            'create',
            'read',
            'update',
            'delete',
            'view',
            'edit',
            'approve',
            'publish',
            'comment',
            'like',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign permissions to each role

        $adminPermissionsIds = Permission::whereIn('name', [
            'create',
            'read',
            'approve',
            'delete',
            'subadmin',
        ])->pluck('id');

        $admin->permissions()->sync($adminPermissionsIds);

        // For sub-admin role
        $subAdminPermissionIds = Permission::whereIn('name', [
            'create',
            'read',
            'update',
            'delete',
            'view',
            'edit',
        ])->pluck('id');

        $subAdmin->permissions()->sync($subAdminPermissionIds);

        // For team-member role
        $teamMemberPermissionIds = Permission::whereIn('name', [
            'publish',
        ])->pluck('id');

        $teamMember->permissions()->sync($teamMemberPermissionIds);

        // For fan role
        $fanPermissionIds = Permission::whereIn('name', [
            'comment',
            'like',
        ])->pluck('id');

        $fan->permissions()->sync($fanPermissionIds);
    }
}
