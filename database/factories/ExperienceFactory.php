<?php

namespace Database\Factories;

use App\Models\Experience;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExperienceFactory extends Factory
{
    protected $model = Experience::class;

    public function definition()
    {
        return [
            'name' => $this->faker->jobTitle(),
            'content' => $this->faker->paragraphs(3, true),
            'start_date' => $this->faker->dateTimeBetween('-10 years', '-1 year'),
            'end_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
