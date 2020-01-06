<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Warehouse_other_issue extends Model
{
    
    public $timestamps=false;
    protected $table = 'warehouse_other_issue';
    protected $guarded = [];
    protected $fillable = [
        'oi_no',
        'oi_date',
        'issued_to',
        'issue_type',
        'customer_id',
        'entry_by'





    ];

}
