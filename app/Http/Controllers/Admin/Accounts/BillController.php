<?php

namespace App\Http\Controllers\Admin\Accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bill\Bill;
use App\Models\Bill\BillDetails;
use App\Models\Bill\BillPayment;
use App\Models\Bill\BillPaymentDetails;
use App\Models\Accounts\ChartOfAccounts;
use App\Models\Crm\Party;
use App\Models\Accounts\Voucher;
use App\Models\Accounts\PaymentVoucher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDF;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Session;

class BillController extends Controller
{
    



    public function index(){
        return view('admin.account.bills.billView');
    }


    public function create(){
        $loggedWarehouseId=Session::get('companySettings')[0]['id'];
        $expense=ChartOfAccounts::where('name','=','Expense')->where('sister_concern_id','like',"%$loggedWarehouseId%")->first();
        $expense_id=$expense->id;
        $coas=ChartOfAccounts::where('deleted','=','No')->where('status','=','Active')->orderBy('code', 'asc')->where('sister_concern_id','like',"%$loggedWarehouseId%")->where('parent_id','=',$expense_id )->get();
        $suppliers=Party::where('party_type','=','Supplier')->where('deleted','=','No')->where('status','=','Active')->orderBy('id','DESC')->get();
        
        return view('admin.account.bills.billCreate',['coas'=>$coas,'suppliers'=>$suppliers]);
    }




    public function getBill(){
        $loggedWarehouseId=Session::get('companySettings')[0]['id'];
        $bills= DB::table('tbl_acc_bills')
            ->leftjoin('parties','parties.id','=','tbl_acc_bills.tbl_crm_vendor_id')
            ->select('tbl_acc_bills.*','parties.name','parties.contact')
            ->where('tbl_acc_bills.deleted','=','No')
            ->orderby('tbl_acc_bills.id','Desc')
            ->get();
        $output = array('data' => array());
        $paidAmount=0;
        $i=1;
        foreach ($bills as $bill) {
        $status = "";
        if($bill->status == 'Active'){
        $status = '<center><i class="fas fa-check-circle" style="color:green; font-size:16px;" title="'.$bill->status.'"></i></center>';
        }else{
        $status = '<center><i class="fas fa-times-circle" style="color:red; font-size:16px;" title="'.$bill->status.'"></i></center>';
        }

        $button = '<div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
            <i class="fas fa-cog"></i>  <span class="caret"></span></button>
            <ul class="dropdown-menu dropdown-menu-right" style="border: 1px solid gray;" role="menu">
            <li class="action"><a href="#/" onclick="seeBills('.$bill->id.')" class="btn"><i class="fas fa-print"></i> See Details </a></li>

        </li>

        </ul>
        </div>';         

        if($bill->payment_status == 'Due'){
            $paymentStatus='<span class="text-danger" >'.$bill->payment_status.'</span>';
        }else{
            $paymentStatus='<span class="text-success" >'.$bill->payment_status.'</span>';
        }

        $paidAmount=$bill->amount-$bill->due_amount;

        $output['data'][] = array(
        $i++. '<input type="hidden" name="id" id="id" value="'.$bill->id.'" />',
        $bill->code,
        '<b>Name: </b>'.$bill->name.'<br><b>Mobile: </b>'.$bill->contact,
        date("d-m-Y", strtotime($bill->transaction_date)),
        $bill->particulars,
        $bill->amount,
        $paidAmount,
        $paymentStatus,
        $status,
        $button
        );            
        }
        return $output;

    }





