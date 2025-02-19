<?php

namespace App\Models\hotelManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingDetails extends Model
{
    use HasFactory;
    protected $table='tbl_booking_details';

    protected $fillable = [
        'tbl_booking_id',
        'tbl_room_id',
        'booking_from',
        'booking_to',
        'tariff_fee',
        'adult',
        'child',
        'price',
        'payable_tariff',
        'checkin_date',
        'checkout_date',
        'cancellation_date',
        'states',
        'deleted',
        'status',
        'created_by',
        'created_date',
        'updated_by',
        'updated_date',
        'deleted_by',
        'deleted_date'
    ];

    public function Booking()
    {
        return $this->belongsTo(Booking::class,'tbl_booking_id');
    }
}
