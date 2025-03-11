<?php

namespace App\Traits;
use App\Models\Crm\Party;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
trait CommonTrait
{
    public function partydue($partyId)
    {
        $party = Party::where('id', '=', $partyId)
                      ->where('deleted', '=', 'No')
                      ->first();
        $due = 0;
        if ($party) {
            $payableOrReceiveable = '';
            $paymentOrReceived = '';
            $paymentOrReceivedReverse = '';
            $adjustmentStr = '';
    
            if ($party->party_type == 'Customer' ||  $party->party_type == 'Walkin_Customer') {
                $payableOrReceiveable = 'Party Payable';
                $paymentOrReceived = 'Payment Received';
                $paymentOrReceivedReverse = 'Payment';
                $adjustmentStr = 'Payment Adjustment';
            } elseif ($party->party_type == 'Investor' || $party->party_type == 'Supplier') {
                $payableOrReceiveable = 'Payable';
                $paymentOrReceived = 'Payment';
                $paymentOrReceivedReverse = 'Payment Received';
                $adjustmentStr = 'Adjustment';
            }
    
             $discount = DB::table('tbl_voucher_payment_vouchers')
                ->where('deleted', '=', 'No')
                ->where('status', '=', 'Active')
                ->where('type', '=', 'Discount')
                ->where('party_id', '=', $partyId)
                ->sum('amount');
    
            $adjustment = DB::table('tbl_voucher_payment_vouchers')
                ->where('deleted', '=', 'No')
                ->where('status', '=', 'Active')
                ->where('type', '=', $adjustmentStr)
                ->where('party_id', '=', $partyId)
                ->sum('amount');
    
            $payableOrReceiveableAmount = DB::table('tbl_voucher_payment_vouchers')
                ->where('deleted', '=', 'No')
                ->where('status', '=', 'Active')
                ->where('type', '=', $payableOrReceiveable)
                ->where('party_id', '=', $partyId)
                ->sum('amount');
    
            $paymentOrReceivedAmount = DB::table('tbl_voucher_payment_vouchers')
                ->where('deleted', '=', 'No')
                ->where('status', '=', 'Active')
                ->where('type', '=', $paymentOrReceived)
                ->where('party_id', '=', $partyId)
                ->sum('amount');
    
            $paymentOrReceivedAmountReverse = DB::table('tbl_voucher_payment_vouchers')
                ->where('deleted', '=', 'No')
                ->where('status', '=', 'Active')
                ->where('type', '=', $paymentOrReceivedReverse)
                ->where('party_id', '=', $partyId)
                ->sum('amount');
    
            if ($party->party_type == 'Customer' || $party->party_type == 'Walkin_Customer') {
                $payableOrReceiveableAmount += $paymentOrReceivedAmountReverse;
                $paymentOrReceivedAmount += $adjustment + $discount;
                $due = $payableOrReceiveableAmount - $paymentOrReceivedAmount;
            } elseif ($party->party_type == 'Investor' || $party->party_type == 'Supplier') {
                $payableOrReceiveableAmount += $paymentOrReceivedAmountReverse;
                $paymentOrReceivedAmount += $adjustment + $discount;
                $due = $payableOrReceiveableAmount - $paymentOrReceivedAmount;
            }
        }
    
        return $due; // Return the calculated due amount
    }
    
}
