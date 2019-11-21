<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Product_sub_group extends Model
{
    public $timestamps=false;
    protected $table = 'item_sub_group';
    protected $guarded = [];
    protected $fillable = [
        'sub_group_id',
        'sub_group_name',
        'group_id',





    ];


    public function product_group(){

        return $this->belongsTo(Product_group::class, 'group_id', 'group_id')->where('status',0);


    }

}

