<?php

namespace App\Models\hotelManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Crm\Party;

class Booking extends Model
{
    use HasFactory;
    protected $table='tbl_booking';
    protected $fillable = [
        'booking_date',
        'approximate_arrival',
        'approximate_checkout',
        'booking_status',
        'tbl_building_Id',
        'tbl_party_id',
        'adult_member',
        'child_member',
        'referal',
        'complementary_breakfast',
        'totalPrice',
        'grand_total',
        'payable_tarrif',
        'discount',
        'total_discount',
        'down_payment',
        'payable_amount',
        'deleted',
        'status',
        'created_by',
        'created_date',
        'updated_by',
        'updated_date',
        'deleted_by',
        'deleted_date'
    ];
    public function BookingDetails()
    {
        return $this->hasMany(BookingDetails::class,'tbl_booking_id');
    }
   
    public function Party()
    {
        return $this->belongsTo(Party::class,'tbl_party_id');
    }

}

