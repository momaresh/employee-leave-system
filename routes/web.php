<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Employees\Index as EmployeeIndex;
use App\Livewire\LeaveRequests\Index as LeaveRequestIndex;
use App\Livewire\Admin\LeaveRequests as AdminLeaveRequests;
use App\Livewire\Reports\LeaveSummary;
use App\Livewire\LeaveRequests as AdminLeaveComponent;
use App\Http\Controllers\ReportExportController;

Route::get('/', function () {
    return view('welcome');
});


Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/employees', EmployeeIndex::class)->name('employees.index');
    Route::get('/admin/leave-requests', AdminLeaveRequests::class)->name('admin.leave-requests');
});

Route::middleware(['auth', 'role:Employee'])->group(function () {
    Route::get('/leave-requests', LeaveRequestIndex::class)->name('leave-requests.index');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/reports/leave-summary', LeaveSummary::class)->name('reports.leave-summary');
    Route::get('/reports/leave-summary/export-pdf', [ReportExportController::class, 'exportLeaveSummary'])->name('reports.leave-summary.pdf');
});
