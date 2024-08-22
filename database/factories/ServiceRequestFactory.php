<?php

namespace Database\Factories;

use App\Enums\ServiceRequest\Priority;
use App\Models\Aircraft;
use App\Models\MaintenanceCompany;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServiceRequest>
 */
class ServiceRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => $this->faker->text(50),
            'priority' => Priority::LOW,
            'due_date' => today()->addDays($this->faker->randomNumber(5, 10)),
            'aircraft_id' => Aircraft::factory(),
            'maintenance_company_id' => MaintenanceCompany::factory()
        ];
    }
}
