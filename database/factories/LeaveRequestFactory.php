<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\LeaveType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LeaveRequest>
 */
class LeaveRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $fromDate = $this->faker->dateTimeBetween('-1 year', 'now');
        $toDate = (clone $fromDate)->modify('+'.rand(1, 5).' days');

        return [
            'employee_id' => Employee::factory(),
            'leave_type_id' => LeaveType::factory(),
            'from_date' => $fromDate,
            'to_date' => $toDate,
            'reason' => $this->faker->sentence,
            'notes' => $this->faker->optional()->paragraph,
        ];
    }
}
