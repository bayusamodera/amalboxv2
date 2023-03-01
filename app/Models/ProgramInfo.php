<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramInfo extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'program_info';
}
