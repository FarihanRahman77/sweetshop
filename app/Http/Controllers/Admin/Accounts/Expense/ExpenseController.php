<?php

namespace App\Http\Controllers\Admin\Accounts\Expense;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Accounts\ChartOfAccounts;
use App\Models\Expense\Expense;
use App\Models\Crm\Party;
use App\Models\Expense\ExpenseDetails;
use App\Models\Accounts\Voucher;
use App\Models\Accounts\VoucherDetails;
use App\Models\Accounts\PaymentVoucher;
use App\Models\payroll\OurTeam;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Report\DailyReport;
use App\Models\Bill\BillPaymentDetails;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;


class ExpenseController extends Controller
{

        public function index(){
            return view('admin.account.expense.expenseView');
        }



        public function getExpense(){
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
        $expenses= DB::table('tbl_acc_expenses')
                    ->leftjoin('our_teams', 'tbl_acc_expenses.tbl_crm_vendor_id', '=', 'our_teams.id')
                    ->select('tbl_acc_expenses.*','our_teams.member_name')
                    ->where('tbl_acc_expenses.sister_concern_id','=',$logged_sister_concern_id)
                    ->where('tbl_acc_expenses.deleted','=','No')
                    ->orderby('tbl_acc_expenses.id','Desc')
                    ->get();

        $output = array('data' => array());
        $i=1;

        foreach($expenses as $expense) {
            $status = "";
            if($expense->status == 'Active'){
                $status = '<center><i class="fas fa-check-circle" style="color:green; font-size:16px;" title="'.$expense->status.'"></i></center>';
            }else{
                $status = '<center><i class="fas fa-times-circle" style="color:red; font-size:16px;" title="'.$expense->status.'"></i></center>';
            }
			
            $button = '<div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <i class="fas fa-cog"></i>  
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-right" style="border: 1px solid gray;" role="menu">
                    <li class="action">
                        <a href="#/" onclick="seeExpense('.$expense->id.')" class="btn">
                            <i class="fa fa-file-pdf"></i> See Details 
                        </a>
                    </li>
                    <li class="action">
                        <a href="#/" onclick="deleteExpense('.$expense->id.')" class="btn">
                            <i class="fa fa-trash"></i> Delete 
                        </a>
                    </li>
                </ul>
            </div>';       
			$output['data'][] = array(
				$i++. '<input type="hidden" name="id" id="id" value="'.$expense->id.'" />',
				$expense->expense_no,
				$expense->member_name,
				$expense->transaction_date,
				$expense->particulars,
				$expense->amount,
				$status,
				$button
			);            
        }
        return $output;
        }








        public function create(){
            $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
            $expense=ChartOfAccounts::where('name','=','Expense')->where('sister_concern_id','like',"%$logged_sister_concern_id%")->where('deleted','=','No')->where('status','=','Active')->first();

            $expense_id=$expense->id;
            $bank=ChartOfAccounts::where('name','=','Bank')->where('sister_concern_id','like',"%$logged_sister_concern_id%")->where('deleted','=','No')->where('status','=','Active')->first();
            $bank_id=$bank->id;
            $coas=ChartOfAccounts::where('parent_id','=',$expense_id)->where('deleted','=','No')
                                    ->where('status','=','Active')
                                    ->orderBy('our_code', 'asc')
                                    ->where('sister_concern_id','like',"%$logged_sister_concern_id%")
                                    ->get();

            $suppliers=OurTeam::where('deleted','=','No')->where('status','=','Active')->get();
            $banks=ChartOfAccounts::where('deleted','=','No')->where('sister_concern_id','like',"%$logged_sister_concern_id%")->where('status','=','Active')->orderBy('id', 'asc')->where('parent_id','=',$bank_id )->where('name','!=','Cash')->get();
            $cashId=ChartOfAccounts::where('name','=','Cash')->where('sister_concern_id','like',"%$logged_sister_concern_id%")->where('deleted','=','No')->where('status','=','Active')->first();
            $transaction_method =ChartOfAccounts::where('slug','=','cash-bank')->where('sister_concern_id','like',"%$logged_sister_concern_id%")->where('deleted','=','No')->where('status','=','Active')->first();
            $methods =ChartOfAccounts::where('parent_id','=',$transaction_method->id)->where('sister_concern_id','like',"%$logged_sister_concern_id%")->where('deleted','=','No')->where('status','=','Active')->get();
        
            return view('admin.account.expense.expenseCreate',['coas'=>$coas,'suppliers'=>$suppliers,'methods'=>$methods,'cashId'=>$cashId,'loggedWarehouseId'=>$logged_sister_concern_id]);
        }








        public function getAccountStatus(Request $request){
                $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
                $coas=ChartOfAccounts::where('deleted','=','No')
                        ->where('status','=','Active')
                        ->orderBy('code', 'asc')
                        ->where('parent_id','=',$request->payment_method)
                        ->where('sister_concern_id','like',"%$logged_sister_concern_id%")
                        ->get();

                $coa_data="<option value='' selected disabled> Select accounts</option  >";
                foreach($coas as $coa){
                    $coa_data.="<option value='".$coa->id."'>".$coa->name."</option>";
                } 

                $status=$coa_data;

                $data=array(
                    'status'=>$status
                );

           return $data;
        }







        public function getAmount(Request $request){
            $coas=ChartOfAccounts::find($request->account_status); 
            return $coas->amount;
        }




