<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IsiCart extends Model
{
    protected $table = 'isi_cart';

    public function program () {
        return $this->belongsTo('App\Models\Program', 'program_profile_id');
    }
}
