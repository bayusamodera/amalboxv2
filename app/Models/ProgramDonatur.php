<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramDonatur extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'program_donatur';
    public const STATUS_KONFIRMASI = 1;

    public function invoice() {
        return $this->belongsto('App\Models\Invoice', 'invoice_id');
    }

    public function program() {
        return $this->belongsTo('App\Models\Program', 'program_profile_id');
    }
}
