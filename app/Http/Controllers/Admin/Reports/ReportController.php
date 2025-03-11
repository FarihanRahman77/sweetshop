<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Journal\Journal;
use App\Models\Journal\JournalDetails;
use App\Models\Accounts\ChartOfAccounts;
use App\Models\Report\DailyReport;
use App\Models\Crm\Party;
use App\Models\Accounts\Voucher;
use App\Models\Accounts\VoucherDetails;
use App\Models\Accounts\MonthlyReport;
use App\Models\Accounts\PaymentVoucher;
use App\Models\inventory\Purchase;
use App\Models\inventory\SaleOrder;
use App\Models\inventory\Sale;
use App\Models\inventory\Purchase_Return;
use App\Models\inventory\SaleReturn;
use App\Models\CarService\Vehicle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDF;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class ReportController extends Controller
{
    public function index()
    {
        $suppliers = Party::where('deleted', '=', 'No')->where('status', '=', 'Active')->get();
        return view('admin.reports.partyLedger', ['suppliers' => $suppliers]);
    }



    public function generateVoucher(Request $request)
    {
       
       
        $loggedWarehouseId=Session::get('companySettings')[0]['id'];
        if($request->vendor_id != 0){

        $vouchers = DB::table('tbl_acc_voucher_details')
            ->leftjoin('tbl_accounts_vouchers', 'tbl_acc_voucher_details.tbl_acc_voucher_id', '=', 'tbl_accounts_vouchers.id')
            ->select('tbl_acc_voucher_details.*', 'tbl_accounts_vouchers.transaction_date', 'tbl_accounts_vouchers.amount', 'tbl_accounts_vouchers.vendor_id', 'tbl_accounts_vouchers.id as voucherId','tbl_accounts_vouchers.type_no')
            ->where('tbl_accounts_vouchers.vendor_id', '=', $request->vendor_id)
            ->whereBetween('tbl_accounts_vouchers.transaction_date', [$request->date_from, $request->date_to])
            ->where('tbl_accounts_vouchers.deleted', '=', 'No')
            ->where('tbl_accounts_vouchers.status', '=', 'Active')
            ->where('tbl_acc_voucher_details.deleted', '=', 'No')
            ->where('tbl_acc_voucher_details.status', '=', 'Active')
            ->get();
      

        $openingDebit = DB::table('tbl_acc_voucher_details')
            ->leftjoin('tbl_accounts_vouchers', 'tbl_acc_voucher_details.tbl_acc_voucher_id', '=', 'tbl_accounts_vouchers.id')
            ->select('tbl_acc_voucher_details.debit', 'tbl_accounts_vouchers.transaction_date', 'tbl_accounts_vouchers.vendor_id')
            ->where('tbl_accounts_vouchers.vendor_id', $request->vendor_id)
            ->where('tbl_accounts_vouchers.transaction_date', '<', $request->date_from)
            ->where('tbl_accounts_vouchers.deleted', '=', 'No')
            ->where('tbl_accounts_vouchers.status', '=', 'Active')
            ->where('tbl_acc_voucher_details.deleted', '=', 'No')
            ->where('tbl_acc_voucher_details.status', '=', 'Active')
            ->sum('tbl_acc_voucher_details.debit');

              $openingCredit = DB::table('tbl_acc_voucher_details')
            ->leftjoin('tbl_accounts_vouchers', 'tbl_acc_voucher_details.tbl_acc_voucher_id', '=', 'tbl_accounts_vouchers.id')
            ->select('tbl_acc_voucher_details.debit', 'tbl_accounts_vouchers.transaction_date', 'tbl_accounts_vouchers.vendor_id')
            ->where('tbl_accounts_vouchers.vendor_id', $request->vendor_id)
            ->where('tbl_accounts_vouchers.transaction_date', '<', $request->date_from)
            ->where('tbl_accounts_vouchers.deleted', '=', 'No')
            ->where('tbl_accounts_vouchers.status', '=', 'Active')
            ->where('tbl_acc_voucher_details.deleted', '=', 'No')
            ->where('tbl_acc_voucher_details.status', '=', 'Active')
            ->sum('tbl_acc_voucher_details.credit');

        $openingBalance = $openingDebit - $openingCredit;






        $openingCreditBalance = 0;
        $openingDebitBalance = 0;
        $balance = $openingDebitBalance-$openingCreditBalance;

        if ($openingBalance < 0) {
            $openingCreditBalance = abs($openingBalance);
            //$openingDebitBalance='';
            $balance = $balance-$openingCreditBalance;
            
            
        } else {
            
            $openingDebitBalance = abs($openingBalance);
           // $openingCreditBalance='';
            $balance = $balance+$openingDebitBalance;
        }


        $data = '';
        $table = '';
        $total = '';
        $totalDebit = 0;
        $totalCredit = 0;
        $button = '';
        $i = 1;
        //$balance = $openingBalance;

        $table .= '<tr >
                        <td colspan="5" class="text-right"><b>Opening Balance:</b></td>
                            <td class="text-right"><b>' . number_format($openingDebitBalance,2) . '</b></td>
                        <td class="text-right "><b>' . number_format($openingCreditBalance,2) . '</b></td>
                        <td class="text-right"><b>' . number_format($balance,2) . '</b></td>
                    </tr>';

        foreach ($vouchers as $voucher) {

            $balance += $voucher->debit ?? 0;
            $balance -= $voucher->credit ?? 0;

            $table .= '<tr>
                            <td class="text-center">' . $i++ . '</td>
                            <td class="text-center">' . $voucher->transaction_date . '</td>
                            <td><a href="#" onclick="ledgerDetails('.$voucher->voucherId.')">' . $voucher->voucher_title . '</a></td>
                            <td class="text-center"># ' . $voucher->voucherId . '</td>
                            <td>' . $voucher->particulars . '</td>
                            <td class="text-right">' . $voucher->debit . '</td>
                            <td class="text-right">' . $voucher->credit . '</td>
                            <td class="text-right">' . number_format($balance,2) . '</td>
                        </tr>';
            $totalDebit += $voucher->debit;
            $totalCredit += $voucher->credit;
        }
        
        //$due = $totalDebit - $totalCredit;

          $total .= '<tr>
                            <td colspan="5" class="text-right"><b>Total:</b></td>
                             <td class="text-right"><b>' . number_format($totalDebit,2) . '</b></td>
                            <td class="text-right"><b>' . number_format($totalCredit,2) . '</b></td>
                            <td class="text-right"><b></b></td>
                        </tr>'; 

        /*  if ($totalDebit < $totalCredit) {
            $aDebit = $due;
            $aCredit = '0';
        } elseif ($totalDebit > $totalCredit) {
            $aDebit = '0';
            $aCredit = $due;
        } else {
            $aDebit = '0';
            $aCredit = '0';
        } */

        $closingCreditBalance = 0;
        $closingDebitBalance = 0;
        if ($balance > 0) {
            $closingCreditBalance = $balance;
        } else {
            $closingDebitBalance = $balance;
        }
/*
<tr>
                        <td colspan="5" class="text-right"><strong class="float-right font-weight-bold">Opening Balance Adjustment </strong></td>
                        <td class="text-right "><b>' . number_format($openingDebitBalance,2) . '</b></td>
                        <td class="text-right"> <strong class="float-right font-weight-bold ">' . number_format($openingCreditBalance,2) . '</strong></td>
                         <td></td>
                    </tr>
*/
        $total .= '<tr>
                        <td colspan="5" class="text-right"><strong class="float-right font-weight-bold">Closing Balance </strong></td>
                        <td class="text-right "><b>' . number_format(abs($closingDebitBalance),2) . '</b></td>
                        <td class="text-right"> <strong class="float-right font-weight-bold ">' . number_format($closingCreditBalance,2) . '</strong></td>
                         <td></td>
                    </tr>
                    
                    <tr>
                        <td colspan="5" class="text-right"><strong class="float-right font-weight-bold">Total Transection Balance</strong></td>
                        <td class="text-right "><b>' . number_format(($totalDebit+$openingDebitBalance - $closingDebitBalance),2) . '</b></td>
                        <td class="text-right"> <strong class="float-right font-weight-bold ">' . number_format(($totalCredit+$openingCreditBalance+$closingCreditBalance),2) . '</strong></td>
                         <td></td>
                    </tr>
                    ';
        
       
        /* $totalDebitWithDue = $totalDebit - $aDebit;
        $totalCreditWithDue = $totalCredit + $aCredit; */

       /*  $total .= '<tr>
                        <td colspan="5" class="text-right"></td>
                         <td class="text-right"><b>' . $totalDebit . '</b></td>
                        <td class="text-right"><b>'  . $totalCredit . '</b></td>
                        <td></td>
                    </tr>'; */

        $button .= '<button class="btn btn-primary float-right" onclick="generateVoucherPdf()"><i class="fa fa-file-pdf"></i> Generate PDF </button>';
        $data = array(
            'table' => $table,
            'total' => $total,
            'button' => $button
        );

        return $data;
        }
    }










    public function generatePdf($vendor_id, $date_from, $date_to)
    {
        
        $loggedWarehouseId=Session::get('companySettings')[0]['id'];
        if($vendor_id > 0 ){
            if($vendor_id == 'null'){
                abort(404);
            }
            $vouchers = DB::table('tbl_acc_voucher_details')
                        ->leftjoin('tbl_accounts_vouchers', 'tbl_acc_voucher_details.tbl_acc_voucher_id', '=', 'tbl_accounts_vouchers.id')
                        ->select('tbl_acc_voucher_details.*', 'tbl_accounts_vouchers.transaction_date', 'tbl_accounts_vouchers.amount', 'tbl_accounts_vouchers.vendor_id', 'tbl_accounts_vouchers.id as voucherId','tbl_accounts_vouchers.type_no')
                        ->where('tbl_accounts_vouchers.vendor_id', '=', $vendor_id)
                        ->whereBetween('tbl_accounts_vouchers.transaction_date', [$date_from, $date_to])
                        ->where('tbl_accounts_vouchers.deleted', '=', 'No')
                        ->where('tbl_accounts_vouchers.status', '=', 'Active')
                        ->where('tbl_acc_voucher_details.deleted', '=', 'No')
                        ->where('tbl_acc_voucher_details.status', '=', 'Active')
                        ->get();

            $party = Party::find($vendor_id);
           
            $debit = DB::table('tbl_acc_voucher_details')
                ->join('tbl_accounts_vouchers', 'tbl_acc_voucher_details.tbl_acc_voucher_id', '=', 'tbl_accounts_vouchers.id')
                ->select('tbl_acc_voucher_details.debit', 'tbl_accounts_vouchers.transaction_date', 'tbl_accounts_vouchers.vendor_id')
                ->where('tbl_accounts_vouchers.vendor_id', $vendor_id)
                ->where('tbl_accounts_vouchers.transaction_date', '<', $date_from)
                ->where('tbl_accounts_vouchers.deleted', '=', 'No')
                ->where('tbl_accounts_vouchers.status', '=', 'Active')
                ->where('tbl_acc_voucher_details.deleted', '=', 'No')
                ->where('tbl_acc_voucher_details.status', '=', 'Active')
                ->sum('tbl_acc_voucher_details.debit');

            $credit = DB::table('tbl_acc_voucher_details')
                ->join('tbl_accounts_vouchers', 'tbl_acc_voucher_details.tbl_acc_voucher_id', '=', 'tbl_accounts_vouchers.id')
                ->select('tbl_acc_voucher_details.debit', 'tbl_accounts_vouchers.transaction_date', 'tbl_accounts_vouchers.vendor_id')
                ->where('tbl_accounts_vouchers.vendor_id', $vendor_id)
                ->where('tbl_accounts_vouchers.transaction_date', '<', $date_from)
                ->where('tbl_accounts_vouchers.deleted', '=', 'No')
                ->where('tbl_accounts_vouchers.status', '=', 'Active')
                ->where('tbl_acc_voucher_details.deleted', '=', 'No')
                ->where('tbl_acc_voucher_details.status', '=', 'Active')
                ->sum('tbl_acc_voucher_details.credit');

            $openingBalance = $debit - $credit;
        }else{
            abort(404);
        }
        $pdf = PDF::loadView('admin.reports.partyLedgerPdf', ['vouchers' => $vouchers, 'party' => $party, 'date_from' => $date_from, 'date_to' => $date_to, 'debit' => $debit, 'credit' => $credit, 'openingBalance' => $openingBalance]);
        return $pdf->stream('party-ledger-pdf.pdf', array("Attachment" => false));
    }








     public function  getVoucherTypeAndId(Request $request){
        $voucher=Voucher::find($request->id);
        return $voucher;
     }






    public function accountsSummaryView()
    {
        return view('admin.reports.accountsSummaryLedger');
    }
    
    
    
    

    public function accountsSummaryGenerate(Request $request)
    {
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
        $stockValueData = $this->getReportCalculation($request->date_from, $request->date_to); // OpeningStockValue, ClosingStockValue, NetPurchaseValue....


        $sales = ChartOfAccounts::where('name', '=', 'Sales')->where('deleted', 'No')->where('sister_concern_id','=',$logged_sister_concern_id)->first();
        $salesId = $sales->id;
        $allsales = ChartOfAccounts::where('parent_id', '=', $salesId)->where('deleted', 'No')->where('sister_concern_id','=',$logged_sister_concern_id)->get();

        $expense = ChartOfAccounts::where('name', '=', 'Expense')->where('deleted', 'No')->where('sister_concern_id','=',$logged_sister_concern_id)->first();
        $expenseId = $expense->id;

        $allExpense = ChartOfAccounts::where('parent_id', '=', $expenseId)->where('deleted', 'No')->where('sister_concern_id','=',$logged_sister_concern_id)->get();

        $purchase = ChartOfAccounts::where('name', '=', 'Purchases')->where('deleted', 'No')->where('sister_concern_id','=',$logged_sister_concern_id)->first();
        $purchaseId = $purchase->id;
        $allpurchases = ChartOfAccounts::where('parent_id', '=', $purchaseId)->where('sister_concern_id','=',$logged_sister_concern_id)->where('deleted', 'No')->get();

        // Sale Section
        $totalSales = 0;
        $totalSaleReturnAmount = 0;

        foreach ($allsales as $key => $sale) {
            $saleAmounts = DB::table('tbl_acc_voucher_details')
                ->join('tbl_accounts_vouchers', 'tbl_acc_voucher_details.tbl_acc_voucher_id', '=', 'tbl_accounts_vouchers.id')
                ->whereBetween('tbl_accounts_vouchers.transaction_date', [$request->date_from, $request->date_to])
                ->where('tbl_acc_voucher_details.tbl_acc_coa_id', '=', $sale->id)
                ->where('tbl_acc_voucher_details.sister_concern_id', '=',$logged_sister_concern_id)
                ->where('tbl_accounts_vouchers.deleted', '=', 'No')
                ->where('tbl_accounts_vouchers.status', '=', 'Active')
                ->where('tbl_acc_voucher_details.deleted', '=', 'No')
                ->where('tbl_acc_voucher_details.status', '=', 'Active')
                ->sum('credit');

            $amountDebitSum = $saleAmounts;
            $totalSales += $saleAmounts;

            $amountDebitSum = $amountDebitSum;
            // Sales Return
            $totalSaleReturnAmount = 0;
            if ($sale->slug == "sales-ruturn") {
                $amountDebitSum = SaleReturn::whereBetween('sale_return_date', [$request->date_from, $request->date_to])->where('deleted', 'No')->where('coa_id', $sale->id)->sum('grand_total');
                $totalSaleReturnAmount = $amountDebitSum;
            }
        }

        // Purchase Section
        $purchaseSum = 0;
        $totalPurchases = 0;
        $totalPurchaseReturnAmount = 0;

        $osValue = $stockValueData['osValue'];
        $csValue = $stockValueData['csValue'];
        $damageProductCosts = $stockValueData['damageProductCosts'];

        $totalApplicantAmount = PaymentVoucher::where('type','=','Party Payable')
                            ->where('voucherType','=','Applicant Order')
                            ->whereBetween('paymentDate', [$request->date_from, $request->date_to])
                            ->where('deleted','=','No')
                            ->where('sister_concern_id', '=',$logged_sister_concern_id)
                            ->sum('amount');
        $totalApplicantAmountReturn = PaymentVoucher::where('type','=','Payment Adjustment')
                            ->where('voucherType','=','Applicant Order Return')
                            ->whereBetween('paymentDate', [$request->date_from, $request->date_to])
                            ->where('deleted','=','No')
                            ->where('sister_concern_id', '=',$logged_sister_concern_id)
                            ->sum('amount');

        $totalVendorAmount = PaymentVoucher::where('type','=','Payable')
                            ->where('voucherType','=','Vendor Order')
                            ->whereBetween('paymentDate', [$request->date_from, $request->date_to])
                            ->where('deleted','=','No')
                            ->where('sister_concern_id', '=',$logged_sister_concern_id)
                            ->sum('amount');
        $totalVendorReturnAmount = PaymentVoucher::where('type','=','Adjustment')
                            ->where('voucherType','=','Vendor Order Return')
                            ->whereBetween('paymentDate', [$request->date_from, $request->date_to])
                            ->where('deleted','=','No')
                            ->where('sister_concern_id', '=',$logged_sister_concern_id)
                            ->sum('amount');

        $totalPurchaseReturnAmount = Purchase_Return::whereBetween('purchase_return_date', [$request->date_from, $request->date_to])
                    ->where('deleted', 'No')->sum('grand_total');
        
        $cost_Of_Goods_Sold = $totalVendorAmount - $totalVendorReturnAmount;


        // Expense Section
        $expenseSum = 0;
        $expenseArray = [];
        $expenseIdsArray = [];
        $totalExpenses = 0;
        foreach ($allExpense as $key =>  $expense) {
            $expenseHeads = DB::table('tbl_acc_voucher_details')
                ->join('tbl_accounts_vouchers', 'tbl_acc_voucher_details.tbl_acc_voucher_id', '=', 'tbl_accounts_vouchers.id')
                ->select('tbl_acc_voucher_details.*', 'tbl_accounts_vouchers.transaction_date', 'tbl_accounts_vouchers.type')
                ->whereBetween('tbl_accounts_vouchers.transaction_date', [$request->date_from, $request->date_to])
                ->where('tbl_acc_voucher_details.tbl_acc_coa_id', '=', $expense->id)
                ->where('tbl_acc_voucher_details.sister_concern_id', '=',$logged_sister_concern_id)
                ->where('tbl_accounts_vouchers.deleted', '=', 'No')
                ->where('tbl_accounts_vouchers.status', '=', 'Active')
                ->where('tbl_acc_voucher_details.deleted', '=', 'No')
                ->where('tbl_acc_voucher_details.status', '=', 'Active')
                ->get();
            $expenseHeadSum = 0;
            foreach ($expenseHeads as $expenseHead) {
              
               $expenseHeadSum += $expenseHead->debit;
            }

            $expenseData = array($expense->name => $expenseHeadSum);
            $expenseArray = array_merge($expenseArray, $expenseData);

            array_push($expenseIdsArray, $expense->id);

            $expenseSum += $expenseHeadSum;
        }

        $allPaidBills=DB::table('tbl_accounts_vouchers')->whereBetween('transaction_date', [$request->date_from, $request->date_to])
                        ->where('tbl_accounts_vouchers.sister_concern_id', '=',$logged_sister_concern_id)
                        ->where('type','=','Bill created')
                        ->where('deleted', '=', 'No')
                        ->where('status', '=', 'Active')
                        ->get();
        $totalBillAmount=0;
        foreach($allPaidBills as $bill){
            $totalBillAmount+=$bill->amount;
        }

        $totalRevenue = ($totalApplicantAmount - $totalApplicantAmountReturn);
        $grossProfit = $totalRevenue - $cost_Of_Goods_Sold;
        
        $expenseFinalGrandTotal = $expenseSum+ $totalBillAmount;
        $netProfit = $grossProfit - $expenseFinalGrandTotal;


        $dataSet = [
            "totalSales" => $totalApplicantAmount,
            "totalSaleReturnAmount" => $totalApplicantAmountReturn,

            "totalRevenue" => $totalRevenue,
            "grossProfit" => $grossProfit,
            "totalBillAmount" => $totalBillAmount,

            "netProfit" => $netProfit,
            "expenseSum"=>$expenseSum,
            "osValue" => $osValue,
            "totalPurchases" => $totalVendorAmount,
            "totalPurchaseReturnAmount" => $totalVendorReturnAmount,
            "csValue" => $csValue,
            "cost_Of_Goods_Sold" => $cost_Of_Goods_Sold,


            "damageProductCosts" => $damageProductCosts,
            "expenseFinalGrandTotal" => $expenseFinalGrandTotal

        ];

        $expenseDataSet = [
            "expenseIdsArray" => $expenseIdsArray,

            "expenseArray" => $expenseArray
        ];

        $pdf = '<button class="btn btn-primary mt-2" onclick="generateAccountsSummaryPdf()"><i class="fas fa-print"></i> Print PDF</button>';
        return response()->json(['dataSet' => $dataSet, "expenseDataSet" => $expenseDataSet]);

    }

    
    
    
    
    
    
    public function getReportCalculation($from, $to)
    {
        ///=============== New =========================///
        $sDate = $from;
        $eDate = $to;
        $loggedWarehouseId=Session::get('warehouse')[0]['id'];
        $products = DB::table('products')
            ->select('id', 'name', 'purchase_price', 'sale_price', 'opening_stock')
            ->where('deleted', 'No')
            ->whereNotIn('type', ['service'])
            ->where('status', 'Active')
            ->get();

        $purchaseStock = 0;
        $saleStock = 0;
        ///
        $osValue = 0;
        $csValue = 0;
        $netPurchase = 0;
        $netSales = 0;
        $damageProductCosts = 0;

        foreach ($products as $key => $product) {
            $spId = $product->id;

            //========== Opening Balance
            $openingBalance = DB::table('tbl_purchase_products')
                ->select(DB::raw('SUM(quantity) as stockInQuantity, 0 as stockOutQuantity'))
                ->join('tbl_purchases', 'tbl_purchase_products.purchase_id', '=', 'tbl_purchases.id')
                ->where('tbl_purchase_products
.product_id', $spId)
                ->where('tbl_purchases.date', '<', $sDate)
                ->where('tbl_purchases.deleted', 'No')
                ->where('tbl_purchase_products
.deleted', 'No')
                ->unionAll(function ($query) use ($spId, $sDate) {
                    $query->select(DB::raw('0 as stockInQuantity, SUM(return_qty) as stockOutQuantity'))
                        ->from('purchase_product_returns')
                        ->join('purchase_returns', 'purchase_product_returns.purchase_return_id', '=', 'purchase_returns.id')
                        ->where('purchase_product_returns.product_id', $spId)
                        ->where('purchase_returns.purchase_return_date', '<', $sDate)
                        ->where('purchase_product_returns.deleted', 'No');
                })
                ->unionAll(function ($query) use ($spId, $sDate) {
                    $query->select(DB::raw('0 as stockInQuantity, SUM(quantity) as stockOutQuantity'))
                        ->from('sale_products')
                        ->join('sales', 'sale_products.sale_id', '=', 'sales.id')
                        ->where('sale_products.product_id', $spId)
                        /// 2nd
                        ->where('sales.date', '<', $sDate)
                        ->where('sales.deleted', 'No')
                        ->where('sale_products.deleted', 'No');
                })
                ->unionAll(function ($query) use ($spId, $sDate) {
                    $query->select(DB::raw('SUM(return_qty) as stockInQuantity, 0 as stockOutQuantity'))
                        ->from('sale_product_returns')
                        ->join('sale_returns', 'sale_product_returns.sale_return_id', '=', 'sale_returns.id')
                        ->where('sale_product_returns.product_id', $spId)
                        ->where('sale_returns.sale_return_date', '<', $sDate)
                        ->where('sale_product_returns.deleted', 'No');
                })
                ->unionAll(function ($query) use ($spId, $sDate) {
                    $query->select(DB::raw('0 AS stockInQuantity, SUM(damage_quantity) AS stockOutQuantity'))
                        ->from('damage_products')
                        ->where('deleted', 'No')
                        ->where('products_id', $spId)
                        ->where('damage_date', '<', $sDate);
                })
                ->get()
                ->sum(function ($query) {
                    return $query->stockInQuantity - $query->stockOutQuantity;
                });
            // End Opening Balance

            // Start Closing Balance
            $closingStock = DB::table('tbl_purchase_products
')
                ->select(DB::raw('SUM(quantity) as stockInQuantity, 0 as stockOutQuantity'))
                ->join('tbl_purchases', 'tbl_purchase_products
.purchase_id', '=', 'tbl_purchases.id')
                ->where('tbl_purchase_products
.product_id', $spId)
                ->where('tbl_purchases.date', '<=', $eDate)
                ->where('tbl_purchases.deleted', 'No')
                ->where('tbl_purchase_products
.deleted', 'No')
                ->unionAll(function ($query) use ($spId, $eDate) {
                    $query->select(DB::raw('0 as stockInQuantity, SUM(return_qty) as stockOutQuantity'))
                        ->from('purchase_product_returns')
                        ->join('purchase_returns', 'purchase_product_returns.purchase_return_id', '=', 'purchase_returns.id')
                        ->where('purchase_product_returns.product_id', $spId)
                        ->where('purchase_returns.purchase_return_date', '<=', $eDate)
                        ->where('purchase_product_returns.deleted', 'No');
                })
                ->unionAll(function ($query) use ($spId, $eDate) {
                    $query->select(DB::raw('0 as stockInQuantity, SUM(quantity) as stockOutQuantity'))
                        ->from('sale_products')
                        ->join('sales', 'sale_products.sale_id', '=', 'sales.id')
                        ->where('sale_products.product_id', $spId)
                        /// 2nd
                        ->where('sales.date', '<=', $eDate)
                        ->where('sales.deleted', 'No')
                        ->where('sale_products.deleted', 'No');
                })
                ->unionAll(function ($query) use ($spId, $eDate) {
                    $query->select(DB::raw('SUM(return_qty) as stockInQuantity, 0 as stockOutQuantity'))
                        ->from('sale_product_returns')
                        ->join('sale_returns', 'sale_product_returns.sale_return_id', '=', 'sale_returns.id')
                        ->where('sale_product_returns.product_id', $spId)
                        ->where('sale_returns.sale_return_date', '<=', $eDate)
                        ->where('sale_product_returns.deleted', 'No');
                })
                ->unionAll(function ($query) use ($spId, $eDate) {
                    $query->select(DB::raw('0 AS stockInQuantity, SUM(damage_quantity) AS stockOutQuantity'))
                        ->from('damage_products')
                        ->where('products_id', $spId)
                        ->where('damage_date', '<=', $eDate)
                        ->where('deleted', 'No');
                })
                ->get()
                ->sum(function ($query) {
                    return $query->stockInQuantity - $query->stockOutQuantity;
                });
            // End Closing Balance


            // Last Purchase Price Within a Date (sDate-eDate)
            $closingPurchaseAmount = 0;
            $closingPurchaseAmount = DB::table('tbl_purchase_products
')
                ->join('tbl_purchases', 'tbl_purchase_products
.purchase_id', '=', 'tbl_purchases.id')
                ->where('tbl_purchases.deleted', 'No')
                ->where('tbl_purchase_products
.deleted', 'No')
                ->where('tbl_purchases.date', '<=', $eDate)
                ->where('tbl_purchase_products
.product_id', $spId)
                ->orderBy('tbl_purchases.date', 'desc')
                ->value('tbl_purchase_products
.unit_price');

            if (!$closingPurchaseAmount) {
                if ($product->purchase_price != 0 && $product->purchase_price != '') {
                    $closingPurchaseAmount = $product->purchase_price;
                } else {
                    $closingPurchaseAmount = $product->sale_price;
                }
            }
            // End

            // Purchase Stock Within a Date (sDate-eDate)
            /*$purchaseStock += DB::table('tbl_purchase_products
')
                ->join('purchases', 'tbl_purchase_products
.purchase_id', '=', 'purchases.id')
                ->where('purchases.deleted', 'No')
                ->where('tbl_purchase_products
.deleted', 'No')
                ->whereBetween('purchases.date', [$sDate, $eDate])
                ->where('tbl_purchase_products
.product_id', $spId)
                ->sum('quantity');
            // End

            // Sales Stock Within a Date (sDate-eDate)
            $saleStock += DB::table('sale_products')
                ->join('sales', 'sale_products.sale_id', '=', 'sales.id')
                ->where('sales.deleted', 'No')
                ->where('sale_products.deleted', 'No')
                ->whereBetween('sales.date', [$sDate, $eDate])
                ->where('sale_products.product_id', $spId)
                ->sum('quantity');*/
            // End

            // Damage Quantity  Within a Date (sDate-eDate)
            $damageQuantity = DB::table('damage_products')
                ->where('damage_products.deleted', 'No')
                ->whereBetween('damage_products.damage_date', [$sDate, $eDate])
                ->where('damage_products.products_id', $spId)
                ->sum('damage_quantity');
            // End

            $tempTotalOpeningProductStock = ($openingBalance + $product->opening_stock);
            $tempTotalClosingProductStock = ($closingStock + $product->opening_stock);

            $purchaseAmount = $closingPurchaseAmount; // Last Purchase Price Within a Date (sDate-eDate)
            $osValue += ($tempTotalOpeningProductStock * $purchaseAmount); //Opening stock value in amount
            $csValue += ($tempTotalClosingProductStock * $purchaseAmount); //Closing stock value in amount

            $damageProductCosts += ($damageQuantity * $purchaseAmount);
        }

        ///==== End
        $data = [
            'osValue' => $osValue,
            'csValue' => $csValue,
            'damageProductCosts' => $damageProductCosts,
        ];

        return $data;
        ///=============== End New =========================///
    }







    public function generateSalesDetailsAccountsPdf($date_from, $date_to)
    {
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
    $applicantSale = ChartOfAccounts::where('slug', '=', 'sale-applicant-service')->where('sister_concern_id','=',$logged_sister_concern_id)->where('deleted', 'No')->first();
    $applicantSaleReturn = ChartOfAccounts::where('slug', '=', 'sales-ruturn')->where('sister_concern_id','=',$logged_sister_concern_id)->where('deleted', 'No')->first();
  
    $sales = DB::table('tbl_acc_voucher_details')
            ->join('tbl_accounts_vouchers', 'tbl_acc_voucher_details.tbl_acc_voucher_id', '=', 'tbl_accounts_vouchers.id')
            ->join('tbl_booking', 'tbl_accounts_vouchers.type_no', '=', 'tbl_booking.id')
            ->join('parties', 'tbl_accounts_vouchers.vendor_id', '=', 'parties.id')
            ->select('tbl_acc_voucher_details.credit', 'tbl_acc_voucher_details.voucher_title', 'tbl_acc_voucher_details.created_date', 'parties.name','tbl_accounts_vouchers.type_no','tbl_booking.sale_no')
            ->whereNotNull('credit')
            ->whereBetween('tbl_accounts_vouchers.transaction_date', [$date_from, $date_to])
            ->where('tbl_acc_voucher_details.tbl_acc_coa_id','=', $applicantSale->id)
            ->where('tbl_acc_voucher_details.sister_concern_id','=',$logged_sister_concern_id)
            ->where('tbl_accounts_vouchers.deleted','=','No')
            ->where('tbl_accounts_vouchers.status','=','Active')
            ->where('tbl_acc_voucher_details.deleted','=','No')
            ->where('tbl_acc_voucher_details.status','=','Active')
            ->get();
   
    
        
    $salesReturns = DB::table('sale_returns')
                    ->join('parties', 'sale_returns.customer_id', '=', 'parties.id')
                    ->select('sale_returns.grand_total', 'sale_returns.sale_return_date', 'sale_returns.sale_no', 'parties.name')
                    ->whereBetween('sale_returns.sale_return_date', [$date_from, $date_to])
                    ->where('sale_returns.deleted', 'No')
                    ->where('sale_returns.coa_id', $applicantSaleReturn->id)
                    ->get();
        
    $pdf = PDF::loadView('admin.reports.salesSummaryPdf',[
                                                            'date_from' => $date_from,
                                                            'date_to' => $date_to,
                                                            'sales' => $sales,
                                                            'salesReturns' => $salesReturns
                                                        ]);

    return $pdf->stream('accounts-summary-pdf.pdf', array("Attachment" => false));

    }







    public function generateSaleReturnDetailsAccountsPdf($date_from, $date_to){
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
        $applicationReturnCoa = ChartOfAccounts::where('slug', '=', 'sale-applicant-service')->where('sister_concern_id','=',$logged_sister_concern_id)->where('deleted', 'No')->first();
        $saleOrderReturns = DB::table('tbl_acc_voucher_details')
            ->join('tbl_accounts_vouchers', 'tbl_acc_voucher_details.tbl_acc_voucher_id', '=', 'tbl_accounts_vouchers.id')
            ->join('sale_order_returns', 'tbl_accounts_vouchers.sale_order_return_id', '=', 'sale_order_returns.id')
            ->join('parties', 'tbl_accounts_vouchers.vendor_id', '=', 'parties.id')
            ->select(   'tbl_acc_voucher_details.credit',
                        'tbl_acc_voucher_details.debit', 
                        'tbl_acc_voucher_details.voucher_title', 
                        'tbl_acc_voucher_details.created_date', 
                        'tbl_accounts_vouchers.type_no',
                        'sale_order_returns.grand_total', 
                        'sale_order_returns.sale_order_return_date', 
                        'sale_order_returns.sale_order_no',
                        'parties.name',
                        'sale_order_returns.sale_order_return_no'
                        )
            ->whereNotNull('debit')
            ->whereBetween('tbl_accounts_vouchers.transaction_date', [$date_from, $date_to])
            ->where('tbl_acc_voucher_details.tbl_acc_coa_id','=', $applicationReturnCoa->id)
            ->where('tbl_acc_voucher_details.sister_concern_id','=',$logged_sister_concern_id)
            ->where('tbl_accounts_vouchers.deleted','=','No')
            ->where('tbl_accounts_vouchers.status','=','Active')
            ->where('tbl_acc_voucher_details.deleted','=','No')
            ->where('tbl_acc_voucher_details.status','=','Active')
            ->get();
        
        $pdf = PDF::loadView('admin.reports.saleReturnSummary',[
                                                                'date_from' => $date_from,
                                                                'date_to' => $date_to,
                                                                'saleOrderReturns' => $saleOrderReturns
                                                            ]);
    
        return $pdf->stream('application-return-summary-pdf.pdf', array("Attachment" => false));
    }








    public function generatePurchaseDetailsAccountsPdf($date_from, $date_to)
    {
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
    $purchaseCoa = ChartOfAccounts::where('slug', '=', 'purchase-vendor-service')->where('deleted', 'No')->where('sister_concern_id','=',$logged_sister_concern_id)->first();
    
    $purchases = DB::table('tbl_acc_voucher_details')
                        ->join('tbl_accounts_vouchers', 'tbl_acc_voucher_details.tbl_acc_voucher_id', '=', 'tbl_accounts_vouchers.id')
                        ->join('parties', 'tbl_accounts_vouchers.vendor_id', '=', 'parties.id')
                        ->select('tbl_acc_voucher_details.debit', 'tbl_acc_voucher_details.voucher_title', 'tbl_acc_voucher_details.created_date', 'parties.name')
                        ->whereNotNull('debit')
                        ->whereBetween('tbl_accounts_vouchers.transaction_date', [$date_from, $date_to])
                        ->where('tbl_acc_voucher_details.tbl_acc_coa_id', '=', $purchaseCoa->id)
                        ->where('tbl_acc_voucher_details.sister_concern_id', '=',$logged_sister_concern_id)
                        ->where('tbl_accounts_vouchers.deleted', '=', 'No')
                        ->where('tbl_accounts_vouchers.status', '=', 'Active')
                        ->where('tbl_acc_voucher_details.deleted', '=', 'No')
                        ->where('tbl_acc_voucher_details.status', '=', 'Active')
                        ->get();
        
    $pdf = PDF::loadView('admin.reports.purchaseSummaryPdf',[   'date_from' => $date_from,
                                                                'date_to' => $date_to,
                                                                'purchases' => $purchases
                                                            ]);
    return $pdf->stream('vendor-order-pdf.pdf', array("Attachment" => false));
    }
    
    
    
    
    public function generatePurchaseReturnDetailsAccountsPdf($date_from, $date_to){
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
        $purchaseCoa = ChartOfAccounts::where('slug', '=', 'purchase-vendor-service')->where('deleted', 'No')->where('sister_concern_id','=',$logged_sister_concern_id)->first();
        $vendorOrderReturns = DB::table('tbl_acc_voucher_details')
            ->join('tbl_accounts_vouchers', 'tbl_acc_voucher_details.tbl_acc_voucher_id', '=', 'tbl_accounts_vouchers.id')
            ->join('sale_order_returns', 'tbl_accounts_vouchers.sale_order_return_id', '=', 'sale_order_returns.id')
            ->join('parties', 'tbl_accounts_vouchers.vendor_id', '=', 'parties.id')
            ->select(   'tbl_acc_voucher_details.credit',
                        'tbl_acc_voucher_details.debit', 
                        'tbl_acc_voucher_details.voucher_title', 
                        'tbl_acc_voucher_details.created_date', 
                        'tbl_accounts_vouchers.type_no',
                        'sale_order_returns.grand_total', 
                        'sale_order_returns.sale_order_return_date', 
                        'sale_order_returns.sale_order_no',
                        'parties.name',
                        'sale_order_returns.sale_order_return_no'
                        )
            ->whereNotNull('credit')
            ->whereBetween('tbl_accounts_vouchers.transaction_date', [$date_from, $date_to])
            ->where('tbl_acc_voucher_details.tbl_acc_coa_id','=', $purchaseCoa->id)
            ->where('tbl_acc_voucher_details.sister_concern_id','=',$logged_sister_concern_id)
            ->where('tbl_accounts_vouchers.deleted','=','No')
            ->where('tbl_accounts_vouchers.status','=','Active')
            ->where('tbl_acc_voucher_details.deleted','=','No')
            ->where('tbl_acc_voucher_details.status','=','Active')
            ->get();
        $pdf = PDF::loadView('admin.reports.vendorReturnSummary',[   'date_from' => $date_from,
                                                                'date_to' => $date_to,
                                                                'vendorOrderReturns' => $vendorOrderReturns
                                                            ]);
        return $pdf->stream('vendor-order-return-pdf.pdf', array("Attachment" => false));
    }
    
    
    public function generateExpenseDetailsAccountsPdf($date_from, $date_to, $expenseId)
    {
        $expenseName = ChartOfAccounts::where('id', $expenseId)->value('name');
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
        $expenseData = DB::table('tbl_acc_expense_details')
            ->join('tbl_acc_expenses', 'tbl_acc_expenses.id', '=', 'tbl_acc_expense_details.tbl_acc_expense_id')
            ->leftjoin('our_teams', 'tbl_acc_expenses.tbl_crm_vendor_id', '=', 'our_teams.id')
            ->select('tbl_acc_expense_details.amount','tbl_acc_expenses.expense_no', 'tbl_acc_expenses.transaction_date', 'tbl_acc_expense_details.particulars', 'our_teams.member_name')
            ->whereBetween('tbl_acc_expenses.transaction_date', [$date_from, $date_to])
            ->where('tbl_acc_expense_details.tbl_acc_coa_id', '=', $expenseId)
            ->where('tbl_acc_expense_details.sister_concern_id', '=',$logged_sister_concern_id)
            ->where('tbl_acc_expenses.deleted', '=', 'No')
            ->where('tbl_acc_expenses.status', '=', 'Active')
            ->where('tbl_acc_expense_details.deleted', '=', 'No')
            ->where('tbl_acc_expense_details.status', '=', 'Active')
            ->get();
            
        $pdf = PDF::loadView(
            'admin.reports.expenseSummaryPdf',
            [
                'date_from' => $date_from,
                'date_to' => $date_to,
                'expenseName' => $expenseName,
                'expenseData' => $expenseData,
            ]
        );
        return $pdf->stream('accounts-summary-pdf.pdf', array("Attachment" => false));
    }
    public function generateOpenigClosingStockDetailsPdf($date_from, $date_to, $stockType = '')
    {
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
        $products = DB::table('tbl_inventory_products')
            ->select('id', 'name', 'purchase_price', 'sale_price', 'opening_stock')
            ->where('deleted', 'No')
            ->whereNotIn('type', ['service'])
            ->where('status', 'Active')
            ->get();


        $pdf = PDF::loadView(
            'admin.reports.openingClosingStocksSummaryPdf',
            [
                'stockType' => $stockType,
                'products' => $products,
                'date_from' => $date_from,
                'date_to' => $date_to,
            ]
        );
        
        return $pdf->stream('accounts-summary-pdf.pdf', array("Attachment" => false));
    }
    public function closingBalanceStore(Request $request)
    {
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
        $lastTwoChar = substr(($request->date_to), -2);
        $time = strtotime($request->date_to);
        $month = date("F", $time);
        $year = date("Y", $time);
        $monthYear = date("F Y", $time);

        $checkPreviousMonthYear = '';
        $checkPreviousMonthYear = MonthlyReport::where('month_year', '=', $monthYear)->first();
        if ($checkPreviousMonthYear != null) {
            $checkPreviousMonthYear->from_date = $request->date_from;
            $checkPreviousMonthYear->to_date = $request->date_to;
            $checkPreviousMonthYear->month_year = $monthYear;
            $checkPreviousMonthYear->sister_concern_id = $logged_sister_concern_id;
            $checkPreviousMonthYear->previous_month_closing = $request->previousMonthClosing;
            $checkPreviousMonthYear->opening_balance = $request->presentClosingBalance;
            $checkPreviousMonthYear->present_month_closing = $request->presentClosingBalance;
            $checkPreviousMonthYear->last_updated_by = Auth::user()->id;
            $checkPreviousMonthYear->save();
            return response()->json(['success' => 'Closing balance updated successfully']);
        } else {
            $closing = new MonthlyReport();
            $closing->from_date = $request->date_from;
            $closing->to_date = $request->date_to;
            $closing->sister_concern_id = $logged_sister_concern_id;
            $closing->previous_month_closing = $request->previousMonthClosing;
            $closing->opening_balance = $request->presentClosingBalance;
            $closing->present_month_closing = $request->presentClosingBalance;
            $closing->month_year = $monthYear;
            $closing->created_by = Auth::user()->id;
            $closing->deleted = 'No';
            $closing->status = 'Active';
            $closing->save();
            return response()->json(['success' => 'Closing balance saved successfully']);
        }
    }



    public function generateAccountsSummaryPdf($date_from, $date_to)
    {
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
        $time = strtotime($date_from);
        $month = date("F", $time);
        $year = date("Y", $time);
        $monthYear = date("F Y", $time);


        $income = ChartOfAccounts::where('name', '=', 'Income')->where('deleted', 'No')->first();
        $incomeId = $income->id;
        $allIncomes = ChartOfAccounts::where('parent_id', '=', $incomeId)->where('deleted', 'No')->get();

        $sales = ChartOfAccounts::where('name', '=', 'Sales')->where('deleted', 'No')->first();
        $salesId = $sales->id;
        $allsales = ChartOfAccounts::where('parent_id', '=', $salesId)->where('deleted', 'No')->get();

        $expense = ChartOfAccounts::where('name', '=', 'Expense')->where('deleted', 'No')->first();
        $expenseId = $expense->id;

        $allExpense = ChartOfAccounts::where('parent_id', '=', $expenseId)->where('deleted', 'No')->get();

        $purchase = ChartOfAccounts::where('name', '=', 'Purchases')->where('deleted', 'No')->first();
        $purchaseId = $purchase->id;
        $allpurchases = ChartOfAccounts::where('parent_id', '=', $purchaseId)->where('deleted', 'No')->get();

        $backDateFrom = date('0' . (date("m", strtotime($date_from)) - 1) . '-d-Y');

        $CashInHandFrom = DB::table('tbl_acc_voucher_details')
            ->join('tbl_accounts_vouchers', 'tbl_acc_voucher_details.tbl_acc_voucher_id', '=', 'tbl_accounts_vouchers.id')
            ->select('tbl_acc_voucher_details.*', 'tbl_accounts_vouchers.transaction_date')
            ->where('tbl_accounts_vouchers.transaction_date', '>=', $backDateFrom)
            ->where('tbl_accounts_vouchers.transaction_date', '<=', $date_from)
            ->where('tbl_acc_voucher_details.sister_concern_id', '=',$logged_sister_concern_id)
            ->where('tbl_accounts_vouchers.deleted', '=', 'No')
            ->where('tbl_accounts_vouchers.status', '=', 'Active')
            ->where('tbl_acc_voucher_details.deleted', '=', 'No')
            ->where('tbl_acc_voucher_details.status', '=', 'Active')
            ->get();
        $salesCashFrom = 0;
        foreach ($CashInHandFrom as $debit) {
            $salesCashFrom += $debit->debit;
        }

        $CashInHandTo = DB::table('tbl_acc_voucher_details')
            ->join('tbl_accounts_vouchers', 'tbl_acc_voucher_details.tbl_acc_voucher_id', '=', 'tbl_accounts_vouchers.id')
            ->select('tbl_acc_voucher_details.*', 'tbl_accounts_vouchers.transaction_date')
            ->where('tbl_accounts_vouchers.transaction_date', '>=', $backDateFrom)
            ->where('tbl_accounts_vouchers.transaction_date', '<=', $date_from)
            ->where('tbl_acc_voucher_details.sister_concern_id', '=',$logged_sister_concern_id)
            ->where('tbl_accounts_vouchers.deleted', '=', 'No')
            ->where('tbl_accounts_vouchers.status', '=', 'Active')
            ->where('tbl_acc_voucher_details.deleted', '=', 'No')
            ->where('tbl_acc_voucher_details.status', '=', 'Active')
            ->get();
        $salesCashTo = 0;
        foreach ($CashInHandTo as $credit) {
            $salesCashTo += $credit->credit;
        }

        $previousMonthYear = date('F Y', strtotime('-1 month', $time));
        $openings = MonthlyReport::where('month_year', '=', $previousMonthYear)->where('deleted', 'No')->first();
        if ($openings != null) {
            $openingbalance = $openings->opening_balance;
        } else {
            $openingbalance = '0.00';
        }
        $openingCash = $salesCashFrom - $salesCashTo;

        $monthYearHeader = '';
        $monthYearHeader .= '';
        $table = '';
        $closingBtn = '';
        $table .= '<table class="table  "  width="100%" >
                        <tr>
                        <td width="50%">
                            <table class="table table-hover dataTable no-footer " style="margin-left:-10px; border-top: 1.5px solid black;" border="1">
                            <tbody>';

        $table .= '<tr class=" text-center  font-weight-bold" width="100%"><td colspan="3"> Income </td></tr>';

        $totalIncome = 0;
        foreach ($allIncomes as $income) {
            $incomeAmounts = DB::table('tbl_acc_voucher_details')
                ->join('tbl_accounts_vouchers', 'tbl_acc_voucher_details.tbl_acc_voucher_id', '=', 'tbl_accounts_vouchers.id')
                ->select('tbl_acc_voucher_details.*', 'tbl_accounts_vouchers.transaction_date')
                ->where('tbl_accounts_vouchers.transaction_date', '>=', $date_from)
                ->where('tbl_accounts_vouchers.transaction_date', '<=', $date_to)
                ->where('tbl_acc_voucher_details.tbl_acc_coa_id', '=', $income->id)
                ->where('tbl_acc_voucher_details.sister_concern_id', '=',$logged_sister_concern_id)
                ->where('tbl_accounts_vouchers.deleted', '=', 'No')
                ->where('tbl_accounts_vouchers.status', '=', 'Active')
                ->where('tbl_acc_voucher_details.deleted', '=', 'No')
                ->where('tbl_acc_voucher_details.status', '=', 'Active')
                ->get();


            $amountDebitSum = 0;

            foreach ($incomeAmounts as $amount) {
                $amountDebitSum += $amount->debit;
            }
            $table .= '<tr width="100%">
                            <td width="70%">' . $income->name . '</td>
                            <td width="30%" class="text-right">' . number_format($amountDebitSum) . '</td>
                        </tr>';
            $totalIncome += $amountDebitSum;
        }

        // Sale Section
        $totalSales = 0;
        $count = count($allsales) - 1;

        foreach ($allsales as $key => $sale) {
            $saleAmounts = DB::table('tbl_acc_voucher_details')
                ->join('tbl_accounts_vouchers', 'tbl_acc_voucher_details.tbl_acc_voucher_id', '=', 'tbl_accounts_vouchers.id')
                ->whereBetween('tbl_accounts_vouchers.transaction_date', [$date_from, $date_to])
                ->where('tbl_acc_voucher_details.tbl_acc_coa_id', '=', $sale->id)
                ->where('tbl_acc_voucher_details.sister_concern_id', '=',$logged_sister_concern_id)
                ->where('tbl_accounts_vouchers.deleted', '=', 'No')
                ->where('tbl_accounts_vouchers.status', '=', 'Active')
                ->where('tbl_acc_voucher_details.deleted', '=', 'No')
                ->where('tbl_acc_voucher_details.status', '=', 'Active')
                ->sum('credit');

            $amountDebitSum = $saleAmounts;
            $totalSales += $saleAmounts;

            $amountDebitSum = $amountDebitSum;
            // Sales Return
            $totalSaleReturnAmount = 0;
            $setBracket = '';
            $setBracket2 = '';
            if ($sale->slug == "sales-ruturn") {
                $amountDebitSum = SaleReturn::whereBetween('sale_return_date', [$date_from, $date_to])
                    ->where('deleted', 'No')->where('coa_id', $sale->id)->sum('grand_total');

                $totalSaleReturnAmount = $amountDebitSum;
                $setBracket = '(';
                $setBracket2 = ')';
            }
            $netSalesAmount = '';
            if ($count == $key) {
                $netSalesAmount = $totalSales - $totalSaleReturnAmount;
            }

            $table .= '<tr width="100%">
                           <td width="50%">' . $sale->name . '</td>
                           <td width="25%" class="text-right">' . $setBracket . $amountDebitSum . $setBracket2 . '</td>
                           <td width="25%" class="text-right">' . $netSalesAmount . '</td>
                       </tr>';
        }

        $totalIncomeWithOpening = (($openingbalance + $totalIncome + $totalSales) - $totalSaleReturnAmount);

        // Purchase Section
        $table .= '</tbody>
                            </table>
                        </td>
                        <td width="50%">
                            <table class="table-hover dataTable no-footer" width="100%" style="margin-left:-24.5px;border-top: 1.5px solid black;" border="1"> 
                            <tbody>';

        $purchaseSum = 0;
        $totalPurchases = 0;
        $count = count($allpurchases) - 1;

        $table .= '<tr class=" text-center font-weight-bold"><td colspan="3"> Expenditure </td></tr>';

        foreach ($allpurchases as $key =>  $purchase) {
            $purchaseAmounts = DB::table('tbl_acc_voucher_details')
                ->join('tbl_accounts_vouchers', 'tbl_acc_voucher_details.tbl_acc_voucher_id', '=', 'tbl_accounts_vouchers.id')
                ->select('tbl_acc_voucher_details.*', 'tbl_accounts_vouchers.transaction_date', 'tbl_accounts_vouchers.type')
                ->whereBetween('tbl_accounts_vouchers.transaction_date', [$date_from, $date_to])
                ->where('tbl_acc_voucher_details.tbl_acc_coa_id', '=', $purchase->id)
                ->where('tbl_acc_voucher_details.sister_concern_id', '=',$logged_sister_concern_id)
                ->where('tbl_accounts_vouchers.deleted', '=', 'No')
                ->where('tbl_accounts_vouchers.status', '=', 'Active')
                ->where('tbl_acc_voucher_details.deleted', '=', 'No')
                ->where('tbl_acc_voucher_details.status', '=', 'Active')
                ->sum('debit');
            $amountSum = $purchaseAmounts;
            $totalPurchases += $purchaseAmounts;

            // Purchase Return
            $setBracket = '';
            $setBracket2 = '';
            $totalPurchaseReturnAmount = 0;
            if ($purchase->slug == "purchase-return") {
                $amountSum = Purchase_Return::whereBetween('purchase_return_date', [$date_from, $date_to])->where('deleted', 'No')->where('coa_id', $purchase->id)->sum('grand_total');
                $totalPurchaseReturnAmount = $amountSum;
                $setBracket = '(';
                $setBracket2 = ')';
            }
            $netPurchaseAmount = '';
            if ($count == $key) {
                $netPurchaseAmount = $totalPurchases - $totalPurchaseReturnAmount;
            }

            $table .= '<tr  width="100%">
                           <td width="50%">' . $purchase->name . '</td>
                           <td width="25%" class="text-right">' . $setBracket . $amountSum . $setBracket2 . '</td>
                           <td width="25%" class="text-right">' . $netPurchaseAmount . '</td>
                        </tr>';
            if ($purchase->id != 43) {
                $purchaseSum += $amountSum;
            }
        }

        $table .= '<tr class=" text-center"><td colspan="3"></td></tr>';

        $expenseSum = 0;
        $totalExpenses = 0;
        $count = count($allExpense) - 1;
        foreach ($allExpense as $key =>  $expense) {
            $incomeAmounts = DB::table('tbl_acc_voucher_details')
                ->join('tbl_accounts_vouchers', 'tbl_acc_voucher_details.tbl_acc_voucher_id', '=', 'tbl_accounts_vouchers.id')
                ->select('tbl_acc_voucher_details.*', 'tbl_accounts_vouchers.transaction_date', 'tbl_accounts_vouchers.type')
                ->whereBetween('tbl_accounts_vouchers.transaction_date', [$date_from, $date_to])
                ->where('tbl_acc_voucher_details.tbl_acc_coa_id', '=', $expense->id)
                ->where('tbl_acc_voucher_details.sister_concern_id', '=',$logged_sister_concern_id)
                ->where('tbl_accounts_vouchers.deleted', '=', 'No')
                ->where('tbl_accounts_vouchers.status', '=', 'Active')
                ->where('tbl_acc_voucher_details.deleted', '=', 'No')
                ->where('tbl_acc_voucher_details.status', '=', 'Active')
                ->get();
            $amountSum = 0;
            foreach ($incomeAmounts as $amount) {
                $amountSum += $amount->credit;
                $totalExpenses += $amount->credit;
            }
            $tempTotalExpenses = '';
            if ($count == $key) {
                $tempTotalExpenses = $totalExpenses;
            }

            $table .= '<tr>
                           <td width="50%">' . $expense->name . '</td>
                           <td width="25%" class="text-right">' . number_format($amountSum) . '</td>
                           <td width="25%" class="text-right">' . $tempTotalExpenses . '</td>
                        </tr>';
            $expenseSum += $amountSum;
        }

        $totalExpense = (($expenseSum + $purchaseSum) - $totalPurchaseReturnAmount);
        $table .= '</tbody>
                            </table>
                        </td>
                        
                    </tr>
                    <tr>
                        <td>
                            <table class=" table-hover dataTable no-footer" width="207%" style="margin-left:-10px;border-top: 1.2px solid black; " border="1">
                                <tbody>
                                    <tr class=" font-weight-bold">
                                        <td width="65%">Total Income: </td>
                                        <td width="35%" class="text-right">' . number_format($totalIncomeWithOpening) . '</td>

                                        <td width="70%">Total Expense: </td>
                                        <td width="30%" class="text-right font-weight-bold">' . number_format($totalExpense) . '</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>';
        $due = $totalIncomeWithOpening - $totalExpense;
        if ($totalIncomeWithOpening < $totalExpense) {
            $incomeClosing = $due;
            $expenseClosing = '0';
        } elseif ($totalIncomeWithOpening > $totalExpense) {
            $incomeClosing = '0';
            $expenseClosing = $due;
        } else {
            $incomeClosing = '0';
            $expenseClosing = '0';
        }

        $totalIncomeWithDue = $totalIncomeWithOpening - $incomeClosing;
        $totalExpenseWithDue = $totalExpense + $expenseClosing;
        $clss = "bg-success";
        if ($totalIncomeWithOpening < $totalExpense) {
            $clss = "bg-danger";
        }
        $table .= '<tr>
                        <td>
                            <table class="table-hover dataTable no-footer" width="100%" style="margin-left:-10px;border-top: 1.2px solid black;" border="1">
                                <tbody>
                                    <tr class="font-weight-bold">
                                        <td width="70%">Balance Closing: </td>
                                        <td width="30%" class="text-right"><strong>' . number_format($expenseClosing) . '</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>';


        // Start Voucher Section
        $voucherSummary = DB::table('tbl_voucher_payment_vouchers')
            ->where('tbl_voucher_payment_vouchers.sister_concern_id', '=',$logged_sister_concern_id)
            ->whereBetween('paymentDate', [$date_from, $date_to])
            ->where('deleted', 'No')
            ->where('status', 'Active')
            ->whereNull('purchase_id')
            ->whereNull('order_sale_id')
            ->whereNull('sales_id')
            ->whereNull('purchase_return_id')
            ->whereNull('sales_return_id')
            ->whereNull('expense_id')
            ->select(
                DB::raw('SUM(CASE WHEN type="Payment Received" THEN tbl_voucher_payment_vouchers.amount END) totalVoucherRcvAmount'),
                DB::raw('SUM(CASE WHEN type="Payment" THEN tbl_voucher_payment_vouchers.amount END) totalVoucherPaymentAmount')
            )->first();
        $table .= '<tr>
                    <td>
                        <table class="table-hover dataTable no-footer" width="100%" style="margin-left:-10px;border-top: 1.2px solid black;" border="1">>
                            <tbody>
                                <tr class="">
                                    <td width="70%"> Voucher Recipient </td>
                                    <td width="30%" class="text-right"><strong>' . number_format($voucherSummary->totalVoucherRcvAmount) . '</strong></td>
                                </tr>
                                <tr class="">
                                    <td width="70%"> Payment Voucher </td>
                                    <td width="30%" class="text-right"><strong>' .  number_format($voucherSummary->totalVoucherPaymentAmount)  . '</strong></td>
                                </tr>
                                <tr class="">
                                    <td width="70%"> Cash In Hand </td>
                                    <td width="30%" class="text-right"><strong>' . number_format(($voucherSummary->totalVoucherRcvAmount - $voucherSummary->totalVoucherPaymentAmount)) . '</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>';
        // End Voucher Section

        $lastTwoChar = substr(($date_to), -2);
        $time = strtotime($date_to);
        $month = date("F", $time);
        $year = date("Y", $time);
        $monthYear = date("F Y", $time);

        $month_value = date("m", strtotime($month));
        $month_days_count = cal_days_in_month(CAL_GREGORIAN, $month_value, $year);

        if ($lastTwoChar == $month_days_count) {
            $closingBtn = '<span class="text-success">Now you can save the closing balance.</span><button class="btn btn-primary float-right" onclick="closeBalance()">Close balance</button>';
        } else {
            $closingBtn = '<span class="text-danger">Select the last day of the month to close the balance</span><button class="btn btn-secondary float-right disabled" >Close balance</button>';
        }
        $pdf = '';
        $pdf = '<button class="btn btn-primary mt-2" onclick="generateAccountsSummaryPdf()"><i class="fas fa-print"></i> Print PDF</button>';
        $data = array(
            'table' => $table,
            'date_from' => $date_from,
            'date_to' => $date_to,

        );

        $pdf = PDF::loadView(
            'admin.reports.accountsSummaryPdf',
            [
                'data' => $data,
                'monthYear' => $monthYear,
            ]
        );
        return $pdf->stream('accounts-summary-pdf.pdf', array("Attachment" => false));

        ////////////////===========================End===========================================////////////////
    }



    public function dailyAccountsLedger()
    {
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
        $lastDailyReport = DailyReport::where('deleted', 'No')
                            ->where('status', 'Active')
                            ->where('sister_concern_id','=',$logged_sister_concern_id)
                            ->get()
                            ->last();
        if ($lastDailyReport != '') {
            $date = $lastDailyReport->date;

            $checkTransaction = DB::table('tbl_voucher_payment_vouchers')
                ->join('daily_reports', 'tbl_voucher_payment_vouchers.paymentDate', '!=', 'daily_reports.date')
                ->select('tbl_voucher_payment_vouchers.paymentDate')
                ->where('tbl_voucher_payment_vouchers.deleted', 'No')
                ->where('tbl_voucher_payment_vouchers.paymentDate', '>', $date)
                ->where('tbl_voucher_payment_vouchers.sister_concern_id', '=',$logged_sister_concern_id)
                ->where('tbl_voucher_payment_vouchers.status', 'Active')
                ->distinct()
                ->get();

            $dateArray = [];
            $i = 0;

            foreach ($checkTransaction as $date) {

                $dateArray[$i] = $date->paymentDate; // store previous not closing date(s)
                $i++;
            }
            // end check preious days report saved or not//

            $purchasePaymentATotal = 0;
            $saleReceivedTotal = 0;
            $expanseAmount = 0;
        } else {
            $dateArray = [];
        }
        return view('admin.reports.accountsDailySummary', ['dateArray' => $dateArray]);

    }


    public function getDailyReport(Request $request)
    {
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];

        $date = $request->date;

        $minusDaysFromDate =  date_create($date)->modify('-1 days')->format('Y-m-d');

        $openingData = DailyReport::where('deleted', 'No')->where('date', '<', $date)->where('sister_concern_id','=',$logged_sister_concern_id)->orderBy('date', 'DESC')->first();
        if ($openingData != null) {
            $lastDailyReport = DailyReport::where('deleted', 'No')->where('date', '<', $date)->where('sister_concern_id','=',$logged_sister_concern_id)->orderBy('date', 'DESC')->first();
        } else {
            $lastDailyReport = 0;
        }
       
        //-----today payment, expense , payment received-------//
        $todayReport = DB::table('tbl_voucher_payment_vouchers')
                    ->leftjoin('tbl_purchases', 'tbl_voucher_payment_vouchers.purchase_id', '=', 'tbl_purchases.id')
                    ->leftjoin('tbl_booking', 'tbl_voucher_payment_vouchers.order_sale_id', '=', 'tbl_booking.id')
                    ->select('tbl_voucher_payment_vouchers.*', 'tbl_booking.grand_total', 'tbl_purchases.total_amount')
                    ->where('tbl_voucher_payment_vouchers.deleted', 'No')
                    ->where('tbl_voucher_payment_vouchers.paymentDate', $date)
                    ->where('tbl_voucher_payment_vouchers.sister_concern_id', '=',$logged_sister_concern_id)
                    ->where('tbl_voucher_payment_vouchers.status', 'Active')
                    ->where('tbl_voucher_payment_vouchers.payment_method', 'Cash')
                    ->where(function ($query) {
                        $query->where('tbl_voucher_payment_vouchers.type', 'Payment')
                            ->orWhere('tbl_voucher_payment_vouchers.type', 'Payment Received');
                    })
                    ->get();

        $purchasePaymentTotal = 0;
        $paymentVoucher = 0;
        $paymentReceivedVoucher = 0;
        $saleReceivedTotal = 0;
        $expanseAmount = 0;
        $vendorOrderPaymentTotal = 0;
        $applicantOrderReceivedTotal = 0;
        $billAmount = 0;
        
        foreach ($todayReport as $report){

            if ($report->purchase_id > 0 && $report->type == "Payment"){
                $purchasePaymentTotal += $report->amount;
            }else if ($report->expense_id != null && $report->voucherType == 'Expense'){
                $expanseAmount += $report->amount;
            }else if ($report->bill_id != null  &&  $report->type == "Payment"){
                $billAmount += $report->amount;
            }else if ($report->sales_id > 0 && $report->type == "Payment Received"){
                $saleReceivedTotal += $report->amount;
            }elseif ($report->order_sale_id > 0 && $report->type == "Payment"){
                $vendorOrderPaymentTotal += $report->amount;
            }else if ($report->order_sale_id > 0 && $report->type == "Payment Received"){
                $applicantOrderReceivedTotal += $report->amount;
            }else if ($report->type == "Payment" && $report->voucherType != 'Transaction'){
                $paymentVoucher += $report->amount;
            }else if ($report->type == "Payment Received" && $report->voucherType != 'Transaction'){
                $paymentReceivedVoucher += $report->amount;
            }

        }

        //cash to bank
        $cashToBanks=Voucher::where('transaction_date','=', $date)
                            ->where('sister_concern_id', '=',$logged_sister_concern_id)
                            ->where('type', '=', 'cashTobank')
                            ->where('deleted', '=', 'No')
                            ->where('status', '=', 'Active')
                            ->get(); 
        $cashToBankAmount=0;
        foreach($cashToBanks as $cashToBank){
            $cashToBankAmount+= $cashToBank->amount;
        }
        //bank to cash
        $bankTocashes=Voucher::where('transaction_date','=', $date)
                            ->where('sister_concern_id', '=',$logged_sister_concern_id)
                            ->where('type', '=','bankTocash')
                            ->where('deleted', '=', 'No')
                            ->where('status', '=', 'Active')
                            ->get(); 
        $bankTocashAmount=0;
        foreach($bankTocashes as $bankTocash){
            $bankTocashAmount+= $bankTocash->amount;
        }
        //cash to mobile banking
        $cashTomobile_bankings=Voucher::where('transaction_date','=', $date)
                            ->where('sister_concern_id', '=',$logged_sister_concern_id)
                            ->where('type', '=', 'cashTomobile-banking')
                            ->where('deleted', '=', 'No')
                            ->where('status', '=', 'Active')
                            ->get(); 
        $cashTomobile_bankingAmount=0;
        foreach($cashTomobile_bankings as $cashTomobile_banking){
            $cashTomobile_bankingAmount+= $cashTomobile_banking->amount;
        }
        //mobile banking to cash
        $mobile_bankingToCashes=Voucher::where('transaction_date','=', $date)
                            ->where('sister_concern_id', '=',$logged_sister_concern_id)
                            ->where('type', '=', 'mobile-bankingTocash')
                            ->where('deleted', '=', 'No')
                            ->where('status', '=', 'Active')
                            ->get(); 
        $mobile_bankingToCashAmount=0;
        foreach($mobile_bankingToCashes as $mobile_bankingToCash){
            $mobile_bankingToCashAmount+= $mobile_bankingToCash->amount;
        }


        $TotalPayment = $purchasePaymentTotal + $paymentVoucher+$vendorOrderPaymentTotal;
        $todayBalance = ($saleReceivedTotal + $paymentReceivedVoucher+$bankTocashAmount+$applicantOrderReceivedTotal+$mobile_bankingToCashAmount) - ($TotalPayment + $expanseAmount + $billAmount + $cashToBankAmount + $cashTomobile_bankingAmount);
        $todayReportArray = [$purchasePaymentTotal, $saleReceivedTotal, $expanseAmount,  $todayBalance];


        $todayReportTable = '<tr>
                                <td>Payment(-)</td>
                                <td>' . number_format($TotalPayment, 2) . '</td>
                            </tr>
                            <tr>
                                <td>Expense(-)</td>
                                <td>' . number_format($expanseAmount, 2) . '</td>
                            </tr>
                            <tr>
                                <td>Bill(-)</td>
                                <td>' . number_format($billAmount, 2) . '</td>
                            </tr>
                            <tr>
                                <td>Payment Received(+)</td>
                                <td>' . number_format($saleReceivedTotal + $paymentReceivedVoucher + $applicantOrderReceivedTotal, 2) . '</td>
                            </tr>
                            <tr>
                                <td>Cash To Bank (-)</td>
                                <td>' . number_format($cashToBankAmount,2) . '</td>
                            </tr>
                            <tr>
                                <td>Bank To Cash (+)</td>
                                <td>' . number_format($bankTocashAmount,2) . '</td>
                            </tr>
                            <tr>
                                <td>Cash To Mobile Banking (-)</td>
                                <td>' . number_format($cashTomobile_bankingAmount,2) . '</td>
                            </tr>
                            <tr>
                                <td>Mobile Banking To Cash (+)</td>
                                <td>' . number_format($mobile_bankingToCashAmount,2) . '</td>
                            </tr>
                            <tr>
                                <td>Balance </td>
                                <td>' . number_format($todayBalance, 2) . '</td>
                            </tr>';



        $todayOtherMethodsReports = DB::table('tbl_voucher_payment_vouchers')
                    ->leftjoin('tbl_purchases', 'tbl_voucher_payment_vouchers.purchase_id', '=', 'tbl_purchases.id')
                    ->leftjoin('tbl_booking', 'tbl_voucher_payment_vouchers.order_sale_id', '=', 'tbl_booking.id')
                    ->select('tbl_voucher_payment_vouchers.*', 'tbl_booking.grand_total', 'tbl_purchases.total_amount')
                    ->where('tbl_voucher_payment_vouchers.deleted', 'No')
                    ->where('tbl_voucher_payment_vouchers.paymentDate', $date)
                    ->where('tbl_voucher_payment_vouchers.sister_concern_id', '=',$logged_sister_concern_id)
                    ->where('tbl_voucher_payment_vouchers.status', 'Active')
                    ->where(function ($query) {
                        $query->where('tbl_voucher_payment_vouchers.type', 'Payment')
                            ->orWhere('tbl_voucher_payment_vouchers.type', 'Payment Received');
                    })
                    ->where(function ($query) {
                        $query->where('tbl_voucher_payment_vouchers.payment_method', 'Bank')
                            ->orWhere('tbl_voucher_payment_vouchers.payment_method', 'Mobile Banking');
                    })
                    ->get();

        $vendorOrderBankPaymentTotal = 0;
        $applicantOrderReceivedBankTotal = 0;
        $expanseAmountBank = 0;
        $vendorOrderMobileBankingPaymentTotal = 0;
        $applicantOrderReceivedMobileBankingTotal = 0;
        $expanseAmountMobileBanking = 0;
        $todayBankReportTable='';
        $todayMobileBankingReportTable='';

        foreach ($todayOtherMethodsReports as $todayOtherMethodsReport){
            if($todayOtherMethodsReport->payment_method == 'Bank'){
                if ($todayOtherMethodsReport->order_sale_id > 0 && $todayOtherMethodsReport->type == "Payment"){
                    $vendorOrderBankPaymentTotal += $todayOtherMethodsReport->amount;
                }else if ($todayOtherMethodsReport->order_sale_id > 0 && $todayOtherMethodsReport->type == "Payment Received"){
                    $applicantOrderReceivedBankTotal += $todayOtherMethodsReport->amount;
                }else if ($todayOtherMethodsReport->expense_id != null && $todayOtherMethodsReport->voucherType == 'Expense'){
                    $expanseAmountBank += $todayOtherMethodsReport->amount;
                }
            }elseif($todayOtherMethodsReport->payment_method == 'Mobile Banking'){
                if ($todayOtherMethodsReport->order_sale_id > 0 && $todayOtherMethodsReport->type == "Payment"){
                    $vendorOrderMobileBankingPaymentTotal += $todayOtherMethodsReport->amount;
                }else if ($todayOtherMethodsReport->order_sale_id > 0 && $todayOtherMethodsReport->type == "Payment Received"){
                    $applicantOrderReceivedMobileBankingTotal += $todayOtherMethodsReport->amount;
                }else if ($todayOtherMethodsReport->expense_id != null && $todayOtherMethodsReport->voucherType == 'Expense'){
                    $expanseAmountMobileBanking += $todayOtherMethodsReport->amount;
                }
            }
        }

        
        $todayBankReportTable =    '<tr>
                                                <td>Payment(-)</td>
                                                <td>' . number_format($vendorOrderBankPaymentTotal, 2) . '</td>
                                            </tr>
                                            <tr>
                                                <td>Expense(-)</td>
                                                <td>' . number_format($expanseAmountBank, 2) . '</td>
                                            </tr>
                                            <tr>
                                                <td>Payment Received(+)</td>
                                                <td>' . number_format($applicantOrderReceivedBankTotal, 2) . '</td>
                                            </tr>';
        $todayMobileBankingReportTable =    '<tr>
                                                <td>Payment(-)</td>
                                                <td>' . number_format($vendorOrderMobileBankingPaymentTotal, 2) . '</td>
                                            </tr>
                                            <tr>
                                                <td>Expense(-)</td>
                                                <td>' . number_format($expanseAmountMobileBanking, 2) . '</td>
                                            </tr>
                                            <tr>
                                                <td>Payment Received(+)</td>
                                                <td>' . number_format($applicantOrderReceivedMobileBankingTotal, 2) . '</td>
                                            </tr>';


                            
        return response()->json([$todayReportTable, $lastDailyReport, $todayReportArray,$todayBankReportTable,$todayMobileBankingReportTable]);
    }
  



    public function saveTodayReport(Request $request)
    {

       DB::beginTransaction();
       try {
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
          $date = $request->date;
          $dailyReport = DailyReport::where('date', $date)
                                    ->where('deleted', 'No')
                                    ->where('status', 'Active')
                                    ->where('sister_concern_id','=',$logged_sister_concern_id)
                                    ->get()
                                    ->last();
          if ($dailyReport){
             $dailyReportId = $dailyReport->id;
             $isTodayDate = $dailyReport->date;
             if ($isTodayDate = $date) {
                $dailyReport = DailyReport::find($dailyReportId);
                $dailyReport->date = $date;
                $dailyReport->previous_closing = $request->openingBalance; //(previous) openingBalance as (today) previous_closing
                $dailyReport->today_closing = $request->totalAmount; // today credit
                $dailyReport->opening_balance = $request->closingAmount;
                $dailyReport->sister_concern_id = $logged_sister_concern_id;
                $dailyReport->created_at = Carbon::now();
                $dailyReport->created_by = auth()->user()->id;
                $dailyReport->save();
             }
          } else {
             $dailyReport = new DailyReport();
             $dailyReport->date =  $date;
             $dailyReport->previous_closing = $request->openingBalance; //(previous) openingBalance as (today) previous_closing
             $dailyReport->today_closing = $request->totalAmount; // today credit
             $dailyReport->opening_balance = $request->closingAmount;
             $dailyReport->sister_concern_id = $logged_sister_concern_id;
             $dailyReport->status = "Active";
             $dailyReport->deleted = "No";
             $dailyReport->created_at = Carbon::now();
             $dailyReport->created_by = auth()->user()->id;
             $dailyReport->save();
          }
 
          DB::commit();
          return response()->json(['success' => "report saved successfully."]);
       } catch (Exception $e) {
          DB::rollBack();
          return response()->json(['error' => 'report rollBack ' . $e]);
       }
    }
 




    public function generateDailySummaryReport(Request $request)
    {

        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
        $time = strtotime($request->date_from);
        $month = date("m", $time);
        $year = date("Y", $time);
        $day = date("d", $time);

        $date =  $year . '-' . $month . '-' . $day;


        $income = ChartOfAccounts::where('name', '=', 'Income')->where('deleted', 'No')->where('sister_concern_id','=',$logged_sister_concern_id)->first();
        $incomeId = $income->id;
        $allIncomes = ChartOfAccounts::where('parent_id', '=', $incomeId)->where('deleted', 'No')->where('sister_concern_id','=',$logged_sister_concern_id)->get();

        $sales = ChartOfAccounts::where('name', '=', 'Sales')->where('deleted', 'No')->where('sister_concern_id','=',$logged_sister_concern_id)->first();
        $salesId = $sales->id;
        $allsales = ChartOfAccounts::where('parent_id', '=', $salesId)->where('deleted', 'No')->where('sister_concern_id','=',$logged_sister_concern_id)->get();

        $expense = ChartOfAccounts::where('name', '=', 'Expense')->where('deleted', 'No')->where('sister_concern_id','=',$logged_sister_concern_id)->first();
        $expenseId = $expense->id;

        $allExpense = ChartOfAccounts::where('parent_id', '=', $expenseId)->where('deleted', 'No')->where('sister_concern_id','=',$logged_sister_concern_id)->get();

        $purchase = ChartOfAccounts::where('name', '=', 'Purchases')->where('deleted', 'No')->where('sister_concern_id','=',$logged_sister_concern_id)->first();
        // jjj

        $purchaseId = $purchase->id;
        $allpurchases = ChartOfAccounts::where('parent_id', '=', $purchaseId)->where('deleted', 'No')->where('sister_concern_id','=',$logged_sister_concern_id)->get();


        $backDate = DailyReport::where('date', '<', $date)
            ->where('deleted', '=', 'No')
            ->where('status', '=', 'Active')
            ->where('sister_concern_id','=',$logged_sister_concern_id)
            ->orderBy('date', 'desc')
            ->first();
        if ($backDate != null) {
            $backDateFrom = $backDate->date;
        } else {
            $backDateFrom = date('Y-m-d', strtotime($date . ' -1 day'));
        }


        $CashInHandFrom = DB::table('tbl_acc_voucher_details')
            ->join('tbl_accounts_vouchers', 'tbl_acc_voucher_details.tbl_acc_voucher_id', '=', 'tbl_accounts_vouchers.id')
            ->select('tbl_acc_voucher_details.*', 'tbl_accounts_vouchers.transaction_date')
            ->where('tbl_accounts_vouchers.transaction_date', '=', $backDateFrom)
            ->where('tbl_acc_voucher_details.sister_concern_id', '=',$logged_sister_concern_id)
            ->where('tbl_accounts_vouchers.deleted', '=', 'No')
            ->where('tbl_accounts_vouchers.status', '=', 'Active')
            ->where('tbl_acc_voucher_details.deleted', '=', 'No')
            ->where('tbl_acc_voucher_details.status', '=', 'Active')
            ->get();
        $salesCashFrom = 0;
        foreach ($CashInHandFrom as $debit) {

            $salesCashFrom += $debit->debit;
        }

        $CashInHandTo = DB::table('tbl_acc_voucher_details')
            ->join('tbl_accounts_vouchers', 'tbl_acc_voucher_details.tbl_acc_voucher_id', '=', 'tbl_accounts_vouchers.id')
            ->select('tbl_acc_voucher_details.*', 'tbl_accounts_vouchers.transaction_date')
            ->where('tbl_accounts_vouchers.transaction_date', '=', $backDateFrom)
            ->where('tbl_acc_voucher_details.sister_concern_id', '=',$logged_sister_concern_id)
            ->where('tbl_accounts_vouchers.deleted', '=', 'No')
            ->where('tbl_accounts_vouchers.status', '=', 'Active')
            ->where('tbl_acc_voucher_details.deleted', '=', 'No')
            ->where('tbl_acc_voucher_details.status', '=', 'Active')
            ->get();
        $salesCashTo = 0;
        foreach ($CashInHandTo as $credit) {
            $salesCashTo += $credit->credit;
        }

        /* start from here */
        $openings = DailyReport::where('date', '=', $backDateFrom)->where('deleted', '=', 'No')->where('sister_concern_id','=',$logged_sister_concern_id)->where('status', '=', 'Active')->first();

        if ($openings != null) {
            $openingbalance = $openings->opening_balance;
        } else {
            $openingbalance = '0.00';
        }
        $openingCash = $salesCashFrom - $salesCashTo;
        $todayDateHeader = '';
        $todayDateHeader .= '<h4>Accounts summary of ' . $date . '</h4>';
        $table = '';
        $closingBtn = '';
        $table .= '<table class="table table-bordered table-hover dataTable no-footer"  width="100%">
                    <tr>
                        <td>
                            <table class="table table-bordered table-hover dataTable no-footer">
                            <tbody>';


        $table .= '<tr>
                                            <td width="70%">Cash in hand</td>
                                            <td width="30%" class="text-right"><input type="hidden" id="previousDayClosing" value=' . $openingbalance . '>' . number_format($openingbalance) . '</td>
                                        </tr>';
        $totalIncome = 0;
        foreach ($allIncomes as $income) {
            $incomeAmounts = DB::table('tbl_acc_voucher_details')
                ->join('tbl_accounts_vouchers', 'tbl_acc_voucher_details.tbl_acc_voucher_id', '=', 'tbl_accounts_vouchers.id')
                ->select('tbl_acc_voucher_details.*', 'tbl_accounts_vouchers.transaction_date')
                ->where('tbl_accounts_vouchers.transaction_date', '=', $request->date_from)
                ->where('tbl_acc_voucher_details.tbl_acc_coa_id', '=', $income->id)
                ->where('tbl_acc_voucher_details.sister_concern_id', '=',$logged_sister_concern_id)
                ->where('tbl_accounts_vouchers.deleted', '=', 'No')
                ->where('tbl_accounts_vouchers.status', '=', 'Active')
                ->where('tbl_acc_voucher_details.deleted', '=', 'No')
                ->where('tbl_acc_voucher_details.status', '=', 'Active')
                ->get();

            $amountDebitSum = 0;
            foreach ($incomeAmounts as $amount) {
                $amountDebitSum += $amount->debit;
            }

            $table .= '<tr>
                                                <td width="70%">' . $income->name . '</td>
                                                <td width="30%" class="text-right">' . number_format($amountDebitSum) . '</td>
                                            </tr>';
            $totalIncome += $amountDebitSum;
        }



        // 
        $totalSales = 0;
        foreach ($allsales as $sale) {
            $saleAmounts = DB::table('tbl_acc_voucher_details')
                ->join('tbl_accounts_vouchers', 'tbl_acc_voucher_details.tbl_acc_voucher_id', '=', 'tbl_accounts_vouchers.id')
                ->select('tbl_acc_voucher_details.*', 'tbl_accounts_vouchers.transaction_date')
                ->where('tbl_accounts_vouchers.transaction_date', '=', $request->date_from)
                ->where('tbl_acc_voucher_details.tbl_acc_coa_id', '=', $sale->id)
                ->where('tbl_acc_voucher_details.sister_concern_id', '=',$logged_sister_concern_id)
                ->where('tbl_accounts_vouchers.deleted', '=', 'No')
                ->where('tbl_accounts_vouchers.status', '=', 'Active')
                ->where('tbl_acc_voucher_details.deleted', '=', 'No')
                ->where('tbl_acc_voucher_details.status', '=', 'Active')
                ->get();
            $amountDebitSum = 0;
            foreach ($saleAmounts as $amount) {
                $amountDebitSum += $amount->debit;
            }
            $table .= '<tr>
                                                <td width="70%">' . $sale->name . '</td>
                                                <td width="30%" class="text-right">' . number_format($amountDebitSum) . '</td>
                                            </tr>';
            $totalSales += $amountDebitSum;
        }


        $totalIncomeWithOpening = $openingbalance + $totalIncome + $totalSales;


        $table .= '</tbody>
                            </table>
                        </td>
                        <td>
                            <table class="table table-bordered table-hover dataTable no-footer">
                            <tbody>';
        $billAmount = 0;
        $billpayments = DB::table('tbl_accounts_vouchers')
            ->where('type', '=', 'Bill paid')
            ->where('tbl_accounts_vouchers.transaction_date', '=', $request->date_from)
            ->where('tbl_acc_voucher_details.sister_concern_id', '=',$logged_sister_concern_id)
            ->where('tbl_accounts_vouchers.deleted', '=', 'No')
            ->where('tbl_accounts_vouchers.status', '=', 'Active')
            ->where('tbl_acc_voucher_details.deleted', '=', 'No')
            ->where('tbl_acc_voucher_details.status', '=', 'Active')
            ->get();
        foreach ($billpayments as $bill) {
            $billAmount += $bill->amount;
        };
        $table .= '<tr>
                                                <td width="70%">Bill</td>
                                                <td width="30%" class="text-right">' . number_format($billAmount) . '</td>
                                            </tr>';

        $purchaseSum = 0;
        foreach ($allpurchases as $purchase) {
            $purchaseAmounts = DB::table('tbl_acc_voucher_details')
                ->join('tbl_accounts_vouchers', 'tbl_acc_voucher_details.tbl_acc_voucher_id', '=', 'tbl_accounts_vouchers.id')
                ->select('tbl_acc_voucher_details.*', 'tbl_accounts_vouchers.transaction_date', 'tbl_accounts_vouchers.type')
                ->where('tbl_accounts_vouchers.transaction_date', '=', $request->date_from)
                ->where('tbl_acc_voucher_details.tbl_acc_coa_id', '=', $purchase->id)
                ->where('tbl_acc_voucher_details.sister_concern_id', '=',$logged_sister_concern_id)
                ->where('tbl_accounts_vouchers.deleted', '=', 'No')
                ->where('tbl_accounts_vouchers.status', '=', 'Active')
                ->where('tbl_acc_voucher_details.deleted', '=', 'No')
                ->where('tbl_acc_voucher_details.status', '=', 'Active')
                ->get();
            $amountSum = 0;
            foreach ($purchaseAmounts as $amount) {
                $amountSum += $amount->credit;
            }

            $table .= '<tr>
                                                <td width="70%">' . $purchase->name . '</td>
                                                <td width="30%" class="text-right">' . number_format($amountSum) . '</td>
                                            </tr>';
            $purchaseSum += $amountSum;
        }

        $expenseSum = 0;
        foreach ($allExpense as $expense) {
            $incomeAmounts = DB::table('tbl_acc_voucher_details')
                ->join('tbl_accounts_vouchers', 'tbl_acc_voucher_details.tbl_acc_voucher_id', '=', 'tbl_accounts_vouchers.id')
                ->select('tbl_acc_voucher_details.*', 'tbl_accounts_vouchers.transaction_date', 'tbl_accounts_vouchers.type')
                ->where('tbl_accounts_vouchers.transaction_date', '=', $request->date_from)
                ->where('tbl_acc_voucher_details.tbl_acc_coa_id', '=', $expense->id)
                ->where('tbl_acc_voucher_details.sister_concern_id', '=',$logged_sister_concern_id)
                ->where('tbl_accounts_vouchers.deleted', '=', 'No')
                ->where('tbl_accounts_vouchers.status', '=', 'Active')
                ->where('tbl_acc_voucher_details.deleted', '=', 'No')
                ->where('tbl_acc_voucher_details.status', '=', 'Active')
                ->get();
            $amountSum = 0;

            foreach ($incomeAmounts as $amount) {
                $amountSum += $amount->credit;
            }

            $table .= '<tr>
                                                <td width="70%">' . $expense->name . '</td>
                                                <td width="30%" class="text-right">' . number_format($amountSum) . '</td>
                                            </tr>';
            $expenseSum += $amountSum;
        }
        $totalExpense = $expenseSum + $billAmount + $purchaseSum;
        $table .= '</tbody>
                            </table>
                        </td>
                        
                    </tr>
                    <tr>
                        <td>
                            <table class="table table-bordered table-hover dataTable no-footer">
                                <tbody>
                                    <tr>
                                        <td width="70%">Total Income: </td>
                                        <td width="30%" class="text-right">' . number_format($totalIncomeWithOpening) . '</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td>
                            <table class="table table-bordered table-hover dataTable no-footer">
                                <tbody>
                                    <tr>
                                        <td width="70%">Total Expense: </td>
                                        <td width="30%" class="text-right">' . number_format($totalExpense) . '</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>';
        $due = $totalIncomeWithOpening - $totalExpense;
        if ($totalIncomeWithOpening < $totalExpense) {
            $incomeClosing = $due;
            $expenseClosing = '0';
        } elseif ($totalIncomeWithOpening > $totalExpense) {
            $incomeClosing = '0';
            $expenseClosing = $due;
        } else {
            $incomeClosing = '0';
            $expenseClosing = '0';
        }
        //  return $due;
        $table .= '<tr>
                        <td>
                            <table class="table table-bordered table-hover dataTable no-footer">
                                <tbody>
                                    <tr>
                                        <td width="70%">Balance Closing: </td> <input type="hidden" id="due" value=' . $due . '>
                                        <td width="30%" class="text-right">' . number_format($incomeClosing) . Session::get('companySettings')[0]['currency'] . '</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td>
                            <table class="table table-bordered table-hover dataTable no-footer">
                                <tbody>
                                    <tr>
                                        <td width="70%">Balance Closing: </td>
                                        <td width="30%" class="text-right">' . number_format($expenseClosing) . Session::get('companySettings')[0]['currency'] . '</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>';
        $totalIncomeWithDue = $totalIncomeWithOpening - $incomeClosing;
        $totalExpenseWithDue = $totalExpense + $expenseClosing;
        $table .= '<tr>
                        <td>
                            <table class="table table-bordered table-hover dataTable no-footer">
                                <tbody>
                                    <tr>
                                        <td width="70%">Total : </td>
                                        <td width="30%" class="text-right">' . number_format($totalIncomeWithDue) . Session::get('companySettings')[0]['currency'] . '</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td>
                            <table class="table table-bordered table-hover dataTable no-footer">
                                <tbody>
                                    <tr>
                                        <td width="70%">Total : </td>
                                        <td width="30%" class="text-right">' . number_format($totalExpenseWithDue) . Session::get('companySettings')[0]['currency'] . '</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>';
        $lastTwoChar = substr(($request->date_to), -2);
        $time = strtotime($request->date_to);
        $month = date("F", $time);
        $year = date("Y", $time);
        $monthYear = date("F Y", $time);

        $month_value = date("m", strtotime($month));
        $month_days_count = cal_days_in_month(CAL_GREGORIAN, $month_value, $year);

        /* if($lastTwoChar == $month_days_count){ */
        $closingBtn = '<button class="btn btn-primary float-right" onclick="closeBalance()">Close balance</button>';
        /*  }else{
                $closingBtn='<span class="text-danger">Select the last day of the month to close the balance</span><button class="btn btn-secondary float-right disabled" >Close balance</button>';
            } */
        $pdf = '';
        $pdf = '<button class="btn btn-primary" onclick="generateAccountsSummaryPdf()"><i class="fas fa-print"></i> Print PDF</button>';
        $data = array(
            'table' => $table,
            'todayDateHeader' => $todayDateHeader,
            'closingBtn' => $closingBtn,
            'pdf' => $pdf
        );
        return $data;
    }




    public function closingDayBalanceStore(Request $request)
    {
           
         
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
        $date = $request->date_from;
        $checkPreviousDate = '';
        $checkPreviousDate = DailyReport::where('date', '=', $date)->where('sister_concern_id','=',$logged_sister_concern_id)->first();

        if ($checkPreviousDate != null) {
            $checkPreviousDate->date = $date;
            $checkPreviousDate->previous_closing = $request->previousDayClosing;
            $checkPreviousDate->today_closing = $request->presentClosingBalance;
            $checkPreviousDate->opening_balance = $request->presentClosingBalance;
            $checkPreviousDate->last_updated_by = Auth::user()->id;
            $checkPreviousDate->save();
            return response()->json(['success' => 'Closing balance updated successfully']);
        } else {
            $closing = new DailyReport();
            $closing->date = $date;
            $closing->previous_closing = $request->previousDayClosing;
            $closing->opening_balance = $request->presentClosingBalance;
            $closing->today_closing = $request->presentClosingBalance;
            $closing->created_by = Auth::user()->id;
            $closing->deleted = 'No';
            $closing->status = 'Active';
            $closing->save();
            return response()->json(['success' => 'Closing balance saved successfully']);
        }
    }




    public function generateDailyAccountsSummaryPdf($date)
    {
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
        $time = strtotime($date);
        $month = date("m", $time);
        $year = date("Y", $time);
        $day = date("d", $time);

        $income = ChartOfAccounts::where('name', '=', 'Income')->first();
        $incomeId = $income->id;
        $allIncomes = ChartOfAccounts::where('parent_id', '=', $incomeId)->get();

        $sales = ChartOfAccounts::where('name', '=', 'Sale')->first();
        $salesId = $sales->id;
        $allsales = ChartOfAccounts::where('parent_id', '=', $salesId)->get();

        $expense = ChartOfAccounts::where('name', '=', 'Expense')->first();
        $expenseId = $expense->id;
        $allExpense = ChartOfAccounts::where('parent_id', '=', $expenseId)->get();

        $purchase = ChartOfAccounts::where('name', '=', 'Purchase')->first();
        $purchaseId = $purchase->id;
        $allpurchases = ChartOfAccounts::where('parent_id', '=', $purchaseId)->get();


        $backDate = DailyReport::where('date', '<', $date)
            ->where('deleted', '=', 'No')
            ->where('status', '=', 'Active')
            ->where('sister_concern_id','=',$logged_sister_concern_id)
            ->orderBy('date', 'desc')
            ->first();
        if ($backDate != null) {
            $backDateFrom = $backDate->date;
        } else {
            $backDateFrom = date('Y-m-d', strtotime($date . ' -1 day'));
        }


        /* start from here */
        $openings = DailyReport::where('date', '=', $backDateFrom)->where('deleted', '=', 'No')->where('status', '=', 'Active')->first();

        if ($openings != null) {
            $openingbalance = $openings->opening_balance;
        } else {
            $openingbalance = '0.00';
        }

        $CashInHandFrom = 0;
        $CashInHandFrom = DB::table('tbl_acc_voucher_details')
            ->join('tbl_accounts_vouchers', 'tbl_acc_voucher_details.tbl_acc_voucher_id', '=', 'tbl_accounts_vouchers.id')
            ->select('tbl_acc_voucher_details.*', 'tbl_accounts_vouchers.transaction_date')
            ->where('tbl_accounts_vouchers.transaction_date', '=', $backDateFrom)
            ->where('tbl_accounts_vouchers.sister_concern_id', '=', $logged_sister_concern_id)
            ->where('tbl_accounts_vouchers.deleted', '=', 'No')
            ->where('tbl_accounts_vouchers.status', '=', 'Active')
            ->where('tbl_acc_voucher_details.deleted', '=', 'No')
            ->where('tbl_acc_voucher_details.status', '=', 'Active')
            ->get();
        $salesCashFrom = 0;
        foreach ($CashInHandFrom as $debit) {
            $salesCashFrom += $debit->debit;
        }
        $CashInHandTo = DB::table('tbl_acc_voucher_details')
            ->join('tbl_accounts_vouchers', 'tbl_acc_voucher_details.tbl_acc_voucher_id', '=', 'tbl_accounts_vouchers.id')
            ->select('tbl_acc_voucher_details.*', 'tbl_accounts_vouchers.transaction_date')
            ->where('tbl_accounts_vouchers.transaction_date', '=', $backDateFrom)
            ->where('tbl_accounts_vouchers.sister_concern_id', '=', $logged_sister_concern_id)
            ->where('tbl_accounts_vouchers.deleted', '=', 'No')
            ->where('tbl_accounts_vouchers.status', '=', 'Active')
            ->where('tbl_acc_voucher_details.deleted', '=', 'No')
            ->where('tbl_acc_voucher_details.status', '=', 'Active')
            ->get();
        $salesCashTo = 0;
        foreach ($CashInHandTo as $credit) {
            $salesCashTo += $credit->credit;
        }
        $openingCash = $salesCashFrom - $salesCashTo;

        $billpayments = DB::table('tbl_accounts_vouchers')
            ->where('type', '=', 'Bill paid')
            ->where('tbl_accounts_vouchers.transaction_date', '=', $date)
            ->where('tbl_accounts_vouchers.deleted', '=', 'No')
            ->where('tbl_accounts_vouchers.status', '=', 'Active')
            ->get();

        $billAmount = 0;
        foreach ($billpayments as $bill) {
            $billAmount += $bill->amount;
        };




        $pdf = PDF::loadView(
            'admin.reports.accountsDailySummaryPdf',
            [
                'openingCash' => $openingCash,
                'openingbalance' => $openingbalance,
                'allIncomes' => $allIncomes,
                'date' => $date,
                'allsales' => $allsales,
                'allpurchases' => $allpurchases,
                'billAmount' => $billAmount,
                'allExpense' => $allExpense,
            ]
        );
        return $pdf->stream('accounts-daily-summary-pdf.pdf', array("Attachment" => false));
    }











    public function dailyServiceLedgerReport()
    {
        return view('admin.reports.serviceCenterDailySummary');
    }





    public function generateDailyServiceReport(Request $request)
    {

        $complete_orders = DB::table('tbl_booking')
            ->leftjoin('parties', 'tbl_booking.customer_id', '=', 'parties.id')
            ->select('tbl_booking.*', 'parties.name as partyName', 'parties.contact')
            ->where('tbl_booking.order_status', '=', 'Completed')
            ->where('tbl_booking.completed_date', '=', $request->date_from)
            ->where('tbl_booking.deleted', '=', 'No')
            ->where('tbl_booking.status', '=', 'Active')
            ->get();
        $table = '';

        $table .= '<h3 class="text-center" style="padding-top:20px;">Completed Jobs</h3>
            <table  class="table table-bordered table-hover dataTable no-footer">
            <thead>';
        $table .= '<tr>
                    <td width="5%"><b>Sl.</b></td>
                    <td width="8%"><b>Job No.</b></td>
                    <td width="15%"><b>COA</b></td>
                    <td width="20%"><b>Party Info</b></td>
                    <td width="15%" class="text-right"><b>Job Amount</b></td>
                    <td width="15%" class="text-right"><b>Sale Amount</b></td>
                    <td width="15%" class="text-right"><b>Balance</b></td>
                    <td class="text-center" width="12%"><b>Status</b></td>
            </tr>
            </thead>
            <tbody>';
        $i = 1;
        $total_amount_sum = 0;
        $total_sale_amount_sum = 0;
        $pdfButton = '';
        foreach ($complete_orders as $order) {
            $coa = ChartOfAccounts::find($order->category);
            $table .= '<tr>
                        <td>' . $i++ . '</td>
                        <td>' . $order->sale_no . '</td>
                        <td>' . $coa->name . '</td>
                        <td>Name: ' . $order->partyName . '<br>Contact: ' . $order->contact . '</td>
                        <td class="text-right">' . number_format($order->grand_total) . ' ' . session::get('companySettings')[0]['currency'] . '</td>
                        <td class="text-right">' . number_format($order->final_sale_amount) . ' ' . session::get('companySettings')[0]['currency'] . '</td>
                        <td class="text-right">' . number_format(($order->grand_total) - ($order->final_sale_amount)) . ' ' . session::get('companySettings')[0]['currency'] . '</td>
                        <td class="text-center">' . $order->order_status . '</td>
                    </tr>';
            $total_amount_sum += $order->grand_total;
            $total_sale_amount_sum += $order->final_sale_amount;
        }

        $table .= '<tr>
                        <td colspan="4" class="text-right"><b>Total: </b></td>
                        <td class="text-right"><b>' . number_format($total_amount_sum) . ' ' . session::get('companySettings')[0]['currency'] . '</b></td>
                        <td class="text-right"><b>' . number_format($total_sale_amount_sum) . ' ' . session::get('companySettings')[0]['currency'] . '</b></td>
                        <td class="text-right"><b>' . number_format(($total_amount_sum - $total_sale_amount_sum)) . ' ' . session::get('companySettings')[0]['currency'] . '</b></td>
                        <td></td>
                  </tr>';

        $table .= '</tbody>';


        $table .= '</table>';



        $table .= '<h3 class="text-center" style="padding-top:30px;">Other Jobs</h3>';
        $table .= '<table class="table table-bordered table-hover dataTable no-footer">';

        $table .= '<thead>';
        $table .= '<tr>
                    <td width="5%"><b>SL</b></td>
                    <td width="8%"><b>Job No</b></td>
                    <td width="15%"><b>COA</b></td>
                    <td width="20%"><b>Party Info</b></td>
                    <td width="15%" class="text-right"><b>Amount</b></td>
                    <td width="15%" class="text-center"><b>Status</b></td>
                    <td width="23%"><b>Remarks</b></td>
            </tr>';
        $table .= '<thead>';

        $table .= '<tbody>';

        $other_orders = DB::table('tbl_booking')
            ->leftjoin('parties', 'tbl_booking.customer_id', '=', 'parties.id')
            ->select('tbl_booking.*', 'parties.name as partyName', 'parties.contact')
            ->where('tbl_booking.order_status', '!=', 'Completed')
            ->where('tbl_booking.created_date', '=', $request->date_from)
            ->where('tbl_booking.deleted', '=', 'No')
            ->where('tbl_booking.status', '=', 'Active')
            ->get();

        $i - 1;
        $totalSum = 0;
        foreach ($other_orders as $order) {
            $coa = ChartOfAccounts::find($order->category);
            $table .= '<tr>
                    <td>' . $i++ . '</td>
                    <td>' . $order->sale_no . '</td>
                    <td>' . $coa->name . '</td>
                    <td>Name: ' . $order->partyName . '<br>Contact: ' . $order->contact . '</td>
                    <td class="text-right">' . $order->grand_total . ' ' . session::get('companySettings')[0]['currency'] . '</td>
                    <td class="text-center">' . $order->order_status . '</td>
                    <td></td>
            </tr>';
            $totalSum += $order->grand_total;
        }
        $table .= '<tr> 
                    <td colspan="4" class="text-right"><b>Total : </b></td>
                    <td class="text-right">' . number_format($totalSum) . ' ' . session::get('companySettings')[0]['currency'] . '</td>
                    <td colspan="2" ></td>
                </tr>';
        $table .= '<tbody>';
        $table .= '</table>';




        $table .= '<h3 class="text-center" style="padding-top:30px;">WI Sales</h3>';
        $table .= '<table class="table table-bordered table-hover dataTable no-footer">';
        $table .= '<thead>';
        $table .= '<tr>
                <td width="5%"><b>SL</b></td>
                <td class="text-center" width="15%"><b>Sale No</b></td>
                <td class="text-center" width="20%"><b>COA</b></td>
                <td width="30%"><b>Party Info</b></td>
                <td width="15%" class="text-right"><b>Total</b></td>
                <td width="15%" class="text-right"><b>Paid</b></td>
            </tr>';
        $table .= '</thead>';
        $table .= '<tbody>';

        $sales = DB::table('sales')
            ->leftjoin('parties', 'sales.customer_id', '=', 'parties.id')
            ->leftjoin('tbl_acc_coas', 'sales.coa_id', '=', 'tbl_acc_coas.id')
            ->select('sales.*', 'parties.name as partyName', 'parties.contact', 'tbl_acc_coas.name as coaName')
            ->where('sales.status', '=', 'Active')
            ->where('sales.date', '=', $request->date_from)
            ->where('sales.type', '=', 'walkin')
            ->where('sales.deleted', '=', 'No')
            ->get();
        $i = 1;
        $grandTotalSum = 0;
        $paidTotalSum = 0;
        foreach ($sales as $sale) {
            $table .= '<tr>
                <td>' . $i++ . '</td>
                <td class="text-center">' . $sale->sale_no . '</td>
                <td class="text-center">' . $sale->coaName . '</td>
                <td >Name: ' . $sale->partyName . '<br>Contact: ' . $sale->contact . '</td>
                <td class="text-right">' . $sale->grand_total . ' ' . session::get('companySettings')[0]['currency'] . '</td>
                <td class="text-right">' . $sale->current_payment . ' ' . session::get('companySettings')[0]['currency'] . '</td>
            </tr>';
            $grandTotalSum += $sale->grand_total;
            $paidTotalSum += $sale->current_payment;
        }
        $table .= '<tr>
                <td colspan="4" class="text-right">Total :</td>
                <td class="text-right">' . $grandTotalSum . ' ' . session::get('companySettings')[0]['currency'] . '</td>
                <td class="text-right">' . $paidTotalSum . ' ' . session::get('companySettings')[0]['currency'] . '</td>
            </tr>';
        $table .= '</tbody>';
        $table .= '</table>';




        $coas = ChartOfAccounts::where('parent_id', '=', 31)->where('name', '!=', 'Sales')->get();
        $table .= '<h3 class="text-center" style="padding-top:30px;">Total Jobs</h3>';
        $table .= '<table class="table table-bordered table-hover dataTable no-footer">';
        $table .= '<thead>';
        $table .= '<tr>
                <td>Service COA</td>
                <td class="text-center">Pending</td>
                <td class="text-center">Servicing</td>
                <td class="text-center">Ready For Delivery</td>
                <td class="text-center">Delivered</td>
                <td class="text-center">Completed</td>
            </tr>';
        $table .= '</thead>';
        $table .= '<tbody>';
        foreach ($coas as $coa) {

            $totalPending = SaleOrder::where('order_status', '=', 'Pending')->where('category', '=', $coa->id)->where('created_date', '=', $request->date_from)->count();
            $totalServicing = SaleOrder::where('order_status', '=', 'Servicing')->where('category', '=', $coa->id)->where('service_start_date', '=', $request->date_from)->count();
            $totalReady = SaleOrder::where('order_status', '=', 'ReadyToDeliverd')->where('category', '=', $coa->id)->where('ready_to_deliver_date', '=', $request->date_from)->count();
            $totalDelivered = SaleOrder::where('order_status', '=', 'Delivered')->where('category', '=', $coa->id)->where('delivered_date', '=', $request->date_from)->count();
            $totalCompleted = SaleOrder::where('order_status', '=', 'Completed')->where('category', '=', $coa->id)->where('completed_date', '=', $request->date_from)->count();

            $table .= '<tr>
                <td>' . $coa->name . '</td>
                <td class="text-center">' . $totalPending . '</td>
                <td class="text-center">' . $totalServicing . '</td>
                <td class="text-center">' . $totalReady . '</td>
                <td class="text-center">' . $totalDelivered . '</td>
                <td class="text-center">' . $totalCompleted . '</td>
            </tr>';
        }
        $table .= '</tbody>';
        $table .= '</table>';


        $pdfButton .= '<br><button class="btn btn-primary" onclick="generatePdf()"><i class="fas fa-print"></i> Generate</button>';

        $array = array('table' => $table, 'pdf' => $pdfButton);

        return $array;
    }




    public function ServiceLedgerReportPdf($date)
    {


        $orders = DB::table('tbl_booking')
            ->leftjoin('parties', 'tbl_booking.customer_id', '=', 'parties.id')
            ->select('tbl_booking.*', 'parties.name as partyName', 'parties.contact')
            ->where('tbl_booking.order_status', '=', 'Completed')
            ->where('tbl_booking.completed_date', '=', $date)
            ->where('tbl_booking.deleted', '=', 'No')
            ->where('tbl_booking.status', '=', 'Active')
            ->get();

        $other_orders = DB::table('tbl_booking')
            ->leftjoin('parties', 'tbl_booking.customer_id', '=', 'parties.id')
            ->select('tbl_booking.*', 'parties.name as partyName', 'parties.contact')
            ->where('tbl_booking.order_status', '!=', 'Completed')
            ->where('tbl_booking.created_date', '=', $date)
            ->where('tbl_booking.deleted', '=', 'No')
            ->where('tbl_booking.status', '=', 'Active')
            ->get();


        $coas = ChartOfAccounts::where('parent_id', '=', 31)->where('name', '!=', 'Sales')->get();
        $pdf = PDF::loadView(
            'admin.reports.serviceCenterDailyPdf',
            [
                'orders' => $orders, 'date' => $date,
                'other_orders' => $other_orders,
                'coas' => $coas
            ]
        );
        return $pdf->stream('accounts-daily-summary-pdf.pdf', array("Attachment" => false));
    }
    
    public function serviceSaleSummaryReport(){
        return view('admin.reports.serviceSaleSummaryReport');
    }
   public function generateSaleSummaryReport(Request $request){
        //return $request;
        $orders = DB::table('tbl_booking')
            ->leftjoin('parties', 'tbl_booking.customer_id', '=', 'parties.id')
            ->select('tbl_booking.*', 'parties.name as partyName', 'parties.contact')
            ->where('tbl_booking.booking_status', '=', 'Completed')
            ->where('tbl_booking.completed_date', '>=', $request->date_from)
            ->where('tbl_booking.completed_date', '<=', $request->date_to)
            ->where('tbl_booking.deleted', '=', 'No')
            ->where('tbl_booking.status', '=', 'Active')
            ->orderBy('tbl_booking.completed_date','DESC')
            ->get();
        $sales = DB::table('sales')
            ->leftjoin('parties', 'sales.customer_id', '=', 'parties.id')
            ->select('sales.*', 'parties.name as partyName', 'parties.contact')
            ->where('sales.status', '=', 'Active')
            ->where('sales.date', '>=', $request->date_from)
            ->where('sales.date', '<=', $request->date_to)
            ->where('sales.type', '=', 'walkin')
            ->where('sales.deleted', '=', 'No')
            ->get();
        //return $sales;
        $html='';
        $html='<table class="table table-bordered table-hover dataTable no-footer"  width="100%">
                    <thead>
                        <tr class="bg-light">
                            <td width="5%" class="text-center">Sl</td>
                            <td width="10%" class="text-center">Date</td>
                            <td width="10%" class="text-center">Order No</td>
                            <td width="25%" class="text-center">Party Info</td>
                            <td width="10%" class="text-center">Type</td>
                            <td width="15%" class="text-right">Total Amount</td>
                            <td width="15%" class="text-right">Final Sale Amount</td>
                            <td width="15%" class="text-right">Balance</td>
                          
                        </tr>
                    </thead>
                    <tbody>';
        $i=1;
        $serviceGrandTotal=0;
        $serviceFinalSale=0;
        $serviceBalance=0;
        foreach($orders as $order){
            $html .='<tr>
                        <td class="text-center">'.$i++.'</td>
                        <td class="text-center">'.$order->completed_date.'</td>
                        <td class="text-center">'.$order->sale_no.'</td>
                        <td>Name: '.$order->partyName.'<br>Contact: '.$order->contact.'</td>
                        <td class="text-center">Service</td>
                        <td class="text-right">'.numberFormat($order->grand_total).'</td>
                        <td class="text-right">'.numberFormat($order->final_sale_amount).'</td>
                        <td class="text-right">'.numberFormat(($order->grand_total - $order->final_sale_amount)).'</td>
                    </tr>';
                    $serviceGrandTotal +=$order->grand_total;
                    $serviceFinalSale +=$order->final_sale_amount;
                    $serviceBalance +=$order->grand_total - $order->final_sale_amount;
        }
        $walkinGrandTotal=0;
        $walkinPurchaseAmount=0;
        $walkinBalance=0;

        $expense = ChartOfAccounts::where('name', '=', 'Expense')->where('deleted', 'No')->first();
        $expenseId = $expense->id;

        $allExpense = ChartOfAccounts::where('parent_id', '=', $expenseId)->where('deleted', 'No')->get();

        $expenseArray=[];

        foreach($sales as $sale){
            $html .='<tr>
                        <td class="text-center">'.$i++.'</td>
                        <td class="text-center">'.$sale->date.'</td>
                        <td class="text-center">'.$sale->sale_no.'</td>
                        <td>Name: '.$sale->partyName.'<br>Contact: '.$sale->contact.'</td>
                        <td class="text-center">Walkin Sale</td>
                        <td class="text-right">'.numberFormat($sale->grand_total).'</td>
                        <td class="text-right">'.numberFormat($sale->total_purchase_amount).'</td>
                        <td class="text-right">'.numberFormat($sale->grand_total - $sale->total_purchase_amount).'</td>
                    </tr>';
            $walkinGrandTotal +=$sale->grand_total;
            $walkinPurchaseAmount +=$sale->total_purchase_amount;
            $walkinBalance +=$sale->grand_total - $sale->total_purchase_amount;
        }
        $html .='<tr>
                <td colspan="5" class="text-right">Total:</td>
                <td class="text-right">'.numberFormat($serviceGrandTotal + $walkinGrandTotal).'</td>
                <td class="text-right">'.numberFormat($serviceFinalSale +$walkinPurchaseAmount).'</td>
                <td class="text-right">'.numberFormat($serviceBalance + $walkinBalance).'</td>
            </tr>'; 
        $html .= '</tbody>
                </table> <br>
                <table class="table table-bordered table-hover dataTable no-footer"  width="100%">
                <tbody>
                ';

                $expenseAmount=0;
        foreach ($allExpense as $key =>  $expense) {
            $incomeAmounts = DB::table('tbl_acc_voucher_details')
                ->join('tbl_accounts_vouchers', 'tbl_acc_voucher_details.tbl_acc_voucher_id', '=', 'tbl_accounts_vouchers.id')
                ->select('tbl_acc_voucher_details.*', 'tbl_accounts_vouchers.transaction_date', 'tbl_accounts_vouchers.type')
                ->whereBetween('tbl_accounts_vouchers.transaction_date', [$request->date_from, $request->date_to])
                ->where('tbl_acc_voucher_details.tbl_acc_coa_id', '=', $expense->id)
                ->where('tbl_accounts_vouchers.deleted', '=', 'No')
                ->where('tbl_accounts_vouchers.status', '=', 'Active')
                ->get();
                $amountSum = 0;
                foreach ($incomeAmounts as $amount) {
                    $amountSum += $amount->credit;
                }
                $html .='<tr>
                        <td  width="5%" class="text-center"></td>
                        <td width="10%" class="text-center"></td>
                        <td  width="10%" class="text-center"></td>
                        <td width="25%"><a href="#" onclick="generateExpenseAccountsDetailsPdf('.$expense->id.')">'.$expense->name.'</a></td>
                        <td width="10%" class="text-center"></td>
                        <td width="15%" class="text-right"></td>
                        <td width="15%" class="text-right">'.numberFormat($amountSum).'</td>
                        <td width="15%" class="text-right"></td>
                    </tr>';
                    $expenseAmount+=$amountSum;
        }

        $html .='<tr>
                    <td colspan="5" class="text-right">Total:</td>
                    <td class="text-right"></td>
                    <td class="text-right">'.numberFormat($expenseAmount).'</td>
                    <td class="text-right"></td>
                </tr>'; 

                $html .= '</tbody>
                </table>
                <table class="table table-bordered table-hover dataTable no-footer"  width="100%">
                <tbody>
                ';
            
        $html .='<tr>
                <td class="text-right">Sale Value: '.numberFormat($serviceGrandTotal + $walkinGrandTotal).'</td>
                <td class="text-right">Product Value: ('.numberFormat($serviceFinalSale +$walkinPurchaseAmount).')</td>
                <td class="text-right">Profit: '.numberFormat($serviceBalance + $walkinBalance).'</td>
                <td class="text-right">Expense: ('.numberFormat($expenseAmount).')</td>
                <td class="text-right">Net Profit: '.numberFormat($serviceBalance + $walkinBalance -$expenseAmount ).'</td>
            </tr>'; 

            $html .= '</tbody>
            </table>$billAmount
            ';

        return $html;
    }
    
    
    public function serviceSaleSummaryPdf($date_from,$date_to){
        $orders = DB::table('tbl_booking')
                ->leftjoin('parties', 'tbl_booking.customer_id', '=', 'parties.id')
                ->select('tbl_booking.*', 'parties.name as partyName', 'parties.contact')
                ->where('tbl_booking.order_status', '=', 'Completed')
                ->where('tbl_booking.completed_date', '>=', $date_from)
                ->where('tbl_booking.completed_date', '<=', $date_to)
                ->where('tbl_booking.deleted', '=', 'No')
                ->where('tbl_booking.status', '=', 'Active')
                ->orderBy('tbl_booking.completed_date','DESC')
                ->get();
        $sales = DB::table('sales')
                ->leftjoin('parties', 'sales.customer_id', '=', 'parties.id')
                ->select('sales.*', 'parties.name as partyName', 'parties.contact')
                ->where('sales.status', '=', 'Active')
                ->where('sales.date', '>=', $date_from)
                ->where('sales.date', '<=', $date_to)
                ->where('sales.type', '=', 'walkin')
                ->where('sales.deleted', '=', 'No')
                ->get();
        $expense = ChartOfAccounts::where('name', '=', 'Expense')->where('deleted', 'No')->first();
        $expenseId = $expense->id;

        $allExpenses = ChartOfAccounts::where('parent_id', '=', $expenseId)->where('deleted', 'No')->get();

        $pdf = PDF::loadView('admin.reports.serviceSaleSummaryPdf',['orders' => $orders,'sales'=>$sales,'allExpenses'=>$allExpenses,'date_from'=>$date_from,'date_to'=>$date_to]);
        return $pdf->stream('service-sale-summary-Pdf.pdf', array("Attachment" => false));
    }


    public function orderReportsIndex($type){
        $parties=Party::where('party_type','=',$type)->where('deleted', 'No')->where('status','=','Active')->get();
        return view('admin.reports.orderReport',['type'=>$type,'parties'=>$parties]);
    }


    public function getReportsPartyOrder(Request $request){
        if($request->type == 'Applicant'){
            $type='takeOrderFromApplicant';
        }elseif($request->type == 'Vendor'){
            $type='giveOrderToVendor';
        }
        if($request->party_id == 'All'){
            $orders=SaleOrder::where('work_approval_date', '>=', $request->dateFrom)
                            ->where('work_approval_date', '<=', $request->dateTo)
                            ->where('deleted','=','No')
                            ->where('order_type','=',$type)
                            ->where('status','=','Active')
                            ->orderBy('id','DESC')
                            ->get();
        }else{
            $orders=SaleOrder::where('customer_id','=',$request->party_id)
                            ->where('work_approval_date', '>=', $request->dateFrom)
                            ->where('work_approval_date', '<=', $request->dateTo)
                            ->where('deleted','=','No')
                            ->where('order_type','=',$type)
                            ->where('status','=','Active')
                            ->orderBy('id','DESC')
                            ->get();
        }
        
                           
        $html ='';
        $i=1;
        $button='';
        foreach($orders as $order){
            $party=Party::find($order->customer_id);
            

            $button = '<div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-cog"></i>  <span class="caret"></span></button>
                                <ul class="dropdown-menu dropdown-menu-right" style="border: 1px solid gray;" role="menu">
                                    <li class="action" onclick="completeInvoice(' . $order->id . ')"  ><a  class="btn" ><i class="fas fa-file-pdf"></i> Complete Invoice </a></li>
                                </ul>
                        </div>';

            $orderDetails=SaleOrderProduct::join('tbl_booking','tbl_booking.id','=','sale_order_products.tbl_sale_orders_id')
                            ->leftjoin('products','products.id','=','sale_order_products.product_id')
                            ->select('sale_order_products.*','products.name','products.process_status','tbl_booking.grand_total','tbl_booking.order_type as saleOrderType')
                            ->where('sale_order_products.tbl_sale_orders_id','=',$order->id)
                            ->where('sale_order_products.deleted','=','No')
                            ->where('sale_order_products.status','=','Active')
                            ->orderBy('sale_order_products.id','DESC')
                            ->get();
            $orderDetailsHtml='';
            if($orderDetails){
                    $k=1;
                foreach($orderDetails as $detail){

                    $ordertoVendor=SaleOrderProduct::join('tbl_booking','tbl_booking.id','=','sale_order_products.tbl_sale_orders_id')
                            ->leftjoin('parties','parties.id','=','tbl_booking.customer_id')
                            ->select('sale_order_products.*','tbl_booking.date','parties.name as partyName','parties.party_type as partyType','tbl_booking.sale_no as deliveryOrderCode','tbl_booking.id as saleOrderId')
                            ->where('sale_order_products.deleted','=','No')
                            ->where('sale_order_products.status','=','Active')
                            ->where('parties.deleted','=','No')
                            ->where('parties.status','=','Active')
                            ->where('sale_order_products.parent_id','=',$detail->id)
                            ->first();
                    $parentOrderToVendorParty=SaleOrderProduct::join('tbl_booking','tbl_booking.id','=','sale_order_products.tbl_sale_orders_id')
                            ->leftjoin('parties','parties.id','=','tbl_booking.customer_id')
                            ->select('parties.*')
                            ->where('sale_order_products.deleted','=','No')
                            ->where('sale_order_products.status','=','Active')
                            ->where('parties.deleted','=','No')
                            ->where('parties.status','=','Active')
                            ->where('sale_order_products.id','!=',0)
                            ->where('sale_order_products.id','=',$detail->parent_id)
                            ->first();

                        $ordertoVendorHtml = '';
                        $receivedFromVendorHtml = '';
                        $deliveredToApplicantHtml='';
                        
                        if($ordertoVendor){
                            $ordertoVendorType='';
                            if($ordertoVendor->order_type == 'takeOrderFromApplicant'){
                                $ordertoVendorType='Ordered from Applicant';
                            }elseif($ordertoVendor->order_type == 'giveOrderToVendor'){
                                $ordertoVendorType='Ordered to Vendor';
                            }elseif($ordertoVendor->order_type == 'receiveOrderFromVendor'){
                                $ordertoVendorType='Received from Vendor';
                            }elseif($ordertoVendor->order_type == 'deliverOrderToApplicant'){
                                $ordertoVendorType='Delivered to Applicant';
                            }
                            
                            if($request->type == 'Applicant'){
                                $ordertoVendorHtml ='<b>Vendor Name: </b>'.$ordertoVendor->partyName.'<br><b> Order Code: </b> <a href="#" onclick="completeInvoice(' . $ordertoVendor->saleOrderId . ')"> '.$ordertoVendor->deliveryOrderCode.'</a> <br> <b>Date: </b> '.date("d-m-Y", strtotime($ordertoVendor->date)).' <br><b>Service Charge: </b>'.$ordertoVendor->subtotal;
                            }elseif($request->type == 'Vendor'){
                                $ordertoVendorHtml ='<b>Vendor Name: </b>'.$ordertoVendor->partyName.'<br><b> Order Code: </b> <a href="#" onclick="completeInvoice(' . $ordertoVendor->saleOrderId . ')"> '.$ordertoVendor->deliveryOrderCode.'</a> <br> <b>Date: </b> '.date("d-m-Y", strtotime($ordertoVendor->date));
                            }
                            $receivedFromVendor=SaleOrderProduct::join('tbl_booking','tbl_booking.id','=','sale_order_products.tbl_sale_orders_id')
                                    ->leftjoin('parties','parties.id','=','tbl_booking.customer_id')
                                    ->select('sale_order_products.*','tbl_booking.date','parties.name as partyName','parties.party_type as partyType','tbl_booking.sale_no as deliveryOrderCode','tbl_booking.id as saleOrderId')
                                    ->where('sale_order_products.deleted','=','No')
                                    ->where('sale_order_products.status','=','Active')
                                    ->where('parties.deleted','=','No')
                                    ->where('parties.status','=','Active')
                                    ->where('sale_order_products.parent_id','=',$ordertoVendor->id)
                                    ->first();
                            
                            if($receivedFromVendor){
                                $receivedFromVendorType='';
                                if($receivedFromVendor->order_type == 'takeOrderFromApplicant'){
                                    $receivedFromVendorType='Ordered from Applicant';
                                }elseif($receivedFromVendor->order_type == 'giveOrderToVendor'){
                                    $receivedFromVendorType='Ordered to Vendor';
                                }elseif($receivedFromVendor->order_type == 'receiveOrderFromVendor'){
                                    $receivedFromVendorType='Received from Vendor';
                                }elseif($receivedFromVendor->order_type == 'deliverOrderToApplicant'){
                                    $receivedFromVendorType='Delivered to Applicant';
                                }
                                $receivedFromVendorHtml = '<b>Vendor Name: </b>'.$receivedFromVendor->partyName.'<br><b> Order Code: </b> <a href="#" onclick="completeInvoice(' . $receivedFromVendor->saleOrderId . ')">'.$receivedFromVendor->deliveryOrderCode.'</a> <br> <b>Date: </b> '.date("d-m-Y", strtotime($receivedFromVendor->date)).' ';
                            
                                $deliveredToApplicant=SaleOrderProduct::join('tbl_booking','tbl_booking.id','=','sale_order_products.tbl_sale_orders_id')
                                        ->leftjoin('parties','parties.id','=','tbl_booking.customer_id')
                                        ->select('sale_order_products.*','tbl_booking.date','parties.name as partyName','parties.party_type as partyType','tbl_booking.sale_no as deliveryOrderCode','tbl_booking.id as saleOrderId')
                                        ->where('sale_order_products.deleted','=','No')
                                        ->where('sale_order_products.status','=','Active')
                                        ->where('parties.deleted','=','No')
                                        ->where('parties.status','=','Active')
                                        ->where('sale_order_products.parent_id','=',$receivedFromVendor->id)
                                        ->first();
                                
                                if($deliveredToApplicant){
                                    $deliveredToApplicantType='';
                                    if($deliveredToApplicant->order_type == 'takeOrderFromApplicant'){
                                        $deliveredToApplicantType='Ordered from Applicant';
                                    }elseif($deliveredToApplicant->order_type == 'giveOrderToVendor'){
                                        $deliveredToApplicantType='Ordered to Vendor';
                                    }elseif($deliveredToApplicant->order_type == 'receiveOrderFromVendor'){
                                        $deliveredToApplicantType='Received from Vendor';
                                    }elseif($deliveredToApplicant->order_type == 'deliverOrderToApplicant'){
                                        $deliveredToApplicantType='Delivered to Applicant';
                                    }
                                    $deliveredToApplicantHtml = '<b>Applicant Name: </b>'.$deliveredToApplicant->partyName.'<br><b> Order Code: </b> <a href="#" onclick="completeInvoice(' . $deliveredToApplicant->saleOrderId . ')">'.$deliveredToApplicant->deliveryOrderCode.'</a> <br> <b>Date: </b> '.date("d-m-Y", strtotime($deliveredToApplicant->date)).' ';
                                }
                            }
                        }

                    
                    
                    $status='<span class="badge badge-success">Completed </span>';
                    
                    if($detail->process_status == 'Internal' && $detail->orderStatus == 'Pending'){
                        $status='<span class="badge badge-success">Completed</span>';
                    }elseif($detail->process_status == 'External' && $detail->orderStatus == 'Pending'){
                        $status='<span class="badge badge-danger">Pending</span>';
                    }elseif($detail->process_status == 'External' && $detail->orderStatus == 'Ordered'){
                        $status='<span class="badge badge-success">Completed</span>';
                    }elseif($detail->process_status == 'External' && $detail->orderStatus == 'Order Received'){
                        $status='<span class="badge badge-success">Completed</span>';
                    }elseif($detail->process_status == 'External' && $detail->orderStatus == 'Completed'){
                        $status='<span class="badge badge-success">Completed</span>';
                    }elseif($detail->process_status == 'Vendor Receive' && $detail->orderStatus == 'Pending'){
                        $status="<span class='badge badge-danger'>Pending</span>";
                    }elseif($detail->process_status == 'Vendor Receive' && $detail->orderStatus == 'Ordered'){
                        $status='<span class="badge badge-warning">Processing</span>';
                    }elseif($detail->process_status == 'Vendor Receive' && $detail->orderStatus == 'Order Received'){
                        $status='<span class="badge badge-success">Completed</span>';
                    }elseif($detail->process_status == 'Vendor Receive' && $detail->orderStatus == 'Completed'){
                        $status='<span class="badge badge-success">Completed</span>';
                    }elseif($detail->process_status == 'Applicant Delivery' && $detail->orderStatus == 'Pending'){
                        $status='<span class="badge badge-danger">Pending</span>';
                    }elseif($detail->process_status == 'Applicant Delivery' && $detail->orderStatus == 'Ordered'){
                        $status='<span class="badge badge-warning">Processing</span>';
                    }elseif($detail->process_status == 'Applicant Delivery' && $detail->orderStatus == 'Order Received'){
                        $status='<span class="badge badge-primary">Ready To Delivery</span>';
                    }elseif($detail->process_status == 'Applicant Delivery' && $detail->orderStatus == 'Completed'){
                        $status='<span class="badge badge-success">Completed</span>';
                    }

                    $applicantData='';
                    if($parentOrderToVendorParty){
                        $applicantData ='<b>Applicant: </b>'.$parentOrderToVendorParty->name.' -  ' . $parentOrderToVendorParty->contact;
                    }
                    
                    if($request->type == 'Applicant'){
                        $orderDetailsHtml.='<table border="1" style="width:100%;" id="order_details_table">
                                            <tbody>
                                                <tr>
                                                    <td width="22%"><b>Applicant Order</b></td>
                                                    <td width="22%"><b>Vendor Order</b></td>
                                                    <td width="22%"><b>Vendor Receive</b></td>
                                                    <td width="22%"><b>Applicant Delivery</b></td>
                                                    <td width="12%"><b>Status</b></td>
                                                </tr>
                                                <tr>
                                                    <td width="22%">
                                                        <b>Service Name: </b>'.$detail->name.' <br> 
                                                        <b>Process Status: </b> '.$detail->process_status.'<br>
                                                        <b>Total Amount: </b> '. $detail->subtotal .' 
                                                    </td>
                                                    <td width="22%">'.$ordertoVendorHtml.'</td>
                                                    <td width="22%">'.$receivedFromVendorHtml.'</td>
                                                    <td width="22%">'.$deliveredToApplicantHtml.'</td>
                                                    <td width="12%">'.$status.'</td>
                                                </tr>
                                            </tbody>
                                        </table>';
                        if($deliveredToApplicantHtml){
                            $orderType='Delivered to Applicant';
                        }elseif($receivedFromVendorHtml){
                            $orderType='Received from Vendor';
                        }elseif($ordertoVendorHtml){
                            $orderType='Ordered to Vendor';
                        }else{
                            $orderType='Ordered from Applicant';
                        }
                    }elseif($request->type == 'Vendor'){
                        $orderDetailsHtml.='<table border="1" style="width:100%;" id="order_details_table">
                                            <tbody>
                                                <tr>
                                                    <td width="30%"><b>VendorOrder</b></td>
                                                    <td width="30%"><b>Vendor Receive</b></td>
                                                    <td width="30%"><b>Applicant Delivery</b></td>
                                                    <td width="10%"><b>Status</b></td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                                <b>Service Name: </b>'.$detail->name.'<br> 
                                                                '.$applicantData.'<br>
                                                                <b>Process Status: </b> '.$detail->process_status.'<br>
                                                                <b>Total Amount: </b> '. $detail->subtotal .' 
                                                    </td>
                                                    <td width="30%">'.$ordertoVendorHtml.'</td>
                                                    <td width="30%">'.$receivedFromVendorHtml.'</td>
                                                    <td width="10%">'.$status.'</td>
                                                </tr>
                                            </tbody>
                                        </table>';
                        if($receivedFromVendorHtml){
                            $orderType='Delivered to Applicant';
                        }elseif($ordertoVendorHtml){
                            $orderType='Received from Vendor';
                        }else{
                            $orderType='Ordered to Vendor';
                        }
                    }
                    
                    
                    
                }
            }
            
            $html.='
                        <tr>
                            <td>'.$i++.'</td>
                            <td class="text-left"><b>Date: </b>'.date("d-m-Y", strtotime($order->work_approval_date)).'<br><b>Order NO: </b><a href="#" onclick="completeInvoice(' . $order->id . ')">'.$order->sale_no.'</a><br><b>Name: </b>'.$party->name.'<br><b>Contact: </b>'.$party->contact.'<br><b>Grand Total: </b>'.$order->total_amount.'
                            </td>
                            <td class="text-left">'.$orderDetailsHtml.'</td>
                        </tr>
                    ';
        }
        return $html;
    }



    public function generateTotalBillAmountDetailsPdf($date_from,$date_to){
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
        $bills= DB::table('tbl_acc_bill_details')
            ->join('tbl_acc_bills','tbl_acc_bills.id','=','tbl_acc_bill_details.tbl_acc_bill_id')
            ->leftjoin('parties','parties.id','=','tbl_acc_bills.tbl_crm_vendor_id')
            ->select('tbl_acc_bill_details.*','parties.name','tbl_acc_bills.code')
            ->where('tbl_acc_bills.deleted','=','No')
            ->where('tbl_acc_bills.sister_concern_id','=',$logged_sister_concern_id)
            ->where('tbl_acc_bill_details.deleted','=','No')
            ->where('tbl_acc_bill_details.deleted','=','No')
            ->where('tbl_acc_bills.transaction_date', '>=', $date_from)
            ->where('tbl_acc_bills.transaction_date', '<=', $date_to)
            ->orderby('tbl_acc_bills.id','Desc')
            ->get();
        $pdf = PDF::loadView('admin.reports.billAmountDetailsPdf',['date_from'=>$date_from,'date_to'=>$date_to,'bills'=>$bills]);
        return $pdf->stream('bill-amount-details-pdf.pdf', array("Attachment" => false));
    }

 

    public function bankLedger(){
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
        $transaction_method =ChartOfAccounts::where('slug','=','cash-bank')->where('sister_concern_id','LIKE', '%'.$logged_sister_concern_id.'%')->where('deleted','=','No')->where('status','=','Active')->first();
        $methods =ChartOfAccounts::where('parent_id','=',$transaction_method->id)->where('sister_concern_id','LIKE', '%'.$logged_sister_concern_id.'%')->where('deleted','=','No')->where('status','=','Active')->get();
        return view('admin.reports.bankLedger', ['methods'=>$methods]);
    }






    public function generateBankLedger(Request $request){
        //return $request;
            $validated = $request->validate([
                'payment_method' => 'required',
                'date_from' => 'required',
                'date_to' => 'required',
            ]);
        
            $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
        
        $coa=ChartOfAccounts::find($request->payment_method);
        
        if($coa->slug != 'cash'){
            $validated = $request->validate([
                'source' => 'required',
                'accounts' => 'required',
            ]);
        }
        
        if($coa->slug == 'cash'){
            $mainCoa=ChartOfAccounts::find($request->payment_method);
        }else{
            $mainCoa=ChartOfAccounts::find($request->accounts);
        }
        
        if($request->date_from < $mainCoa->opening_balance_entry_date){
            $fromDate=$mainCoa->opening_balance_entry_date;
        }else{
            $fromDate=$request->date_from;
        }

        $vouchers = DB::table('tbl_voucher_payment_vouchers')
                ->select('tbl_voucher_payment_vouchers.*')
                ->where('tbl_voucher_payment_vouchers.sister_concern_id', '=',$logged_sister_concern_id)
                ->whereBetween('tbl_voucher_payment_vouchers.paymentDate', [$fromDate, $request->date_to])
                ->where('tbl_voucher_payment_vouchers.deleted', '=', 'No')
                ->where('tbl_voucher_payment_vouchers.status', '=', 'Active')
                ->where(function ($query) {
                        $query->where('tbl_voucher_payment_vouchers.type', 'Payment')
                            ->orWhere('tbl_voucher_payment_vouchers.type', 'Payment Received');
                    });
                $paymentMethodId=0;
                $sourceId=0;
                $accountId=0;
                if($coa->slug == 'cash'){
                    $paymentMethodId=$request->payment_method;
                    $vouchers->where('tbl_voucher_payment_vouchers.payment_method_coa_id', '=',  $paymentMethodId);
                }else{
                    $paymentMethodId=$request->payment_method;
                    $sourceId=$request->source;
                    $accountId=$request->accounts;
                    $vouchers->where('tbl_voucher_payment_vouchers.payment_method_coa_id', '=',  $paymentMethodId)
                            ->where('tbl_voucher_payment_vouchers.source_coa_id', '=',  $sourceId)
                            ->where('tbl_voucher_payment_vouchers.account_coa_id', '=',  $accountId);
                }
         $vouchers = $vouchers->orderBy('paymentDate','ASC')->get();
        
        
        if($coa->slug == 'cash'){
            $coaOpening=ChartOfAccounts::find($paymentMethodId);
        }else{
            $coaOpening=ChartOfAccounts::find($accountId);
        }
        $openingDebit = DB::table('tbl_voucher_payment_vouchers')
                        ->select('tbl_voucher_payment_vouchers.*')
                        ->where('tbl_voucher_payment_vouchers.sister_concern_id', '=',$logged_sister_concern_id)
                        ->where('tbl_voucher_payment_vouchers.paymentDate', '>=', $fromDate)
                        ->where('tbl_voucher_payment_vouchers.paymentDate', '<', $request->date_from)
                        ->where('tbl_voucher_payment_vouchers.deleted', '=', 'No')
                        ->where('tbl_voucher_payment_vouchers.status', '=', 'Active')
                        ->where('tbl_voucher_payment_vouchers.type', 'Payment Received');
                        $paymentMethodId=0;
                        $sourceId=0;
                        $accountId=0;
                        if($coa->slug == 'cash'){
                            $paymentMethodId=$request->payment_method;
                            $openingDebit->where('tbl_voucher_payment_vouchers.payment_method_coa_id', '=',  $paymentMethodId);
                        }else{
                            $paymentMethodId=$request->payment_method;
                            $sourceId=$request->source;
                            $accountId=$request->accounts;
                            $openingDebit->where('tbl_voucher_payment_vouchers.payment_method_coa_id', '=',  $paymentMethodId)
                                    ->where('tbl_voucher_payment_vouchers.source_coa_id', '=',  $sourceId)
                                    ->where('tbl_voucher_payment_vouchers.account_coa_id', '=',  $accountId);
                        }   
        
        $openingDebit = $openingDebit->sum('tbl_voucher_payment_vouchers.amount') + $coaOpening->opening_balance;
        
        
    
        $openingCredit = DB::table('tbl_voucher_payment_vouchers')
                        ->select('tbl_voucher_payment_vouchers.*')
                        ->where('tbl_voucher_payment_vouchers.sister_concern_id', '=',$logged_sister_concern_id)
                        ->where('tbl_voucher_payment_vouchers.paymentDate', '>=', $fromDate)
                        ->where('tbl_voucher_payment_vouchers.paymentDate', '<', $request->date_from)
                        ->where('tbl_voucher_payment_vouchers.deleted', '=', 'No')
                        ->where('tbl_voucher_payment_vouchers.status', '=', 'Active')
                        ->where('tbl_voucher_payment_vouchers.type', 'Payment');
                        $paymentMethodId=0;
                        $sourceId=0;
                        $accountId=0;
                        if($coa->slug == 'cash'){
                            $paymentMethodId=$request->payment_method;
                            $openingCredit->where('tbl_voucher_payment_vouchers.payment_method_coa_id', '=',  $paymentMethodId);
                        }else{
                            $paymentMethodId=$request->payment_method;
                            $sourceId=$request->source;
                            $accountId=$request->accounts;
                            $openingCredit->where('tbl_voucher_payment_vouchers.payment_method_coa_id', '=',  $paymentMethodId)
                                    ->where('tbl_voucher_payment_vouchers.source_coa_id', '=',  $sourceId)
                                    ->where('tbl_voucher_payment_vouchers.account_coa_id', '=',  $accountId);
                        }     
                        
        $openingCredit=$openingCredit->sum('tbl_voucher_payment_vouchers.amount');
        
        
        
       
        
        
        $openingBalance=$openingDebit - $openingCredit ;
        
        $openingCreditBalance = 0;
        $openingDebitBalance = 0;
        $balance = $openingDebitBalance-$openingCreditBalance;

        if ($openingBalance < 0) {
            $openingCreditBalance = abs($openingBalance);
            //$openingDebitBalance='';
            $balance = $balance-$openingCreditBalance;
            
            
        } else {
            
            $openingDebitBalance = abs($openingBalance);
           // $openingCreditBalance='';
            $balance = $balance+$openingDebitBalance;
        }
        
        
        $data = '';
        $table = '';
        $total = '';
        $totalDebit = 0;
        $totalCredit = 0;
        $button = '';
        $i = 1;
        
            $table .=   '<tr>
                            <td colspan="4" class="text-right"><b>Opening Balance:</b></td>
                            <td class="text-right"><b>'.number_format($openingDebitBalance).'</b></td>
                            <td class="text-right "><b>'.number_format($openingCreditBalance).'</b></td>
                            <td class="text-right"><b>' . number_format($balance,2) . '</b></td>
                        </tr>';
        
             foreach ($vouchers as $voucher) {
                    $debit=0;
                    $credit=0;
                    if($voucher->type == 'Payment Received'){
                        $debit=$voucher->amount;
                    }elseif($voucher->type == 'Payment'){
                        $credit=$voucher->amount;
                    }
                    $balance += $debit ?? 0;
                    $balance -= $credit ?? 0;
        
                    $table .= '<tr>
                                    <td class="text-center">' . $i++ . '</td>
                                    <td class="text-center">' . $voucher->paymentDate . '</td>
                                    <td><a href="#" onclick="ledgerDetails('.$voucher->id.')">' . $voucher->remarks . '</a></td>
                                    <td class="text-center"># ' . $voucher->voucherNo . '</td>
                                    <td class="text-right">' . $debit . '</td>
                                    <td class="text-right">' . $credit . '</td>
                                    <td class="text-right">' . number_format($balance,2) . '</td>
                                </tr>';
                    $totalDebit += $debit;
                    $totalCredit += $credit;
                }
                //$due = $totalDebit - $totalCredit;
        
                  $total .= '<tr>
                                <td colspan="4" class="text-right"><b>Total:</b></td>
                                <td class="text-right"><b>' . number_format($totalDebit + $openingDebitBalance,2) . '</b></td>
                                <td class="text-right"><b>' . number_format($totalCredit + $openingCreditBalance,2) . '</b></td>
                                <td class="text-right"><b></b></td>
                            </tr>'; 
        
                
        
                $closingCreditBalance = 0;
                $closingDebitBalance = 0;
                if ($balance > 0) {
                    $closingCreditBalance = $balance;
                } else {
                    $closingDebitBalance = $balance;
                }
        
        
                $total .= '<tr>
                                <td colspan="4" class="text-right"><strong class="float-right font-weight-bold">Closing Balance </strong></td>
                                <td class="text-right "><b>' . number_format(abs($closingDebitBalance ),2) . '</b></td>
                                <td class="text-right"> <strong class="float-right font-weight-bold ">' . number_format($closingCreditBalance ,2) . '</strong></td>
                                 <td></td>
                            </tr>
                            
                            <tr>
                                <td colspan="4" class="text-right"><strong class="float-right font-weight-bold">Total Transection Balance</strong></td>
                                <td class="text-right "><b>' . number_format(($totalDebit+$openingDebitBalance - $closingDebitBalance),2) . '</b></td>
                                <td class="text-right"> <strong class="float-right font-weight-bold ">' . number_format(($totalCredit+$openingCreditBalance+$closingCreditBalance),2) . '</strong></td>
                                 <td></td>
                            </tr>';
                            
                $button .= '<button class="btn btn-primary float-right" onclick="generateBankLedgerPdf()"><i class="fa fa-file-pdf"></i> Generate PDF </button>';
                $data = array(
                    'table' => $table,
                    'total' => $total,
                    'button' => $button
                );
                return $data;
    }







    public function generateBankLedgerPdf($payment_method, $source,$accounts,$date_from, $date_to){
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
        if($payment_method > 0){
            
            $coa=ChartOfAccounts::find($payment_method);
            
            if($coa->slug == 'cash'){
                $mainCoa=ChartOfAccounts::find($payment_method);
            }else{
                $mainCoa=ChartOfAccounts::find($accounts);
            }
            
            
            if($date_from < $mainCoa->opening_balance_entry_date){
                $fromDate=$mainCoa->opening_balance_entry_date;
            }else{
                $fromDate=$date_from;
            }
            
            if($coa){
                if($coa->slug == 'cash'){
                    $paymentMethodId=$payment_method;
                    $sourceCoa='';
                    $accountCoa='';
                }else{
                    if($source > 0){
                        $sourceCoa=ChartOfAccounts::where('id','=',$source)
                                                    ->where('parent_id','=',$payment_method)
                                                    ->where('deleted', '=', 'No')
                                                    ->where('status', '=', 'Active')
                                                    ->where('sister_concern_id','LIKE', '%'.$logged_sister_concern_id.'%')
                                                    ->first();
                        if($sourceCoa){                            
                            if($accounts > 0){
                                $accountCoa=ChartOfAccounts::where('id','=',$accounts)
                                                ->where('parent_id','=',$sourceCoa->id)
                                                ->where('deleted', '=', 'No')
                                                ->where('status', '=', 'Active')
                                                ->where('sister_concern_id','LIKE', '%'.$logged_sister_concern_id.'%')
                                                ->first();
                                if($accountCoa){
                                    $paymentMethodId=$accountCoa->id;
                                }else{
                                    abort(404);
                                }
                            }else{
                                abort(404);
                            }
                        }else{
                            abort(404);
                        }
                    }else{
                        abort(404);
                    }
                }
            }else{
                abort(404);
            }
            
       
        
            $vouchers = DB::table('tbl_voucher_payment_vouchers')
                ->select('tbl_voucher_payment_vouchers.*')
                ->where('tbl_voucher_payment_vouchers.sister_concern_id', '=',$logged_sister_concern_id)
                ->whereBetween('tbl_voucher_payment_vouchers.paymentDate', [$fromDate, $date_to])
                ->where('tbl_voucher_payment_vouchers.deleted', '=', 'No')
                ->where('tbl_voucher_payment_vouchers.status', '=', 'Active')
                ->where(function ($query) {
                        $query->where('tbl_voucher_payment_vouchers.type', 'Payment')
                            ->orWhere('tbl_voucher_payment_vouchers.type', 'Payment Received');
                    });
                $paymentMethodId=0;
                $sourceId=0;
                $accountId=0;
                if($coa->slug == 'cash'){
                    $paymentMethodId=$payment_method;
                    $vouchers->where('tbl_voucher_payment_vouchers.payment_method_coa_id', '=',  $paymentMethodId);
                }else{
                    $paymentMethodId=$payment_method;
                    $sourceId=$source;
                    $accountId=$accounts;
                    $vouchers->where('tbl_voucher_payment_vouchers.payment_method_coa_id', '=',  $paymentMethodId)
                            ->where('tbl_voucher_payment_vouchers.source_coa_id', '=',  $sourceId)
                            ->where('tbl_voucher_payment_vouchers.account_coa_id', '=',  $accountId);
                }
            $vouchers = $vouchers->orderBy('paymentDate','ASC')->get();


        if($coa->slug == 'cash'){
            $coaOpening=ChartOfAccounts::find($paymentMethodId);
        }else{
            $coaOpening=ChartOfAccounts::find($accountId);
        } 
        $openingDebit = DB::table('tbl_voucher_payment_vouchers')
                        ->select('tbl_voucher_payment_vouchers.*')
                        ->where('tbl_voucher_payment_vouchers.sister_concern_id', '=',$logged_sister_concern_id)
                        ->where('tbl_voucher_payment_vouchers.paymentDate', '>=', $fromDate)
                        ->where('tbl_voucher_payment_vouchers.paymentDate', '<', $date_from)
                        ->where('tbl_voucher_payment_vouchers.deleted', '=', 'No')
                        ->where('tbl_voucher_payment_vouchers.status', '=', 'Active')
                        ->where('tbl_voucher_payment_vouchers.type', 'Payment Received');
                        $paymentMethodId=0;
                        $sourceId=0;
                        $accountId=0;
                        if($coa->slug == 'cash'){
                            $paymentMethodId=$payment_method;
                            $openingDebit->where('tbl_voucher_payment_vouchers.payment_method_coa_id', '=',  $paymentMethodId);
                        }else{
                            $paymentMethodId=$payment_method;
                            $sourceId=$source;
                            $accountId=$accounts;
                            $openingDebit->where('tbl_voucher_payment_vouchers.payment_method_coa_id', '=',  $paymentMethodId)
                                    ->where('tbl_voucher_payment_vouchers.source_coa_id', '=',  $sourceId)
                                    ->where('tbl_voucher_payment_vouchers.account_coa_id', '=',  $accountId);
                        }   
        
        $openingDebit = $openingDebit->sum('tbl_voucher_payment_vouchers.amount') + $coaOpening->opening_balance;
        
        
    
        $openingCredit = DB::table('tbl_voucher_payment_vouchers')
                        ->select('tbl_voucher_payment_vouchers.*')
                        ->where('tbl_voucher_payment_vouchers.sister_concern_id', '=',$logged_sister_concern_id)
                        ->where('tbl_voucher_payment_vouchers.paymentDate', '>=', $fromDate)
                        ->where('tbl_voucher_payment_vouchers.paymentDate', '<', $date_from)
                        ->where('tbl_voucher_payment_vouchers.deleted', '=', 'No')
                        ->where('tbl_voucher_payment_vouchers.status', '=', 'Active')
                        ->where('tbl_voucher_payment_vouchers.type', 'Payment');
                        $paymentMethodId=0;
                        $sourceId=0;
                        $accountId=0;
                        if($coa->slug == 'cash'){
                            $paymentMethodId=$payment_method;
                            $openingCredit->where('tbl_voucher_payment_vouchers.payment_method_coa_id', '=',  $paymentMethodId);
                        }else{
                            $paymentMethodId=$payment_method;
                            $sourceId=$source;
                            $accountId=$accounts;
                            $openingCredit->where('tbl_voucher_payment_vouchers.payment_method_coa_id', '=',  $paymentMethodId)
                                    ->where('tbl_voucher_payment_vouchers.source_coa_id', '=',  $sourceId)
                                    ->where('tbl_voucher_payment_vouchers.account_coa_id', '=',  $accountId);
                        }  
                        
        $openingCredit=$openingCredit->sum('tbl_voucher_payment_vouchers.amount');
        
        
        
        $openingBalance = $openingDebit - $openingCredit  ;
        $balance=0;
        if ($openingBalance < 0) {
            $openingCreditBalance = abs($openingBalance);
            //$openingDebitBalance='';
            $balance = $balance-$openingCreditBalance;
            
            
        } else {
            
            $openingDebitBalance = abs($openingBalance);
           // $openingCreditBalance='';
            $balance = $balance+$openingDebitBalance;
        }
            $party='';
            $pdf = PDF::loadView('admin.reports.BankLedgerPdf', ['vouchers' => $vouchers,'accountCoa'=>$accountCoa,'sourceCoa'=>$sourceCoa,'coa' => $coa, 'date_from' => $date_from, 'date_to' => $date_to, 'debit' => $openingDebit, 'credit' => $openingCredit, 'openingBalance' => $balance]);
            return $pdf->stream('BankLedgerPdf.pdf', array("Attachment" => false));
        }else{
            abort(404);
        }

    }





    public function partyDues(){
        return view('admin.reports.partyDue');
    }


    
    public function generatePartyDueReport(Request $request){
        $parties = Party::where('party_type', '=', $request->party_type)
                        ->where('deleted', '=', 'No')
                        ->get();
        
        if ($request->party_type == 'Applicant') {
            $payableOrReceiveable = 'Party Payable';
            $paymentOrReceived = 'Payment Received';
             $paymentOrReceivedReverse = 'Payment';
            $adjustmentStr = 'Payment Adjustment';
        } elseif ($request->party_type == 'Vendor' || $request->party_type == 'Supplier') {
            $payableOrReceiveable = 'Payable';
            $paymentOrReceived = 'Payment';
             $paymentOrReceivedReverse = 'Payment Received';
            $adjustmentStr = 'Adjustment';
        }

        $partyDueData = [];

        foreach ($parties as $party) {
            $discount = DB::table('tbl_voucher_payment_vouchers')
                ->whereBetween('tbl_voucher_payment_vouchers.paymentDate', [$request->date_from, $request->date_to])
                ->where('tbl_voucher_payment_vouchers.deleted', '=', 'No')
                ->where('tbl_voucher_payment_vouchers.status', '=', 'Active')
                ->where('tbl_voucher_payment_vouchers.type', '=', 'Discount')
                ->where('tbl_voucher_payment_vouchers.party_id', '=', $party->id)
                ->sum('tbl_voucher_payment_vouchers.amount');
            $adjustment = DB::table('tbl_voucher_payment_vouchers')
                ->whereBetween('tbl_voucher_payment_vouchers.paymentDate', [$request->date_from, $request->date_to])
                ->where('tbl_voucher_payment_vouchers.deleted', '=', 'No')
                ->where('tbl_voucher_payment_vouchers.status', '=', 'Active')
                ->where('tbl_voucher_payment_vouchers.type', '=', $adjustmentStr)
                ->where('tbl_voucher_payment_vouchers.party_id', '=', $party->id)
                ->sum('tbl_voucher_payment_vouchers.amount');
            $payableOrReceiveableAmount = DB::table('tbl_voucher_payment_vouchers')
                ->whereBetween('tbl_voucher_payment_vouchers.paymentDate', [$request->date_from, $request->date_to])
                ->where('tbl_voucher_payment_vouchers.deleted', '=', 'No')
                ->where('tbl_voucher_payment_vouchers.status', '=', 'Active')
                ->where('tbl_voucher_payment_vouchers.type', '=', $payableOrReceiveable)
                ->where('tbl_voucher_payment_vouchers.party_id', '=', $party->id)
                ->sum('tbl_voucher_payment_vouchers.amount');
    
            $paymentOrReceivedAmount = DB::table('tbl_voucher_payment_vouchers')
                ->whereBetween('tbl_voucher_payment_vouchers.paymentDate', [$request->date_from, $request->date_to])
                ->where('tbl_voucher_payment_vouchers.deleted', '=', 'No')
                ->where('tbl_voucher_payment_vouchers.status', '=', 'Active')
                ->where('tbl_voucher_payment_vouchers.type', '=', $paymentOrReceived)
                ->where('tbl_voucher_payment_vouchers.party_id', '=', $party->id)
                ->sum('tbl_voucher_payment_vouchers.amount');
                
            $paymentOrReceivedAmountReverse = DB::table('tbl_voucher_payment_vouchers')
                ->whereBetween('tbl_voucher_payment_vouchers.paymentDate', [$request->date_from, $request->date_to])
                ->where('tbl_voucher_payment_vouchers.deleted', '=', 'No')
                ->where('tbl_voucher_payment_vouchers.status', '=', 'Active')
                ->where('tbl_voucher_payment_vouchers.type', '=', $paymentOrReceivedReverse)
                ->where('tbl_voucher_payment_vouchers.party_id', '=', $party->id)
                ->sum('tbl_voucher_payment_vouchers.amount');
                
            if ($request->party_type == 'Applicant') {
                $payableOrReceiveableAmount=$payableOrReceiveableAmount+$paymentOrReceivedAmountReverse ;
                $paymentOrReceivedAmount=$paymentOrReceivedAmount ;
                $due = $payableOrReceiveableAmount - $paymentOrReceivedAmount - $adjustment-$discount;
            } elseif ($request->party_type == 'Vendor' || $request->party_type == 'Supplier') {
                $payableOrReceiveableAmount=$payableOrReceiveableAmount+$paymentOrReceivedAmountReverse ;
                $paymentOrReceivedAmount=$paymentOrReceivedAmount;
                $due = $payableOrReceiveableAmount - $paymentOrReceivedAmount  - $adjustment- $discount;
            }
            
            
             if ($due != 0) {
                $partyDueData[] = [
                    'party' => $party,
                    'payableOrReceiveableAmount' => $payableOrReceiveableAmount,
                    'paymentOrReceivedAmount' => $paymentOrReceivedAmount,
                    'due' => $due,
                    'discount'=>$discount,
                    'adjustment'=>$adjustment
                    
                ];
             }
        }

        // Sort the array by 'due' amount in descending order
        usort($partyDueData, function($a, $b) {
            return $b['due'] <=> $a['due'];
        });

        $html = '';
        $html .= '<table class="table table-bordered table-hover dataTable no-footer" width="100%">
                    <thead>
                        <tr class="bg-light">
                            <th width="5%" class="text-center">Sl</th>
                            <th width="50%" class="text-center">Party Info</th>
                            <th width="15%" class="text-right">'.$payableOrReceiveable.'</th>
                            <th width="15%" class="text-right">'.$paymentOrReceived.'</th>
                            <th width="15%" class="text-right">Discount</th>
                            <th width="15%" class="text-right">Adjustment</th>
                            <th width="15%" class="text-right">Due</th>
                        </tr>
                    </thead>
                    <tbody>';
    
        $i = 1;
        $totalPayableOrReceiveableAmount=0;
        $totalPaymentOrReceivedAmount=0;
        $totalDue=0;
        $totalDiscount=0;
        $totalAdjustment=0;
        foreach ($partyDueData as $data) {
            $html .= '<tr>
                        <td>'.$i++.'</td>
                        <td>'.$data['party']->name.' - '.$data['party']->contact.' - ('.$data['party']->code.')</td>
                        <td class="text-right">'.$data['payableOrReceiveableAmount'].'</td>
                        <td class="text-right">'.$data['paymentOrReceivedAmount'].'</td>
                        <td class="text-right">'.$data['discount'].'</td>
                        <td class="text-right">'.$data['adjustment'].'</td>
                        <td class="text-right">'.$data['due'].'</td>
                      </tr>';
                      $totalPayableOrReceiveableAmount+=$data['payableOrReceiveableAmount'];
                      $totalPaymentOrReceivedAmount+=$data['paymentOrReceivedAmount'];
                      $totalDiscount+=$data['discount'];
                      $totalAdjustment+=$data['adjustment'];
                      $totalDue+=$data['due'];
        }
            $html .= '<tr>
                        <td colspan="2" class="text-right"><b>Total: </b></td>
                        <td class="text-right"><b>'.$totalPayableOrReceiveableAmount.'</b></td>
                        <td class="text-right"><b>'.$totalPaymentOrReceivedAmount.'</b></td>
                        <td class="text-right"><b>'.$totalDiscount.'</b></td>
                        <td class="text-right"><b>'.$totalAdjustment.'</b></td>
                        <td class="text-right"><b>'.$totalDue.'</b></td>
                      </tr>';
        $html .= '</tbody>
                </table>';
    
        return $html;
    }





    public function generatePartyDuePdf($party_type,$date_from,$date_to){
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
        $parties = Party::where('party_type', '=', $party_type)
                        ->where('deleted', '=', 'No')
                        ->get();
        
        if ($party_type == 'Applicant') {
            $payableOrReceiveable = 'Party Payable';
            $paymentOrReceived = 'Payment Received';
             $paymentOrReceivedReverse = 'Payment';
            $adjustmentStr = 'Payment Adjustment';
        } elseif ($party_type == 'Vendor' || $party_type == 'Supplier') {
            $payableOrReceiveable = 'Payable';
            $paymentOrReceived = 'Payment';
             $paymentOrReceivedReverse = 'Payment Received';
            $adjustmentStr = 'Adjustment';
        }
        
        $partyDueData = [];

        foreach ($parties as $party) {
            $discount = DB::table('tbl_voucher_payment_vouchers')
                ->whereBetween('tbl_voucher_payment_vouchers.paymentDate', [$date_from, $date_to])
                ->where('tbl_voucher_payment_vouchers.deleted', '=', 'No')
                ->where('tbl_voucher_payment_vouchers.status', '=', 'Active')
                ->where('tbl_voucher_payment_vouchers.type', '=', 'Discount')
                ->where('tbl_voucher_payment_vouchers.party_id', '=', $party->id)
                ->sum('tbl_voucher_payment_vouchers.amount');
            $adjustment = DB::table('tbl_voucher_payment_vouchers')
                ->whereBetween('tbl_voucher_payment_vouchers.paymentDate', [$date_from, $date_to])
                ->where('tbl_voucher_payment_vouchers.deleted', '=', 'No')
                ->where('tbl_voucher_payment_vouchers.status', '=', 'Active')
                ->where('tbl_voucher_payment_vouchers.type', '=', $adjustmentStr)
                ->where('tbl_voucher_payment_vouchers.party_id', '=', $party->id)
                ->sum('tbl_voucher_payment_vouchers.amount');
            $payableOrReceiveableAmount = DB::table('tbl_voucher_payment_vouchers')
                ->whereBetween('tbl_voucher_payment_vouchers.paymentDate', [$date_from, $date_to])
                ->where('tbl_voucher_payment_vouchers.deleted', '=', 'No')
                ->where('tbl_voucher_payment_vouchers.status', '=', 'Active')
                ->where('tbl_voucher_payment_vouchers.type', '=', $payableOrReceiveable)
                ->where('tbl_voucher_payment_vouchers.party_id', '=', $party->id)
                ->sum('tbl_voucher_payment_vouchers.amount');
    
            $paymentOrReceivedAmount = DB::table('tbl_voucher_payment_vouchers')
                ->whereBetween('tbl_voucher_payment_vouchers.paymentDate', [$date_from, $date_to])
                ->where('tbl_voucher_payment_vouchers.deleted', '=', 'No')
                ->where('tbl_voucher_payment_vouchers.status', '=', 'Active')
                ->where('tbl_voucher_payment_vouchers.type', '=', $paymentOrReceived)
                ->where('tbl_voucher_payment_vouchers.party_id', '=', $party->id)
                ->sum('tbl_voucher_payment_vouchers.amount');
                
            $paymentOrReceivedAmountReverse = DB::table('tbl_voucher_payment_vouchers')
                ->whereBetween('tbl_voucher_payment_vouchers.paymentDate', [$date_from, $date_to])
                ->where('tbl_voucher_payment_vouchers.deleted', '=', 'No')
                ->where('tbl_voucher_payment_vouchers.status', '=', 'Active')
                ->where('tbl_voucher_payment_vouchers.type', '=', $paymentOrReceivedReverse)
                ->where('tbl_voucher_payment_vouchers.party_id', '=', $party->id)
                ->sum('tbl_voucher_payment_vouchers.amount');
                
            if ($party_type == 'Applicant') {
                $payableOrReceiveableAmount=$payableOrReceiveableAmount+$paymentOrReceivedAmountReverse ;
                $paymentOrReceivedAmount=$paymentOrReceivedAmount ;
                $due = $payableOrReceiveableAmount - $paymentOrReceivedAmount - $adjustment-$discount;
            } elseif ($party_type == 'Vendor' || $party_type == 'Supplier') {
                $payableOrReceiveableAmount=$payableOrReceiveableAmount+$paymentOrReceivedAmountReverse ;
                $paymentOrReceivedAmount=$paymentOrReceivedAmount;
                $due = $payableOrReceiveableAmount - $paymentOrReceivedAmount  - $adjustment -$discount;
            }
            
            
            if ($due != 0) {
                $partyDueData[] = [
                    'party' => $party,
                    'payableOrReceiveableAmount' => $payableOrReceiveableAmount,
                    'paymentOrReceivedAmount' => $paymentOrReceivedAmount,
                    'due' => $due,
                    'discount'=>$discount,
                    'adjustment'=>$adjustment
                    
                ];
             }
        }
        // Sort the array by 'due' amount in descending order
        usort($partyDueData, function($a, $b) {
            return $b['due'] <=> $a['due'];
        });
        
        $pdf = PDF::loadView('admin.reports.partyDuePdf', ['partyDueData' => $partyDueData, 'party_type' => $party_type, 'date_from' => $date_from, 'date_to' => $date_to,'payableOrReceiveable'=>$payableOrReceiveable,'paymentOrReceived'=>$paymentOrReceived,'discount'=>$discount,
                    'adjustment'=>$adjustment]);
        return $pdf->stream(''.$party_type.'-due-report-pdf.pdf', array("Attachment" => false));
        
    }



    public function applicantWiseProfit($type){
        $applicants = Party::where('deleted', '=', 'No')->where('status', '=', 'Active')->where('party_type','=','Applicant')->get();
        return view('admin.reports.applicantWiseProfit',['applicants'=>$applicants,'type'=>$type]);
    }
    
    public function generateOrderWiseProfit(Request $request){
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
        $applicantSale = ChartOfAccounts::where('slug', '=', 'sale-applicant-service')->where('sister_concern_id','=',$logged_sister_concern_id)->where('deleted', 'No')->first();
        $applicantSaleReturn = ChartOfAccounts::where('slug', '=', 'sales-ruturn')->where('sister_concern_id','=',$logged_sister_concern_id)->where('deleted', 'No')->first();
        
            if($request->applicant_id == 'all'){
                $sales = DB::table('sale_order_products')
                    ->leftjoin('products', 'sale_order_products.product_id', '=', 'products.id')
                    ->join('tbl_booking', 'sale_order_products.tbl_sale_orders_id', '=', 'tbl_booking.id')
                    ->join('parties', 'tbl_booking.customer_id', '=', 'parties.id')
                    ->select('sale_order_products.id','sale_order_products.approximate_vendor_payable_amount','sale_order_products.subtotal', 'tbl_booking.date', 'parties.name','parties.contact','parties.code as partyCode','tbl_booking.sale_no','tbl_booking.id as saleId','parties.party_type','products.name as productName','products.code as productCode')
                    ->where('parties.party_type', '=','Applicant')
                    ->whereBetween('tbl_booking.date', [$request->date_from, $request->date_to])
                    // ->where('tbl_booking.warehouse','=',$loggedWarehouseId)
                    ->where('tbl_booking.deleted','=','No')
                    ->where('tbl_booking.status','=','Active')
                    ->where('sale_order_products.deleted','=','No')
                    ->where('sale_order_products.status','=','Active')
                    ->orderBy('sale_order_products.id','desc')
                    ->get();
                    
            }else{
                $sales = DB::table('sale_order_products')
                    ->leftjoin('products', 'sale_order_products.product_id', '=', 'products.id')
                    ->join('tbl_booking', 'sale_order_products.tbl_sale_orders_id', '=', 'tbl_booking.id')
                    ->join('parties', 'tbl_booking.customer_id', '=', 'parties.id')
                    ->select('sale_order_products.id','sale_order_products.approximate_vendor_payable_amount','sale_order_products.subtotal', 'tbl_booking.date', 'parties.name','parties.contact','parties.code as partyCode','tbl_booking.sale_no','tbl_booking.id as saleId','parties.party_type','products.name as productName','products.code as productCode')
                    ->where('parties.party_type', '=','Applicant')
                    ->where('tbl_booking.customer_id', '=',$request->applicant_id)
                    ->whereBetween('tbl_booking.date', [$request->date_from, $request->date_to])
                    // ->where('tbl_booking.warehouse','=',$loggedWarehouseId)
                    ->where('tbl_booking.deleted','=','No')
                    ->where('tbl_booking.status','=','Active')
                    ->where('sale_order_products.deleted','=','No')
                    ->where('sale_order_products.status','=','Active')
                    ->orderBy('sale_order_products.id','desc')
                    ->get();
            }
            
       
            $totalSaleAmount = 0;
            $html='';
            $saleReturnAmount=0;
            $vendorPayableAmount=0;
            $vendorReturnAmount=0;
            $profit=0;
            $totalSaleReturnAmount=0;
            $totalVendorPayableAmount=0;
            $totalVendorReturnAmount=0;
            $totalAproximateAmount=0;
            $totalProfit=0;
            $vendorPayableHtml='';
            $key=1;
            $aproximateAmount=0;
            foreach($sales as  $sale){
                $saleReturnAmount = DB::table('sale_order_product_returns')->where('sale_order_product_id', $sale->id)->where('deleted','No')->sum('order_return_amount');
                $vendorPayableAmount = SaleOrderProduct::where('parent_id', $sale->id)->where('deleted','No')->sum('subtotal');
                
                $vendorPayable = SaleOrderProduct::where('parent_id', $sale->id)->where('deleted','No')->first();
                if($vendorPayable){
                    $vendorReturnAmount = DB::table('sale_order_product_returns')->where('sale_order_product_id', $vendorPayable->id)->where('deleted','No')->sum('order_return_amount');
                }else{
                    $vendorReturnAmount=0;
                }
                $aproximateAmount=0;
                if($vendorPayableAmount <= 0){
                    $profit= $sale->subtotal + $vendorReturnAmount - $saleReturnAmount -  $sale->approximate_vendor_payable_amount ;
                    $aproximateAmount=$sale->approximate_vendor_payable_amount;
                }elseif($vendorPayableAmount > 0){
                    $profit= $sale->subtotal + $vendorReturnAmount - $saleReturnAmount - $vendorPayableAmount ;
                    $aproximateAmount='<del class="text-danger">'.$sale->approximate_vendor_payable_amount.'</del>';
                }
                
                $html.='<tr>
                            <td>'.$key++.'</td>
                            <td><b>Order No: </b><a href="#" onclick="completeInvoice(' . $sale->saleId . ')">'.$sale->sale_no.'</a><br><b>Date: </b>'.$sale->date.'</td>
                            <td><b>Name: </b>'. $sale->name .'<br><b>Contact: </b>'.$sale->contact.'</td>
                            <td>'. $sale->productName .' - '.$sale->productCode.'</td>
                            <td class="text-right">'. $sale->subtotal .'</td>
                            <td class="text-right">'. $saleReturnAmount .'</td>
                            <td class="text-right">'. $aproximateAmount .'</td>
                            <td class="text-right">'. $vendorPayableAmount .'</td>
                            <td class="text-right">'.$vendorReturnAmount.'</td>
                            <td class="text-right">'.$profit.'</td>
                        </tr>';
                $totalSaleAmount += $sale->subtotal;
                $totalSaleReturnAmount += $saleReturnAmount;
                $totalAproximateAmount += $sale->approximate_vendor_payable_amount;
                $totalVendorPayableAmount += $vendorPayableAmount;
                $totalVendorReturnAmount += $vendorReturnAmount;
                $totalProfit += $profit;
            } 
                $html.='<tr class="txt-right">
                            <td colspan="4" ><strong>Total:</strong></td>
                            <td class="text-right"><strong> '. number_format($totalSaleAmount) .' </strong></td>
                            <td class="text-right"><strong> '. number_format($totalSaleReturnAmount) .' </strong></td>
                            <td class="text-right"><strong> '. number_format($totalAproximateAmount) .' </strong></td>
                            <td class="text-right"><strong> '. number_format($totalVendorPayableAmount) .' </strong></td>
                            <td class="text-right"><strong> '. number_format($totalVendorReturnAmount) .' </strong></td>
                            <td class="text-right"><strong> '. number_format($totalProfit) .' </strong></td>
                            
                        </tr>';    
          
            $data=array('html'=>$html);
            return $data;
        
    }

    public function generateOrderWiseProfitPdf($applicant_id,$date_from,$date_to,$type){
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
        // $warehouse=DB::table('tbl_warehouse')->where('id',$loggedWarehouseId)->first();
        $applicantSale = ChartOfAccounts::where('slug', '=', 'sale-applicant-service')->where('sister_concern_id','=',$logged_sister_concern_id)->where('deleted', 'No')->first();
        $applicantSaleReturn = ChartOfAccounts::where('slug', '=', 'sales-ruturn')->where('sister_concern_id','=',$logged_sister_concern_id)->where('deleted', 'No')->first();
      
         if($applicant_id == 'all'){
                $sales = DB::table('sale_order_products')
                    ->leftjoin('products', 'sale_order_products.product_id', '=', 'products.id')
                    ->join('tbl_booking', 'sale_order_products.tbl_sale_orders_id', '=', 'tbl_booking.id')
                    ->join('parties', 'tbl_booking.customer_id', '=', 'parties.id')
                    ->select('sale_order_products.id','sale_order_products.approximate_vendor_payable_amount','sale_order_products.subtotal', 'tbl_booking.date', 'parties.name','parties.contact','parties.code as partyCode','tbl_booking.sale_no','tbl_booking.id as saleId','parties.party_type','products.name as productName','products.code as productCode')
                    ->where('parties.party_type', '=','Applicant')
                    ->whereBetween('tbl_booking.date', [$date_from, $date_to])
                    ->where('tbl_booking.sister_concern_id','=',$logged_sister_concern_id)
                    ->where('tbl_booking.deleted','=','No')
                    ->where('tbl_booking.status','=','Active')
                    ->where('sale_order_products.deleted','=','No')
                    ->where('sale_order_products.status','=','Active')
                    ->orderBy('sale_order_products.id','desc')
                    ->get();
                    
            }else{
                $sales = DB::table('sale_order_products')
                    ->leftjoin('products', 'sale_order_products.product_id', '=', 'products.id')
                    ->join('tbl_booking', 'sale_order_products.tbl_sale_orders_id', '=', 'tbl_booking.id')
                    ->join('parties', 'tbl_booking.customer_id', '=', 'parties.id')
                    ->select('sale_order_products.id','sale_order_products.approximate_vendor_payable_amount','sale_order_products.subtotal', 'tbl_booking.date', 'parties.name','parties.contact','parties.code as partyCode','tbl_booking.sale_no','tbl_booking.id as saleId','parties.party_type','products.name as productName','products.code as productCode')
                    ->where('parties.party_type', '=','Applicant')
                    ->where('tbl_booking.customer_id', '=',$applicant_id)
                    ->whereBetween('tbl_booking.date', [$date_from, $date_to])
                    ->where('tbl_booking.sister_concern_id','=',$logged_sister_concern_id)
                    ->where('tbl_booking.deleted','=','No')
                    ->where('tbl_booking.status','=','Active')
                    ->where('sale_order_products.deleted','=','No')
                    ->where('sale_order_products.status','=','Active')
                    ->orderBy('sale_order_products.id','desc')
                    ->get();
            }
            
        
            $totalSaleAmount = 0;
            $html='';
            $saleReturnAmount=0;
            $vendorPayableAmount=0;
            $vendorReturnAmount=0;
            $profit=0;
            $totalSaleReturnAmount=0;
            $totalVendorPayableAmount=0;
            $totalVendorReturnAmount=0;
            $totalAproximateAmount=0;
            $totalProfit=0;
            $vendorPayableHtml='';
            $key=1;
            foreach($sales as  $sale){
                $saleReturnAmount = DB::table('sale_order_product_returns')->where('sale_order_product_id', $sale->id)->where('deleted','No')->sum('order_return_amount');
                $vendorPayableAmount = SaleOrderProduct::where('parent_id', $sale->id)->where('deleted','No')->sum('subtotal');
                
                $vendorPayable = SaleOrderProduct::where('parent_id', $sale->id)->where('deleted','No')->first();
                if($vendorPayable){
                    $vendorReturnAmount = DB::table('sale_order_product_returns')->where('sale_order_product_id', $vendorPayable->id)->where('deleted','No')->sum('order_return_amount');
                }else{
                    $vendorReturnAmount=0;
                }
                $aproximateAmount=0;
                if($vendorPayableAmount <= 0){
                    $profit= $sale->subtotal + $vendorReturnAmount - $saleReturnAmount -  $sale->approximate_vendor_payable_amount ;
                    $aproximateAmount=number_format($sale->approximate_vendor_payable_amount);
                }elseif($vendorPayableAmount > 0){
                    $profit= $sale->subtotal + $vendorReturnAmount - $saleReturnAmount - $vendorPayableAmount ;
                    $aproximateAmount='<del class="text-danger">'.number_format($sale->approximate_vendor_payable_amount).'</del>';
                }
                
                $html.='<tr>
                            <td>'.$key++.'</td>
                            <td><b>Order No: </b>'.$sale->sale_no.'<br><b>Date: </b>'.$sale->date.'</td>
                            <td>'. $sale->name .'<br>'.$sale->contact.'</td>
                            <td>'. $sale->productName .' - '.$sale->productCode.'</td>
                            <td class="text-right">'. number_format($sale->subtotal) .'</td>
                            <td class="text-right">'. number_format($saleReturnAmount) .'</td>
                            <td class="text-right">'. $aproximateAmount .'</td>
                            <td class="text-right">'. number_format($vendorPayableAmount) .'</td>
                            <td class="text-right">'.number_format($vendorReturnAmount).'</td>
                            <td class="text-right">'.number_format($profit).'</td>
                        </tr>';
                $totalSaleAmount += $sale->subtotal;
                $totalSaleReturnAmount += $saleReturnAmount;
                $totalAproximateAmount += $sale->approximate_vendor_payable_amount;
                $totalVendorPayableAmount += $vendorPayableAmount;
                $totalVendorReturnAmount += $vendorReturnAmount;
                $totalProfit += $profit;
            } 
                $html.='<tr class="txt-right">
                            <td colspan="4" ><strong>Total:</strong></td>
                            <td class="text-right"><strong> '. number_format($totalSaleAmount) .' </strong></td>
                            <td class="text-right"><strong> '. number_format($totalSaleReturnAmount) .' </strong></td>
                            <td class="text-right"><strong> '. number_format($totalAproximateAmount) .' </strong></td>
                            <td class="text-right"><strong> '. number_format($totalVendorPayableAmount) .' </strong></td>
                            <td class="text-right"><strong> '. number_format($totalVendorReturnAmount) .' </strong></td>
                            <td class="text-right"><strong> '. number_format($totalProfit) .' </strong></td>
                        </tr>';    
          
           $pdf = PDF::loadView('admin.reports.applicantWiseProfitPdf',[
                                                                    'date_from' => $date_from,
                                                                    'date_to' => $date_to,
                                                                    'html'=>$html,
                                                                    'type'=>$type
                                                                    // 'warehouse'=>$warehouse
                                                                ])->setPaper("legal","landscape");
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();
            $canvas = $dom_pdf->get_canvas();
            $canvas->page_text(930 , 587, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
            return $pdf->stream('Profit-and-loss-report('.$date_from.'-'.$date_to.').pdf', array("Attachment" => false));
            
    }

    
   



}
