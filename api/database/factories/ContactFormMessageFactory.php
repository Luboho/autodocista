<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\ContactFormMessage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFormMessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ContactFormMessage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'message' => $this->faker->paragraph,
            'read' => $this->faker->boolean(50),
            'branch_id' => Branch::factory()
        ];
    }
}
