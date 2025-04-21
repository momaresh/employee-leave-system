<?php

namespace App\Livewire\LeaveRequests;

use Livewire\Component;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Index extends Component
{
    public $leave_type_id, $reason, $from_date, $to_date, $notes, $leave_request_id, $updateMode = false;

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

    public function edit($id)
    {
        $leave_request = LeaveRequest::findOrFail($id);

        $this->leave_type_id = $leave_request->leave_type_id;
        $this->reason = $leave_request->reason;
        $this->from_date = $leave_request->from_date;
        $this->to_date = $leave_request->to_date;
        $this->notes = $leave_request->notes;
        $this->leave_request_id = $id;

        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
            'leave_type_id' => 'required|exists:leave_types,id',
            'reason' => 'required|string',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
        ]);

        // validate leave request overlaps with an existing request
        $overlap = LeaveRequest::where('employee_id', Auth::user()->employee->id)
            ->where('id', '!=', $this->leave_request_id)
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


        LeaveRequest::findOrFail($this->leave_request_id)->update([
            'leave_type_id' => $this->leave_type_id,
            'reason' => $this->reason,
            'from_date' => $this->from_date,
            'to_date' => $this->to_date,
            'notes' => $this->notes,
            'status' => 'Pending'
        ]);

        session()->flash('message', 'Leave request updated successfully.');
        $this->updateMode = false;
        $this->reset(['leave_type_id', 'reason', 'from_date', 'to_date', 'notes']);
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->reset(['leave_type_id', 'reason', 'from_date', 'to_date', 'notes']);
    }

    public function delete($id) {
        LeaveRequest::findOrFail($id)->delete();
        session()->flash('message', 'Leave request deleted successfully.');
    }

    public function render()
    {
        return view('livewire.leave-requests.index', [
            'leaveTypes' => LeaveType::all(),
            'requests' => LeaveRequest::where('employee_id', Auth::user()->employee->id)->latest()->get()
        ])->layout('layouts.app');
    }
}
