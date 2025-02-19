<?php

namespace App\Models\hotelManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;
    protected $table='tbl_facilities';
    protected $fillable = [
        'facility_name',
        'facility_value',
        'serial',
        'icons',
        'facility_head',
        'tbl_sisterconcern_id',
        'deleted',
        'status',
    ];
}
