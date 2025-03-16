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
        margin-top: 2cm;
        margin-left: 0.5cm;
        margin-right: 0.5cm;
        margin-bottom: 0.2cm;
    }

    /** Define the header rules **/
    header {
        position: fixed;
        top: .5cm;
        left: 0cm;
        right: 0.3cm;
        margin-left: 0.5cm;
        margin-top: -0.5cm;
    }

    .header2 {
        position: fixed;
        top: 15cm;
        left: 0cm;
        right: 0cm;
        margin-left: 0.5cm;
        margin-top: -0.5cm;
    }

    .main2 {
        position: fixed;
        top: 17cm;
        left: 0cm;
        right: 0cm;
        margin-left: 0.5cm;
        margin-top: -0.5cm;
    }

    .customer-info {
        margin-top: 0.5cm;
    }

    img {}

    /** Define the footer rules **/
    footer {
        position: fixed;
        bottom: 0.5cm;
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

    .column-left {
        float: left;
        width: 70%;
        height: 140px;
    }

    .column-right {
        float: right;
        width: 40%;

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

    /* Clear floats after the columns */
    .row:after {
        content: "";
        display: table;
        clear: both;
    }

    .signatures {
        
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

    .column1 {
        float: left;
        width: 35%;
        padding: 1% 0% 0% 2%;
        height: 300px;
        /* Should be removed. Only for demonstration */
    }

    .column2 {
        float: left;
        width: 33.33%;
        padding: 1% 0% 0% 2%;
        height: 300px;
        /* Should be removed. Only for demonstration */
    }

    .column3 {
        float: right;
        width: 20%;
        padding: 0% 0% 0% 2%;
        height: 300px;
        /* Should be removed. Only for demonstration */
    }

    /* Clear floats after the columns */
    .row2:after {
        content: "";
        display: table;
        clear: both;
    }

    .pagenum:before {
        content: counter(page);
        margin-left: 90%;
    }

    /*img {
              margin-top: 25px
            }*/
    </style>
    <title>Bill Invoice</title>
</head>

<body style="font-family: Arial, Helvetica, sans-serif;font-size: 13px;">
    <!-- Content Wrapper. Contains page content -->
    <header>
        <div class="row2">
            <div class="column1">
                <img src="{{'upload/images/'.Session::get('companySettings')[0]['logo']}}" width='150' height='60'>
                <div class="supAddressFont">
                    {!!Session::get("companySettings")[0]["report_header"]!!}
                </div>
            </div>
            <div class="column3">
                <div class="textLeft"><strong>Vendor Name:</strong> {{ $party->name . ' - ' . $party->code }}</div>
                <div class="textLeft"><strong>Phone: </strong> {{ $party->contact }}</div>
                <div class="textLeft"><strong>Address: </strong> {{ $party->address }}</div>
            </div>
        </div>
    </header>


    <footer>
        <div class="signatures">
            <div class="row " style="font-size:10px;">
                <div class="column">
                    
                    <br>-----------------------<br>
                    Vendor Signature
                </div>
                <div class="column">
                    {{Session::get('userName')}}
                    <br>-----------------------<br>
                    Created By
                </div>
                <div class="column">
                    
                    <br>-----------------------<br>
                    Authorized Signature
                </div>
            </div>
            <div style="font-size:10px;">{!!Session::get('companySettings')[0]['report_footer']!!}</div>
        </div>
    </footer>
    <main>

        <!-- Content Wrapper. Contains page content -->
        <div>
            <div style="text-align: center;">
                <div class="citiestd13">Bill Invoice </div>
                <table border="1" class="invoice-info" cellspacing="0" cellpadding="3">
                    <thead>
                        <tr>
                            <th width="10%">SL</th>
                            <th width="40%">Account</th>
                            <th width="40%">Particulars</th>
                            <th width="15%">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $i = 1;
                        @endphp
                        @foreach($details as $detail)
                        <tr>
                            <td class="text-center">{{$i++}}</td>
                            <td>{{$detail->coa_name}}</td>
                            <td> {{$detail->particulars}}</td>
                            <td class="text-center" style="text-align:right;">{{numberFormat($detail->amount)}} {!!
                                Session::get('companySettings')[0]["currency"]!!}</td>
                        </tr>
                        @endforeach

                        <tr>
                            <td colspan="3" style="text-align:right;"> Total = </td>
                            <td style="text-align:right;"> {{numberFormat($bills->amount)}} {!!
                                Session::get('companySettings')[0]["currency"] !!}</td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <div class="row2">
                    <div class="column1">
                        <b>In word: </b> {{ numberToWord($bills->amount) }} {{ Session::get('companySettings')[0]['currency'] }}
                    </div>
                    <div class="column3">
                        <div class="textLeft"><strong>Bill Status:</strong> {{$bills->payment_status}}</div>
                        <div class="textLeft"><strong>Total Bill: </strong> {{$bills->amount}}{{ Session::get('companySettings')[0]['currency'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>