<?php

use App\Models\Employee;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('create employee', function () {
    $employee = Employee::factory()->create([
        'employee_name' => 'Mohammed Maresh',
        'employee_number' => 'EMP001',
    ]);

    $this->assertDatabaseHas('employees', [
        'employee_number' => 'EMP001',
    ]);
});

test('update employee', function () {
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
});

test('employee has leave requests', function () {
    $employee = Employee::factory()->hasLeaveRequests(3)->create();

    expect($employee->leaveRequests)->toHaveCount(3);
});

test('employee has user', function () {
    $employee = Employee::factory()->create();

    expect($employee->user)->toBeInstanceOf(\App\Models\User::class);
});
