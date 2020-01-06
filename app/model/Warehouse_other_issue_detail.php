<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Warehouse_other_issue_detail extends Model
{
    
    public $timestamps=false;
    protected $table = 'warehouse_other_issue_detail';
    protected $guarded = [];
    protected $fillable = [
        'oi_no',
        'item_id',
        'issued_to',
        'oi_date',
      
        'issue_type',
        'warehouse_id',
        'unit_name',
        'rate',
        'qty',
        'discount',
        'amount',
        'entry_by',
        'entry_at',

    ];

}