    public function store(Request $request){
        // return $request;
        $loggedWarehouseId=Session::get('companySettings')[0]['id'];
        $request->validate([ 
            'bill_date'             => 'required',
            'vendor_id'             => 'required',
            'reference'             => 'nullable',
            'particulars'           => 'nullable',
            'amountTotal'           => 'required'
        ]);
          
            $billNo = Bill::max('code');
			$billNo++;
			$billNo = str_pad($billNo, 6, '0', STR_PAD_LEFT);
        DB::beginTransaction();
        try {
            $bill = new Bill();
            $bill->code=$billNo;
            $bill->transaction_date=$request->bill_date;
            $bill->tbl_crm_vendor_id=$request->vendor_id;
            $bill->reference=$request->reference;
            $bill->particulars=$request->particulars;
            $bill->amount=$request->amountTotal;
            $bill->sister_concern_id=$loggedWarehouseId;
            $bill->due_amount=$request->amountTotal;
            $bill->payment_status="Due";
            $bill->deleted="No";
            $bill->status="Active";
            $bill->created_by=Auth::user()->id;
            $bill->created_date=date('Y-m-d h:s');
            $bill->save();
            $last_id=$bill->id;

            /* bill details */
            for($i=0;$i < count($request->account);$i++){
                $item_array = [
                    'tbl_acc_bill_id'       => $last_id,
                    'transaction_date'      => $request->bill_date,
                    'tbl_acc_coa_id'        => $request->account[$i],
                    'particulars'           => $request->particular[$i],
                    'amount'                => $request->amount[$i],
                    'deleted'               => 'No',
                    'status'                => 'Active',
                    'created_by'            => Auth::user()->id,
                    'created_date'          => date('Y-m-d h:s')
                ];
                DB::table('tbl_acc_bill_details')->insert($item_array);
            } 

            /* voucher entry */
            $voucher=new Voucher();
            $voucher->vendor_id=$request->vendor_id;
            $voucher->amount=$request->amountTotal;
            $voucher->transaction_date=$request->bill_date;
            $voucher->type_no=$last_id;
            $voucher->sister_concern_id=$loggedWarehouseId;
            $voucher->type='Bill created';
            $voucher->deleted="No";
            $voucher->status="Active";
            $voucher->created_by=Auth::user()->id;
            $voucher->created_date=date('Y-m-d h:s');
            $voucher->save();
            $voucherId=$voucher->id;

            /* voucher details entry */
            for($j=0;$j < count($request->account);$j++){  
                $item_array = [
                    'tbl_acc_voucher_id'    => $voucherId,
                    'tbl_acc_coa_id'        => $request->account[$j],
                    'debit'                 => $request->amount[$j],
                    'particulars'           => $request->particular[$j],
                    'voucher_title'         => 'Bill created with ID '.$bill->code,
                    'deleted'               => 'No',
                    'status'                => 'Active',
                    'created_by'            => Auth::user()->id,
                    'created_date'          => date('Y-m-d')
                ];
                DB::table('tbl_acc_voucher_details')->insert($item_array);

                $expense=ChartOfAccounts::find($request->account[$j]);
                $expense->increment('amount',$request->amount[$j]);
            }


            /* Payment voucher  */
            $maxCode = PaymentVoucher::max('voucherNo');
            $maxCode++;
            $maxCode=str_pad($maxCode, 6, '0', STR_PAD_LEFT);
            $PaymentVoucher = new PaymentVoucher();
            $PaymentVoucher->party_id = $request->vendor_id;
            $PaymentVoucher->voucherNo =$maxCode;
            $PaymentVoucher->amount =$request->amountTotal;
            $PaymentVoucher->created_by = Auth::user()->id;
            $PaymentVoucher->paymentDate = $request->bill_date;
            $PaymentVoucher->bill_id = $last_id;
            $PaymentVoucher->sister_concern_id=$loggedWarehouseId;
            $PaymentVoucher->type = "Payable";
            $PaymentVoucher->voucherType = "Bill";
            $PaymentVoucher->customerType = "Party";
            $PaymentVoucher->remarks = 'Bill created for billing ID '.$bill->code;
            $PaymentVoucher->deleted="No";
            $PaymentVoucher->status="Active";
            $PaymentVoucher->created_by=Auth::user()->id;
            $PaymentVoucher->created_date=date('Y-m-d h:s');
            $PaymentVoucher->save();

            $party=Party::find($request->vendor_id);
            $party->increment('current_due',$request->amountTotal);

            DB::commit();
            return  redirect('account/bills/view')->with('message','Bill saved sucessfully');
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Bill  rollBack ' . $e]);
        }  
    }






