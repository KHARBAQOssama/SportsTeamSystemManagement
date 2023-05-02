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
            'Create User',
            'View Users',
            'Update User',
            'Delete User',
            'Update Profile',
            'Add Blog',
            'Update Blog',
            'Delete Blog',
            'View Blogs',
            'Add Product',
            'Update Product',
            'Delete Product',
            'view Products',
            'Add Tournament',
            'Update Tournament',
            'Delete Tournaments',
            'View Tournaments',
            'Add Branch',
            'View Branches',
            'Update Branch',
            'Delete Branch',
            'Assign Permissions',
            'Delete Comment',
            'Add Comment',
            'Add To Cart',
            'Remove From Cart',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign permissions to each role

        $adminPermissionsIds = Permission::whereIn('name', [
            'Create User',
            'View Users',
            'Update User',
            'Delete User',
            'Update Profile',
            'Add Blog',
            'Update Blog',
            'Delete Blog',
            'View Blogs',
            'Add Product',
            'Update Product',
            'Delete Product',
            'view Products',
            'Update Tournament',
            'Delete Tournaments',
            'View Tournaments',
            'Add Branch',
            'View Branches',
            'Update Branch',
            'Delete Branch',
            'Assign Permissions',
            'Delete Comment',
            'Add Comment',
            'Add To Cart',
            'Remove From Cart',
        ])->pluck('id');

        $admin->permissions()->sync($adminPermissionsIds);

        // For sub-admin role
        $subAdminPermissionIds = Permission::whereIn('name', [
            'Create User',
            'View Users',
            'Update User',
            'Delete User',
            'Update Profile',
            'Add Blog',
            'Update Blog',
            'Delete Blog',
            'View Blogs',
            'Add Product',
            'Update Product',
            'Delete Product',
            'view Products',
            'Add Tournament',
            'Update Tournament',
            'Delete Tournaments',
            'View Tournaments',
            'Delete Comment',
            'Add Comment',
            'Add To Cart',
            'Remove From Cart',
        ])->pluck('id');

        $subAdmin->permissions()->sync($subAdminPermissionIds);

        // For team-member role
        $teamMemberPermissionIds = Permission::whereIn('name', [
            'Update Profile',
            'View Blogs',
            'view Products',
            'View Tournaments',
            'Delete Comment',
            'Add Comment',
            'Add To Cart',
            'Remove From Cart',
        ])->pluck('id');

        $teamMember->permissions()->sync($teamMemberPermissionIds);

        // For fan role
        $fanPermissionIds = Permission::whereIn('name', [
            'Update Profile',
            'View Blogs',
            'view Products',
            'View Tournaments',
            'Delete Comment',
            'Add Comment',
            'Add To Cart',
            'Remove From Cart',
        ])->pluck('id');

        $fan->permissions()->sync($fanPermissionIds);
    }
}
