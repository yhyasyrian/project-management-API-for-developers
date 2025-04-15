<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\Project;
use App\Enums\TaskStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence(6),
            'content' => $this->faker->paragraphs(3, true),
            'status' => $this->faker->randomElement(array_column(TaskStatusEnum::cases(), 'value')),
            'can_view_for_client' => $this->faker->boolean(),
        ];
    }
}
