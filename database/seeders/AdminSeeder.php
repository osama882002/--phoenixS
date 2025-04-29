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
        // إنشاء الدور إن لم يكن موجودًا
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // إنشاء أو تحديث المستخدم الإداري
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
            ]
        );

        // تأكد من أن المستخدم لديه الدور
        $admin->syncRoles([$adminRole]);
    }
}
