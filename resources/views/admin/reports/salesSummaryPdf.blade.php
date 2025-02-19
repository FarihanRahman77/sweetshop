<html>
<head>
    <link rel="stylesheet" type="text/css" href="{{ base_path() . '/public/backend/assets/assets/libs/bootstrap/dist/css/bootstrap.min.css' }}">
    <link rel="stylesheet" type="text/css" href="{{ base_path() . '/public/backend/dist/css/report.style.css' }}">

    
    <title>Income & Expenditure Statement ({{ $date_from }} - {{ $date_to }})</title>
</head>

<body>
    <!-- Content Wrapper. Contains page content -->
    <header>
        <div class="">
            <div class="">
                <img src="{{ 'upload/images/' . Session::get('companySettings')[0]['logo'] }}" width='210'height='100'>
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
                    Income & Expenditure Statement ( Sales Details ) &nbsp; ({{ $date_from }} - {{ $date_to }})
                </div>
            </div>
        </div>


        <div class="container-fluid  p-0 mt-2">
            <div class="row no-gutters">
                <div class="col-md-12">
                    <table border="1" width="100%" class="invoice-info" cellspacing="0" cellpadding="3">
                        <thead>
                            <tr>
                                <td scope="col" style="width:5%;">SL#</td>
                                <td scope="col" style="width:10%;">Order No</td>
                                <td scope="col" style="width:15%;">Party Name</td>
                                <td scope="col" style="width:10%;">Created Date</td>
                                <td scope="col" style="width:25%;">Services</td>
                                <td scope="col" style="width:25%;">Voucher Details</td>
                                <td scope="col" style="width:10%;">Amount</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalSaleAmount = 0;
                            @endphp
                            @forelse ($sales as $key => $sale)
                                @php
                                    $totalSaleAmount += $sale->credit;
                                @endphp
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{$sale->sale_no}}</td>
                                    <td>{{ $sale->name }}</td>
                                    <td>{{ $sale->created_date }}</td>
                                    <td>
                                        @php 
                                        $products=DB::table('sale_order_products')
                                                            ->join('products', 'sale_order_products.product_id', '=', 'products.id')
                                                            ->select('products.name')
                                                            ->where('sale_order_products.deleted','=','No')
                                                            ->where('sale_order_products.status','=','Active')
                                                            ->where('sale_order_products.tbl_sale_orders_id','=',$sale->type_no)
                                                            ->get();
                                        @endphp
                                        @foreach($products as $product)
                                            {{$product->name}}<br>
                                        @endforeach
                                    </td>
                                    <td>{{ $sale->voucher_title }}</td>
                                    <td class="txt-right">{{ $sale->credit }}</td>
                                </tr>
                                @if ($loop->last)
                                    <tr class="txt-right">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td colspan="3" ><strong> Total Sale Amount  </strong></td>
                                        <td class="txt-right"><strong> {{ number_format($totalSaleAmount) }} </strong></td>
                                    </tr>
                                @endif
                            @empty
                                <h4>No Sales</h4>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            
            
        </div>

    </main>



</body>

</html>
