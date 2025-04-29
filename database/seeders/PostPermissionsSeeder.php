<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PostPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // إنشاء الصلاحيات المتعلقة بالمقالات
        $permissions = [
            'view posts',
            'create posts',
            'edit posts',
            'delete posts',
            'review posts',
            'approve posts',
            'reject posts'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // تعيين الصلاحيات إلى دور المشرف
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions($permissions);

        // يمكنك لاحقًا ربط صلاحيات معينة بدور "user" لو أردت
    }
}
