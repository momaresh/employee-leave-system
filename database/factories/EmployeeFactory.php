<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'employee_name' => $this->faker->name,
            'employee_number' => 'EMP' . $this->faker->unique()->numberBetween(100, 999),
            'mobile' => $this->faker->phoneNumber,
            'user_id' => User::factory()->state([
                            'role' => 'Employee',
                        ]),
            'address' => $this->faker->address,
            'notes' => $this->faker->optional()->sentence,
        ];
    }
}
