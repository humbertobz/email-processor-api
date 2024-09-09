<?php

namespace Database\Factories;

use App\Models\SuccessfulEmail;
use Illuminate\Database\Eloquent\Factories\Factory;

class SuccessfulEmailFactory extends Factory
{
    // Define o nome do model associado a esta factory
    protected $model = SuccessfulEmail::class;

    // Define os valores padrão para cada campo
    public function definition()
    {
        return [
            'affiliate_id' => $this->faker->numberBetween(1, 1000),
            'envelope' => $this->faker->text(200),
            'from' => $this->faker->email,
            'subject' => $this->faker->sentence,
            'dkim' => $this->faker->optional()->text(255),
            'SPF' => $this->faker->optional()->text(255),
            'spam_score' => $this->faker->optional()->randomFloat(2, 0, 10),
            'email' => $this->faker->randomHtml(),
            'raw_text' => $this->faker->paragraph,
            'sender_ip' => $this->faker->ipv4,
            'to' => $this->faker->email,
            'timestamp' => $this->faker->unixTime(),
        ];
    }
}
