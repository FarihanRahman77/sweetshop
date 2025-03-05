<?php

namespace App\Traits;
use App\Models\Accounts\ChartOfAccounts;
use App\Models\Voucher\PaymentVoucher;
use App\Models\Voucher\AccountsVoucher;
use App\Models\Voucher\AccountsVoucherDetails;
use Illuminate\Support\Facades\DB;


trait PaymentVoucherTrait
{
    public function storePartyPayable($logged_sister_concern_id,$maxCode, $party_id, $amount, $orderId,$payment_method_name, $payment_method,$voucherType, $type, $remarks)
    {
        $paymentVoucher = new PaymentVoucher();
        $paymentVoucher->voucherNo = $maxCode;
        $paymentVoucher->amount = floatval($amount);
        $paymentVoucher->resturant_order_id = $orderId;
        $paymentVoucher->party_id = $party_id;
        $paymentVoucher->payment_method_id = $payment_method;
        $paymentVoucher->payment_method = $payment_method_name;
        $paymentVoucher->sister_concern_id=$logged_sister_concern_id;
        $paymentVoucher->paymentDate  = date('Y-m-d');
        $paymentVoucher->discount  ='0.00';
        $paymentVoucher->type  = $type;
        $paymentVoucher->voucherType  = $voucherType;
        $paymentVoucher->remarks  = 'WalkinSale: ' . ' payment: ' . $amount;
        $paymentVoucher->entryBy  = auth()->user()->id;
        $paymentVoucher->save(); 
    }



    public function storePaymentReceived($logged_sister_concern_id,$maxCode, $party_id, $amount, $orderId,$payment_method_name, $payment_method,$voucherType, $type, $remarks)
    {
        $paymentVoucher = new PaymentVoucher();
        $paymentVoucher->voucherNo = $maxCode;
        $paymentVoucher->amount = floatval($amount);
        $paymentVoucher->resturant_order_id = $orderId;
        $paymentVoucher->party_id = $party_id;
        $paymentVoucher->payment_method_id = $payment_method;
        $paymentVoucher->payment_method = $payment_method_name;
        $paymentVoucher->sister_concern_id=$logged_sister_concern_id;
        $paymentVoucher->paymentDate  = date('Y-m-d');
        $paymentVoucher->discount  ='0.00';
        $paymentVoucher->type  = $type;
        $paymentVoucher->voucherType  = $voucherType;
        $paymentVoucher->remarks  = 'WalkinSale: ' . ' payment: ' . $amount;
        $paymentVoucher->entryBy  = auth()->user()->id;
        $paymentVoucher->save();
    }


    public function storePayable()
    {
        return "Hello from the trait!";
    }



    public function storePayament()
    {
        return "Hello from the trait!";
    }
}