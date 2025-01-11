<?php

namespace Database\Factories;

use App\Models\Person;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonFactory extends Factory
{
    protected $model = Person::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(), // Automatically create a related User
            'address' => $this->faker->address(),
            'phone'   => $this->faker->phoneNumber(),
        ];
    }
}
