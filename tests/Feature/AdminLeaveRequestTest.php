<?php

use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;

test('admin can approve leave request', function () {
    $admin = User::factory()->create(['role' => 'Admin']);
    $employee = Employee::factory()->create();
    $leaveRequest = LeaveRequest::factory()->create([
        'employee_id' => $employee->id,
        'status' => 'Pending',
    ]);

    $this->actingAs($admin);

    Livewire::test(\App\Livewire\Admin\LeaveRequests::class)
        ->call('updateStatus', $leaveRequest->id, 'Approved');

    $this->assertDatabaseHas('leave_requests', [
        'id' => $leaveRequest->id,
        'status' => 'Approved',
    ]);
});

test('admin can reject leave request', function () {
    $admin = User::factory()->create(['role' => 'Admin']);
    $employee = Employee::factory()->create();
    $leaveRequest = LeaveRequest::factory()->create([
        'employee_id' => $employee->id,
        'status' => 'Pending',
    ]);

    $this->actingAs($admin);

    Livewire::test(\App\Livewire\Admin\LeaveRequests::class)
        ->call('updateStatus', $leaveRequest->id, 'Rejected');

    $this->assertDatabaseHas('leave_requests', [
        'id' => $leaveRequest->id,
        'status' => 'Rejected',
    ]);
});
