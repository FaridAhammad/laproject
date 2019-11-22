<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Item_info extends Model
{
    protected $table= 'item_info';
    public $timestamps = false;

    protected $fillable = [
        'item_id',
        'item_name',
        'sub_group_id',
        'item_description',
        'product_nature',
        'unit_name',
        'cost_price',
        'sale_price',
        'entry_by',
        'entry_at',
        'edit_by',
        'edit_at',
        'delete_by',
        'delete_at',
    ];

    public function product_sub_group() {
        return $this->belongsTo(product_sub_group::class, 'sub_group_id')->where('status', 0);
    } 

}
