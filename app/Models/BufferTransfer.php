<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BufferTransfer extends Model
{
    protected $table = "kode_unik_transfer";
    protected $primaryKey = "value";
    public $incrementing = false;

}