    public function seeDetails($id){
        
        $details = DB::table('tbl_acc_bill_details')
            ->leftjoin('tbl_acc_coas','tbl_acc_coas.id','=','tbl_acc_bill_details.tbl_acc_coa_id')
            ->select('tbl_acc_bill_details.*','tbl_acc_coas.name as coa_name')
            ->where('tbl_acc_bill_details.deleted','No')
            ->where('tbl_acc_bill_details.tbl_acc_bill_id', $id)
            ->get();
            
        $bills=Bill::find($id);
        $payment=0;
        $paymentDetails=BillPaymentDetails::where('tbl_acc_bill_id','=',$id)->get();
        foreach($paymentDetails as $payments){
            $payment +=$payments->amount;
        }
        $party=Party::find($bills->tbl_crm_vendor_id);
        $pdf = PDF::loadView('admin.account.bills.billPdf',  ['details'=>$details,'bills'=>$bills,'party'=>$party,'payment'=>$payment]);
        return $pdf->stream('bill-report-pdf.pdf', array("Attachment" => false)); 

    }












    public function payBills(){
        $loggedWarehouseId=Session::get('companySettings')[0]['id'];
        $expense=ChartOfAccounts::where('name','=','Expense')->where('deleted','=','No')->where('status','=','Active')->where('sister_concern_id','like',"%$loggedWarehouseId%")->first();
        $expense_id=$expense->id;
        $bank=ChartOfAccounts::where('name','=','Bank')->where('deleted','=','No')->where('status','=','Active')->where('sister_concern_id','like',"%$loggedWarehouseId%")->first();
        $bank_id=$bank->id;
        $coas=ChartOfAccounts::where('deleted','=','No')->where('status','=','Active')->where('sister_concern_id','like',"%$loggedWarehouseId%")->orderBy('code', 'asc')->where('parent_id','=',$expense_id )->get();
        $suppliers=Party::where('party_type','=','Supplier')->where('deleted','=','No')->where('status','=','Active')->get();
        $banks=ChartOfAccounts::where('deleted','=','No')->where('status','=','Active')->orderBy('code', 'asc')->where('parent_id','=',$bank_id )->where('name','!=','Cash')->get();
        $cashId=ChartOfAccounts::where('slug','=','cash-bank')->where('deleted','=','No')->where('status','=','Active')->where('sister_concern_id','like',"%$loggedWarehouseId%")->first();
        $paymentMethods=ChartOfAccounts::where('parent_id','=',$cashId->id)->where('deleted','=','No')->where('status','=','Active')->where('sister_concern_id','like',"%$loggedWarehouseId%")->get();
        return view('admin.account.bills.billPay',['coas'=>$coas,'suppliers'=>$suppliers,'banks'=>$banks,'paymentMethods'=>$paymentMethods]);
    }




