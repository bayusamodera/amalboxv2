<?php

use Illuminate\Database\Seeder;
use App\Models\Category;


class IdxProgramCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = new Category();
        $category->id = 'A0';
        $category->category_name = 'Pembangunan';
        $category->save();

        $category = new Category();
        $category->id = 'A1';
        $category->category_name = 'Gerakan';
        $category->save();

        $category = new Category();
        $category->id = 'A2';
        $category->category_name = 'Pemberdayaan';
        $category->save();

        $category = new Category();
        $category->id = 'Z0';
        $category->category_name = 'Fakir Miskin';
        $category->save();

        $category = new Category();
        $category->id = 'Z1';
        $category->category_name = 'Fisabilillah';
        $category->deskripsi = 'Pejuang di Jalan Allah';
        $category->save();
    }
}
