<div class="p-4">
    <h2 class="text-2xl font-bold mb-4">Manage Leave Requests</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">
            {{ session('message') }}
        </div>
    @endif

    <div class="mb-4">
        <label class="mr-2">Filter by Status:</label>
        <select wire:model="statusFilter" class="border p-1 rounded">
            <option value="">All</option>
            <option value="Pending">Pending</option>
            <option value="Approved">Approved</option>
            <option value="Rejected">Rejected</option>
        </select>
    </div>

    <table class="w-full text-sm border border-gray-300">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2">Employee</th>
                <th class="p-2">Type</th>
                <th class="p-2">From - To</th>
                <th class="p-2">Status</th>
                <th class="p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($requests as $req)
                <tr class="border-t">
                    <td class="p-2">{{ $req->employee->employee_name }}</td>
                    <td class="p-2">{{ $req->leaveType->name }}</td>
                    <td class="p-2">{{ $req->from_date }} → {{ $req->to_date }}</td>
                    <td class="p-2">{{ $req->status }}</td>
                    <td class="p-2 space-x-2">
                        @if ($req->status === 'Pending')
                            <button wire:click="updateStatus({{ $req->id }}, 'Approved')" class="text-green-600">Approve</button>
                            <button wire:click="updateStatus({{ $req->id }}, 'Rejected')" class="text-red-600">Reject</button>
                        @else
                            <span class="text-gray-500 italic">No action</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center p-2">No leave requests found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
