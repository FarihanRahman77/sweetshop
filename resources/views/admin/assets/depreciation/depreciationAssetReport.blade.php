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
            margin-bottom: 3cm;
        }

        /** Define the header rules **/
        header {
            position: fixed;
            top: .65cm;
            left: 0cm;
            right: 0cm;
            text-align: center;
        }


        /** Define the footer rules **/
        footer {
            
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

        .underAlignment {
            text-align: right;
            font-size: 11px;
        }

        .underAlignmentLeft {
            text-align: left;
            font-size: 11px;
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

        h2 {
            margin: .2%;
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
        .text-right {
            text-align: right;
        }
        .leftAlign{font-size: 11px;}
    </style>
    <title>Asset Invoice</title>
</head>

<body style="font-family: Arial, Helvetica, sans-serif;font-size: 13px;">
    <!-- Content Wrapper. Contains page content -->
    <header>
        <img src="{{ 'upload/images/' . Session::get('companySettings')[0]['logo'] }}" width='205' height='105'>
        <div class="supAddressFont">
            {!! Session::get('companySettings')[0]['report_header'] !!}
        </div>
    </header>


    
    <main>
       
            <!-- Content Wrapper. Contains page content -->
            <div>
                <div style="text-align: center;">
                    <div class="citiestd13">Depreciation Report </div>
            <table border="1" class="invoice-info" cellspacing="0" cellpadding="3">
                <thead>
                    <tr>
                        <td width="3%" class="text-center">SL</td>
                        <td width="8%" class="text-center">Purchase Date</td>
                        <td width="12%" class="text-center">Product Name</td>
                        <td width="5%" class="text-center">Serial</td>
                        <td width="13%"class="text-center">Supplier Info</td>
                        <td width="10%" class="text-center">Purchased By</td>
                        <td width="10%" class="text-right">Purchase Price</td>
                        <td width="12%" class="text-right">Depreciation Rate</td>
                        <td width="12%" class="text-center">Deducted</td>
                        <td width="10%" class="text-right">Tenure Amount</td>
                    </tr>
                </thead>
                <tbody>
                    @php 
                    $i = 1;
                    $total=0;
                    @endphp
                    @foreach($assetDepreciationProducts as $product)
                    <tr>
                        <td class="text-center">{{$i++}}</td>
                        <td class="text-center">{{date("d-m-Y h:i a",strtotime($product->created_date))}}</td>
                        <td class="text-center" >{{$product->productName}}</td>
                        <td class="text-center">{{$product->serial_no}}</td>
                        <td>
                            <b>Name : </b>{{$product->partyName}}<br> 
                            <b>Mobile : </b>{{$product->partyContact}}
                        </td>
                        <td class="text-center">{{$product->userName}}</td>
                        <td class="text-right">{{$product->price}}</td>
                        <td><span>{{$product->per_month}} Taka {{$product->depreciation}} depreciation for {{$product->no_of_month}} years</span></td> 
                        <td><span>Amount : {{$product->deducted}}<br> Tenure : {{$product->deducted_month}}</span></td>
                        <td class="text-right">{{$product->per_month}}</td>
                    </tr>
                    @php $total +=$product->price; @endphp
                    @endforeach
                    <tr>
                        <td colspan='6' class="text-right">Total Asset Value: (In {{Session::get('companySettings')[0]['currency']}})</td>
                        <td class="text-right">{{$total}}.00 </td>
                        <td colspan='3' ></td>
                    </tr>
                </tbody>
            </table><br><br>
            <!-- check table -->
            
<!-- end check table -->


</div>
</div>



</div>
</div>
</div>
</section>
</div>


</main>
<footer>
        <div class="signatures">
            <div class="row " style="font-size:10px;">
                <div class="column">
                    Ali Tech
                    <br>-----------------------<br>
                    Customer Signature
                </div>
                <div class="column">
                    {{ auth()->user()->name }}
                    <br>-----------------------<br>
                    Created By
                </div>
                <div class="column">
                    Manager
                    <br>-----------------------<br>
                    Authorized Signature
                </div>
            </div><br>
            <hr />
            <div style="font-size:10px;">{!! Session::get('companySettings')[0]['report_footer'] !!}</div>
        </div>
    </footer>
</body>

</html>
