<?php

namespace Database\Factories;

use App\Models\Pharmacist;
use App\Models\Person;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PharmacistFactory extends Factory
{
    protected $model = Pharmacist::class;

    public function definition()
    {
        return [
            'person_id'    => Person::factory()->create()->id,
            'license_number' => $this->faker->unique()->randomNumber(8),
            'bio'           => $this->faker->paragraph(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Pharmacist $pharmacist) {
            $pharmacist->person->user()->update([
                'role' => User::ROLE_APOTEKER,
            ]);
        });
    }
}
