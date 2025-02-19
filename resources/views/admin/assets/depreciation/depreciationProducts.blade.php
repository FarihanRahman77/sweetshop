@extends('admin.master')
@section('title')
{{ Session::get('companySettings')[0]['name'] }} Asset Sale View
@endsection
@section('content')
<div class="content-wrapper">
    <section class="content box-border">
        <div class="card">
            <div class="card-header">
                <h3 style="float:left;">Depreciation Asset</h3>
                <!-- <a class="btn btn-primary float-right" href="{{ route('assets.sales.add') }}"> <i
                            class="fa fa-plus-circle"></i> Sale Asset
                    </a> -->
                <a class="btn btn-primary" style="margin-left:20px;" onclick="reloadDt()"><i class="fas fa-sync"></i>
                    Refresh
                </a>
                <a class="btn btn-primary" style="margin-left:20px;"
                    href="{{route('assets.products.depreciationAssetsPdf')}}">
                    <i class="fa fa-file-pdf"></i> PDF
                </a>
                <a class="btn btn-primary" style="margin-left:20px;"
                    href="{{route('assets.products.cloaseDepreciation')}}">
                    <i class="fa fa-minus-square"></i> Close Yearly Depreciation
                </a>

                


            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="table-responsive">
                    <table id="manageSalesTable" width="100%" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <td width="3%" class="text-center">SL</td>
                                <td width="8%" class="text-center">Purchase Date</td>
                                <td width="12%" class="text-center">Product Name</td>
                                <td width="5%" class="text-center">Serial</td>
                                <td width="13%" class="text-center">Supplier Info</td>
                                <td width="10%" class="text-center">Purchased By</td>
                                <td width="10%" class="text-right">Purchase Price</td>
                                <td width="12%" class="text-right">Depreciation Rate</td>
                                <td width="12%" class="text-right">Deducted</td>
                                <td width="10%" class="text-right">Tenure Amount</td>
                                <td width="5%" class="text-center">Actions</td>
                            </tr>
                        </thead>
                    </table>


                </div>
            </div>
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
var table;

$(document).ready(function() {

    table = $('#manageSalesTable').DataTable({
        'ajax': "{{ url('assets/products/getDepreciationAssets') }}",
        processing: true,
        destroy: true,
    });
    //loadFilterDatatable();

});

function loadFilterDatatable(filterBy = 'days') {

    /*  const days = $("#daysFilters").val();
     const party = $("#partyFilters").val();
     var filterByTypeDateParty = filterBy + "@" + days;

     if (filterBy === "party" && party === 'FilterByDays') {
         $('#partyFilters').prop('disabled', true);
         $('#daysFilters').prop('disabled', false);
         return;
     } else if (filterBy === "days" && days === 'FilterByCustomers') {
         $('#daysFilters').prop('disabled', true);
         $('#partyFilters').prop('disabled', false);
         return;
     }

     if (filterBy === "party") {
         filterByTypeDateParty = filterBy + "@" + party;
     } 

     table = $('#manageSalesTable').DataTable({
         'ajax': `{{ url('assets/getAssets') }}`,
         processing: true,
         destroy: true,
     });*/

}



function seeTenure(id) {
    $('#assignModel').modal('show');
    $.ajax({
        url: "{{ route('assets.products.getDepreciationTenure') }}",
        method: "GET",
        data: {
            "id": id
        },
        datatype: "json",
        success: function(result) {
            //alert(JSON.stringify(result));
            $('#tenure_div').html(result.html);
            $('#product_name_text').text(result.span);
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


}



function reloadDt() {
    table.ajax.reload(null, false);
}
</script>
@endsection