    public function getBillData(Request $request){
        $loggedWarehouseId=Session::get('companySettings')[0]['id'];
        $bills=Bill::where('tbl_crm_vendor_id','=',$request->vendor_id)
                    ->where('payment_status','=','Due')
                    ->where('deleted','=','No')
                    ->where('status','=','Active')
                    ->get();
            $output='';
            $tfoot='';
            $totalAmount=0;

            foreach($bills as $bill){

            $output.='<tr class="row0">
                        <td class="text-center"><input type="hidden" name="billId[]" value='.$bill->id.'>'.$bill->id.'</td>
                        <td class="text-center"><input type="hidden" name="totalAmount[]" id="totalAmount" value='.$bill->amount.'>'.$bill->amount.'</td>
                        <td class="text-center"><input class="form-control" type="hidden" name="dueAmount[]" id="dueAmountInput" value='.$bill->due_amount.' style="text-align:right;"><span id="dueAmount">'.$bill->due_amount.'</span></td>
                        <td class="text-center"><input type="number" class="form-control" name="amount[]" id="amount"  oninput="totalBalance()" onchange="dueTotal()" style="text-align:right;" value='.$bill->due_amount.' ></td>
                        <td>
                            <label style="display:none;">.</label>
                            <a href="#/" class="text-danger" onclick="remove_btn(this)"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>';
                    $totalAmount += $bill->due_amount;
            }
            $tfoot .='<tr>
                        <td>#</td>
                        <td colspan="2" style="text-align:right;">Total:</td>
                        <td>
                            <input type="text" class="form-control" name="amountTotal" id="amountTotal"   style="text-align:right;" value='.$totalAmount.' readonly>
                        </td>
                        <td></td>
                    </tr>';
          $data =array(
            'output'    =>$output,
            'tfoot'     => $tfoot
          );
        return $data;
    }






public function billPayStore(Request $request){

        $request->validate([ 
            'payment_date'          => 'required',
            'vendor_id'             => 'required',
            'reference'             => 'nullable',
            'payment_method'        => 'required',
            'transaction_id'        => 'nullable',
        ]);

            $loggedWarehouseId=Session::get('companySettings')[0]['id'];
            $cash=ChartOfAccounts::where('slug','=','cash')
                                ->where('sister_concern_id','like',"%$loggedWarehouseId%")
                                ->where('deleted','=','No')
                                ->where('status','=','Active')
                                ->first();
            if($request->payment_method != $cash->id){
                $request->validate([
                    'sources' => 'required',
                    'account_status' => 'required'
                ]);
                $paymentMethod=ChartOfAccounts::find($request->payment_method);
                $source=ChartOfAccounts::find($request->sources);
                $account=ChartOfAccounts::find($request->account_status);
                $paymentMethodCOA=$account->id;
            }else{
                $paymentMethod=ChartOfAccounts::find($request->payment_method);
                $source='';
                $account='';
                $paymentMethodCOA=$paymentMethod->id;
            }


            
        DB::beginTransaction();
        try {    
            $billNo = BillPayment::max('code');
			$billNo++;
			$billNo = str_pad($billNo, 6, '0', STR_PAD_LEFT);

            $billPayments=new BillPayment();
            $billPayments->code=$billNo;
            $billPayments->tbl_acc_vendor_id=$request->vendor_id;
            $billPayments->payment_date=$request->payment_date;
            $billPayments->reference=$request->reference;
            $billPayments->payment_method=$paymentMethodCOA;
            $billPayments->account_status=$paymentMethod->id;
            $billPayments->sister_concern_id=$loggedWarehouseId;
            $billPayments->amount=$request->amountTotal;
            $billPayments->status="Active";
            $billPayments->deleted="No";
            $billPayments->save();
            $lastId=$billPayments->id;
        
            $paymentMethod->decrement('amount',$request->amountTotal);
    
        /* bill payment details */
        for($i=0;$i < count($request->billId);$i++){
            $item_array = [
                'tbl_acc_billPayment_id' => $lastId,
                'tbl_acc_bill_id'        => $request->billId[$i],
                'amount'                 => $request->amount[$i],
                'deleted'                => 'No',
                'status'                 => 'Active',
                'created_by'             => Auth::user()->id,
                'created_date'           => date('Y-m-d')
            ];
            DB::table('tbl_acc_bill_payment_details')->insert($item_array);
            
            if($request->amount == $request->dueAmount){
                $bills=Bill::find($request->billId[$i]);
                $bills->due_amount=$request->dueAmount[$i] - $request->amount[$i];
                $bills->payment_status='Paid';
                $bills->save();
            }else{
                $bills=Bill::find($request->billId[$i]);
                $bills->due_amount=$request->dueAmount[$i] - $request->amount[$i];
                $bills->payment_status='Due';
                $bills->save();
            }
        }
    
            $party= Party::find($request->vendor_id);
            $party->decrement('current_due', $request->amountTotal);
    
            $vouchers=new Voucher(); 
            $vouchers->vendor_id=$request->vendor_id;
            $vouchers->amount=$request->amountTotal;
            $vouchers->transaction_date=date('Y-m-d h:s');
            $vouchers->payment_method=$paymentMethodCOA;
            $vouchers->type_no=$lastId;
            $vouchers->sister_concern_id=$loggedWarehouseId;
            $vouchers->type='Bill paid';
            $vouchers->deleted="No";
            $vouchers->status="Active";
            $vouchers->created_by=Auth::user()->id;
            $vouchers->created_date=date('Y-m-d h:s');
            $vouchers->save();
            $voucherId=$vouchers->id;
   

            /* voucher details entry */
            for($j=0;$j < count($request->billId);$j++){  
                $item_array = [
                    'tbl_acc_voucher_id'    => $voucherId,
                    'tbl_acc_coa_id'        => $paymentMethodCOA,
                    'credit'                => $request->amount[$j],
                    'voucher_title'         => 'Bill paid with voucher '.$voucherId,
                    'deleted'               => 'No',
                    'status'                => 'Active',
                    'created_by'            => Auth::user()->id,
                    'created_date'          => date('Y-m-d')
                ];
                DB::table('tbl_acc_voucher_details')->insert($item_array);
            }

    
    

            /* Payment voucher  */
            $maxCode = PaymentVoucher::max('voucherNo');
            $maxCode++;
            $maxCodes=str_pad($maxCode, 6, '0', STR_PAD_LEFT);
            $PaymentVoucher = new PaymentVoucher();
            $PaymentVoucher->party_id = $request->vendor_id;
            $PaymentVoucher->voucherNo =$maxCodes;
            $PaymentVoucher->amount =$request->amountTotal;
            $PaymentVoucher->payment_method = $paymentMethod->name;
            $PaymentVoucher->source = $source->name ?? '';
            $PaymentVoucher->account = $account->name ?? '';
            
            $PaymentVoucher->payment_method_coa_id = $request->payment_method;
            if($request->payment_method != $cash->id){
                $PaymentVoucher->source_coa_id = $request->sources;
                $PaymentVoucher->account_coa_id = $request->account_status;
            }
            
            $PaymentVoucher->accountNo =$paymentMethod->id;
            $PaymentVoucher->created_by = Auth::user()->id;
            $PaymentVoucher->paymentDate = $request->payment_date;
            $PaymentVoucher->bill_id = $lastId;
            $PaymentVoucher->sister_concern_id=$loggedWarehouseId;
            $PaymentVoucher->type = "Payment";
            $PaymentVoucher->voucherType = "Bill Payment";
            $PaymentVoucher->customerType = "Party";
            $PaymentVoucher->remarks = "Bill paid for bill no ".$billNo;
            $PaymentVoucher->deleted="No";
            $PaymentVoucher->status="Active";
            $PaymentVoucher->created_by=Auth::user()->id;
            $PaymentVoucher->created_date=date('Y-m-d h:s');
            $PaymentVoucher->save();

            DB::commit();
            return  redirect('account/bills/view')->with('message','Bill paid successfully');
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Bill  rollBack ' . $e]);
        } 
     
}



    public function partyDue(Request $request){
        $party=Party::find($request->vendor_id);
        return $party;
    }




    public function getBillsources(Request $request){
        $loggedWarehouseId=Session::get('companySettings')[0]['id'];
            $method=ChartOfAccounts::find($request->payment_method);
            $sources=ChartOfAccounts::where('parent_id','=',$request->payment_method)
                                        ->where('deleted','=','No')
                                        ->where('status','=','Active')
                                        ->where('sister_concern_id','like',"%$loggedWarehouseId%")
                                        ->get();
            $data='';
            $data .='<option value=""selected >Select Source</option>';
            foreach($sources as $source){
                $data.='<option value="'.$source->id.'">'.$source->name.'</option>';
            }
            $cashAmount=0;
            if($method->slug == 'cash'){
                $cashAmount=$method->amount;
            }
            $output=array(
                'method_slug'=>$method->slug,
                'data'=>$data,
                'cash_amount'=>$cashAmount
            );
            return $output;
    }


}