<?php

namespace Database\Factories;

use App\Enums\JobTypeEnum;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $descriptions = array(
            [
                'title' => 'Software Developer',
                'description' => 'Develop Software',
                'requirements' => 'Ability to Develop Software'
            ],
            [
                'title' => 'UX Designer',
                'description' => 'Design User Interfaces',
                'requirements' => 'Ability to Design User Interfaces'
            ],
            [
                'title' => 'Product Owner',
                'description' => 'Own the Product',
                'requirements' => 'Ability to Own the Product'
            ],
            [
                'title' => 'Quality Assurance',
                'description' => 'Test Software',
                'requirements' => 'Ability to Test Software'
            ],
            [
                'title' => 'Team Lead',
                'description' => 'Lead the Team',
                'requirements' => 'Ability to Lead the Team'
            ]

        );

        $randomKey = array_rand($descriptions);

        return [
            'job_id' => fake()->uuid,
            'job_code' => fake()->regexify('[A-Z]{3}[0-9]{2}'),
            'title' => $descriptions[$randomKey]['title'],
            'location' => fake()->randomElement(['Remote', 'Westport']),
            'job_type' => fake()->randomElement(JobTypeEnum::all()),
            'salary' => round(fake()->randomNumber(5, true), -1),
            'application_deadline' => Carbon::now()->addMonths(2),
            'description' => $descriptions[$randomKey]['description'],
            'requirements' => $descriptions[$randomKey]['requirements'],
            'accepting_applications' => (bool) rand(0, 1)
        ];
    }
}
