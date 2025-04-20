<?php

namespace Tests\Unit\Models;

use App\Models\LeaveRequest;
use Tests\TestCase;
use App\Models\LeaveType;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LeaveTypeTest extends TestCase
{
    use RefreshDatabase;

    public function test_leave_type_can_be_created()
    {
        $type = LeaveType::create([
            'name' => 'Sick Leave',
        ]);

        $this->assertDatabaseHas('leave_types', [
            'name' => 'Sick Leave',
        ]);
    }

    public function test_leave_type_can_be_updated()
    {
        $type = LeaveType::create([
            'name' => 'Sick Leave',
        ]);

        $type->update([
            'name' => 'Vacation',
        ]);

        $this->assertDatabaseHas('leave_types', [
            'name' => 'Vacation',
        ]);
    }

    public function test_leave_type_has_many_leave_requests()
    {
        $type = LeaveType::factory()->create();
        LeaveRequest::factory()->for($type)->create();

        $this->assertInstanceOf(LeaveRequest::class, $type->leaveRequests->first());
    }
}
