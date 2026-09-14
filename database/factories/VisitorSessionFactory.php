<?php

namespace Database\Factories;

use App\Models\VisitorSession;
use App\Models\Website;
use Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<VisitorSession>
 */
class VisitorSessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'website_id' => Website::factory(),
            'hash' => Hash::make($this->faker->uuid()),
            'id_address' => $this->faker->ipv4(),
            'country' => $this->faker->country(),
            'city' => $this->faker->city(),
            'region' => $this->faker->state(),
            'os' => $this->faker->word(),
            'device_type' => $this->faker->word(),
            'referrer_domain' => $this->faker->domainName(),
            'last_seen_at' => $this->faker->dateTime(),
        ];
    }
}