        public function store(Request $request){
           
            $request->validate([   
                'transaction_date'      => 'required',
                'vendor_id'             => 'required',
                'account.*'             => ['required'],
                'reference'             => 'nullable',
                'particulars'           => 'nullable',
                'payment_method'        => 'required',
                'credit_amount'         => 'numeric',
                'address'               => 'nullable'
            ]);
            $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
            $cash=ChartOfAccounts::where('slug','=','cash')
                                ->where('sister_concern_id','like',"%$logged_sister_concern_id%")
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
                $expenseCode = Expense::max('expense_no');
                $expenseCode++;
                $expenseCode=str_pad($expenseCode, 6, '0', STR_PAD_LEFT);
                $expense = new Expense();
                $expense->expense_no=$expenseCode;
                $expense->transaction_date=$request->transaction_date;
                // $expense->from_warehouse=$loggedWarehouseId;
                $expense->sister_concern_id=$logged_sister_concern_id;
                $expense->tbl_crm_vendor_id=$request->vendor_id;
                $expense->reference=$request->reference;
                $expense->particulars=$request->particulars;
                $expense->payment_method=$paymentMethodCOA;
                $expense->amount=$request->amountTotal;
                $expense->taxable_amountTotal=$request->taxable_amountTotal;
                $expense->transaction_no=$request->transaction_id;
                $expense->address=$request->address;
                $expense->deleted="No";
                $expense->status="Active";
                $expense->created_by=Auth::user()->id;
                $expense->created_date=date('Y-m-d h:s');
                $expense->save();  
                $last_id=$expense->id;
    
                /* add to expense details */
                for($i=0;$i < count($request->account);$i++){
                    $item_array = [
                        'tbl_acc_expense_id'    => $last_id,
                        'tbl_acc_coa_id'        => $request->account[$i],
                        'particulars'           => $request->particular[$i],
                        'amount'                => $request->amount[$i],
                        'taxable_amount'        => $request->taxable_amount[$i],
                        'warehouse_id'          => $loggedWarehouseId,
                        'deleted'               => 'No',
                        'status'                => 'Active',
                        'created_by'            => Auth::user()->id,
                        'created_date'          => date('Y-m-d h:s')
                      ];
                    DB::table('tbl_acc_expense_details')->insert($item_array);
                }
    
                /* add to voucher */
                $voucher=new Voucher();
                $voucher->vendor_id=0;
                $voucher->amount=$request->amountTotal;
                $voucher->transaction_date=$request->transaction_date;
                $voucher->payment_method=$paymentMethodCOA;
                $voucher->type_no=$last_id;
                $voucher->type='Expense';
                // $voucher->warehouse_id=$loggedWarehouseId;
                $voucher->sister_concern_id=$logged_sister_concern_id;
                $voucher->deleted="No";
                $voucher->status="Active";
                $voucher->created_by=Auth::user()->id;
                $voucher->created_date=date('Y-m-d h:s');
                $voucher->save();
                $voucherId=$voucher->id;
    
                /* voucher details table entry */
                for($j=0;$j < count($request->account);$j++){  
                    $item_array = [
                        'tbl_acc_voucher_id'    => $voucherId,
                        'tbl_acc_coa_id'        => $request->account[$j],
                        'debit'                 => $request->amount[$j],
                        'particulars'           => $request->particular[$j],
                        'warehouse_id'           => $loggedWarehouseId,
                        'voucher_title'         => 'Expense created with voucher '.$expenseCode,
                        'deleted'               => 'No',
                        'status'                => 'Active',
                        'created_by'            => Auth::user()->id,
                        'created_date'          => date('Y-m-d h:s')
                        ];
                        DB::table('tbl_acc_voucher_details')->insert($item_array);
    
                        $expense=ChartOfAccounts::find($request->account[$j]);
                        $expense->increment('amount',$request->amount[$j]);
                }

                $item_array_single=[
                    'tbl_acc_voucher_id'    => $voucherId,
                    'tbl_acc_coa_id'        => $paymentMethodCOA,
                    'credit'                 => $request->amountTotal,
                    'warehouse_id'          => $loggedWarehouseId,
                    'voucher_title'         => 'Expense paid with voucher '.$expenseCode,
                    'deleted'               => 'No',
                    'status'                => 'Active',
                    'created_by'            => Auth::user()->id,
                    'created_date'          => date('Y-m-d h:s')
                  ];
                  DB::table('tbl_acc_voucher_details')->insert($item_array_single);
                  
                $cashId=ChartOfAccounts::where('slug','=','Cash')->where('sister_concern_id','like',"%$logged_sister_concern_id%")->where('deleted','=','No')->where('status','=','Active')->first()->id;
                   if($request->payment_method == $cashId){
                    $expense=ChartOfAccounts::find($request->payment_method);
                    $expense->decrement('amount',$request->amountTotal);
                   }else{
                    $expense=ChartOfAccounts::find($request->account_status);
                    $expense->decrement('amount',$request->amountTotal);
                   }
                    
    
                    /* Payment voucher  */
                    $maxCode = PaymentVoucher::max('voucherNo');
                    $maxCode++;
                    $maxCodes=str_pad($maxCode, 6, '0', STR_PAD_LEFT);
                    $PaymentVoucher = new PaymentVoucher();
                    $PaymentVoucher->party_id = 0;
                    $PaymentVoucher->voucherNo =$maxCodes;
                    $PaymentVoucher->amount =$request->amountTotal;
                    $PaymentVoucher->accountNo =$request->account_status;
                    $PaymentVoucher->created_by = Auth::user()->id;
                    $PaymentVoucher->payment_method = $paymentMethod->name;
                    $PaymentVoucher->source = $source->name ?? '';
                    $PaymentVoucher->account = $account->name ?? '';
                    
                    $PaymentVoucher->payment_method_coa_id =$request->payment_method ?? '';
                    $PaymentVoucher->source_coa_id = $request->sources ?? '0';
                    $PaymentVoucher->account_coa_id = $request->account_status ?? '0';
                    $PaymentVoucher->voucherType = 'Voucher';
                    
                    $PaymentVoucher->paymentDate = $request->transaction_date;
                    $PaymentVoucher->expense_id = $last_id;
                    $PaymentVoucher->warehouse_id = $loggedWarehouseId;
                    $PaymentVoucher->type = "Payment";
                    $PaymentVoucher->voucherType = "Expense";
                    $PaymentVoucher->customerType = "Party";
                    
                    $PaymentVoucher->remarks = 'Voucher Entry for Expense Code: '.$expenseCode.' ( '.$request->particulars.' )';
                    
                    $PaymentVoucher->deleted="No";
                    $PaymentVoucher->status="Active";
                    $PaymentVoucher->created_by=Auth::user()->id;
                    $PaymentVoucher->entryBy=Auth::user()->id;
                    $PaymentVoucher->created_date=date('Y-m-d h:s');
                    $PaymentVoucher->save();

                    DB::commit();
                    return  redirect('expense/View/')->with('message','Expense saved sucessfully');
                } catch (Exception $e) {
                    DB::rollBack();
                    return response()->json(['error' => 'Purchase rollBack!']);
                }
                
             
            }
            

        








    public function seeDetails($id){
        $loggedWarehouseId=Session::get('warehouse')[0]['id'];
        $details = DB::table('tbl_acc_expense_details')
            ->leftjoin('tbl_acc_coas','tbl_acc_coas.id','=','tbl_acc_expense_details.tbl_acc_coa_id')
            ->select('tbl_acc_expense_details.*','tbl_acc_coas.name as coa_name')
            ->where('tbl_acc_expense_details.deleted','No')
            ->where('tbl_acc_expense_details.tbl_acc_expense_id', $id)
            ->get();
        $expenses=Expense::find($id);
        $party= OurTeam::find($expenses->tbl_crm_vendor_id);
        $pdf = PDF::loadView('admin.account.expense.expensePdf',  ['details'=>$details,'expenses'=>$expenses,'party'=>$party]);
        return $pdf->stream('expense-report-pdf.pdf', array("Attachment" => false));
    }
    


    public function reportView()
    {
        return view('admin.reports.expenses.expenseReportGenerate');
    }




    
    public function expenseReportGenerate(Request $request)
    {
        $loggedWarehouseId=Session::get('warehouse')[0]['id'];
        $request->validate([
            'dateFrom' => 'required',
        ]);

        $expenses = DB::table('payment_vouchers')
            ->leftjoin('purchases', 'payment_vouchers.purchase_id', '=', 'purchases.id')
            ->leftjoin('sales', 'payment_vouchers.sales_id', '=', 'sales.id')
            ->leftjoin('parties', 'payment_vouchers.party_id', '=', 'parties.id')
            ->select('payment_vouchers.*', 'sales.grand_total', 'sales.current_payment', 'purchases.total_amount', 'parties.name', 'parties.address')
            ->where('payment_vouchers.deleted', 'No')
            ->where('payment_vouchers.paymentDate', '=', $request->dateFrom)
            ->where('payment_vouchers.warehouse_id', '=', $loggedWarehouseId)
            ->where('payment_vouchers.status', 'Active')
            ->where('payment_vouchers.payment_method', 'Cash')
            ->where(function ($query) {
                $query->where('payment_vouchers.type', 'Payment')
                    ->orWhere('payment_vouchers.type', 'Payment Received');
                    //->orWhere('payment_vouchers.type', 'Party Payable');
            })
            ->get();

        
        $button = '';
        $cashIn = 0;
        $cashOut = 0;
        $balance = 0;
        
        $info = "";
        $i = 1;
        $reportDetails='';
        $seeDetails='';
        foreach ($expenses as $report) {

            if($report->voucherType == 'Expense'){
                $expense_details = DB::table('tbl_acc_expense_details')
                            ->leftjoin('tbl_acc_coas','tbl_acc_coas.id','=','tbl_acc_expense_details.tbl_acc_coa_id')
                            ->select('tbl_acc_expense_details.*','tbl_acc_coas.name as coa_name')
                            ->where('tbl_acc_expense_details.deleted','No')
                            ->where('tbl_acc_expense_details.tbl_acc_expense_id', $report->expense_id)
                            ->get();
                $a=1;
                $reportDetails='';
                foreach($expense_details as  $expense_detail){
                    $reportDetails.=$a++.' . '.$expense_detail->coa_name . '('.$expense_detail->particulars.')<br>';
                } 
                $seeDetails='expenseDetails('.$report->expense_id.')';
            }elseif($report->voucherType == 'Bill Payment'){
                 $bill_payment_details = DB::table('tbl_acc_bill_details')
                            ->join('tbl_acc_bill_payment_details','tbl_acc_bill_details.tbl_acc_bill_id','=','tbl_acc_bill_payment_details.tbl_acc_bill_id')
                            ->leftjoin('tbl_acc_coas','tbl_acc_coas.id','=','tbl_acc_bill_details.tbl_acc_coa_id','tbl_acc_bill_details.particulars')
                            ->select('tbl_acc_bill_details.*','tbl_acc_coas.name as coa_name')
                            ->where('tbl_acc_bill_details.deleted','=','No')
                            ->where('tbl_acc_bill_details.status','=','Active')
                            ->where('tbl_acc_bill_payment_details.tbl_acc_billPayment_id','=', $report->bill_id)
                            ->get();
                $b=1;
                $reportDetails='';
                foreach($bill_payment_details as  $bill_payment_detail){
                    $reportDetails.=$b++.' . '.$bill_payment_detail->coa_name.  '('.$bill_payment_detail->particulars.')<br>';
                }
                $billId=BillPaymentDetails::where('tbl_acc_billPayment_id','=',$report->bill_id)->first()->tbl_acc_bill_id;
                if($billId){
                    $seeDetails='billDetails('.$billId.')';
                }
            }elseif($report->voucherType == 'Applicant Order' || $report->voucherType == 'Vendor Order'){
                $orderDetails=DB::table('sale_order_products')
                                ->leftJoin('products', 'sale_order_products.product_id', '=', 'products.id')
                                ->select('sale_order_products.*','products.name as product_name')
                                ->where('sale_order_products.deleted','=','No')
                                ->where('products.deleted','=','No')
                                ->where('products.status','=','Active')
                                ->where('sale_order_products.tbl_sale_orders_id','=',$report->order_sale_id)
                                ->get();
                $c=1;
                $reportDetails='';
                foreach($orderDetails as  $orderDetail){
                    $reportDetails.=$c++.' . '.$orderDetail->product_name. '<br>';
                }
                $seeDetails='orderDetails('.$report->order_sale_id.')';
            }else{
                $reportDetails='';
                $seeDetails='';
            }

            if ($report->type == "Payment") {
                $cashOut += $report->amount;
                $balance -= $report->amount;
                $info .= '<tr>
                            <td class="text-center">' . $i++ . '</td>' .
                            '<td class="text-left"><a href="#"  onclick="'.$seeDetails.'">'. $report->remarks . '<br>' . $report->name . ' | ' . $report->address . '</a></td>' .
                            '<td class="text-center">' . $reportDetails . '</td>' .
                            '<td class="text-center">' . $report->voucherNo . '</td>' .
                            '<td></td>' .
                            '<td class="text-right">' . $report->amount . '</td>' .
                            '<td class="text-right">' . number_format($balance) . '</td>' .
                        '</tr>';
            } else if ($report->type == "Payment Received") {
                $cashIn += $report->amount;
                $balance += $report->amount;
                $info .= '<tr>
                            <td class="text-center">' . $i++ . '</td>' .
                    '<td class="text-left"><a href="#"  onclick="'.$seeDetails.'">' . $report->remarks . '<br>'  . $report->name . ' | ' . $report->address . '</a></td>' .
                    '<td class="text-center">' . $reportDetails . '</td>' .
                    '<td class="text-center">' . $report->voucherNo . '</td>' .
                    '<td class="text-right">' . $report->amount . '</td>' .
                    '<td></td>' .
                    '<td class="text-right">' . number_format($balance) . '</td>' .
                    '</tr>';
            } else {
                $info .= '<tr>
                            <td class="text-center">' . $i++ . '</td>' .
                    '<td class="text-left"><a href="#"  onclick="'.$seeDetails.'">' . $report->remarks . '<br>' . $report->name . ' | ' . $report->address . '</a></td>' .
                    '<td class="text-center">' . $reportDetails . '</td>' .
                    '<td class="text-center">' . $report->voucherNo . '</td>' .
                    '<td class="text-right"></td>' .
                    '<td></td>' .
                    '<td class="text-right"></td>' .
                    '</tr>';
            }
           
        }
        
        
        



        $todayBankReports = DB::table('payment_vouchers')
                        ->leftjoin('purchases', 'payment_vouchers.purchase_id', '=', 'purchases.id')
                        ->leftjoin('sales', 'payment_vouchers.sales_id', '=', 'sales.id')
                        ->leftjoin('parties', 'payment_vouchers.party_id', '=', 'parties.id')
                        ->select('payment_vouchers.*', 'sales.grand_total', 'sales.current_payment', 'purchases.total_amount', 'parties.name', 'parties.address')
                        ->where('payment_vouchers.deleted', 'No')
                        ->where('payment_vouchers.paymentDate', '=', $request->dateFrom)
                        ->where('payment_vouchers.warehouse_id', '=', $loggedWarehouseId)
                        ->where('payment_vouchers.status', 'Active')
                        ->where('payment_vouchers.payment_method', 'Bank')
                    ->where(function ($query) {
                        $query->where('payment_vouchers.type', 'Payment')
                            ->orWhere('payment_vouchers.type', 'Payment Received');
                    })
                    ->get();


        $todayMobileBankingReports = DB::table('payment_vouchers')
                        ->leftjoin('purchases', 'payment_vouchers.purchase_id', '=', 'purchases.id')
                        ->leftjoin('sales', 'payment_vouchers.sales_id', '=', 'sales.id')
                        ->leftjoin('parties', 'payment_vouchers.party_id', '=', 'parties.id')
                        ->select('payment_vouchers.*', 'sales.grand_total', 'sales.current_payment', 'purchases.total_amount', 'parties.name', 'parties.address')
                        ->where('payment_vouchers.deleted', 'No')
                        ->where('payment_vouchers.paymentDate', '=', $request->dateFrom)
                        ->where('payment_vouchers.warehouse_id', '=', $loggedWarehouseId)
                        ->where('payment_vouchers.status', 'Active')
                        ->where('payment_vouchers.payment_method', 'Mobile Banking')
                    ->where(function ($query) {
                        $query->where('payment_vouchers.type', 'Payment')
                            ->orWhere('payment_vouchers.type', 'Payment Received');
                    })
                    ->get();

        $cashInBank = 0;
        $cashOutBank = 0;
        $balanceBank = 0;
        
        $infoBank = "";
        
        $iBank = 1;      
        foreach ($todayBankReports as $todayBankReport){
            if($todayBankReport->voucherType == 'Expense'){
                $bank_expense_details = DB::table('tbl_acc_expense_details')
                            ->leftjoin('tbl_acc_coas','tbl_acc_coas.id','=','tbl_acc_expense_details.tbl_acc_coa_id')
                            ->select('tbl_acc_expense_details.*','tbl_acc_coas.name as coa_name')
                            ->where('tbl_acc_expense_details.deleted','No')
                            ->where('tbl_acc_expense_details.tbl_acc_expense_id',$todayBankReport->expense_id)
                            ->get();
                $bank_a=1;
                $bank_reportDetails='';
                foreach($bank_expense_details as  $bank_expense_detail){
                    $bank_reportDetails.=$bank_a++.' . '.$bank_expense_detail->coa_name. '('.$bank_expense_detail->particulars.')<br>';
                } 
                $bank_seeDetails='expenseDetails('.$todayBankReport->expense_id.')';
            }elseif($todayBankReport->voucherType == 'Bill Payment'){
                 $bank_bill_payment_details = DB::table('tbl_acc_bill_details')
                            ->join('tbl_acc_bill_payment_details','tbl_acc_bill_details.tbl_acc_bill_id','=','tbl_acc_bill_payment_details.tbl_acc_bill_id')
                            ->leftjoin('tbl_acc_coas','tbl_acc_coas.id','=','tbl_acc_bill_details.tbl_acc_coa_id')
                            ->select('tbl_acc_bill_details.*','tbl_acc_coas.name as coa_name','tbl_acc_bill_details.particulars')
                            ->where('tbl_acc_bill_details.deleted','=','No')
                            ->where('tbl_acc_bill_details.status','=','Active')
                            ->where('tbl_acc_bill_payment_details.tbl_acc_billPayment_id','=', $todayBankReport->bill_id)
                            ->get();
                $bank_b=1;
                $bank_reportDetails='';
                foreach($bank_bill_payment_details as  $bank_bill_payment_detail){
                    $bank_reportDetails.=$bank_b++.' . '.$bank_bill_payment_detail->coa_name. '('.$bank_bill_payment_detail->particulars.')<br>';
                }
                $bank_billId=BillPaymentDetails::where('tbl_acc_billPayment_id','=',$todayBankReport->bill_id)->first()->tbl_acc_bill_id;
                if($bank_billId){
                    $bank_seeDetails='billDetails('.$bank_billId.')';
                }
            }elseif($todayBankReport->voucherType == 'Applicant Order' || $todayBankReport->voucherType == 'Vendor Order'){
                $bank_orderDetails=DB::table('sale_order_products')
                                ->leftJoin('products', 'sale_order_products.product_id', '=', 'products.id')
                                ->select('sale_order_products.*','products.name as product_name')
                                ->where('sale_order_products.deleted','=','No')
                                ->where('products.deleted','=','No')
                                ->where('products.status','=','Active')
                                ->where('sale_order_products.tbl_sale_orders_id','=',$todayBankReport->order_sale_id)
                                ->get();
                $bank_c=1;
                $bank_reportDetails='';
                foreach($bank_orderDetails as  $bank_orderDetail){
                    $bank_reportDetails.=$bank_c++.' . '.$bank_orderDetail->product_name. '<br>';
                }
                $bank_seeDetails='orderDetails('.$todayBankReport->order_sale_id.')';
            }else{
                $bank_reportDetails='';
                $bank_seeDetails='';
            }
                if ($todayBankReport->type == "Payment") {
                    $cashOutBank += $todayBankReport->amount;
                    $balanceBank -= $todayBankReport->amount;
                    $infoBank .= '<tr>
                                <td class="text-center">' . $iBank++ . '</td>' .
                                '<td class="text-left"><a href="#"  onclick="'.$bank_seeDetails.'">' . $todayBankReport->remarks . '<br>' . $todayBankReport->name . ' | ' . $todayBankReport->address . '</a></td>' .
                                '<td class="text-center">' . $bank_reportDetails . '</td>' .
                                '<td class="text-center">' . $todayBankReport->voucherNo . '</td>' .
                                '<td></td>' .
                                '<td class="text-right">' . $todayBankReport->amount . '</td>' .
                                '<td class="text-right">' . number_format($balanceBank) . '</td>' .
                            '</tr>';
                }else if($todayBankReport->type == "Payment Received"){
                    $cashInBank += $todayBankReport->amount;
                    $balanceBank += $todayBankReport->amount;
                    $infoBank .= '<tr>
                                <td class="text-center">' . $i++ . '</td>' .
                        '<td class="text-left"><a href="#"  onclick="'.$bank_seeDetails.'">' . $todayBankReport->remarks . '<br>' . $todayBankReport->name . ' | ' . $todayBankReport->address . '</a></td>' .
                        '<td class="text-center">' . $bank_reportDetails . '</td>' .
                        '<td class="text-center">' . $todayBankReport->voucherNo . '</td>' .
                        '<td class="text-right">' . $todayBankReport->amount . '</td>' .
                        '<td></td>' .
                        '<td class="text-right">' . number_format($balanceBank) . '</td>' .
                        '</tr>';
                }else{
                    $infoBank .= '<tr>
                                <td class="text-center">' . $i++ . '</td>' .
                                '<td class="text-left"><a href="#"  onclick="'.$bank_seeDetails.'">' . $todayBankReport->remarks . '<br>' . $todayBankReport->name . ' | ' . $todayBankReport->address . '</a></td>' .
                                '<td class="text-center">' . $bank_reportDetails . '</td>' .
                                '<td class="text-center">' . $todayBankReport->voucherNo . '</td>' .
                                '<td class="text-right"></td>' .
                                '<td></td>' .
                                '<td class="text-right"></td>' .
                        '</tr>';
                } 
        }

        $cashInMobileBanking = 0;
        $cashOutMobileBanking = 0;
        $balanceMobileBanking = 0;
        $infoMobileBanking = "";
        $iMobileBanking = 1;
        foreach ($todayMobileBankingReports as $todayMobileBankingReport){

            if($todayMobileBankingReport->voucherType == 'Expense'){
                $mobile_bank_expense_details = DB::table('tbl_acc_expense_details')
                            ->leftjoin('tbl_acc_coas','tbl_acc_coas.id','=','tbl_acc_expense_details.tbl_acc_coa_id')
                            ->select('tbl_acc_expense_details.*','tbl_acc_coas.name as coa_name')
                            ->where('tbl_acc_expense_details.deleted','No')
                            ->where('tbl_acc_expense_details.tbl_acc_expense_id',$todayMobileBankingReport->expense_id)
                            ->get();
                $mobile_bank_a=1;
                $mobile_bank_reportDetails='';
                foreach($mobile_bank_expense_details as  $mobile_bank_expense_detail){
                    $mobile_bank_reportDetails.=$mobile_bank_a++.' . '.$mobile_bank_expense_detail->coa_name. '('.$mobile_bank_expense_detail->particulars.')<br>';
                } 
                $mobile_bank_seeDetails='expenseDetails('.$todayMobileBankingReport->order_sale_id.')';
            }elseif($todayMobileBankingReport->voucherType == 'Bill Payment'){
                 $mobile_bank_bill_payment_details = DB::table('tbl_acc_bill_details')
                            ->join('tbl_acc_bill_payment_details','tbl_acc_bill_details.tbl_acc_bill_id','=','tbl_acc_bill_payment_details.tbl_acc_bill_id')
                            ->leftjoin('tbl_acc_coas','tbl_acc_coas.id','=','tbl_acc_bill_details.tbl_acc_coa_id','tbl_acc_bill_details.particulars')
                            ->select('tbl_acc_bill_details.*','tbl_acc_coas.name as coa_name')
                            ->where('tbl_acc_bill_details.deleted','=','No')
                            ->where('tbl_acc_bill_details.status','=','Active')
                            ->where('tbl_acc_bill_payment_details.tbl_acc_billPayment_id','=', $todayMobileBankingReport->bill_id)
                            ->get();
                $mobile_bank_b=1;
                $mobile_bank_reportDetails='';
                foreach($mobile_bank_bill_payment_details as  $mobile_bank_bill_payment_detail){
                    $mobile_bank_reportDetails.=$mobile_bank_b++.' . '.$mobile_bank_bill_payment_detail->coa_name. '('.$mobile_bank_bill_payment_detail->particulars.')<br>';
                }
                $mobile_bank_billId=BillPaymentDetails::where('tbl_acc_billPayment_id','=',$todayMobileBankingReport->bill_id)->first()->tbl_acc_bill_id;
                if($mobile_bank_billId){
                    $mobile_bank_seeDetails='billDetails('.$mobile_bank_billId.')';
                }
            }elseif($todayMobileBankingReport->voucherType == 'Applicant Order' || $todayMobileBankingReport->voucherType == 'Vendor Order'){
                $mobile_bank_orderDetails=DB::table('sale_order_products')
                                ->leftJoin('products', 'sale_order_products.product_id', '=', 'products.id')
                                ->select('sale_order_products.*','products.name as product_name')
                                ->where('sale_order_products.deleted','=','No')
                                ->where('products.deleted','=','No')
                                ->where('products.status','=','Active')
                                ->where('sale_order_products.tbl_sale_orders_id','=',$todayMobileBankingReport->order_sale_id)
                                ->get();
                $mobile_bank_c=1;
                $mobile_bank_reportDetails='';
                foreach($mobile_bank_orderDetails as  $mobile_bank_orderDetail){
                    $mobile_bank_reportDetails.=$mobile_bank_c++.' . '.$mobile_bank_orderDetail->product_name. '<br>';
                }
                $mobile_bank_seeDetails='orderDetails('.$todayMobileBankingReport->order_sale_id.')';
            }else{
                $mobile_bank_reportDetails='';
                $mobile_bank_seeDetails='';
            }

            if ($todayMobileBankingReport->type == "Payment") {
                $cashOutMobileBanking  += $todayMobileBankingReport->amount;
                $balanceMobileBanking  -= $todayMobileBankingReport->amount;
                $infoMobileBanking  .= '<tr>
                            <td class="text-center">' . $iMobileBanking++ . '</td>' .
                            '<td class="text-left"><a href="#"  onclick="'.$mobile_bank_seeDetails.'">' . $todayMobileBankingReport->remarks . '<br>' . $todayMobileBankingReport->name . ' | ' . $todayMobileBankingReport->address . '</a></td>' .
                            '<td class="text-center">' . $mobile_bank_reportDetails . '</td>' .
                            '<td class="text-center">' . $todayMobileBankingReport->voucherNo . '</td>' .
                            '<td></td>' .
                            '<td class="text-right">' . $todayMobileBankingReport->amount . '</td>' .
                            '<td class="text-right">' . number_format($balanceMobileBanking) . '</td>' .
                        '</tr>';
            } else if ($todayMobileBankingReport->type == "Payment Received") {
                $cashInMobileBanking  += $todayMobileBankingReport->amount;
                $balanceMobileBanking  += $todayMobileBankingReport->amount;
                $infoMobileBanking  .= '<tr>
                            <td class="text-center">' . $iMobileBanking++ . '</td>' .
                    '<td class="text-left"><a href="#"  onclick="'.$mobile_bank_seeDetails.'">' . $todayMobileBankingReport->remarks . '<br>' . $todayMobileBankingReport->name . ' | ' . $todayMobileBankingReport->address . '</a></td>' .
                    '<td class="text-center">' . $mobile_bank_reportDetails . '</td>' .
                    '<td class="text-center">' . $todayMobileBankingReport->voucherNo . '</td>' .
                    '<td class="text-right">' . $todayMobileBankingReport->amount . '</td>' .
                    '<td></td>' .
                    '<td class="text-right">' . number_format($balanceMobileBanking) . '</td>' .
                    '</tr>';
            } else {
                $infoMobileBanking  .= '<tr>
                            <td class="text-center">' . $iMobileBanking++ . '</td>' .
                    '<td class="text-left"><a href="#"  onclick="'.$mobile_bank_seeDetails.'">' . $todayMobileBankingReport->remarks . '<br>' . $todayMobileBankingReport->name . ' | ' . $todayMobileBankingReport->address . '</a></td>' .
                    '<td class="text-center">' . $mobile_bank_reportDetails . '</td>' .
                    '<td class="text-center">' . $todayMobileBankingReport->voucherNo . '</td>' .
                    '<td class="text-right"></td>' .
                    '<td></td>' .
                    '<td class="text-right"></td>' .
                    '</tr>';
            }
        }
           
        $data=array(
            'info'=>$info,
            'infoBank'=>$infoBank,
            'infoMobileBanking'=>$infoMobileBanking
        );
        return $data;
    }











    public function generateExpensePdf($data)
    {
        $loggedWarehouseId=Session::get('warehouse')[0]['id'];
        $dataArray = explode(",", $data);
        $startAndEndDate = array($dataArray[0], $dataArray[1]);
        $from = $dataArray[0];
        $to = $dataArray[1];
        $date = $from;

        $todayPaymentReport = DB::table('payment_vouchers')
            ->leftjoin('purchases', 'payment_vouchers.purchase_id', '=', 'purchases.id')
            ->leftjoin('sales', 'payment_vouchers.sales_id', '=', 'sales.id')
            ->leftjoin('parties', 'payment_vouchers.party_id', '=', 'parties.id')
            ->select('payment_vouchers.*', 'sales.grand_total', 'sales.current_payment', 'purchases.total_amount', 'parties.name', 'parties.address')
            ->where('payment_vouchers.deleted', 'No')
            ->where('payment_vouchers.paymentDate', $date)
            ->where('payment_vouchers.warehouse_id', $loggedWarehouseId)
            ->where('payment_vouchers.status', 'Active')
            ->where('payment_vouchers.payment_method', 'Cash')
            ->where(function ($query) {
                $query->where('payment_vouchers.type', 'Payment')
                    //->orWhere('payment_vouchers.type', 'Party Payable')
                    ->orWhere('payment_vouchers.type', 'Payment Received');
            })
            ->get();

       

        $cashIn = 0;
        $cashOut = 0;
        $balance = 0;

        $table = "";
        $i = 1;

        foreach ($todayPaymentReport as $report) {
            
            if ($report->voucherType == "Expense") {
                $nameData = '';
            }else{
                $nameData =$report->name .' | '. $report->address;
            }
            
            if($report->voucherType == 'Expense'){
                $expense_details = DB::table('tbl_acc_expense_details')
                            ->leftjoin('tbl_acc_coas','tbl_acc_coas.id','=','tbl_acc_expense_details.tbl_acc_coa_id')
                            ->select('tbl_acc_expense_details.*','tbl_acc_coas.name as coa_name')
                            ->where('tbl_acc_expense_details.deleted','No')
                            ->where('tbl_acc_expense_details.tbl_acc_expense_id', $report->expense_id)
                            ->get();
                $a=1;
                $reportDetails='';
                foreach($expense_details as  $expense_detail){
                    $reportDetails.=$a++.' . '.$expense_detail->coa_name. '('.$expense_detail->particulars.')<br>';
                } 
            }elseif($report->voucherType == 'Bill Payment'){
                 $bill_payment_details = DB::table('tbl_acc_bill_details')
                            ->join('tbl_acc_bill_payment_details','tbl_acc_bill_details.tbl_acc_bill_id','=','tbl_acc_bill_payment_details.tbl_acc_bill_id')
                            ->leftjoin('tbl_acc_coas','tbl_acc_coas.id','=','tbl_acc_bill_details.tbl_acc_coa_id')
                            ->select('tbl_acc_bill_details.*','tbl_acc_coas.name as coa_name')
                            ->where('tbl_acc_bill_details.deleted','=','No')
                            ->where('tbl_acc_bill_details.status','=','Active')
                            ->where('tbl_acc_bill_payment_details.tbl_acc_billPayment_id','=', $report->bill_id)
                            ->get();
                $b=1;
                $reportDetails='';
                foreach($bill_payment_details as  $bill_payment_detail){
                    $reportDetails.=$b++.' . '.$bill_payment_detail->coa_name.  '('.$bill_payment_detail->particulars.')<br>';
                }
            }elseif($report->voucherType == 'Applicant Order' || $report->voucherType == 'Vendor Order'){
                $orderDetails=DB::table('sale_order_products')
                                ->leftJoin('products', 'sale_order_products.product_id', '=', 'products.id')
                                ->select('sale_order_products.*','products.name as product_name')
                                ->where('sale_order_products.deleted','=','No')
                                ->where('products.deleted','=','No')
                                ->where('products.status','=','Active')
                                ->where('sale_order_products.tbl_sale_orders_id','=',$report->order_sale_id)
                                ->get();
                $c=1;
                $reportDetails='';
                foreach($orderDetails as  $orderDetail){
                    $reportDetails.=$c++.' . '.$orderDetail->product_name. '<br>';
                }
            }else{
                $reportDetails='';
            }


            if ($report->type == "Payment") {
                $cashOut += $report->amount;
                $balance -= $report->amount;
                $table .= "<tr>
                            <td class='text-center'>" . $i++ . "</td>
                            <td class='text-left'>" . $report->remarks . "<br>" . $nameData . "</td>
                            <td class='text-center'>" . $reportDetails . "</td>
                            <td class='text-center'>" . $report->voucherNo . "</td>
                            <td></td>
                            <td class='textRight'>" . $report->amount . "</td>
                            <td class='textRight'>" . number_format($balance) . "</td>
                        </tr>";
            } else if ($report->type == "Payment Received") {
                $cashIn += $report->amount;
                $balance += $report->amount;
                $table .= "<tr>
                            <td class='text-center'>" . $i++ . "</td>
                            <td class='text-left'>" . $report->remarks . "<br>" . $nameData . "</td>
                            <td class='text-center'>" . $reportDetails . "</td>
                            <td class='text-center'>" . $report->voucherNo . "</td>
                            <td class='textRight'>" . $report->amount . "</td>
                            <td></td>
                            <td class='textRight'>" . number_format($balance) . "</td></tr>";
            } else {
                $table .= "<tr>
                            <td class='text-center'>" . $i++ . "</td>
                            <td class='text-left'>" . $report->remarks . "<br>" . $nameData . "</td>
                            <td class='text-center'>" . $reportDetails . "</td>
                            <td class='text-center'>" . $report->voucherNo . "</td>
                            <td class='textRight'></td>
                            <td></td>
                            <td class='textRight'></td></tr>";
            }
        }


        // bank
        $todayPaymentReportBank = DB::table('payment_vouchers')
                            ->leftjoin('purchases', 'payment_vouchers.purchase_id', '=', 'purchases.id')
                            ->leftjoin('sales', 'payment_vouchers.sales_id', '=', 'sales.id')
                            ->leftjoin('parties', 'payment_vouchers.party_id', '=', 'parties.id')
                            ->select('payment_vouchers.*', 'sales.grand_total', 'sales.current_payment', 'purchases.total_amount', 'parties.name', 'parties.address')
                            ->where('payment_vouchers.deleted', 'No')
                            ->where('payment_vouchers.paymentDate', $date)
                            ->where('payment_vouchers.warehouse_id', $loggedWarehouseId)
                            ->where('payment_vouchers.status', 'Active')
                            ->where('payment_vouchers.payment_method', 'Bank')
                            ->where(function ($query) {
                                $query->where('payment_vouchers.type', 'Payment')
                                    //->orWhere('payment_vouchers.type', 'Party Payable')
                                    ->orWhere('payment_vouchers.type', 'Payment Received');
                            })
                            ->get();
    
    
   

    $BankIn = 0;
    $BankOut = 0;
    $balanceBank = 0;

    $tableBank = "";
    $iBank = 1;

    foreach ($todayPaymentReportBank as $reportBank) {
        
        if ($reportBank->voucherType == "Expense") {
            $nameDataBank = '';
        }else{
            $nameDataBank =$reportBank->name .' | '. $reportBank->address;
        }
        
        if($reportBank->voucherType == 'Expense'){
            $bank_expense_details = DB::table('tbl_acc_expense_details')
                        ->leftjoin('tbl_acc_coas','tbl_acc_coas.id','=','tbl_acc_expense_details.tbl_acc_coa_id')
                        ->select('tbl_acc_expense_details.*','tbl_acc_coas.name as coa_name')
                        ->where('tbl_acc_expense_details.deleted','No')
                        ->where('tbl_acc_expense_details.tbl_acc_expense_id',$reportBank->expense_id)
                        ->get();
            $bank_a=1;
            $bank_reportDetails='';
            foreach($bank_expense_details as  $bank_expense_detail){
                $bank_reportDetails.=$bank_a++.' . '.$bank_expense_detail->coa_name. '('.$bank_expense_detail->particulars.')<br>';
            } 
        }elseif($reportBank->voucherType == 'Bill Payment'){
             $bank_bill_payment_details = DB::table('tbl_acc_bill_details')
                        ->join('tbl_acc_bill_payment_details','tbl_acc_bill_details.tbl_acc_bill_id','=','tbl_acc_bill_payment_details.tbl_acc_bill_id')
                        ->leftjoin('tbl_acc_coas','tbl_acc_coas.id','=','tbl_acc_bill_details.tbl_acc_coa_id')
                        ->select('tbl_acc_bill_details.*','tbl_acc_coas.name as coa_name')
                        ->where('tbl_acc_bill_details.deleted','=','No')
                        ->where('tbl_acc_bill_details.status','=','Active')
                        ->where('tbl_acc_bill_payment_details.tbl_acc_billPayment_id','=', $reportBank->bill_id)
                        ->get();
            $bank_b=1;
            $bank_reportDetails='';
            foreach($bank_bill_payment_details as  $bank_bill_payment_detail){
                $bank_reportDetails.=$bank_b++.' . '.$bank_bill_payment_detail->coa_name. '('. $bank_bill_payment_detail->particulars.')<br>';
            }
        }elseif($reportBank->voucherType == 'Applicant Order' || $reportBank->voucherType == 'Vendor Order'){
            $bank_orderDetails=DB::table('sale_order_products')
                            ->leftJoin('products', 'sale_order_products.product_id', '=', 'products.id')
                            ->select('sale_order_products.*','products.name as product_name')
                            ->where('sale_order_products.deleted','=','No')
                            ->where('products.deleted','=','No')
                            ->where('products.status','=','Active')
                            ->where('sale_order_products.tbl_sale_orders_id','=',$reportBank->order_sale_id)
                            ->get();
            $bank_c=1;
            $bank_reportDetails='';
            foreach($bank_orderDetails as  $bank_orderDetail){
                $bank_reportDetails.=$bank_c++.' . '.$bank_orderDetail->product_name. '<br>';
            }
        }else{
            $bank_reportDetails='';
        }

        if ($reportBank->type == "Payment") {
            $BankOut += $reportBank->amount;
            $balanceBank -= $reportBank->amount;
            $tableBank .= "<tr>
                        <td class='text-center'>" . $iBank++ . "</td>
                        <td class='text-left'>" . $reportBank->remarks . "<br>" . $nameDataBank . "</td>
                        <td class='text-center'>" . $bank_reportDetails . "</td>
                        <td class='text-center'>" . $reportBank->voucherNo . "</td>
                        <td></td>
                        <td class='textRight'>" . $reportBank->amount . "</td>
                        <td class='textRight'>" . number_format($balanceBank) . "</td>
                    </tr>";
        } else if ($reportBank->type == "Payment Received") {
            $BankIn += $reportBank->amount;
            $balanceBank += $reportBank->amount;
            $tableBank .= "<tr>
                        <td class='text-center'>" . $iBank++ . "</td>
                        <td class='text-left'>" . $reportBank->remarks . "<br>" . $nameDataBank . "</td>
                        <td class='text-center'>" . $bank_reportDetails . "</td>
                        <td class='text-center'>" . $reportBank->voucherNo . "</td>
                        <td class='textRight'>" . $reportBank->amount . "</td>
                        <td></td>
                        <td class='textRight'>" . number_format($balanceBank) . "</td></tr>";
        } else {
            $tableBank .= "<tr>
                        <td class='text-center'>" . $iBank++ . "</td>
                        <td class='text-left'>" . $reportBank->remarks . "<br>" . $nameDataBank . "</td>
                        <td class='text-center'>" . $bank_reportDetails . "</td>
                        <td class='text-center'>" . $reportBank->voucherNo . "</td>
                        <td class='textRight'></td>
                        <td></td>
                        <td class='textRight'></td></tr>";
        }
    }


       


        // mobile banking
        $todayPaymentReportMobileBanking = DB::table('payment_vouchers')
                            ->leftjoin('purchases', 'payment_vouchers.purchase_id', '=', 'purchases.id')
                            ->leftjoin('sales', 'payment_vouchers.sales_id', '=', 'sales.id')
                            ->leftjoin('parties', 'payment_vouchers.party_id', '=', 'parties.id')
                            ->select('payment_vouchers.*', 'sales.grand_total', 'sales.current_payment', 'purchases.total_amount', 'parties.name', 'parties.address')
                            ->where('payment_vouchers.deleted', 'No')
                            ->where('payment_vouchers.paymentDate', $date)
                            ->where('payment_vouchers.warehouse_id', $loggedWarehouseId)
                            ->where('payment_vouchers.status', 'Active')
                            ->where('payment_vouchers.payment_method', 'Mobile Banking')
                            ->where(function ($query) {
                                $query->where('payment_vouchers.type', 'Payment')
                                    //->orWhere('payment_vouchers.type', 'Party Payable')
                                    ->orWhere('payment_vouchers.type', 'Payment Received');
                            })
                            ->get();

   

        $MobileBankingIn = 0;
        $MobileBankingOut = 0;
        $balanceMobileBanking = 0;

        $tableMobileBanking = "";
        $iMobileBanking = 1;

        foreach ($todayPaymentReportMobileBanking as $reportMobileBanking) {
            
            if ($reportMobileBanking->voucherType == "Expense") {
                $nameDataMobileBanking = '';
            }else{
                $nameDataMobileBanking =$reportMobileBanking->name .' | '. $reportMobileBanking->address;
            }
            
            if($reportMobileBanking->voucherType == 'Expense'){
                $mobile_bank_expense_details = DB::table('tbl_acc_expense_details')
                            ->leftjoin('tbl_acc_coas','tbl_acc_coas.id','=','tbl_acc_expense_details.tbl_acc_coa_id')
                            ->select('tbl_acc_expense_details.*','tbl_acc_coas.name as coa_name')
                            ->where('tbl_acc_expense_details.deleted','No')
                            ->where('tbl_acc_expense_details.tbl_acc_expense_id',$reportMobileBanking->expense_id)
                            ->get();
                $mobile_bank_a=1;
                $mobile_bank_reportDetails='';
                foreach($mobile_bank_expense_details as  $mobile_bank_expense_detail){
                    $mobile_bank_reportDetails.=$mobile_bank_a++.' . '.$mobile_bank_expense_detail->coa_name. '('. $mobile_bank_expense_detail->particulars.')<br>';
                } 
            }elseif($reportMobileBanking->voucherType == 'Bill Payment'){
                 $mobile_bank_bill_payment_details = DB::table('tbl_acc_bill_details')
                            ->join('tbl_acc_bill_payment_details','tbl_acc_bill_details.tbl_acc_bill_id','=','tbl_acc_bill_payment_details.tbl_acc_bill_id')
                            ->leftjoin('tbl_acc_coas','tbl_acc_coas.id','=','tbl_acc_bill_details.tbl_acc_coa_id')
                            ->select('tbl_acc_bill_details.*','tbl_acc_coas.name as coa_name')
                            ->where('tbl_acc_bill_details.deleted','=','No')
                            ->where('tbl_acc_bill_details.status','=','Active')
                            ->where('tbl_acc_bill_payment_details.tbl_acc_billPayment_id','=', $reportMobileBanking->bill_id)
                            ->get();
                $mobile_bank_b=1;
                $mobile_bank_reportDetails='';
                foreach($mobile_bank_bill_payment_details as  $mobile_bank_bill_payment_detail){
                    $mobile_bank_reportDetails.=$mobile_bank_b++.' . '.$mobile_bank_bill_payment_detail->coa_name. '('. $mobile_bank_bill_payment_detail->particulars.')<br>';
                }
            }elseif($reportMobileBanking->voucherType == 'Applicant Order' || $reportMobileBanking->voucherType == 'Vendor Order'){
                $mobile_bank_orderDetails=DB::table('sale_order_products')
                                ->leftJoin('products', 'sale_order_products.product_id', '=', 'products.id')
                                ->select('sale_order_products.*','products.name as product_name')
                                ->where('sale_order_products.deleted','=','No')
                                ->where('products.deleted','=','No')
                                ->where('products.status','=','Active')
                                ->where('sale_order_products.tbl_sale_orders_id','=',$reportMobileBanking->order_sale_id)
                                ->get();
                $mobile_bank_c=1;
                $mobile_bank_reportDetails='';
                foreach($mobile_bank_orderDetails as  $mobile_bank_orderDetail){
                    $mobile_bank_reportDetails.=$mobile_bank_c++.' . '.$mobile_bank_orderDetail->product_name. '<br>';
                }
            }else{
                $mobile_bank_reportDetails='';
                $mobile_bank_seeDetails='';
            }

            if ($reportMobileBanking->type == "Payment") {
                $MobileBankingOut += $reportMobileBanking->amount;
                $balanceMobileBanking -= $reportMobileBanking->amount;
                $tableMobileBanking .= "<tr>
                            <td class='text-center'>" . $iMobileBanking++ . "</td>
                            <td class='text-left'>" . $reportMobileBanking->remarks . "<br>" . $nameDataMobileBanking . "</td>
                            <td class='text-center'>" . $mobile_bank_reportDetails . "</td>
                            <td class='text-center'>" . $reportMobileBanking->voucherNo . "</td>
                            <td></td>
                            <td class='textRight'>" . $reportMobileBanking->amount . "</td>
                            <td class='textRight'>" . number_format($balanceMobileBanking) . "</td>
                        </tr>";
            } else if ($reportMobileBanking->type == "Payment Received") {
                $MobileBankingIn += $reportMobileBanking->amount;
                $balanceMobileBanking += $reportMobileBanking->amount;
                $tableMobileBanking .= "<tr>
                            <td class='text-center'>" . $iMobileBanking++ . "</td>
                            <td class='text-left'>" . $reportMobileBanking->remarks . "<br>" . $nameDataMobileBanking . "</td>
                            <td class='text-center'>" . $mobile_bank_reportDetails . "</td>
                            <td class='text-center'>" . $reportMobileBanking->voucherNo . "</td>
                            <td class='textRight'>" . $reportMobileBanking->amount . "</td>
                            <td></td>
                            <td class='textRight'>" . number_format($balanceMobileBanking) . "</td></tr>";
            } else {
                $tableMobileBanking .= "<tr>
                            <td class='text-center'>" . $iMobileBanking++ . "</td>
                            <td class='text-left'>" . $reportMobileBanking->remarks . "<br>" . $nameDataMobileBanking . "</td>
                            <td class='text-center'>" . $mobile_bank_reportDetails . "</td>
                            <td class='text-center'>" . $reportMobileBanking->voucherNo . "</td>
                            <td class='textRight'></td>
                            <td></td>
                            <td class='textRight'></td></tr>";
            }
        }




        $minusDaysFromDate =  date_create($date)->modify('-1 days')->format('Y-m-d');

        $openingData = DailyReport::where('deleted', 'No')->where('date', '<', $date)->orderBy('date', 'DESC')->first();
        if ($openingData != null) {
            $opening_balance = $openingData->opening_balance;
        } else {
            $opening_balance = 0;
        }
        
        $bank=ChartOfAccounts::where('name','=','Bank')->where('deleted', 'No')->where('status', 'Active')->first();
        
        $bankSources=ChartOfAccounts::where('parent_id','=',$bank->id)->where('deleted', 'No')->where('status', 'Active')->get();
        $allBankOpeningBalance=0;
        foreach($bankSources as $source){
            $bankAccounts=ChartOfAccounts::where('parent_id','=',$source->id)->where('deleted', 'No')->where('status', 'Active')->get();
            $singleBankAccountTotalOpeningBalance=0;
            foreach($bankAccounts as $account){
                $bankPayments = DB::table('payment_vouchers')
                                    ->where('payment_vouchers.deleted','=','No')
                                    ->where('payment_vouchers.paymentDate','>=', $account->opening_balance_entry_date)
                                    ->where('payment_vouchers.paymentDate','<', $date)
                                    ->where('payment_vouchers.warehouse_id', $loggedWarehouseId)
                                    ->where('payment_vouchers.status','=', 'Active')
                                    ->where('payment_vouchers.payment_method', 'Bank')
                                    ->where('payment_vouchers.account_coa_id','=',$account->id)
                                    ->where('payment_vouchers.type', 'Payment')
                                    ->get();
               
                $netBankPayment=0;
                foreach($bankPayments as $bankPayment){
                     $netBankPayment+=$bankPayment->amount;
                }
                
                $bankPaymentReceives = DB::table('payment_vouchers')
                                    ->where('payment_vouchers.deleted','=','No')
                                    ->where('payment_vouchers.paymentDate','>=', $account->opening_balance_entry_date)
                                    ->where('payment_vouchers.paymentDate','<', $date)
                                    ->where('payment_vouchers.warehouse_id', $loggedWarehouseId)
                                    ->where('payment_vouchers.status','=', 'Active')
                                    ->where('payment_vouchers.payment_method', 'Bank')
                                    ->where('payment_vouchers.account_coa_id','=',$account->id)
                                    ->where('payment_vouchers.type', 'Payment Received')
                                    ->get();
               
                $netBankPaymentReceived=0;
                foreach($bankPaymentReceives as $bankPaymentReceive){
                      $netBankPaymentReceived+=$bankPaymentReceive->amount;
                }
                
                $singleBankAccountOpeningBalance=$netBankPaymentReceived - $netBankPayment + $account->opening_balance;
                $singleBankAccountTotalOpeningBalance+=$singleBankAccountOpeningBalance;
            }
            
                $allBankOpeningBalance+= $singleBankAccountTotalOpeningBalance;
        }
        
        
        $mobileBank=ChartOfAccounts::where('name','=','Mobile Banking')->where('deleted', 'No')->where('status', 'Active')->first();
        $mobileBankSources=ChartOfAccounts::where('parent_id','=',$mobileBank->id)->where('deleted', 'No')->where('status', 'Active')->get();
        //return $date;
        $allMobileBankOpeningBalance=0;
        foreach($mobileBankSources as $mobileBanksource){
             $mobileBankAccounts=ChartOfAccounts::where('parent_id','=',$mobileBanksource->id)->where('warehouse_id','like',"%$loggedWarehouseId%")->where('deleted', 'No')->where('status', 'Active')->get();
             $singleMobileBankOpeningBalance=0;
            foreach($mobileBankAccounts as $mobileBankAccount){
                 $mobileBankPayments = DB::table('payment_vouchers')
                                    ->where('payment_vouchers.deleted','=','No')
                                    ->where('payment_vouchers.paymentDate','>=',$mobileBankAccount->opening_balance_entry_date)
                                    ->where('payment_vouchers.paymentDate','<', $date)
                                    ->where('payment_vouchers.warehouse_id', $loggedWarehouseId)
                                    ->where('payment_vouchers.status','=', 'Active')
                                    ->where('payment_vouchers.payment_method', 'Mobile Banking')
                                    ->where('payment_vouchers.account_coa_id','=',$mobileBankAccount->id)
                                    ->where('payment_vouchers.type', 'Payment')
                                    ->get();
               
                $netMobileBankPayment=0;
                foreach($mobileBankPayments as $mobileBankPayment){
                     $netMobileBankPayment+=$mobileBankPayment->amount;
                }
                //return $netMobileBankPayment; 
                $mobileBankPaymentReceives = DB::table('payment_vouchers')
                                    ->where('payment_vouchers.deleted','=','No')
                                    ->where('payment_vouchers.paymentDate','>=', $mobileBankAccount->opening_balance_entry_date)
                                    ->where('payment_vouchers.paymentDate','<', $date)
                                    ->where('payment_vouchers.warehouse_id', $loggedWarehouseId)
                                    ->where('payment_vouchers.status','=', 'Active')
                                    ->where('payment_vouchers.payment_method', 'Mobile Banking')
                                    ->where('payment_vouchers.account_coa_id','=',$mobileBankAccount->id)
                                    ->where('payment_vouchers.type', 'Payment Received')
                                    ->get();
               
                $netMobileBankPaymentReceived=0;
                foreach($mobileBankPaymentReceives as $mobileBankPaymentReceive){
                      $netMobileBankPaymentReceived+=$mobileBankPaymentReceive->amount;
                }
                //return $netMobileBankPaymentReceived;
                //return $mobileBankAccount->opening_balance;
                $singleMobileBankAccountOpeningBalance=$netMobileBankPaymentReceived - $netMobileBankPayment + $mobileBankAccount->opening_balance;
                $singleMobileBankOpeningBalance+=$singleMobileBankAccountOpeningBalance;
            }
            $allMobileBankOpeningBalance+=$singleMobileBankOpeningBalance;
        }
        
       $allMobileBankOpeningBalance;
        $pdf = PDF::loadView('admin.reports.expenses.expenseReport',  [   'table' => $table,
                                                                            'tableBank'=>$tableBank,
                                                                            'tableMobileBanking'=>$tableMobileBanking,
                                                                            'balance' => $balance,
                                                                            'balanceBank'=>$balanceBank,
                                                                            'balanceMobileBanking'=>$balanceMobileBanking,
                                                                            'cashIn' => $cashIn,
                                                                            'BankIn'=>$BankIn,
                                                                            'MobileBankingIn'=>$MobileBankingIn, 
                                                                            'cashOut' => $cashOut,
                                                                            'MobileBankingOut'=>$MobileBankingOut,
                                                                            'BankOut'=>$BankOut, 
                                                                            'openingBalance' => $opening_balance,
                                                                            'startAndEndDate' => $startAndEndDate,
                                                                            'allBankOpeningBalance'=>$allBankOpeningBalance,
                                                                            'allMobileBankOpeningBalance'=>$allMobileBankOpeningBalance
                                                                            
                                                                        ]);

        return $pdf->stream('expense-report-pdf.pdf', array("Attachment" => false));


        //-----End today payment, expense , payment received-------//

    }
    ///








        public function delete(Request $request){

            DB::beginTransaction();
		    try {

                $expense=Expense::find($request->id);
                $expense->deleted='Yes';
                $expense->status='Inactive';
                $expense->save();
                $expenseId=$request->id;

                $coa=ChartOfAccounts::find($expense->payment_method);
                $coa->increment('amount',$expense->amount);

                $expenseDetails=ExpenseDetails::where('tbl_acc_expense_id','=',$expenseId)->get();
                foreach($expenseDetails as $details){
                    $expenseDetail=ExpenseDetails::find($details->id);
                    $expenseDetail->deleted='Yes';
                    $expenseDetail->status='Inactive';
                    $expenseDetail->save();
                    $coa=ChartOfAccounts::find($expenseDetail->tbl_acc_coa_id);
                    $coa->decrement('amount',$expenseDetail->amount);
                }
                $voucher=Voucher::where('type_no','=',$expenseId)->where('type','=','Expense')->first();
                $voucher->deleted='Yes';
                $voucher->status='Inactive';
                $voucher->save();
                $voucherDetails=VoucherDetails::where('tbl_acc_voucher_id','=',$voucher->id)->get();
                foreach($voucherDetails as $voucherDetail){
                    $voucherDetail=VoucherDetails::find($voucherDetail->id);
                    $voucherDetail->deleted='Yes';
                    $voucherDetail->status='Inactive';
                    $voucherDetail->save();
                }
                $paymentVoucher=PaymentVoucher::where('expense_id','=',$expenseId)->where('voucherType','=','Expense')->first();
                $paymentVoucher->deleted='Yes';
                $paymentVoucher->status='Inactive';
                $paymentVoucher->save();

                DB::commit();
                return response()->json(['success' => 'Expense deleted successfully']);
            } catch (Exception $e) {
                DB::rollBack();
                return response()->json(['error' => 'Purchase rollBack!']);
            }
        }













 






}
