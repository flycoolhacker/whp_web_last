<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Logmodel extends Model
{
    protected $table='log';
    protected  $primaryKey='log_id';
    public $timestamps=false;
    protected  $guarded=[];
}
