<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Warehouse_other_receive_detail extends Model
{
    public $timestamps=false;
    protected $table = 'warehouse_other_receive_detail';
    protected $guarded = [];
    protected $fillable = [
        'or_no',
        'or_date',
        'vendor_name',
        'receive_type',





    ];

}
