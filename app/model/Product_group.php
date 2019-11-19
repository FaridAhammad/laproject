<?php

namespace App\model;

use Illuminate\Database\Eloquent\SoftDeletes;


use Illuminate\Database\Eloquent\Model;

class Product_group extends Model

{

    protected $table = 'item_group';
    protected $fillable = [
       
        'group_name',
        
    ];


    
}
