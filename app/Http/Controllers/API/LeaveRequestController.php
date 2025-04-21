<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    //
    public function index(Request $request)
    {
        $employee = $request->user()->employee;
        return LeaveRequest::where('employee_id', $employee->id)->latest()->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'leave_type_id' => 'required|exists:leave_types,id',
            'reason' => 'required|string',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'notes' => 'nullable|string',
        ]);

        $employeeId = $request->user()->employee->id;

        // Overlap check
        $overlap = LeaveRequest::where('employee_id', $employeeId)
            ->where(function ($q) use ($validated) {
                $q->whereBetween('from_date', [$validated['from_date'], $validated['to_date']])
                    ->orWhereBetween('to_date', [$validated['from_date'], $validated['to_date']])
                    ->orWhereRaw('? BETWEEN from_date AND to_date', [$validated['from_date']])
                    ->orWhereRaw('? BETWEEN from_date AND to_date', [$validated['to_date']]);
            })
            ->exists();

        if ($overlap) {
            return response()->json(['message' => 'Leave request overlaps'], 422);
        }

        $leaveRequest = LeaveRequest::create([
            'employee_id' => $employeeId,
            ...$validated,
            'status' => 'Pending',
        ]);

        return response()->json(['message' => 'Created', 'data' => $leaveRequest], 201);
    }
}
