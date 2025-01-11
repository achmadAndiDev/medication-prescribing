<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PatientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Patient::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'patient_code'  => 'P' . strtoupper(Str::random(6)),
            'name'          => $this->faker->name(),
            'gender'        => $this->faker->randomElement(['L', 'P']),
            'date_of_birth' => $this->faker->date('Y-m-d', '-18 years'),
            'phone'         => $this->faker->phoneNumber(),
            'email'         => $this->faker->unique()->safeEmail(),
            'address'       => $this->faker->address(),
            'blood_type'    => $this->faker->optional()->randomElement(['A', 'B', 'AB', 'O']),
        ];
    }
}
