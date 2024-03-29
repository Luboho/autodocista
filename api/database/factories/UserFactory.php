<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // 'name' => $this->faker->name,
            // 'email' => $this->faker->unique()->safeEmail,
            // 'phone' => $this->faker->e164PhoneNumber,
            // 'email_verified_at' => now(),
            // 'is_admin' => (bool)random_int(0, 1),
            // // 'role' => 'user',
            // 'branch_id' => Branch::factory(),
            // 'password' => Hash::make('password'),//$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            // 'remember_token' => Str::random(10),

            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'phone' => $this->faker->e164PhoneNumber,
            'email_verified_at' => now(),
            'is_admin' => 1,
            // 'role' => 'user',
            'branch_id' => Branch::factory(),
            'password' => Hash::make('password'),//$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
