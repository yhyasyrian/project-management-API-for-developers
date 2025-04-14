<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\Project;
use App\Enums\StatusTaskEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence(6),
            'information' => $this->faker->paragraphs(3, true),
            'status' => $this->faker->randomElement(array_column(StatusTaskEnum::cases(), 'value')),
            'can_view_for_client' => $this->faker->boolean(),
        ];
    }
}
