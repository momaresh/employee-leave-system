<?php

namespace App\Livewire\LeaveRequests;

use Livewire\Component;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Index extends Component
{
    public $leave_type_id, $reason, $from_date, $to_date, $notes;

    protected $rules = [
        'leave_type_id' => 'required|exists:leave_types,id',
        'reason' => 'required|string',
        'from_date' => 'required|date',
        'to_date' => 'required|date|after_or_equal:from_date',
    ];

    public function store()
    {
        $this->validate();

        $overlap = LeaveRequest::where('employee_id', Auth::user()->employee->id)
            ->where(function ($q) {
                $q->whereBetween('from_date', [$this->from_date, $this->to_date])
                  ->orWhereBetween('to_date', [$this->from_date, $this->to_date])
                  ->orWhereRaw('? BETWEEN from_date AND to_date', [$this->from_date])
                  ->orWhereRaw('? BETWEEN from_date AND to_date', [$this->to_date]);
            })
            ->exists();

        if ($overlap) {
            session()->flash('error', 'Leave request overlaps with an existing request.');
            return;
        }

        //validate that from date is before to date
        if (strtotime($this->from_date) > strtotime($this->to_date)) {
            session()->flash('error', 'From date must be before to date.');
            return;
        }

        LeaveRequest::create([
            'employee_id' => Auth::user()->employee->id,
            'leave_type_id' => $this->leave_type_id,
            'reason' => $this->reason,
            'from_date' => $this->from_date,
            'to_date' => $this->to_date,
            'notes' => $this->notes,
            'status' => 'Pending'
        ]);

        session()->flash('message', 'Leave request submitted successfully.');
        $this->reset(['leave_type_id', 'reason', 'from_date', 'to_date', 'notes']);
    }

    public function render()
    {
        return view('livewire.leave-requests.index', [
            'leaveTypes' => LeaveType::all(),
            'requests' => LeaveRequest::where('employee_id', Auth::user()->employee->id)->latest()->get()
        ])->layout('layouts.app');
    }
}
