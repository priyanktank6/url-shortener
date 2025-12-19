<?php

namespace Database\Factories;

use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShortUrl>
 */
class ShortUrlFactory extends Factory
{
    protected $model = ShortUrl::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'short_code' => Str::random(8),
            'original_url' => fake()->url(),
            'user_id' => User::factory()->state(function () {
                return [
                    'company_id' => \App\Models\Company::factory(),
                ];
            }),

            // 👇 derive company from user
            'company_id' => function (array $attributes) {
                return \App\Models\User::find($attributes['user_id'])->company_id;
            },
            // 'user_id' => User::factory(),
        ];
    }
}
