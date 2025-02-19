<?php

namespace App\Models\hotelManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignRoomsToFloorAndWarehouse extends Model
{
    use HasFactory;
    protected $table='tbl_room_floor_and_warehouses';
}
