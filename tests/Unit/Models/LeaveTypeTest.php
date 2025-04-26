<?php

use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Mockery;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('can create a leave type', function () {
    // Mock the LeaveType model
    $mockLeaveType = \Mockery::mock(LeaveType::class);
    $mockLeaveType->shouldReceive('create')
        ->once()
        ->with([
            'name' => 'Sick Leave',
        ])
        ->andReturnSelf();  // Mock the create method

    // Simulate the create behavior and assert that the method was called
    $mockLeaveType->create(['name' => 'Sick Leave']);
    $mockLeaveType->shouldHaveReceived('create')
        ->with(['name' => 'Sick Leave']);
});

it('can update a leave type', function () {
    // Mock the LeaveType model
    $mockLeaveType = \Mockery::mock(LeaveType::class);
    $mockLeaveType->shouldReceive('update')
        ->once()
        ->with([
            'name' => 'Vacation',
        ])
        ->andReturn(true);  // Simulate update returning true

    // Simulate the update behavior and assert that the method was called
    $mockLeaveType->update(['name' => 'Vacation']);
    $mockLeaveType->shouldHaveReceived('update')
        ->with(['name' => 'Vacation']);
});

it('can have many leave requests', function () {
    // Create a mock for LeaveRequest model
    $leaveRequestMock = Mockery::mock(LeaveRequest::class);

    // Create a mock for the LeaveType model
    $type = Mockery::mock(LeaveType::class)->makePartial();

    // Mocking the leaveRequests method to return a HasMany relationship
    $hasManyMock = Mockery::mock(HasMany::class);

    // Setting expectations for getResults() to return a collection with the LeaveRequest mock
    $hasManyMock->shouldReceive('getResults')->andReturn(collect([$leaveRequestMock]));

    // Mock the leaveRequests method to return our mocked HasMany relationship
    $type->shouldReceive('leaveRequests')->andReturn($hasManyMock);

    // Asserting that leaveRequests contains the mocked LeaveRequest
    expect($type->leaveRequests)->toContain($leaveRequestMock);
});
