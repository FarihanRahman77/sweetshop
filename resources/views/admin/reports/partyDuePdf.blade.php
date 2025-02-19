<html>
<head>
     <style>
            #footer { position: fixed; right: 0px; bottom: 20px; text-align: center;border-top: 1px solid black;}
            #footer .page:after { content: counter(1, decimal); }
            @page {margin: 0.2cm 0.2cm 0.2cm 0.2cm;}

            /** Define now the real margins of every page in the PDF **/
            body { margin-top: 3.2cm;margin-left: 0.5cm;margin-right: 1cm;margin-bottom: 1cm;font-family: "Arial Narrow";font-size: 12pt;}

            /** Define the header rules **/
            header {position: fixed;top: .5cm;left: 0cm;right: 0cm;text-align:center;font-family: "Arial Narrow";font-size: 12pt;}
            

            /** Define the footer rules **/
            footer {position: fixed; bottom: 0.8cm; left: 0cm; right: 0cm;height: 0.5cm;text-align:center;font-family: "Arial Narrow";font-size: 10pt;}
            .column {float: left;width: 33.33%;height:30px;}
            
            

            /* Clear floats after the columns */
            .row:after {content: "";display: table;clear: both;}
            .signatures{padding-bottom:-500px;font-family: "Arial Narrow";font-size: 10pt;}
            .citiestd13 {border:1px solid gray;color: black;text-align: center;font-size: 13px;padding: 5px;}
            .supAddressFont {font-size:11px;}
            .underAlignment {text-align:right;font-size:13px;}
            .underAlignmentLeft {text-align:left;font-size:13px;}
            table {width:100%; border-collapse: collapse;margin-top: 10px;font-size: 0.8em; min-width: 400px;box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);}
            /* .td-text{
                text-align:right;
                padding-right:35px ;
            } */
            thead tr {background-color: #ffff;color: black;text-align: left;}
            /* th, td {
                padding: 12px 15px;
            } */
            .overline {text-decoration: overline;}
            .emi-table {width:80%;padding-left:10%;}
            .emi-table-title {padding-left:10px;margin-bottom:-5px;padding-left:11%;}

            .text-center{text-align:center;}
            .column {
            float: left;
            width: 45%;
            height: 33px;
        }
        .column11 {
            text-align: center;
            width: 30%;
            height: 33px;
        }
        .column22 {
            float: right;
            width: 15%;
            height: 33px;
        }
            .column3 {
                float: left;
                padding: 1% 0% 0% 2%;
                height: 300px; /* Should be removed. Only for demonstration */
                }
            .column2 {
                float: right;
                width: 60%;
                padding: 0% 0% 0% 2%;
                //height: 300px; /* Should be removed. Only for demonstration */
                }
                /* Clear floats after the columns */

            .row2:after {
                content: "";
                display: table;
                clear: both;
                }

            .textLeft {
                text-align: left;
                font-size: 14px;
            }
            .text-right{
                text-align:right;
            }
        </style>
    <title>Party Due Report ({{ $party_type }})</title>
</head>
<body>
<!-- Content Wrapper. Contains page content -->
    <header>
        <div class="row2">
            <div class="column3">
                <img src="{{'upload/images/'.Session::get('companySettings')[0]['logo']}}" width='250' height='90'>
                <div class="supAddressFont">
                    {!!Session::get("companySettings")[0]["report_header"]!!}
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
        <div class="citiestd13">{{ $party_type }} Due Report : <b>( {{$date_from}} - {{$date_to}} ) </b> </div>
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
                    <th width="5%" class="text-center">Sl</th>
                    <th width="50%" class="text-center">Party Info</th>
                    <th width="15%" class="text-right">{{$payableOrReceiveable}}</th>
                    <th width="15%" class="text-right">{{$paymentOrReceived}}</th>
                    <th width="15%" class="text-right">Discount</th>
                    <th width="15%" class="text-right">Adjustment/Return</th>
                    <th width="15%" class="text-right">Due</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $i=1;
                    $totalPayableOrReceiveableAmount=0;
                    $totalPaymentOrReceivedAmount=0;
                    $totalDue=0;
                    $totaldiscount=0;
                    $totaladjustment=0;
                @endphp
                @foreach($partyDueData as $data) {
                <tr>
                    <td class="text-center">{{$i++}}</td>
                    <td >{{$data['party']->name}} - {{$data['party']->contact}} - ({{$data['party']->code}})</td>
                    <td style="text-align:right;">{{$data['payableOrReceiveableAmount']}}</td>
                    <td style="text-align:right;">{{$data['paymentOrReceivedAmount']}}</td>
                    <td style="text-align:right;">{{$data['discount']}}</td>
                    <td style="text-align:right;">{{$data['adjustment']}}</td>
                    <td style="text-align:right;">{{$data['due']}}</td>
                </tr>
                @php 
                    $totalPayableOrReceiveableAmount+=$data['payableOrReceiveableAmount'];
                    $totalPaymentOrReceivedAmount+=$data['paymentOrReceivedAmount'];
                    $totaldiscount+=$data['discount'];
                    $totaladjustment+=$data['adjustment'];
                    $totalDue+=$data['due'];
                @endphp
                @endforeach
                <tr>
                    <td colspan="2" class="text-right"><b>Total: </b></td>
                    <td class="text-right"><b>{{$totalPayableOrReceiveableAmount}}</b></td>
                    <td class="text-right"><b>{{$totalPaymentOrReceivedAmount}}</b></td>
                    <td class="text-right"><b>{{$totaldiscount}}</b></td>
                    <td class="text-right"><b>{{$totaladjustment}}</b></td>
                    <td class="text-right"><b>{{$totalDue}}</b></td>
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