@extends('admin.master')
@section('title')
{{ Session::get('companySettings')[0]['name'] }} Asset Sale View
@endsection
@section('content')
<div class="content-wrapper">
    <section class="content box-border">
        <div class="card">
            <div class="card-header">
                <h3 style="float:left;">Close Depreciation Tenure</h3>
                <!-- <a class="btn btn-primary float-right" href="{{ route('assets.sales.add') }}"> <i
                            class="fa fa-plus-circle"></i> Sale Asset
                    </a> -->
                <a class="btn btn-primary" style="margin-left:20px;" onclick="reloadDt()"><i class="fas fa-sync"></i>
                    Refresh
                </a>
            </div><!-- /.card-header -->



            <div class="card-body p-2">
                <h4> <span id="paidText" class="text-success"></span> </h4>
                <div class="row">
                    <input type="hidden" id="current_month_year" value="{{date('Y-m')}}">
                    <div class="form-group col-md-4 p-1">
                        <label>Year: <span class="text-danger">*</span></label>
                        <select  class="form-control" id="month_year" name="month_year" onchange="yearWiseDate()">
                        @php 
                        for($i = 0; $i < 100; $i++){
                                    $tenure=Date('Y-F', strtotime(Date("Y-m").' '.$i.' Month -1 Day'));
									$tenureDate=Date('Y-m', strtotime(Date("Y-m").' '.$i.' Month -1 Day'));
							echo '<option value="'.$tenureDate.'">'.$tenure.'</option>';
                        }
                        @endphp
                        </select>
                        <span class="text-danger" id="advanceYearText"></span>
                    </div>
                    <div class="form-group p-1 col-md-4">
                        <label>To Date: <span class="text-danger">*</span></label>
                        <input class="form-control" id="to_date" name="to_date" readonly>
                    </div>
                    <div class="form-group p-1 col-md-4">
                        <label>From Date: <span class="text-danger">*</span></label>
                        <input class="form-control" id="from_date" name="from_date" readonly>
                    </div>
                </div>
                <div class="table-responsive" id="dTable"></div>
            </div>
            <div class="row">
                <div class="col-md-10"></div>
                <div class="col-md-2">
                    <a class="check-out-btn btn-block " href="#" onclick="checkOutCart()"> <i
                            class="fa fa-save"></i><span class="check-out-text"> Save All Tenure </span> 
                    </a>
                </div>
            </div>
            <span class="text-danger" id="advanceYearCheckoutText"></span>
        </div>
    </section>
    <section>
        <!-- Modal -->
        <div class="modal fade" id="assignModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog    modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Running Depreciation of <span id="product_name_text"></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <div class="modal-body" id="tenure_div">

                    </div>
                    <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div> -->
                </div>
            </div>
        </div>
    </section>
</div>
<!-- /.content-wrapper -->
@endsection
@section('javascript')
<script>
    
//var table;

/* $(document).ready(function() {

    table = $('#manageSalesTable').DataTable({
        'ajax': "{{ url('assets/products/getDepreciationAssets') }}",
        processing: true,
        destroy: true,
    });
    //loadFilterDatatable();

}); */


    yearWiseDate();
    function yearWiseDate(){
        var month_year=$('#month_year').val();
        $('#to_date').val(month_year+'-01');
        var to_date=$('#to_date').val();
        var current_month_year=$('#current_month_year').val();
        /* if(current_month_year < month_year){
            $('#advanceYearText').text('You can not close the depreciation of next year.')
        }else{ */
            $.ajax({
                url: "{{ route('assets.products.getDepreciationProductsYearwise') }}",
                method: "GET",
                data: {
                    "to_date": to_date,
                    "month_year":month_year
                },
                datatype: "json",
                success: function(result) {
                    //alert(JSON.stringify(result));
                    $('#from_date').val(result.from_date);
                     $('#dTable').html(result.html);
                    $('#dataTable').DataTable();
                    if(result.message){
                        $('#paidText').text(result.message);
                        
                    }else{
                        $('#paidText').hide();
                    }

                },
                error: function(response){
                    //alert(JSON.stringify(response));
                },
                beforeSend: function() {
                    $('#loading').show();
                },
                complete: function() {
                    $('#loading').hide();
                }
            });
       /*  } */
    }


    function checkOutCart(){
        var month_year=$('#month_year').val();
        var current_month_year=$('#current_month_year').val();
        var to_date=$('#to_date').val();
        var from_date=$('#from_date').val();
       /*  if(current_year < year){
            Swal.fire("Error: ", "Can not save the depreciation of next year.!", "error");
            
        }else{ */
            $.ajax({
                url: "{{ route('assets.products.saveDepriciationTenure') }}",
                method: "GET",
                data: {
                    "to_date": to_date,
                    "from_date": from_date,
                    "month_year":month_year
                },
                datatype: "json",
                success: function(result) {
                    //alert(JSON.stringify(result));
                    if (result.Success) {
                        Swal.fire({
                            title: "Saved !",
                            text: result.success,
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // printPurchase(purchaseId);
                            }
                        });
                        //yearWiseDate();
                    } else if(result.message){
                        Swal.fire("Error: ", result.message, "error");
                    }
                },
                error: function(response) {
                    //alert(JSON.stringify(response));
                },
                beforeSend: function() {
                    $('#loading').show();
                },
                complete: function() {
                    $('#loading').hide();
                }
            });
       /*  } */
    }




    function reloadDt() {
        yearWiseDate();
    }
</script>
@endsection