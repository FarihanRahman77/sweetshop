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
        margin-top: 4cm;
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
    <title>Sale Invoice</title>
</head>

<body>
    <!-- Content Wrapper. Contains page content -->
    <header>

        <img src="{{ 'upload/images/' . Session::get('companySettings')[0]['logo'] }}" width='205' height='105'>
        <div class="supAddressFont">
            {!! Session::get('companySettings')[0]['report_header'] !!}
        </div>
    </header>
    <footer>

    </footer>
    <main>
        @if ($assetSale->deleted == 'No')
        <!-- Content Wrapper. Contains page content -->
        <div>
            <div style="text-align: center;">
                <div class="citiestd13">Asset Sales Invoice

                </div>
                <table cellspacing="0" cellpadding="3">
                    <tr>
                        <td width="70%" class="supAddress">
                            <div><strong>Name : </strong>{{ $assetSale->party_name }}</div>
                        </td>
                        <td width="30%" class="supAddress">
                            <div><strong id="invoiceNo">Invoice: #{{ $assetSale->sale_no }}</strong></div>
                            <div><strong>Sale Date: </strong> {{ date("d-m-Y",strtotime($assetSale->date)) }}</div>
                            <div><strong>Entry By: </strong> {{ $assetSale->name }}</div>
                        </td>
                    </tr>
                </table>
                <table border="1" class="invoice-info underFontSize" cellspacing="0" cellpadding="3">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Product Name</th>
                            <th>Product Serial</th>
                            <th>Purchase Price</th>
                            <th>Depreciation Value</th>
                            <th>Sale Amount</th>
                            <th>Qty</th>
                            <th>Total</th>
                            <th>Profit/Lose</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $i = 1;
                        $totalAmount = 0;
                        $totalQty = 0;

                        @endphp
                        @foreach ($products as $product)
                        @php
                            $status='';
                            if(($product->sold_price-$product->price_after_depreciation) > 0){
                                $status='Profit';
                            }elseif(($product->sold_price-$product->price_after_depreciation) < 0){
                                $status='Lose';
                            }else{
                                $status='No Profit';
                            }
                        @endphp
                        <tr>
                            <td class="text-center">{{ $i++ }}</td>
                            <td class="citiestd15">{{ $product->productName . ' - ' . $product->productCode }}</td>
                            <td class="text-center">{{$product->serial_no}}</td>
                            <td class="textRight">{{$product->price}}</td>
                            <td class="textRight">{{$product->price_after_depreciation}}</td>
                            <td class="textRight">{{ $product->sold_price }}</td>
                            <td class="text-center">{{ $product->quantity }}</td>
                            <td class="textRight"> {{ $product->sold_price }}</td>
                            <td class="text-center"> {{ $status }}</td>
                            @php
                            $totalQty += $product->quantity;
                            $totalAmount += $product->sold_price;
                            @endphp
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="6" class="textRight"> Total ({!! Session::get('companySettings')[0]['currency'] !!})=</td>
                            <td class="text-center">{{ $totalQty }}</td>
                            <td class="textRight"> {{ numberFormat($totalAmount) }}</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
               
            </div>
        </div>
        @else
        <div class="textCenter">Invoice Deleted Please check again !</div>
        @endif
        <br><br><br>
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
            <div style="font-size:10px;text-align:center">{!! Session::get('companySettings')[0]['report_footer'] !!}
            </div>
            <hr />

        </div>

    </main>


</body>

</html>