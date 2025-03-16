@extends('admin.master')
@section('title')
    Admin Add Expense
@endsection


@section('content')
    <div class="container-fluid">
        <section class="content box-border">
            <div class="card">
                <div class="card-header">
                    <h3>Add Expense</h3>
                    <h3 class="text-center text-danger">{{ Session::get('message') }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{route('expenseStore')}}" method="post">
                        @csrf
                    <div class="row m-1">
                        <div class="col-md-4">
                            <label class="form-label">Pay to</label>
                            <select type="date" class="form-control" name="vendor_id" id="vendor_id">
                                <option value="0"selected>Choose Employee</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{$supplier->id}}">{{$supplier->member_name}}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="vendor_idError">{{ $errors->has('vendor_id') ? $errors->first('vendor_id') : '' }}</span>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Transaction Date</label>
                            <input type="date" class="form-control" name="transaction_date">
                            <span class="text-danger" id="transaction_dateError">{{ $errors->has('transaction_date') ? $errors->first('transaction_date') : '' }}</span>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Reference</label>
                            <input type="text" class="form-control" name="reference" placeholder="Reference ">
                            <span class="text-danger" id="referenceError">{{ $errors->has('reference') ? $errors->first('reference') : '' }}</span>
                        </div>
                        <div class="col-md-3 d-none">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" name="address" placeholder="Type address">
                            <span class="text-danger" id="addressError">{{ $errors->has('address') ? $errors->first('address') : '' }}</span>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Payment method: </label>
                            <select type="text" class="form-control" name="payment_method" id="payment_method" onchange="getsources()">
                                <option value=""selected >Select Payment Method</option>
                                @foreach($methods as $method)
                                <option value="{{$method->id}}">{{$method->name}}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="payment_methodError">{{ $errors->has('payment_method') ? $errors->first('payment_method') : '' }}</span>
                        </div>
                        <div class="col-md-3"  id="from_source" style="display:none;">
                            <label class="form-label" >Sources:</label>
                            <select type="text" class="form-control" name="sources" id="sources" onchange="getAccountStatus()">
                                <option value="" selected disabled>Select Source</option>
                            </select>
                            <span class="text-danger" id="sourcesError">{{ $errors->has('sources') ? $errors->first('sources') : '' }}</span>
                        </div>
                        <div class="col-md-3" style="display:none;" id="div_account_status">
                            <label class="form-label" >Accounts: </label>
                            <!--select type="text" class="form-control" name="account_status" id="account_status" onchange="getAmount()" -->
                            <select type="text" class="form-control" name="account_status" id="account_status" onchange="getAmount()">
                                <option value="" selected disabled>Select Accounts</option>
                            </select>
                            <span class="text-danger" id="account_statusError">{{ $errors->has('account_status') ? $errors->first('account_status') : '' }}</span>
                        </div>
                        
                        <div class="col-md-3" style="display:none;" id="div_credit_amount">
                            <label class="form-label">Credit Amount: </label>
                            <input type="text" class="form-control" name="credit_amount" id="credit_amount" readonly>
                            <span class="text-danger" id="credit_amountError">{{ $errors->has('credit_amount') ? $errors->first('credit_amount') : '' }}</span>
                        </div>
                        <div class="col-md-4" style="display:none;" id="div_transaction_id">
                            <label class="form-label">Transaction No: </label>
                            <input type="text" class="form-control" name="transaction_id" id="transaction_id" placeholder="Transaction NO">
                            <span class="text-danger" id="transaction_idError">{{ $errors->has('transaction_id') ? $errors->first('transaction_id') : '' }}</span>
                           </div>
                        
                        <div class="col-md-8">
                            <label class="form-label">Remarks: </label>
                            <input type="text" class="form-control" name="particulars" placeholder="Remarks">
                            <span class="text-danger" id="particularsError">{{ $errors->has('particulars') ? $errors->first('particulars') : '' }}</span>
                        </div>
                        
                    </div>
                        
                    
                    <div class="table-responsive ">
                        <table class="table table-bordered table-hover dataTable no-footer m-1" id="manageJournalTable" width="100%">
                            <thead>
                                <tr class="bg-light">
                                    <td width="5%" class="text-center">Sl</td>
                                    <td width="30%" class="text-center">Account</td>
                                    <td width="30%" class="text-center">Particulars</td>
                                    <td width="15%" class="text-center">Amount</td>
                                    <td width="15%" class="text-center">Taxable</td>
                                    <td width="5%" class="text-center">Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="row0">
                                    <td>#</td>
                                    <td>
                                        <select class="form-control ddl_account" name="account[]">
                                            <option value="" selected>Choose COA</option>
                                            @php 
                                                $status='';
                                            @endphp
                                            @foreach($coas as $coa)
                                            @php
                                                if($coa->parent_id == '0' && $coa->unused == 'No'){
                                                    $status='';
                                                }elseif($coa->parent_id !== '0' && $coa->unused == 'No'){
                                                    $status='.';
                                                }else{
                                                    $status='..';
                                                }
                                            @endphp
                                            <option  value="{{$coa->id}}">{{$status}} {{$coa->name}} - {{$coa->code}}</option>
                                            @php
                                            $coaChildss=App\Models\Accounts\ChartOfAccounts::where('parent_id','=',$coa->id)->where('deleted','=','No')
                                                ->where('status','=','Active')
                                                ->orderBy('our_code', 'asc')
                                                ->where('warehouse_id','like',"%$loggedWarehouseId%")
                                                ->get();
                                            @endphp
                                            @foreach($coaChildss as $coaChild)
                                                <option value="{{$coaChild->id}}">.. {{$coaChild->name}} - {{$coaChild->code}}</option>
                                            @endforeach
                                            @endforeach
                                        </select>
                                        @error('account.0')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                       
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="particular[]" placeholder="Particulars">
                                        <span class="text-danger" id="particularError">{{ $errors->has('particular') ? $errors->first('particular') : '' }}</span>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" name="amount[]" value="0" onkeyup="totalBalance()"  style="text-align:right;">
                                        <span class="text-danger" id="amountError">{{ $errors->has('amount') ? $errors->first('amount') : '' }}</span>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" name="taxable_amount[]" value="0" onkeyup="totalTaxableBalance()"  style="text-align:right;">
                                        <span class="text-danger" id="taxable_amountError">{{ $errors->has('taxable_amount') ? $errors->first('taxable_amount') : '' }}</span>
                                    </td>
                                    <td>
                                        <label style="display:none;">.</label>
                                        <a href="#/" class="text-danger" onclick="remove_btn(this)"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>#</td>
                                    <td colspan="2" style="text-align:right;">Total:</td>
                                    <td>
                                        <input type="text" class="form-control" name="amountTotal" id="amountTotal"   style="text-align:right;">
                                        <span class="text-danger" id="amountTotalError">{{ $errors->has('amountTotal') ? $errors->first('amountTotal') : '' }}</span>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="taxable_amountTotal" id="taxable_amountTotal"   style="text-align:right;">
                                        <span class="text-danger" id="taxable_amountTotalError">{{ $errors->has('taxable_amountTotal') ? $errors->first('taxable_amountTotal') : '' }}</span>
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-12 ">
                            <div class=""><button class="btn btn-primary m-2" id="btn_addRow"> <i class="fas fa-plus"></i> Add row</button></div>
                            <button type="submit" class="btn btn-primary float-right  m-2" id="saveBtn" style="display:none;"> <i class="fas fa-save"></i> Save</button>
                            <button  class="btn btn-danger float-right  m-2" id="saveErrorBtn" disabled style="display:none;"> <i class="fas fa-save"></i> Save</button>
                            <span class="text-danger"id="saveErrorSpan" style="display:none;">You dont have enough credit..</span>
                            
                        </div>
                    </div>
                    </form>
                </div><!-- Card Content end -->
               
               
        </section>
    </div><!-- pc-container end -->
