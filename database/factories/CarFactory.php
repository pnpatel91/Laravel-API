<?php

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class CarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Car::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = (new \Faker\Factory())::create();
        $faker->addProvider(new \Faker\Provider\Fakecar($faker));
        $v = $faker->vehicleArray();
        $colour = array("red", "white", "black", "green", "yellow", "blue");

        return [
            'name'              => $v['model'],
            'colour'            => $colour[array_rand($colour, 1)],
            'price'             => rand(19000,22000),
            'plate'             => $faker->vehicleRegistration('[A-Z]{2}[0-9]{2} [A-Z]{3}'),
            'doors'             => $faker->vehicleDoorCount,
            'transmission'      => $faker->vehicleGearBoxType,
            'fuel'              => $faker->vehicleFuelType,
        ];
    }
}
