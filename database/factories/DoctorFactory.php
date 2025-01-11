<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\Person;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorFactory extends Factory
{
    protected $model = Doctor::class;

    public function definition()
    {
        return [
            'person_id' => Person::factory(),
            'specialty' => $this->faker->randomElement(['Cardiology', 'Pediatrics', 'Orthopedics', 'Dermatology']),
            'bio'       => $this->faker->paragraph(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Doctor $doctor) {
            $doctor->person->user()->update([
                'role' => User::ROLE_DOKTER,
            ]);
        });
    }
}
