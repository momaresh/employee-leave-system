<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeaveSummary extends Component
{
    public $search = '';

    public function render()
    {
        $user = Auth::user();

        $query = Employee::with(['leaveRequests.leaveType']);

        if (!$user->isAdmin()) {
            $query->where('id', $user->employee->id); // Adjust if your relation is different
        }

        $employees = $query
            ->where('employee_name', 'like', '%' . $this->search . '%')
            ->get()
            ->map(function ($employee) {
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

        return view('livewire.reports.leave-summary', compact('employees'))->layout('layouts.app');
    }
}
