<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">{{__('messages.leave_summary_report')}}</h2>

    <div class="mb-4">
        <input type="text" wire:model.debounce.500ms="search" placeholder="Search by employee name..."
            class="border p-2 rounded w-1/3" />
    </div>

    <div class="mb-4">
        <a href="{{ route('reports.leave-summary.pdf') }}"
            class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600" target="_blank">
            {{__('messages.export_pdf')}}
        </a>
    </div>

    <table class="w-full border text-sm text-left">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-2">{{__('messages.employee_name')}}</th>
                <th class="p-2">{{__('messages.employee_number')}}</th>
                <th class="p-2">{{__('messages.mobile')}}</th>
                <th class="p-2">{{__('messages.total')}}</th>
                <th class="p-2">{{__('messages.last_leave_date')}}</th>
                <th class="p-2">{{__('messages.last_leave_type')}}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($employees as $emp)
            <tr class="border-t">
                <td class="p-2">{{ $emp->name }}</td>
                <td class="p-2">{{ $emp->number }}</td>
                <td class="p-2">{{ $emp->mobile }}</td>
                <td class="p-2">{{ $emp->total }}</td>
                <td class="p-2">{{ $emp->last_date }}</td>
                <td class="p-2">{{ $emp->last_type }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="p-4 text-center text-gray-600">{{__('messages.no_data_found')}}</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
