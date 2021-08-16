<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\Factory;

class BranchFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Branch::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'city' => $this->faker->country,
            'address' => $this->faker->address,
            'postal_code' => $this->faker->postcode,
            'phone' => $this->faker->e164PhoneNumber,
            'email' => $this->faker->email,
            'ico' => $this->faker->numerify('SK############')
        ];
    }
}
