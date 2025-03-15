<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

	    'name' => $this->faker->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'), // Default password
            'role' => $this->faker->randomElement(['admin', 'pegawai']),
            'nik' => $this->faker->numerify('################'), // 16 digit angka
            'departemen' => $this->faker->randomElement(['HRD',  'Finance', 'Marketing']),
            'cabang_asal' => 'HO',
            'no_hp' => $this->faker->phoneNumber(),
            'nama_lengkap' => $this->faker->name(),
            'ttd' => '', // Tanda tangan bisa diisi null atau path file
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
