<?php

namespace Tests\Unit\Models;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_employee()
    {
        $employee = Employee::factory()->create([
            'employee_name' => 'Mohammed Maresh',
            'employee_number' => 'EMP001',
        ]);

        $this->assertDatabaseHas('employees', [
            'employee_number' => 'EMP001',
        ]);
    }

    public function test_update_employee()
    {
        $employee = Employee::factory()->create([
            'employee_name' => 'Mohammed Maresh',
            'employee_number' => 'EMP001',
        ]);

        $employee->update([
            'employee_name' => 'Ali',
        ]);

        $this->assertDatabaseHas('employees', [
            'employee_name' => 'Ali',
        ]);
    }

    public function test_employee_has_leave_requests()
    {
        $employee = Employee::factory()->hasLeaveRequests(3)->create();

        $this->assertCount(3, $employee->leaveRequests);
    }

    public function test_employee_has_user()
    {
        $employee = Employee::factory()->create();

        $this->assertInstanceOf(\App\Models\User::class, $employee->user);
    }
}
