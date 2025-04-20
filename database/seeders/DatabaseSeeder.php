<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(RoleSeeder::class);

        // Create Admin user
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'Admin',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('Admin');

        // Create leave types
        LeaveType::factory()->count(4)->create();

        // Create employees with linked users and leave requests
        Employee::factory()->count(10)->create()->each(function ($employee) {
            $employee->user->assignRole('Employee');

            LeaveRequest::factory()->count(rand(1, 5))->create([
                'employee_id' => $employee->id,
            ]);
        });
    }
}
