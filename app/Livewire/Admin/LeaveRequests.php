<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\LeaveRequest;
use App\Models\Employee;

class LeaveRequests extends Component
{
    public $statusFilter = '';

    public function updateStatus($id, $status)
    {
        $leave = LeaveRequest::findOrFail($id);
        $leave->status = $status;
        $leave->save();

        session()->flash('message', "Leave request {$status}.");
    }

    public function render()
    {
        $requests = LeaveRequest::with(['employee.user', 'leaveType'])
            ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
            ->latest()->get();

        return view('livewire.admin.leave-requests', [
            'requests' => $requests,
        ])->layout('layouts.app');
    }
}
