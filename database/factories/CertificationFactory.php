<?php

namespace Database\Factories;

use App\Models\Certification;
use Illuminate\Database\Eloquent\Factories\Factory;

class CertificationFactory extends Factory
{
    protected $model = Certification::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'date' => $this->faker->dateTimeBetween('-5 years', 'now'),
            'url' => $this->faker->url(),
            'id_check' => $this->faker->uuid(),
        ];
    }
}
