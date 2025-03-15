<html>
<head>
    <title>Sale Return Invoice</title>
        <link href="{{asset('backend/dist/css/report.style.css')}}" rel="stylesheet">
        
 </head>

    <body>
        <!-- Content Wrapper. Contains page content -->
        <header>
        <!-- Content Header (Page header) -->

        <div><img src="{{'upload/images/KH-report-header.jpg'}}" class="reportLogo"></div>
       <!--  <div class="supAddressFont"> {!!Session::get("companySettings")[0]["report_header"]!!}</div> -->
         <div><img src="{{'upload/images/'.Session::get('companySettings')[0]['watermark']}}" class="reportWatermark"></div> 
        </header>


        <footer>
        
    </footer>
    <main class="waterMark">
        <!-- Content Wrapper. Contains page content -->
        <div>
            <div style="text-align: center;">
                <div class="citiestd13">Sale Return Invoice 
                    
                </div>
                <table cellspacing="0" cellpadding="3">
                    <tr>
                        <td width="60%" class="supAddress">
                            @foreach($invoice as $user)
                            <div><strong>Name : </strong>{{$user->customer_name. ' - '. $user->code}}</div>
                            <div><strong>Phone: </strong>{{$user->contact}}</div>
                            <div><strong>Address: </strong>{{$user->address}}</div>
                            @break
                            @endforeach
                        </td>
                        <td width="40%" class="supAddress">
                            @foreach($invoice as $info)
                            <div><strong id="invoiceNo">Invoice: #{{$info->sale_no}}</strong></div>
                            <div><strong>Sale Date: </strong> {{$info->sale_date}}</div>
                            <div><strong>Return Date: </strong> {{$info->sale_return_date}}</div>
                            <div><strong>Entry By: </strong> {{$info->entryBy}}</div>
                            @break
                            @endforeach
                        </td>
                    </tr>
                </table>
                <table border="1" class="invoice-info" cellspacing="0" cellpadding="3">
                    <thead>
                        <tr>
                            <th class="textCenter">SL</th>
                            <th class="textLedft">Product Name</th>
                            <th class="textCenter">Qty</th>
                            <th class="textCenter">Unit Price</th>
                            <th class="textRight">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $i = 1;
                        @endphp
                        @foreach($invoice as $products)
                        @php
                        $grand_total = $products->grand_total;
                        @endphp
                        <tr>
                            <td class="textCenter">{{$i++}}</td>
                            <td class="citiestd15">{{$products->name.' - '.$products->productCode}}</td>
                            <td class="text-center">{{$products->return_qty}}</td>
                            <td class="text-center">{{$products->unit_price}}</td>
                            <td class="textRight"> {{$products->total_price}}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-center">Total </td>
                            <td class="textRight">{{ Session::get('companySettings')[0]["currency"].' '.numberFormat($grand_total) }}</td>
                        </tr>
                    </tbody>
                </table><br><br>
                <div>Net payable amount: {{ Session::get('companySettings')[0]["currency"].' '.$grand_total }}   [{{ numberToWord($grand_total) }} take only]</div>
            </div>
        </div>
        </div>
        </div>
        </div>
        </section>
        </div>
        <br>
        <div class="signatures">
           
            <div class="row ">
                <div class="column">
                 
                    <br>-----------------------<br>                 
                    Customer Signature
                </div>
                <div class="columnCenter"> 
                    {{ Session::get('userName') }}
                    <br>-----------------------<br>
                     Created By                        
                </div>
                <div class="columnRight">
                  
                    <br>-----------------------<br>                       
                    Authorized Signature
                </div>                 
            </div><br>
            <hr />
            <div class="supAddressFont"><br><br>{!!Session::get('companySettings')[0]['report_footer']!!}</div>
        </div>
    </main>
</body>

</html>