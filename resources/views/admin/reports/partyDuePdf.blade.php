<html>
<head>
    
    <!-- <link href="{{asset('backend/dist/css/report.style.css')}}" rel="stylesheet"> -->
    <style>
        #footer {
            position: fixed;
            right: 0px;
            bottom: 10px;
            text-align: center;
            border-top: 1px solid black;
        }

        #footer .page:after {
            content: counter(1, decimal);
        }

        @page {
            margin: 0.2cm 0.2cm 0.2cm 0.2cm;
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 2cm;
            margin-left: 0.5cm;
            margin-right: 0.5cm;
            margin-bottom: 2.1cm;
        }

        /** Define the header rules **/
        header {
            position: fixed;
            top: .5cm;
            left: 0cm;
            right: 0cm;
            margin-left:0.5cm;
            margin-top:-0.5cm;
        }
        .header2 {
            position: fixed;
            top: 15cm;
            left: 0cm;
            right: 0cm;
            margin-left:0.5cm;
            margin-top:-0.5cm;
        }
        .main2{
            position: fixed;
            top: 17cm;
            left: 0cm;
            right: 0cm;
            margin-left:0.5cm;
            margin-top:-0.5cm;
        }
        .customer-info{
            margin-top:0.5cm;
        }

        img {}

        /** Define the footer rules **/
        footer{
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 1.8cm;
            text-align: center;
        }

        .column-middle {
            float: left;
            width: 50.33%;
            padding: 1% 0% 0% 2%;
            height: 300px;
        }
        .column-left {
            float: left;
            width: 15%;
            padding: 1% 0% 0% 2%;
            height: 300px;
        }
        .column-right {
            float: right;
            width: 20%;
            padding: 0% 0% 0% 2%;
            height: 300px; 
        }
        .column11 {
            text-align: left;
            width: 100%;
            height: 33px;
        }
        .column22 {
            float: right;
            width: 15%;
            height: 33px;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        .column {
            float: left;
            width: 33.33%;
           
        }

        .signatures {
            padding-bottom: -500px;
        }

        .citiestd13 {
            border: 1px solid gray;
            color: black;
            text-align: center;
            font-size: 11px;
            padding: 3px;
        }

        .supAddressFont {
            font-size: 11px;
        }

        .supAddressFont h2 {
            margin: 0% 0% 0% 0%;
        }

        .supAddressFontEmi {
            font-size: 13px;
        }

        .underAlignment {
            text-align: right;
            font-size: 10px;
        }

        .underAlignmentLeft {
            text-align: left;
            font-size: 10px;
        }

        .textLeft {
            text-align: left;
            font-size: 11px;
        }

        .textRight {
            text-align: right;
        }

        .textCenter {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 0.8em;
            min-width: 400px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        }

        /* .td-text{
                text-align:right;
                padding-right:35px ;
            } */
        thead tr {
            background-color: #ffff;
            color: black;
            text-align: left;
        }

        /* th, td {
                padding: 12px 15px;
            } */
        .overline {
            text-decoration: overline;
        }

        .emi-table {
            width: 80%;
            padding-left: 10%;
        }

        .emi-table-title {
            padding-left: 10px;
            margin-bottom: -5px;
            padding-left: 11%;
        }

        .text-center {
            text-align: center;
        }

        .spaces {
            color: white;
        }
        .column1{
            text-align: center;
            width: 35%;
            padding: 1% 0% 0% 2%;
            height: 300px; /* Should be removed. Only for demonstration */
        }
        .column2{
            float: left;
            width: 33.33%;
            padding: 1% 0% 0% 2%;
            height: 300px; /* Should be removed. Only for demonstration */
        }
        .column3 {
            float: right;
            width: 30%;
            padding: 0% 0% 0% 2%;
            height: 300px; /* Should be removed. Only for demonstration */
            }
            /* Clear floats after the columns */
            .row2:after {
            content: "";
            display: table;
            clear: both;
            }
        .pagenum:before {
                content: counter(page);
                margin-left:90%;
        }

        /*img {
              margin-top: 25px
            }*/
    </style>
    <title>Party Dues Report</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif;font-size: 13px;">
<!-- Content Wrapper. Contains page content -->
    <header>
        <div class="row2">
        <div class="text-center">
                <img src="{{'upload/images/'.Session::get('companySettings')[0]['logo']}}" width='180' height='60'>
                <div class="supAddressFont">
                    {!!Session::get("companySettings")[0]["report_header"]!!}
                </div>
            </div>
        </div>
    </header>
    <footer>
        <div class="signatures">
            <div class="row " style="font-size:10px;">
                <div class="column-left">
                    <br>--------------------------<br>
                    Customer Signature
                </div>
                <div class="column-middle">
                    {{ auth()->user()->name }}
                    <br>----------------------------<br>
                    Created By
                </div>
                <div class="column-right">
                    <br>-----------------------------<br>
                    Authorized Signature
                </div>
            </div>
        </div>
        <hr>
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
                @foreach($partyDueData as $data) 
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