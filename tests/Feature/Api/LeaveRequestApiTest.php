<?php

namespace Tests\Feature\Api;

use App\Models\Employee;
use App\Models\LeaveType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LeaveRequestApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_employee_can_submit_leave_request_api()
    {
        $user = User::factory()->create(['role' => 'Employee']);
        $employee = Employee::factory()->create(['user_id' => $user->id]);
        $leaveType = LeaveType::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/leave-requests', [
            'leave_type_id' => $leaveType->id,
            'reason' => 'Test reason',
            'from_date' => now()->toDateString(),
            'to_date' => now()->addDays(2)->toDateString(),
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('leave_requests', ['reason' => 'Test reason']);
    }
}
