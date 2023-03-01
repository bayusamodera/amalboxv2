<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([                        
            IdxUserTypeTableTableSeeder::class,
            UserTableSeeder::class,
            IdxProgramCategoryTableSeeder::class,
            //komentarin yang atas jika sebelumnya sudah pernah seed dan ingin menambahkan categorydua
            IdxProgramCategoryDuaTableSeeder::class
        ]);

    }
}
