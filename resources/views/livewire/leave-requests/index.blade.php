<div class="p-4">
    <h2 class="text-xl font-bold mb-4">{{__('messages.request_leave')}}</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
    <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
        {{ session('error') }}
    </div>
@endif


    <div class="grid md:grid-cols-2 gap-4 mb-6">
        <div class="md:col-span-1">
            <label for="leave_type_id" class="block font-medium text-sm text-gray-700 mb-2">{{__('messages.leave_type')}}</label>
            <select wire:model="leave_type_id" class="w-full border p-2 rounded">
                <option value="">{{__('messages.select_leave_type')}}</option>
                @foreach ($leaveTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
            @error('leave_type_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="md:col-span-1">
            <label for="status" class="block font-medium text-sm text-gray-700 mb-2">{{__('messages.reason')}}</label>
            <input type="text" wire:model="reason" placeholder="{{__('messages.reason')}}" class="w-full border p-2 rounded" />
            @error('reason')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="md:col-span-1">
            <label for="from_date" class="block font-medium text-sm text-gray-700 mb-2">{{__('messages.from_date')}}</label>
            <input type="date" wire:model="from_date" class="w-full border p-2 rounded" />
            @error('from_date')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="md:col-span-1">
            <label for="to_date" class="block font-medium text-sm text-gray-700 mb-2">{{__('messages.to_date')}}</label>
            <input type="date" wire:model="to_date" class="w-full border p-2 rounded" />
            @error('to_date')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>



        <div class="md:col-span-2">
            <label for="notes" class="block font-medium text-sm text-gray-700 mb-2">{{__('messages.notes')}}</label>
            <textarea wire:model="notes" placeholder="{{__('messages.notes')}}" class="w-full border p-2 rounded md:col-span-2"></textarea>
            @error('notes')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <button wire:click="store" class="bg-blue-500 text-white px-4 py-2 rounded">{{__('messages.submit')}}</button>

    <h3 class="text-lg font-semibold mt-8 mb-2">{{__('messages.your_leave_requests')}}</h3>
    <table class="w-full text-sm border border-gray-300">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2">{{__('messages.leave_type')}}</th>
                <th class="p-2">{{__('messages.from_date')}}</th>
                <th class="p-2">{{__('messages.to_date')}}</th>
                <th class="p-2">{{__('messages.status')}}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($requests as $req)
                <tr class="border-t">
                    <td class="p-2">{{ $req->leaveType->name }}</td>
                    <td class="p-2">{{ $req->from_date }}</td>
                    <td class="p-2">{{ $req->to_date }}</td>
                    <td class="p-2">{{ $req->status }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="p-2 text-center">{{__('messages.no_leave_requests_found')}}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
