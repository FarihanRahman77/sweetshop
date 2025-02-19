<html>
<head>
     
    <title>Service/Sale Summary</title>
    <link href="{{asset('backend/dist/css/report.style.css')}}" rel="stylesheet">
</head>
<body>
<!-- Content Wrapper. Contains page content -->
    <header>
        <div class="">
            <div class="">
                <img src="{{ 'upload/images/' . Session::get('companySettings')[0]['logo'] }}" width='220' height='115'>
                <div class="supAddressFont">
                    {!! Session::get('companySettings')[0]['report_header'] !!}
                </div>
            </div>
        </div>
    </header>
    <footer>
        <hr/>
        <div style="font-size:10px;">{!!Session::get('companySettings')[0]['report_footer']!!}</div>
    </footer>

    
<main>
        
<!-- Content Wrapper. Contains page content -->
<div>
    <div style="text-align: center;">
        <div class="citiestd13">Service/Sale Summary</div>
        <table  cellspacing="0" cellpadding="3">
            <tr>
                <td width="60%" class="supAddress">
                  
                </td>
                <td width="40%" class="supAddress">
                   
                </td>
            </tr>
        </table>   
        <table border="1" class="invoice-info" cellspacing="0" cellpadding="3">
            <thead>
                <tr class="bg-light">
                    <td width="5%" class="text-center">Sl</td>
                    <td width="10%" class="text-center">Date</td>
                    <td width="10%" class="text-center">Order No</td>
                    <td width="15%" class="text-center">Party Info</td>
                    <td width="10%" class="text-center">Type</td>
                    <td width="10%" class="textRight">Total Amount</td>
                    <td width="10%" class="textRight">Final Sale Amount</td>
                    <td width="10%" class="textRight">Balance</td>
                    
                </tr>
            </thead>
            <tbody>
                @php 
                    $i=1;
                    $serviceGrandTotal=0;
                    $serviceFinalSale=0;
                    $serviceBalance=0;
                    $walkinGrandTotal=0;
                    $walkinPurchaseAmount=0;
                    $walkinBalance=0;
                @endphp
               @foreach($orders as $order)
               <tr>
                    <td class="text-center supAddressFont">{{$i++}}</td>
                    <td class="text-center supAddressFont">{{$order->completed_date}}</td>
                    <td class="text-center supAddressFont">{{$order->sale_no}}</td>
                    <td class="supAddressFont">Name: {{$order->partyName}}<br>Contact: {{$order->contact}}</td>
                    <td class="text-center supAddressFont">Service</td>
                    <td class="textRight supAddressFont">{{numberFormat($order->grand_total)}}</td>
                    <td class="textRight supAddressFont">{{numberFormat($order->final_sale_amount)}}</td>
                    <td class="textRight supAddressFont">{{numberFormat(($order->grand_total - $order->final_sale_amount))}}</td>
                </tr>
                @php 
                    $serviceGrandTotal +=$order->grand_total;
                    $serviceFinalSale +=$order->final_sale_amount;
                    $serviceBalance +=$order->grand_total - $order->final_sale_amount;
                @endphp
               @endforeach
               
               @foreach($sales as $sale)
                    <tr>
                        <td class="text-center supAddressFont">{{$i++}}</td>
                        <td class="text-center supAddressFont">{{$sale->date}}</td>
                        <td class="text-center supAddressFont">{{$sale->sale_no}}</td>
                        <td class="supAddressFont">Name: {{$sale->partyName}}<br>Contact: {{$sale->contact}}</td>
                        <td class="text-center supAddressFont">Walkin Sale</td>
                        <td class="textRight supAddressFont">{{numberFormat($sale->grand_total)}}</td>
                        <td class="textRight supAddressFont">{{numberFormat($sale->total_purchase_amount)}}</td>
                        <td class="textRight supAddressFont">{{numberFormat($sale->grand_total - $sale->total_purchase_amount)}}</td>
                    </tr>
                    @php
                        $walkinGrandTotal +=$sale->grand_total;
                        $walkinPurchaseAmount +=$sale->total_purchase_amount;
                        $walkinBalance +=$sale->grand_total - $sale->total_purchase_amount;
                    @endphp
                @endforeach
                <tr>
                    <td colspan="5" class="textRight">Total: </td>
                    <td class="textRight supAddressFont">{{numberFormat($serviceGrandTotal + $walkinGrandTotal)}}</td>
                    <td class="textRight supAddressFont">{{numberFormat($serviceFinalSale +$walkinPurchaseAmount)}}</td>
                    <td class="textRight supAddressFont">{{numberFormat($serviceBalance + $walkinBalance)}}</td>
                    
                </tr>
            </tbody>
        </table>
        <table border="0" class="invoice-info" cellspacing="0" cellpadding="3">
            <tbody>
                @php 
                    $expenseAmount=0;
                @endphp
                @foreach($allExpenses as $expense)
                @php
                $incomeAmounts = DB::table('tbl_acc_voucher_details')
                                ->join('tbl_acc_vouchers', 'tbl_acc_voucher_details.tbl_acc_voucher_id', '=', 'tbl_acc_vouchers.id')
                                ->select('tbl_acc_voucher_details.*', 'tbl_acc_vouchers.transaction_date', 'tbl_acc_vouchers.type')
                                ->whereBetween('tbl_acc_vouchers.transaction_date', [$date_from, $date_to])
                                ->where('tbl_acc_voucher_details.tbl_acc_coa_id', '=', $expense->id)
                                ->where('tbl_acc_vouchers.deleted', '=', 'No')
                                ->where('tbl_acc_vouchers.status', '=', 'Active')
                                ->get();
                $amountSum = 0;
                foreach ($incomeAmounts as $amount) {
                    $amountSum += $amount->credit;
                }
                @endphp
                <tr>
                    <td  width="5%" class="text-center"></td>
                    <td width="10%" class="text-center"></td>
                    <td width="10%" class="text-center"></td>
                    <td width="15%">{{$expense->name}}</td>
                    <td width="10%" class="text-center"></td>
                    <td width="10%" class="text-right"></td>
                    <td width="10%" class="textRight">{{numberFormat($amountSum)}}</td>
                    <td width="10%" class="text-right"></td>
                </tr>
                @php 
                    $expenseAmount+=$amountSum;
                @endphp
                @endforeach
                <tr>
                    <td colspan="6" class="textRight">Total Expense: </td>
                    <td class="textRight">{{numberFormat($expenseAmount)}}</td>
                    <td class="textRight"></td>
                </tr>
            </tbody>
        </table>
        <table border="1" class="invoice-info" cellspacing="0" cellpadding="3">
            <tbody>
                <tr>
                    <td class="textRight"> Sale Value: {{numberFormat($serviceGrandTotal + $walkinGrandTotal)}}</td>
                    <td class="textRight"> Product Value: ({{numberFormat($serviceFinalSale +$walkinPurchaseAmount)}})</td>
                    <td class="textRight"> Profit: {{numberFormat($serviceBalance + $walkinBalance)}}</td>
                    <td class="textRight"> Expense: ({{numberFormat($expenseAmount)}})</td>
                    <td class="textRight"> Net Profit: {{numberFormat($serviceBalance + $walkinBalance - $expenseAmount)}}</td>
                </tr>
            </tbody>
        </table>
        
    </div>
</div>



            </div>
            </div>
        </div>
    </section>
  </div><br><br>
        <div class="signatures">
            <div class="row " style="font-size:11px;">
                <div class="column">
                    <br>-----------------------<br>
                    Customer Signature
                </div>
                <div class="column">
                    {{ auth()->user()->name }}
                    <br>-----------------------<br>
                    Created By
                </div>
                <div class="column22">
                    <br>-----------------------<br>
                    Authorized Signature
                </div>
            </div>
            
        </div>
  
    </main>   
</body>
</html>