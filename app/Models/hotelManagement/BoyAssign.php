<?php

namespace App\Models\hotelManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmployeeManagement\Employee;
use App\Models\Setups\Warehouse;


class BoyAssign extends Model
{
    use HasFactory;
    protected $table = 'tbl_boy_assign';
    public function Employee()
    {
        return $this->belongsTo(Employee::class, 'tbl_our_team_id');
    }
    public function Warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'room_id');
    }

}


