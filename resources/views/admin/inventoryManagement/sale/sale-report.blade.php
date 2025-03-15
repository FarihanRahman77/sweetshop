<html>
<head>
    <title> Sale Invoice </title>
    <<link href="{{asset('backend/dist/css/report.style.css')}}" rel="stylesheet">
</head>

<body>
    <!-- Content Wrapper. Contains page content -->
    <header>
        <!-- Content Header (Page header) -->

        <div><img src="{{'upload/images/KH-report-header.jpg'}}" class="reportLogo"></div>
       <!--  <div class="supAddressFont"> {!!Session::get("companySettings")[0]["report_header"]!!}</div> -->
         <div><img src="{{'upload/images/'.Session::get('companySettings')[0]['watermark']}}" class="reportWatermark"></div> 
    </header>


    <!-- <footer>
                
    </footer> -->
    <main class="waterMark">
        @if ($sale->deleted == 'No')
        <!-- Content Wrapper. Contains page content -->

        <div>
            <div style="text-align: center;">
                <div class="citiestd13">Sales Invoice
                    @if($sale->sales_type=='party_sale')
                    Party Sales
                    @elseif ($sale->sales_type=='walkin_sale')
                    WI Sale
                    @elseif ($sale->sales_type=='FS')
                    Final Sale
                    @endif
                </div>
                <table cellspacing="0" cellpadding="3">
                    <tr>
                        <td width="70%" class="supAddress">
                            @foreach ($invoice as $user)
                            <div><strong>Name : </strong>{{ $user->customerName . ' - ' . $user->code }}</div>
                            <div><strong>Phone: </strong>{{ $user->contact }}</div>
                            <div><strong>Address: </strong>{{ $user->address }}</div>
                            <div><strong>P.O NO : </strong>{{ $user->po_number }} | <strong>P.O Date :
                                </strong>{{ $user->po_date }}</div>
                            @break
                            @endforeach
                        </td>
                        <td width="30%" class="supAddress">
                            @foreach ($invoice as $info)
                            <div><strong id="invoiceNo">Invoice: #{{ $info->sale_no }}</strong></div>
                            <div><strong>Sale Date: </strong> {{ $info->date }}</div>
                            <div><strong>Entry By: </strong> {{ $info->entryBy }}</div>
                            @break
                            @endforeach
                        </td>
                    </tr>
                </table>
                <table border="1" class="invoice-info" cellspacing="0" cellpadding="3">
                    <thead>
                        <tr>
                            <th width="6%">SL</th>
                            <th>Product Name</th>
                            <th width="10%">Qty</th>
                            <th width="10%">Unit Price</th>
                            <th width="12%">Unit Discount</th>
                            <th width="10%">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $i = 1;
                        $totalAmount=0;
                        $totalQty=0;
                        @endphp
                        @foreach ($invoice as $products)
                        <tr>

                            <td class="text-center">{{ $i++ }}</td>
                            <td class="citiestd15">{{ $products->name}}
                                ({!!$products->specs!!})</td>
                            <td class="text-center">{{ $products->quantity.' '. $products->unitName }}</td>
                            <td class="textRight">{{ numberFormat($products->unit_price)}}</td>
                            <td class="textRight">{{ numberFormat($products->unit_discount) }}</td>
                            <td class="textRight"> {{ $products->subtotal }}</td>

                            @php
                            $totalQty += $products->quantity;
                            $totalAmount += $products->subtotal;
                            @endphp
                        </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td class="text-center"> Total =</td>
                            <td class="text-center">{{$totalQty}}</td>
                            <td></td>
                            <td></td>
                            <td class="textRight"> {{ numberFormat($totalAmount) }}</td>
                        </tr>
                    </tbody>
                </table>
                <!-- start table -->
                <table cellspacing="0" cellpadding="3">
                    <tr>
                        <td width="70%" class="supAddress">


                            <table width="100%">
                                <tr>
                                    <td width="30%" class="underAlignment"><b>Amount In Words :</b></td>
                                    <td colspan="2" width="70%" class="underAlignmentLeft">
                                        {{ numberToWord($sale->grand_total) }} taka only</td>
                                </tr>
                                <tr>
                                    <td width="30%" class="underAlignment"><b>Previous due :</b></td>
                                    <td width="20%" class="textRight underAlignmentLeft"> {{ $sale->previous_due }}</td>
                                    <td width="50%"></td>
                                </tr>
                                <tr>
                                    <td width="30%" class="underAlignment"><b>Current Bill :</b></td>
                                    <td width="20%" class="textRight underAlignmentLeft"> {{ $sale->grand_total }}</td>
                                    <td width="50%"></td>
                                </tr>
                                <tr>
                                    <td width="30%" class="underAlignment"><b>Paid Amount :</b></td>
                                    <td width="20%" class="textRight underAlignmentLeft"> {{ $sale->current_payment }}
                                    </td>
                                    <td width="50%"></td>
                                </tr>
                                <tr>
                                    <td width="30%" class="underAlignment"><b>Current due :</b></td>
                                    <td width="20%" class="textRight underAlignmentLeft"> {{ $sale->current_dues }}</td>
                                    <td width="50%"></td>
                                </tr>

                            </table>

                        </td>
                        <td width="20%" class="supAddress" style="text-align:right;">

                            @php
                            $totalCost = $sale->total_amount + $sale->carrying_cost+ $sale->vat+ $sale->ait;
                            $payment = $sale->current_payment + $sale->discount;
                            $dueForThisTransection = $totalCost - $payment;
                            @endphp
                            <div><strong>Total Amount: </strong></div>
                            <div><strong>Discount: </strong></div>
                            <div><strong>Transport: </strong></div>
                            <div><strong>Vat: </strong></div>
                            <div><strong>Ait: </strong></div>
                            <div><strong>Net Payable (Round): </strong></div>

                        </td>
                        <td width="10%" class="supAddress textRight">

                            @php
                            $totalCost = $sale->total_amount + $sale->carrying_cost+ $sale->vat+ $sale->ait;
                            $payment = $sale->current_payment + $sale->discount;
                            $dueForThisTransection = $totalCost - $payment;
                            $saledueForEmi = $sale->current_dues;
                            @endphp
                            <div>{{ numberFormat($totalAmount) }}</div>
                            <div>{{ $sale->discount }}</div>
                            <div>{{ $sale->carrying_cost }}</div>
                            <div>{{ $sale->vat }}</div>
                            <div>{{ $sale->ait }}</div>
                            <div>{{ $sale->grand_total }}</div>

                        </td>
                    </tr>
                </table>
                <!-- End Table -->
            </div>
        </div>
        @else
        <div class="textCenter">Invoice Deleted Please check again !</div>
        @endif<br><br>
        <div class="signatures">

            <div class="row">
                <div class="column">

                    <br>-----------------------<br>
                    Customer Signature
                </div>
                <div class="columnCenter">
                    {{ Session::get('userName') }}
                    <br>-----------------<br>
                    Created By
                </div>
                <div class="columnRight">

                    <br>-----------------------<br>
                    Authorized Signature
                </div>
            </div><br>

            <div class="supAddressFont"><br><br>{!!Session::get('companySettings')[0]['report_footer']!!}</div>


        </div>
    </main>


</body>

</html>