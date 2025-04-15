<?php

namespace Database\Factories;

use App\Enums\ContactTypeEnum;
use App\Models\User;
use App\Models\ContactInformation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactInformationFactory extends Factory
{
    protected $model = ContactInformation::class;

    public function definition()
    {
        return [
            'type' => $this->faker->randomElement(array_column(ContactTypeEnum::cases(), 'value')),
            'value' => $this->faker->word(),
            'user_id' => User::factory(),
        ];
    }
}
