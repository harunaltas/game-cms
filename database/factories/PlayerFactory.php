<?php

namespace Database\Factories;

use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'gamer_id' => fake()->unique()->uuid,
            'email' => fake()->unique()->safeEmail,
            'password' => Hash::make('password'),
            'nick' => fake()->userName,
            'ip_address' => fake()->ipv4,
            'security_question' => fake()->sentence,
            'security_answer' => fake()->word,
            'nick_update_dates' => fake()->dateTimeThisMonth,
            'last_login_dates' => fake()->dateTimeThisMonth,
            'pc_user_info' => fake()->text,
        ];
    }
}