@endsection


@section('javascript')
    <script>

        $(".ddl_account").each(function() {
            select2Class($(this));
        });





        function select2Class(ddl_account){

			$(ddl_account).select2({
                placeholder: "Select COA",
                allowClear: true,
                width:'100%'
		    });
			$('#vendor_id').select2({
                placeholder: "Select supplier",
                allowClear: true,
                width:'100%'
		    });
			$('#payment_method').select2({
                placeholder: "Select payment method",
                allowClear: true,
                width:'100%'
		    });
			$('#sources').select2({
                placeholder: "Select Sources",
                allowClear: true,
                width:'100%'
		    });
			$('#account_status').select2({
                placeholder: "Select Accounts",
                allowClear: true,
                width:'100%'
		    });
            
        }





       
     

        function getsources(){
        var payment_method=$('#payment_method').val();
        $.ajax({
            url:"{{route('getBillsources')}}",
            method:"GET",
            data:{"payment_method":payment_method},
            datatype:"json",
            success:function(result){
                //alert(JSON.stringify(result));
                if(result.method_slug =='cash'){
                    $('#from_source').hide();
                    $('#div_account_status').hide();
                    $('#div_credit_amount').show();
                    $('#credit_amount').val(result.cash_amount);
                    totalBalance();
                }else{
                    $('#from_source').show();
                    $('#div_account_status').show();
                    $('#sources').html(result.data);
                    $('#div_credit_amount').hide();
                }
            }, beforeSend: function () {
                  $('#loading').show();
            },complete: function () {
                  $('#loading').hide();
            }, error: function(response) {
                //alert(JSON.stringify(response));
            }
        });
    }


    function getAccountStatus(){
            var payment_method=$('#sources').val();
            $.ajax({
                url:"{{route('getAccountStatus')}}",
                method:"GET",
                data:{"payment_method":payment_method},
                datatype:"json",
                success:function(result){
                    //alert(JSON.stringify(result));
                    $('#div_account_status').show();
                    $('#div_account_id').show();
                    $('#div_credit_amount').show();
                    $('#div_transaction_id').show();
                    $('#account_status').html(result.status);
                    $('#credit_amount').val(result.credit_amount); 
                }, beforeSend: function () {
                    $('#loading').show();
                },complete: function () {
                    $('#loading').hide();
                }, error: function(response) {
                    //alert(JSON.stringify(response));
                }
            });
        }

           function getAmount(){
            var account_status=$('#account_status').val();
            
            $.ajax({
                url:"{{route('getAmount')}}",
                method:"GET",
                data:{"account_status":account_status},
                datatype:"json",
                success:function(result){
                    //alert(JSON.stringify(result));
                    $('#credit_amount').val(result); 
                    totalBalance();
                }, beforeSend: function () {
                    $('#loading').show();
                },complete: function () {
                    $('#loading').hide();
                }, error: function(response) {
                    //alert(JSON.stringify(response));
                }
            });
           }
                
               

        function totalBalance(){
            var totalAmount = 0;  
            $("input[name='amount[]']").each(function() {
                totalAmount += parseFloat($(this).val());
            });
            $("#amountTotal").val(totalAmount);


            var credit_amount=$('#credit_amount').val();
            $('#saveBtn').show();
        }     
        
        function totalTaxableBalance(){
            var totalAmount = 0;  
            $("input[name='taxable_amount[]']").each(function() {
                totalAmount += parseFloat($(this).val());
            });
            $("#taxable_amountTotal").val(totalAmount);
        }



      



       

        var rowIndex = 2;
        $("#btn_addRow").click(function (e){
            e.preventDefault();
            var trData = $("#manageJournalTable tbody tr:last").html();
            $("#manageJournalTable tbody").append("<tr class='row"+rowIndex+"'>"+trData+"</tr>");
            var ddl = $("#manageJournalTable tbody tr:last td:nth-child(2) select");
            $(ddl).next().remove();
            var ind = $(".ddl_account").length-2;
            select2Class($(".ddl_account").eq(ind));
            select2Class($(".ddl_account").eq(ind+1));
            rowIndex++;
        })

        



        var i = 0;
        function remove_btn(remove_row){
           // alert(remove_row);
            var rowNo = $('#manageJournalTable tbody tr').length;
            if(rowNo > 1){
                $(remove_row).parent().parent().remove();
            }else{
                Swal.fire("Last 1 rows cannot be removed");
                //alert("Not possible to remove last 2 rows");
            }
            totalBalance();
        }



    </script>
@endsection
