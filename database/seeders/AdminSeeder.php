<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // إنشاء الأدوار
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);

        // إنشاء مشرف عادي
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
            ]
        );
        $admin->syncRoles([$adminRole]);

        // إنشاء السوبر أدمن
        $superAdmin = User::updateOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('superpassword'), 
            ]    
        );
        $superAdmin->syncRoles([$superAdminRole]);
    }
}
