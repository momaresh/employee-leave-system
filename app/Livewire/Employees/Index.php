<?php

namespace App\Livewire\Employees;

use Livewire\Component;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Index extends Component
{
    public $employee_name, $employee_number, $mobile, $address, $notes, $employeeId, $email, $password;
    public $updateMode = false;

    protected $rules = [
        'employee_name' => 'required|string',
        'employee_number' => 'required|unique:employees,employee_number',
        'email' => 'required|unique:users,email',
        'password' => 'required',
        'mobile' => 'required',
        'address' => 'nullable',
        'notes' => 'nullable'
    ];

    public function render()
    {
        return view('livewire.employees.index', [
            'employees' => Employee::latest()->get()
        ])->layout('layouts.app');
    }

    public function resetInputFields()
    {
        $this->employee_name = '';
        $this->employee_number = '';
        $this->email = '';
        $this->password = '';
        $this->mobile = '';
        $this->address = '';
        $this->notes = '';
        $this->employeeId = null;
    }

    public function store()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->employee_name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => 'Employee',
        ]);

        $user->assignRole('Employee');


        Employee::create([
            'employee_name' => $this->employee_name,
            'employee_number' => $this->employee_number,
            'mobile' => $this->mobile,
            'address' => $this->address,
            'notes' => $this->notes,
            'user_id' => $user->id
        ]);

        session()->flash('message', 'Employee added successfully.');
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $emp = Employee::findOrFail($id);
        $this->employeeId = $id;
        $this->employee_name = $emp->employee_name;
        $this->employee_number = $emp->employee_number;
        $this->mobile = $emp->mobile;
        $this->address = $emp->address;
        $this->notes = $emp->notes;
        $this->email = $emp->user->email;
        $this->updateMode = true;
    }

    public function update()
    {
        $emp = Employee::findOrFail($this->employeeId);

        $this->validate([
            'employee_name' => 'required|string',
            'employee_number' => 'required|unique:employees,employee_number,' . $emp->id,
            'email' => 'required|unique:users,email,' . $emp->user->id,
            'password' => 'required',
            'mobile' => 'required',
        ]);

        $emp->user->update([
            'email' => $this->email,
        ]);

        $emp->update([
            'employee_name' => $this->employee_name,
            'employee_number' => $this->employee_number,
            'mobile' => $this->mobile,
            'address' => $this->address,
            'notes' => $this->notes,
        ]);

        session()->flash('message', 'Employee updated successfully.');
        $this->resetInputFields();
        $this->updateMode = false;
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function delete($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        User::findOrFail($employee->user_id)->delete();
        session()->flash('message', 'Employee deleted successfully.');
    }
}
