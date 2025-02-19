<html>

<head>
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
            margin-top: 3cm;
            margin-left: 0.5cm;
            margin-right: 0.5cm;
            margin-bottom: 1cm;
        }

        /** Define the header rules **/
        header {
            position: fixed;
            top: .5cm;
            left: 0cm;
            right: 0cm;
            text-align: center;
        }

        img {}

        /** Define the footer rules **/
        footer {
            position: fixed;
            bottom: 2cm;
            left: 0cm;
            right: 0cm;
            height: 1.8cm;
            text-align: center;
        }


        .column {
            float: left;
            width: 33.33%;
            height: 30px;
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

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
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
            font-size: 12px;
        }

        .underAlignmentLeft {
            text-align: left;
            font-size: 12px;
        }

        .underFontSize {
            font-size: 12px;
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

        /*img {
              margin-top: 25px
            }*/
    </style>
    <title>Order Invoice</title>
</head>

<body>
    <!-- Content Wrapper. Contains page content -->
    <header>

        <img src="{{ 'upload/images/' . Session::get('companySettings')[0]['logo'] }}" width='200' height='75'>
        <div class="d-flex">
           <small>
             Address: {{ Session::get('companySettings')[0]['address'] }}.
            Contact: {{ Session::get('companySettings')[0]['phone'] }}
        </small>
        </div>
        <div class="supAddressFont">
            {!! Session::get('companySettings')[0]['report_header'] !!} 
        </div>
    </header>
    <footer>


  <div class="signatures">

    <div class="row " style="font-size:10px;">
        <div class="column">
       
            <br>-----------------------<br>
            Customer Signature
        </div>
        <div class="column">
            {{ auth()->user()->name }}
            <br>-----------------------<br>
            Created By
        </div>
        <div class="column">
            
            <br>-----------------------<br>
            Authorized Signature
        </div>
    </div><br><br>
    <hr />
    <div style="font-size:10px;">{!! Session::get('companySettings')[0]['report_footer'] !!}</div>


</div>

</footer>
<main>
   
        @if (count($orderinvoicedata) >0)
            <!-- Content Wrapper. Contains page content -->
            <div>
                <div style="text-align: center;">

                    <table cellspacing="0" cellpadding="3">
                        <tr>
                            <td width="70%" class="supAddress">
                                @foreach ($orderinvoicedata as $user)
                                    <div><strong>Customer Name : </strong>{{ $user->party_name}}</div>
                                    <div><strong>Contact: </strong>{{ $user->party_contact }}</div>
                                    <div><strong>Table Name: </strong>{{ $user->table_name }}</div>
                        
                                @break
                            @endforeach
                        </td>
                        <td width="30%" class="supAddress">
                            @foreach ($orderinvoicedata as $info)
                          
                                <div><strong>order Date: </strong> {{ $info->order_date }}</div>
                                <div><strong>Entry By: </strong>  {{ auth()->user()->name }}</div>
                            @break
                        @endforeach
                    </td>
                </tr>
            </table>
            <table border="1" class="invoice-info underFontSize" cellspacing="0" cellpadding="5" style="width: 100%; border-collapse: collapse; text-align: center;">
    <thead>
        <tr>
            <th style="border: 1px solid #000; padding: 8px;">SL</th>
            <th style="border: 1px solid #000; padding: 8px;">Menu Name</th>
            <th style="border: 1px solid #000; padding: 8px;">Menu Quantity</th>
            <th style="border: 1px solid #000; padding: 8px;">Unit Price</th>
            <th style="border: 1px solid #000; padding: 8px;">Total</th>
        </tr>
    </thead>
    <tbody>
        @php
            $i = 1;
            $totalAmount = 0;
            $totalQty = 0;
            $paidAmount = 0;
        @endphp
        @foreach ($orderinvoicedata as $info)
        @php
            $totalAmount = $info->order_total;
            $paidAmount = $info->paid_amount;
            $DiscountAmount = $info->grand_discount;
            $UnittotalAmount = $info->unit_total_price;
            $Vat = $info->vat;
            $DUE = $info->due;
            $UNITPrice = $info->unit_price;
        @endphp
        <tr>
            <td style="border: 1px solid #000; padding: 8px;">{{ $i++ }}</td>
            <td style="border: 1px solid #000; padding: 8px;">{{ $info->menu_name }}</td>
            <td style="border: 1px solid #000; padding: 8px;">{{ $info->menu_quantity }}</td>
            <td style="border: 1px solid #000; padding: 8px;">{{  $UNITPrice}}</td>
            <td style="border: 1px solid #000; padding: 8px;">{{  $UnittotalAmount }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Displaying VAT, Discount, and Total Amount outside of the table and aligned to the right -->
<table cellspacing="0" cellpadding="3">
    <tr>
        <td width="70%" class="supAddress">
            <table width="100%">
                <tr>
                    <td width="30%" class="underAlignment"><b>Amount In Words:</b></td>
                    <td width="70%" class="underAlignmentLeft">
                        {{ ucfirst(numberToWord($totalAmount)) }} taka only
                    </td>
                </tr>
                <tr>
                    <td width="30%" class="underAlignment"><b>Paid Amount:</b></td>
                    <td width="70%" class="underAlignmentLeft">{{ $paidAmount }}</td>
                </tr>
                <tr>
                    <td width="30%" class="underAlignment"><b>Due Amount:</b></td>
                    <td width="70%" class="underAlignmentLeft">{{  $DUE }}</td>
                </tr>
            </table>
        </td>
        <td width="20%" class="supAddress" style="text-align:right;">
            <div class="leftAlign"><strong>Vat:</strong></div>
            <div class="leftAlign"><strong>Discount:</strong></div>
            <div class="leftAlign"><strong>Total Amount:</strong></div>
        </td>
        <td width="10%" class="supAddress">
            <div class="leftAlign">{{ numberFormat($Vat) }}</div>
            <div class="leftAlign">{{ numberFormat($DiscountAmount) }}</div>
            <div class="leftAlign">{{ numberFormat($totalAmount) }}</div>
        </td>
    </tr>
</table>
     

</div>
</div>
@else
<div class="textCenter">No data !</div>
@endif
<br>


</main>


</body>

</html>
