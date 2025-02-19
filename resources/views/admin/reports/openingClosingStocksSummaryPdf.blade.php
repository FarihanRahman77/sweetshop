<html>

<head>
    <link rel="stylesheet" type="text/css"
        href="{{ base_path() . '/public/backend/assets/assets/libs/bootstrap/dist/css/bootstrap.min.css' }}">

    <style>
        #footer {
            position: fixed;
            right: 0px;
            bottom: 20px;
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
            margin-top: 3.2cm;
            margin-left: 0.5cm;
            margin-right: 0.5cm;
            margin-bottom: 4cm;
            font-family: "Roboto, 'Segoe UI', Tahoma, sans-serif";
            /* font-family: "Arial Narrow"; */
            font-size: 12pt;
        }

        /** Define the header rules **/
        header {
            position: fixed;
            top: .5cm;
            left: 0cm;
            right: 0cm;
            text-align: center;
            font-family: "Arial Narrow";
            font-size: 12pt;
        }


        /** Define the footer rules **/
        footer {
            position: fixed;
            bottom: 1cm;
            /*  left: 0cm;
            right: 0cm; */
            height: 1.8cm;
            text-align: center;
            font-family: "Arial Narrow";
            font-size: 10pt;
        }

        td {
            font-size: 12px;
        }

        /*  .column {
            float: left;
            width: 33.33%;
            height: 30px;
        } */

        /* Clear floats after the columns */
        /* .row:after {
            content: "";
            display: table;
            clear: both;
        } */

        .signatures {
            padding-bottom: -500px;
            font-family: "Arial Narrow";
            font-size: 10pt;
        }

        .citiestd13 {
            background-color: rgb(242, 242, 242);
            border: 1px solid gray;
            color: black;
            text-align: center;
            font-size: 13px;
            padding: 5px;
        }

        .supAddressFont {
            font-size: 11px;
        }

        .underAlignment {
            text-align: right;
            font-size: 13px;
        }

        .underAlignmentLeft {
            text-align: left;
            font-size: 13px;
        }

        /* table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 0.8em;
            min-width: 400px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        } */

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

        .column2 {
            float: left;
            width: 50%;
            padding: 10px;
            height: 300px;
            /* Should be removed. Only for demonstration */
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

        .text-right {
            text-align: right;
            padding-right: 65px;
        }

        tr {
            margin: 0px;
            padding: 0px;
        }

        td {
            font-size: 12px;
        }

        .txt-right {
            text-align: right;
        }
    </style>
    <title>Income & Expenditure Statement Stock Value</title>
</head>

<body>
    <!-- Content Wrapper. Contains page content -->
    <header>
        <div class="">
            <div class="">
                <img src="{{ 'upload/images/' . Session::get('companySettings')[0]['logo'] }}"
                    width='250'height='110'>
                <div class="supAddressFont">
                    {!! Session::get('companySettings')[0]['report_header'] !!}
                </div>
            </div>

        </div>

    </header>


    <main>

        <div>
            <div style="text-align: center; border: 1px solid gray;font-size:13px;" class="">
                <div>
                    Income & Expenditure Statement ({{ $stockType }}) <br> ({{ $stockType == "Opening Stock" ? $date_from : $date_to }})
                </div>
            </div>
        </div>
        <br>

        <div class="container-fluid  p-0 mt-2">
            <div class="row no-gutters">
                <div class="col-md-12">
                    @php
                        $sDate = $date_from;
                        $eDate = $date_to;
                    @endphp

                    @if ($stockType == "Opening Stock")
                        <table border="1" width="100%" class="invoice-info" cellspacing="0" cellpadding="3">
                            <thead>
                                <tr>
                                    <td scope="col" style="width:6%;">SL#</td>
                                    <td scope="col" style="width:40%;">Name</td>
                                    <td scope="col" style="width:15%;">Opening Stock</td>
                                    <td scope="col" style="width:20%;">Last Purchase Price</td>
                                    <td scope="col" style="width:15%;">Stock Value</td>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    set_time_limit(60);
                                    $purchaseStock = 0;
                                    $osValue = 0;
                                @endphp

                                @foreach ($products as $key => $product)
                                    @php
                                        $spId = $product->id;
                                        
                                        //========== Opening Balance
                                        
                                        $openingBalance = App\Models\Report\DailyReport::saleSerializeProducts($spId, $sDate,$eDate,$product);
                                        $lastPurchasePrice = $openingBalance[1];
                                        // End
                                        
                                        $tempTotalOpeningProductStock = $openingBalance[0] + $product->opening_stock;
                                        
                                        
                                        $osValue += $tempTotalOpeningProductStock * $lastPurchasePrice; //Opening stock value in amount
                                    @endphp


                                    <tr>
                                        <td>{{ $key + 1 }}</td>td>
                                        <td>{{ $product->name }}</td>
                                        <td class="text-right">{{ $tempTotalOpeningProductStock }}</td>
                                        <td class="txt-right">{{ $lastPurchasePrice }}</td>
                                        <td class="txt-right">{{ $tempTotalOpeningProductStock * $lastPurchasePrice }}
                                        </td>
                                    </tr>
                                    @if ($loop->last)
                                        <tr class="txt-right">
                                            <td></td>
                                            <td></td>
                                            <td colspan="2"><strong> Opening Stock Value As {{ $sDate }}
                                                </strong></td>
                                            <td><strong> {{ number_format($osValue) }} </strong></td>
                                        </tr>
                                    @endif
                                @endforeach

                            </tbody>
                        </table>
                    @endif



                    @if ($stockType == 'Closing Stock')
                        <table border="1" width="100%" class="invoice-info" cellspacing="0" cellpadding="3">
                            <thead>
                                <tr>
                                    <td scope="col" style="width:6%;">SL#</td>
                                    <td scope="col" style="width:40%;">Name</td>
                                    <td scope="col" style="width:15%;">Closing Stock</td>
                                    <td scope="col" style="width:20%;">Last Purchase Price</td>
                                    <td scope="col" style="width:15%;">Stock Value</td>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $purchaseStock = 0;
                                    $csValue = 0;
                                @endphp

                                @foreach ($products as $key => $product)
                                    @php
                                        $spId = $product->id;
                                        
                                        // Start Closing Balance
                                        $closingStock = DB::table('purchase_products')
                                            ->select(DB::raw('SUM(quantity) as stockInQuantity, 0 as stockOutQuantity'))
                                            ->join('purchases', 'purchase_products.purchase_id', '=', 'purchases.id')
                                            ->where('purchase_products.product_id', $spId)
                                            ->where('purchases.date', '<=', $eDate)
                                            ->where('purchases.deleted', 'No')
                                            ->where('purchase_products.deleted', 'No')
                                            ->unionAll(function ($query) use ($spId, $eDate) {
                                                $query
                                                    ->select(DB::raw('0 as stockInQuantity, SUM(return_qty) as stockOutQuantity'))
                                                    ->from('purchase_product_returns')
                                                    ->join('purchase_returns', 'purchase_product_returns.purchase_return_id', '=', 'purchase_returns.id')
                                                    ->where('purchase_product_returns.product_id', $spId)
                                                    ->where('purchase_returns.purchase_return_date', '<=', $eDate)
                                                    ->where('purchase_product_returns.deleted', 'No');
                                            })
                                            ->unionAll(function ($query) use ($spId, $eDate) {
                                                $query
                                                    ->select(DB::raw('0 as stockInQuantity, SUM(quantity) as stockOutQuantity'))
                                                    ->from('sale_products')
                                                    ->join('sales', 'sale_products.sale_id', '=', 'sales.id')
                                                    ->where('sale_products.product_id', $spId)
                                                    /// 2nd
                                                    ->where('sales.date', '<=', $eDate)
                                                    ->where('sales.deleted', 'No')
                                                    ->where('sale_products.deleted', 'No');
                                            })
                                            ->unionAll(function ($query) use ($spId, $eDate) {
                                                $query
                                                    ->select(DB::raw('SUM(return_qty) as stockInQuantity, 0 as stockOutQuantity'))
                                                    ->from('sale_product_returns')
                                                    ->join('sale_returns', 'sale_product_returns.sale_return_id', '=', 'sale_returns.id')
                                                    ->where('sale_product_returns.product_id', $spId)
                                                    ->where('sale_returns.sale_return_date', '<=', $eDate)
                                                    ->where('sale_product_returns.deleted', 'No');
                                            })
                                            ->unionAll(function ($query) use ($spId, $eDate) {
                                                $query
                                                    ->select(DB::raw('0 AS stockInQuantity, SUM(damage_quantity) AS stockOutQuantity'))
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
                                        $closingPurchaseAmount = DB::table('purchase_products')
                                            ->join('purchases', 'purchase_products.purchase_id', '=', 'purchases.id')
                                            ->where('purchases.deleted', 'No')
                                            ->where('purchase_products.deleted', 'No')
                                            ->where('purchases.date', '<=', $eDate)
                                            ->where('purchase_products.product_id', $spId)
                                            ->orderBy('purchases.date', 'desc')
                                            ->value('purchase_products.unit_price');
                                        
                                        if (!$closingPurchaseAmount) {
                                            if ($product->purchase_price != 0 && $product->purchase_price != '') {
                                                $closingPurchaseAmount = $product->purchase_price;
                                            } else {
                                                $closingPurchaseAmount = $product->sale_price;
                                            }
                                        }
                                        // End

                                        $tempTotalClosingProductStock = $closingStock + $product->opening_stock;
                                        $lastPurchasePrice = $closingPurchaseAmount; // Last Purchase Price Within a Date (sDate-eDate)
                                        $csValue += $tempTotalClosingProductStock * $lastPurchasePrice; //Closing stock value in amount
                                        
                                    @endphp


                                    <tr>
                                        <td>{{ $key + 1 }}</td>td>
                                        <td>{{ $product->name }}</td>
                                        <td class="text-right">{{ $tempTotalClosingProductStock }}</td>
                                        <td class="txt-right">{{ $lastPurchasePrice }}</td>
                                        <td class="txt-right">{{ $tempTotalClosingProductStock * $lastPurchasePrice }}
                                        </td>
                                    </tr>
                                    @if ($loop->last)
                                        <tr class="txt-right">
                                            <td></td>
                                            <td></td>
                                            <td colspan="2"><strong> Closing Stock As {{ $eDate }}
                                                </strong></td>
                                            <td><strong> {{ number_format($csValue) }} </strong></td>
                                        </tr>
                                    @endif
                                @endforeach

                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

        </div>

    </main>



</body>

</html>
