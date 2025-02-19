<?php

namespace App\Models\Voucher;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentVoucher extends Model
{
    use HasFactory;
    protected $table='tbl_voucher_payment_vouchers';
}
