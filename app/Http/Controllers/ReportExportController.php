<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use PDF;

class ReportExportController extends Controller
{
    public function exportLeaveSummary()
    {
        $user = Auth::user();

        $query = Employee::with(['leaveRequests.leaveType']);

        if (!$user->isAdmin()) {
            $query->where('id', $user->employee->id); // Adjust if your relation is different
        }

        $employees = $query->get()->map(function ($employee) {
            $lastLeave = $employee->leaveRequests->sortByDesc('created_at')->first();

            return (object)[
                'name' => $employee->employee_name,
                'number' => $employee->employee_number,
                'mobile' => $employee->mobile,
                'total' => $employee->leaveRequests->count(),
                'last_date' => optional($lastLeave)->created_at?->format('Y-m-d') ?? '—',
                'last_type' => optional($lastLeave?->leaveType)->name ?? '—',
            ];
        });

        $pdf = PDF::loadView('exports.leave-summary', ['employees' => $employees]);
        return $pdf->download('leave_summary_report.pdf');
    }
}
