<?php

namespace App\model;

use Illuminate\Database\Eloquent\SoftDeletes;


use Illuminate\Database\Eloquent\Model;

class user_activity_management extends Model

{

    protected $table = 'user_activity_management';
    protected $fillable = [
        'user_id',
        'fname',
        'username',
        'email',
        'level',
        'password',




    ];


    public function user_types(){

        return $this->belongsTo(User_type::class, 'level');


    }
}
