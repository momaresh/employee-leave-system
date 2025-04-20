<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\LeaveType;
use App\Models\Employee;
use App\Models\LeaveRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

class LeaveRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_employee_can_create_leave_request()
    {
        // Create the user first
        $user = \App\Models\User::factory()->create([
            'role' => 'Employee',
        ]);

        // Create the employee and associate with user
        $employee = \App\Models\Employee::factory()->create([
            'user_id' => $user->id,
        ]);

        // Create a leave type
        $leaveType = \App\Models\LeaveType::factory()->create();

        // Log in the user
        $this->actingAs($user);

        // Perform Livewire test
        Livewire::test(\App\Livewire\LeaveRequests\Index::class)
            ->set('leave_type_id', $leaveType->id)
            ->set('reason', 'Need rest')
            ->set('from_date', now()->toDateString())
            ->set('to_date', now()->addDays(2)->toDateString())
            ->call('store')
            ->assertHasNoErrors();

        // Assert in the database
        $this->assertDatabaseHas('leave_requests', [
            'employee_id' => $employee->id,
            'reason' => 'Need rest',
            'leave_type_id' => $leaveType->id,
            'status' => 'Pending',
        ]);
    }

    public function test_employee_can_submit_valid_leave_request()
    {
        $user = User::factory()->create(['role' => 'Employee']);
        $employee = Employee::factory()->create(['user_id' => $user->id]);
        $leaveType = LeaveType::factory()->create();

        $this->actingAs($user);

        Livewire::test(\App\Livewire\LeaveRequests\Index::class)
            ->set('leave_type_id', $leaveType->id)
            ->set('reason', 'Personal reason')
            ->set('from_date', now()->toDateString())
            ->set('to_date', now()->addDays(2)->toDateString())
            ->call('store')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('leave_requests', [
            'employee_id' => $employee->id,
            'reason' => 'Personal reason',
        ]);
    }

    public function test_leave_request_requires_all_fields()
    {
        $user = User::factory()->create(['role' => 'Employee']);
        $employee = Employee::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        Livewire::test(\App\Livewire\LeaveRequests\Index::class)
            ->call('store')
            ->assertHasErrors(['leave_type_id', 'reason', 'from_date', 'to_date']);
    }

    public function test_prevent_overlapping_leave_requests()
    {
        $user = User::factory()->create(['role' => 'Employee']);
        $employee = Employee::factory()->create(['user_id' => $user->id]);
        $leaveType = LeaveType::factory()->create();

        // Existing leave
        LeaveRequest::create([
            'employee_id' => $employee->id,
            'leave_type_id' => $leaveType->id,
            'reason' => 'Vacation',
            'from_date' => '2024-04-01',
            'to_date' => '2024-04-10',
            'status' => 'Pending',
        ]);

        $this->actingAs($user);

        Livewire::test(\App\Livewire\LeaveRequests\Index::class)
            ->set('leave_type_id', $leaveType->id)
            ->set('reason', 'Overlap attempt')
            ->set('from_date', '2024-04-05')
            ->set('to_date', '2024-04-12')
            ->call('store');

        $this->assertDatabaseMissing('leave_requests', [
            'reason' => 'Overlap attempt'
        ]);
    }
}
