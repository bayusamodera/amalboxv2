<?php

use Illuminate\Database\Seeder;
use App\Models\UserType;

class IdxUserTypeTableTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usertype = new UserType;
        $usertype->id = 1;
        $usertype->type_name = 'anonim';
        $usertype->save();

        $usertype = new UserType;
        $usertype->id = 2;
        $usertype->type_name = 'member';
        $usertype->save();

        $usertype = new UserType;
        $usertype->id = 3;
        $usertype->type_name = 'admin';
        $usertype->save();
    }
}
