<?php

declare(strict_types=1);

namespace Database\Seeders;

use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        Db::table('users')->insert([
            'uuid' => $faker->uuid(),
            'name' => $faker->name(),
            'email' => $faker->email(),
            'password' => password_hash('123456', PASSWORD_DEFAULT),
        ]);
    }
}
