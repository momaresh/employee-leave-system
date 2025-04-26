<?php

use App\Models\LeaveRequest;
use App\Models\LeaveType;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('leave type can be created', function () {
    $type = LeaveType::create([
        'name' => 'Sick Leave',
    ]);

    $this->assertDatabaseHas('leave_types', [
        'name' => 'Sick Leave',
    ]);
});

test('leave type can be updated', function () {
    $type = LeaveType::create([
        'name' => 'Sick Leave',
    ]);

    $type->update([
        'name' => 'Vacation',
    ]);

    $this->assertDatabaseHas('leave_types', [
        'name' => 'Vacation',
    ]);
});

test('leave type has many leave requests', function () {
    $type = LeaveType::factory()->create();
    LeaveRequest::factory()->for($type)->create();

    expect($type->leaveRequests->first())->toBeInstanceOf(LeaveRequest::class);
});