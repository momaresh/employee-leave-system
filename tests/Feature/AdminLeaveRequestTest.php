<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class AdminLeaveRequestTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_admin_can_approve_leave_request()
    {
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
    }

    public function test_admin_can_reject_leave_request()
    {
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
    }
}
