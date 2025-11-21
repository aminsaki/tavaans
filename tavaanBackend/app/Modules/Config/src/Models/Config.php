<?php

namespace holoo\modules\Config\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
     protected $table = 'configs';

     protected $primaryKey = 'id';

     public $timestamps = false;
     protected $fillable = ['id' ,'mobile'];
}
