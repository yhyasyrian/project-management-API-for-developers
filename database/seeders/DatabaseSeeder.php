<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\Models\Experience;
use App\Enums\TypeUserEnum;
use App\Models\BankAccount;
use App\Models\Certification;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContactInformation;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => config('app.admin.name'),
            'email' => config('app.admin.email'),
            'password' => config('app.admin.password'),
            'type' => TypeUserEnum::ADMIN->value,
        ]);
        if (app()->environment('local')) {
            $this->createFactoryData();
        }
    }
    private function createFactoryData()
    {
        User::factory(10)
            ->has(
                Project::factory(2)->has(Task::factory(6))
                    ->has(Tag::factory(20))
            )
            ->has(
                ContactInformation::factory(3)
            )
            ->create();
        BankAccount::factory(10)->create();
        Experience::factory(30)->create();
        Certification::factory(20)->create();
    }
}
