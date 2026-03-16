<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin Role
        $adminRole = Role::firstOrCreate(
            ['slug' => 'admin'],
            [
                'name' => 'Administrator',
                'description' => 'Full system access with all permissions',
                'status' => 'active',
            ]
        );

        // Assign all permissions to admin role
        $allPermissions = Permission::pluck('id')->toArray();
        $adminRole->assignPermissions($allPermissions);

        // Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('1234'),
                'role_id' => $adminRole->id,
                'email_verified_at' => now(),
            ]
        );

        // Update role_id if user exists but doesn't have role
        if ($admin->role_id !== $adminRole->id) {
            $admin->update(['role_id' => $adminRole->id]);
        }

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@gmail.com');
        $this->command->info('Password: 1234');
    }
}
