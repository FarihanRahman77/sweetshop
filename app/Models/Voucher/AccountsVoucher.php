<?php

namespace App\Models\Voucher;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountsVoucher extends Model
{
    use HasFactory;
    protected $table='tbl_accounts_vouchers';
    protected $fillable = ['deleted'];
}
