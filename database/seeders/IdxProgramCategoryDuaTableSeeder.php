<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class IdxProgramCategoryDuaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = new Category();
        $category->id = 'Z2';
        $category->category_name = 'Gharimin';
        $category->deskripsi = 'Terlilit Hutang';
        $category->save();

        $category = new Category();
        $category->id = 'Z3';
        $category->category_name = 'Muallaf';
        $category->deskripsi = 'Muallaf';
        $category->save();

        $category = new Category();
        $category->id = 'Z4';
        $category->category_name = 'Riqob';
        $category->deskripsi = 'Budak atau Tawanan';
        $category->save();

        $category = new Category();
        $category->id = 'Z5';
        $category->category_name = 'Ibnu Sabil';
        $category->deskripsi = 'Musafir Kehabisan Bekal';
        $category->save();
    }
}
