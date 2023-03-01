<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'idx_program_category';
    public $incrementing = false;
    public const KODE_ZAKAT = 'Z';
    public const KODE_AMAL = 'A';
    public const AMAL = 'Amal';
    public const ZAKAT = 'Zakat';

    public static function getZakat() {
        return Category::where('id','like','Z%')->get();
    }
    public static function getAmal() {
        return Category::where('id','like','A%')->get();
    }

    public function jenis() {
        $depan = \substr($this->id, 0, 1);
        if($depan == Category::KODE_ZAKAT) {
            return Category::ZAKAT;
        }else if($depan == Category::KODE_AMAL) {
            return Category::AMAL;
        }else {
            return null;
        }
    }

     public function subjenis() {
       $subjenis = Category::where('id',$this->id)->first();
       return $subjenis->category_name;
    }
}
