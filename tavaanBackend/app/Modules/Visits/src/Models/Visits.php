<?php

namespace App\Modules\Visits\src\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visits extends Model
{
     use HasFactory;

     protected $table = 'visits';

   protected $fillable =[
       'fullName',
       'phone',
       'companions',
       'has_car',
       'entry_time',
       'exit_time',
       'command',
       'statusSms'
   ];

    protected $casts = [
        'has_car' => 'boolean',
        'entry_time' => 'datetime',
        'exit_time' => 'datetime',
    ];
}
