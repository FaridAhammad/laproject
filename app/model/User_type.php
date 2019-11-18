<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class User_type extends Model
{
    protected $table = 'user_type';
    protected $guarded = [];
    protected $fillable = [
       'id',
       'user_level',
       'user_type_name',
       'user_type_name_show'



    ];

}
