<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $types = ['Sick Leave', 'Annual Leave', 'Maternity Leave'];
        foreach ($types as $type) {
            \App\Models\LeaveType::create(['name' => $type]);
        }
    }
}
