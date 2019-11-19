<?php

namespace App\model;

use Illuminate\Database\Eloquent\SoftDeletes;


use Illuminate\Database\Eloquent\Model;

class unit_management extends Model

{

    protected $table = 'unit_management';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'unit_name',
        'unit_detail',
        'entry_by',
        'entry_at',
        'edit_by',
        'edit_at',
    ];


    
}
