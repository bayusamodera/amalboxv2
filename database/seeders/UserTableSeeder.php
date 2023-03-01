<?php

use Illuminate\Database\Seeder;
use App\User;
use Faker\Factory;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $user = new User;
        $user->name = $faker->name;
        $user->email = 'admin@example.com';
        $user->password = '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm'; //secret
        $user->phone_number = $faker->randomNumber();
        $user->idx_user_type_id = 3;
        $user->status = 1;
        $user->save();
    }
}
