<div class="p-4">
    <h2 class="text-2xl font-bold mb-4">Employee Management</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="space-y-2">
            <input type="text" wire:model="employee_name" placeholder="Employee Name" class="w-full border rounded p-2" />
            @error('employee_name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <input type="text" wire:model="employee_number" placeholder="Employee Number" class="w-full border rounded p-2" />
            @error('employee_number')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <input type="text" wire:model="mobile" placeholder="Mobile Number" class="w-full border rounded p-2" />
            @error('mobile')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <input type="email" wire:model="email" placeholder="Email" class="w-full border rounded p-2" />
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
            @if (!$updateMode)
                <input type="password"  wire:model="password" placeholder="Password" class="w-full border rounded p-2" />
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            @endif

            <input type="text" wire:model="address" placeholder="Address" class="w-full border rounded p-2" />
            @error('address')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <textarea wire:model="notes" placeholder="Notes" class="w-full border rounded p-2"></textarea>
            @if ($updateMode)
                <button wire:click="update" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
                <button wire:click="cancel" class="bg-gray-300 px-4 py-2 rounded">Cancel</button>
            @else
                <button wire:click="store" class="bg-green-500 text-white px-4 py-2 rounded">Save</button>
            @endif
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded">
                <thead>
                    <tr class="bg-gray-200 text-left">
                        <th class="p-2">Name</th>
                        <th class="p-2">Number</th>
                        <th class="p-2">Mobile</th>
                        <th class="p-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $emp)
                        <tr class="border-t">
                            <td class="p-2">{{ $emp->employee_name }}</td>
                            <td class="p-2">{{ $emp->employee_number }}</td>
                            <td class="p-2">{{ $emp->mobile }}</td>
                            <td class="p-2 space-x-2">
                                <button wire:click="edit({{ $emp->id }})" class="bg-yellow-400 px-2 py-1 rounded">Edit</button>
                                <button wire:click="delete({{ $emp->id }})" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
