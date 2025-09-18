<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'prefecture' => $this->faker->randomElement($array = array ('Hokkaido','Tokyo','Kanagawa','Nagoya','Kyoto','Osaka','Hyogo','Hiroshima','Fukuoka','Nagasaki','Kumamoto','Kagoshima','Okinawa')),
            'sex' => $this->faker->randomElement($array = array ('Male','Female')),
            'age' => $this->faker->numberBetween($min = 18, $max = 65),
            'house_type' => $this->faker->randomElement($array = array ('a','b','c')),
            'house_build_year' => $this->faker->numberBetween($min = 1, $max = 70),
            'house_area' => $this->faker->numberBetween($min = 20, $max = 200),
        ];
    }
}
