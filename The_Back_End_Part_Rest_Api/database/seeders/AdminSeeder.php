<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $credentials = [
            'first_name' => 'The',
            'last_name' => 'Admin',
            'birth_day' => '1999-01-01',
            'role_id' => '1',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];

        DB::table('users')->insert($credentials);

        $admin = User::where('email', 'admin@admin.com')->first();

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

        $admin->permissions()->attach($adminPermissionsIds);
    }
}