<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'program_profile';

    public const STATUS_UNPUBLISH = 0;
    public const STATUS_PUBLISH = 1;


    public static function getZakat() {
        return Program::where('idx_program_category_id', 'like', Category::KODE_ZAKAT.'%');
    }

    public static function getAmal() {
        return Program::where('idx_program_category_id', 'like', Category::KODE_AMAL.'%');
    }
    public function images() {
        return $this->hasMany('App\Models\ProgramPicture', 'program_profile_id'); 
    }

    public function programInfo() {
        return $this->hasMany('App\Models\ProgramInfo', 'program_profile_id'); 
    }

    public function category() {
        return $this->belongsTo('App\Models\Category', 'idx_program_category_id');
    }

    public function donasi() {
        return $this->hasMany('App\Models\ProgramDonatur', 'program_profile_id');
    }

    public function donasilunas() {
        return $this->hasMany('App\Models\ProgramDonatur', 'program_profile_id')->where('status',ProgramDonatur::STATUS_KONFIRMASI);
    }

    public function pembuat() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function jumlahGambar() {
        return $this->images()->count();
    }

    public function targetDonation($format=false) {
        $target = $this->target_donation;
        if($format) {
            $target = number_format($this->target_donation, 0,',','.');
        }
        return $target;
    }

    public function jumlahDonasi($format=false) {
        $donasi = $this->donasi;
        $jumlah = 0;
        foreach ($donasi as $value) {
            if($value->status == ProgramDonatur::STATUS_KONFIRMASI) {
                $jumlah = $jumlah + $value->value;
            }
        }
        if($format) {
            $jumlah = number_format($jumlah, 0,',','.');
        }
        return $jumlah;
    }

    public function jumlahDonasiPersen() {
        $donasi = $this->donasi;
        $jumlah = 0;
        foreach ($donasi as $value) {
            if($value->status == ProgramDonatur::STATUS_KONFIRMASI) {
                $jumlah = $jumlah + $value->value;
            }
        }
        return round($jumlah/$this->target_donation * 100);
    }

    public function waktuTersisa() {
        $sekarang = Carbon::now();    
        return $sekarang->diffInDays($this->date_end);
    }
}
