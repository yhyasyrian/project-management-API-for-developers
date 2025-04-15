<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Project;
use App\Enums\ProjectStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(3),
            'content' => $this->faker->paragraphs(5, true),
            'price' => $this->faker->randomFloat(2, 100, 10000),
            'url' => $this->faker->url(),
            'route_check' => $this->faker->boolean(),
            'status' => $this->faker->randomElement(array_map(fn($status) => $status->getStatusNumber(), ProjectStatusEnum::cases())),
            'can_check' => $this->faker->boolean(),
            'start_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'end_at' => $this->faker->dateTimeBetween('now', '+1 year'),
        ];
    }
}
