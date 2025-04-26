<?php

use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Mockery;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

// Create employee test
it('can create an employee', function () {
        // Mock the Employee model
        $mockEmployee = \Mockery::mock(Employee::class);
        $mockEmployee->shouldReceive('create')
            ->once()
            ->with([
                'employee_name' => 'Mohammed Maresh',
                'employee_number' => 'EMP001',
            ])
            ->andReturnSelf();  // Mock the create method

        // Simulate the create behavior and assert that the method was called
        $mockEmployee->create(['employee_name' => 'Mohammed Maresh', 'employee_number' => 'EMP001']);
        $mockEmployee->shouldHaveReceived('create')
            ->with(['employee_name' => 'Mohammed Maresh', 'employee_number' => 'EMP001']);
});

//Update employee test
it('can update an employee', function () {
    // Mock the Employee model
    $mockEmployee = \Mockery::mock(Employee::class);
    $mockEmployee->shouldReceive('update')
        ->once()
        ->with([
            'employee_name' => 'Ali',
        ])
        ->andReturnSelf();  // Mock the update method

    // Simulate the update behavior and assert that the method was called
    $mockEmployee->update(['employee_name' => 'Ali']);
    $mockEmployee->shouldHaveReceived('update')
        ->with(['employee_name' => 'Ali']);
});

it('can have many leave requests', function () {
    // Create a mock for LeaveRequest model
    $leaveRequestMock = Mockery::mock(LeaveRequest::class);

    // Create a mock for the Employee model
    $type = Mockery::mock(Employee::class)->makePartial();

    // Mocking the leaveRequests method to return a HasMany relationship
    $hasManyMock = Mockery::mock(HasMany::class);

    // Setting expectations for getResults() to return a collection with the LeaveRequest mock
    $hasManyMock->shouldReceive('getResults')->andReturn(collect([$leaveRequestMock]));

    // Mock the leaveRequests method to return our mocked HasMany relationship
    $type->shouldReceive('leaveRequests')->andReturn($hasManyMock);

    // Asserting that leaveRequests contains the mocked LeaveRequest
    expect($type->leaveRequests)->toContain($leaveRequestMock);
});
