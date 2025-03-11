<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar" data-sidebarbg="skin5">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="p-t-30">

                {{-- Start New Sidebar --}}
                
                    
                    
                {{-- Start Inventory Module --}}
               <!--  <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark"
                        href="javascript:void(0)" aria-expanded="false"><i class="fa fa-th-list"></i> Inventory Module
                    </a>
                    <ul aria-expanded="false" class="collapse  first-level"> -->
                        <li class="sidebar-item"><a href="javascript:void(0)" class="sidebar-link has-arrow waves-effect waves-dark" aria-expanded="false"><i class="fa fa-shopping-cart"></i><span class="hide-menu"> Inventory </span></a>
                            <ul aria-expanded="false" class="collapse  first-level">
                           
                                <li class="sidebar-item menu-design"> <a class="sidebar-link waves-effect waves-dark sidebar-link"  href="{{ route('products.view') }}" aria-expanded="false"><i class="fa fa-bars"></i><span class="hide-menu">Products</span></a></li>
                           
                                <li class="sidebar-item menu-design"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('damage.view') }}" aria-expanded="false"><i class="fa fa-bars"></i><span class="hide-menu">Damage Products</span></a></li>
                                <li class="sidebar-item menu-design"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('products.barcodegeneratreindex') }}" aria-expanded="false"><i class="fa fa-bars"></i><span class="hide-menu">Barcode Generate</span></a></li>
                            
                                <li class="sidebar-item menu-design d-none"> <a class="sidebar-link waves-effect waves-dark sidebar-link"  href="{{ url('warehouse/transfer/') }}" aria-expanded="false"><i class="fa fa-bars"></i><span class="hide-menu">Warehouse Transfer</span></a></li>
                            
                            </ul>
                        </li>
                        
                        {{-- Purchase --}}
                        <li class="sidebar-item"><a href="javascript:void(0)" class="sidebar-link has-arrow waves-effect waves-dark" aria-expanded="false"><i class="fa fa-shopping-cart"></i><span class="hide-menu"> Purchase Management </span></a>
                            <ul aria-expanded="false" class="collapse  first-level">
                               
                                <li class="sidebar-item menu-design"><a href="{{ route('purchase.index') }}"class="sidebar-link"><i class="fa fa-bars"></i><span class="hide-menu">Purchase</span></a></li>
                               
                                <li class="sidebar-item menu-design"><a href="{{ route('purchase.return.list') }}"class="sidebar-link"><i class="fa fa-bars"></i><span class="hide-menu">Purchase Return </span></a></li>
                                 
                            </ul>
                        </li>
                        
                        {{-- Sale --}}
                       
                        <li class="d-none sidebar-item"><a href="javascript:void(0)"
                                class="sidebar-link has-arrow waves-effect waves-dark" aria-expanded="false"><i class="fa fa-shopping-bag"></i><span class="hide-menu"> Sale Management</span></a>
                            <ul aria-expanded="false" class="collapse  first-level">
                               
                                <li class="sidebar-item menu-design"><a href="{{ route('sale.service.SaleOrders') }} " class="sidebar-link"><i class="fa fa-bars"></i></i><span class="hide-menu"> Service Orders </span></a></li>
                                
                                <li class="sidebar-item menu-design"><a href="{{ route('sale.sales', ['type' => 'walkin_sale']) }} " class="sidebar-link"><i class="fa fa-bars"></i></i><span class="hide-menu"> WI Sale </span></a></li>
                                <li class="sidebar-item menu-design"><a href="{{ route('sale.return.list', ['type' => 'walkin_sale']) }}"class="sidebar-link"><i class="fa fa-bars"></i><span class="hide-menu">Sale Return </span></a></li>
                                <li class="sidebar-item menu-design"><a href="{{ route('sale.sales', ['type' => 'service']) }} " class="sidebar-link"><i class="fa fa-bars"></i></i><span class="hide-menu"> Order Sale View </span></a></li>
                                
                                <li class="sidebar-item menu-design d-none"><a href="{{ route('sale.sales', ['type' => 'party_sale']) }}" class="sidebar-link"><i class="fa fa-bars"></i><span class="hide-menu"> Party Sale </span></a></li>
                                <li class="sidebar-item menu-design d-none"><a href="{{ route('sale.return.list', ['type' => 'party_sale']) }}" class="sidebar-link"><i class="fa fa-bars"></i><span class="hide-menu">Party Sale Return </span></a></li>
                                
                                <li class="sidebar-item menu-design d-none"><a href="{{ route('sale.sales', ['type' => 'ts']) }}" class="sidebar-link"><i class="fa fa-bars"></i><span class="hide-menu"> TS </span></a></li>
                                <li class="sidebar-item menu-design d-none"><a href="{{ route('sale.return.list', ['type' => 'ts']) }}" class="sidebar-link"><i class="fa fa-bars"></i><span class="hide-menu">TS Return </span></a></li>
                               
                                <li class="sidebar-item menu-design d-none"><a href="{{ route('sale.sales', ['type' => 'FS']) }}" class="sidebar-link"><i class="fa fa-bars"></i><span class="hide-menu"> Final Sale </span></a></li>
                                <li class="sidebar-item menu-design d-none"><a href="{{ route('sale.return.list', ['type' => 'FS']) }}" class="sidebar-link"><i class="fa fa-bars"></i><span class="hide-menu"> FS Return </span></a></li>
                               
                            </ul>
                        </li>
                       
                    <!-- </ul>
                </li> -->
                {{-- End Inventory Module --}}
                

                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-credit-card"></i><span class="hide-menu"> Voucher </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item menu-design"><a href="{{url('voucher/payment')}}" class="sidebar-link"><i class="fas fa-bars"></i><span class="hide-menu"> Payment Voucher</span></a></li>
                        <li class="sidebar-item menu-design"><a href="{{url('voucher/payment Received')}}" class="sidebar-link"><i class="fas fa-bars"></i><span class="hide-menu"> Received Voucher </span></a></li>
                        <li class="sidebar-item menu-design"><a href="{{url('voucher/Discount')}}" class="sidebar-link"><i class="fas fa-bars"></i><span class="hide-menu"> Discount Voucher</span></a></li> 
                    </ul>
                </li>

                
              


               

                              

                     
                  <!-- Sweets and confectionery route start -->


                  <li class="sidebar-item"> 
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"> <i class="fa fa-birthday-cake"></i><span class="hide-menu"> Menu Order </span<></a>
                        <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item menu-design"><a href="{{url('sweetsconfectionary/order/list')}}" class="sidebar-link"><i class="fas fa-bars"></i><span class="hide-menu"> Walkin Sale</span></a></li>
                        </ul>
                  </li>

                              <!-- Sweets and confectionery route end -->












                 
               
                
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-user-plus"></i> <span class="hide-menu"> User management</span> </a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="javascript:void(0)" class="sidebar-link has-arrow waves-effect waves-dark" aria-expanded="false"><i class="fa fa-tasks"></i><span class="hide-menu"> Roles & Permissions </span></a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item menu-design"><a href="{{ route('rolesView') }}" class="sidebar-link"><i class="fas fa-bars"></i><span class="hide-menu"> Roles</span></a> </li>
                                <li class="sidebar-item menu-design"><a href="{{ route('permissionView') }}" class="sidebar-link"><i class="fas fa-bars"></i><span class="hide-menu"> Permissions</span></a></li>
                                <li class="sidebar-item menu-design"><a href="{{ route('permissionToRoleList') }}" class="sidebar-link"><i class="fas fa-bars"></i><span class="hide-menu"> Give Permission to Role</span></a></li>
                            </ul>
                        </li>
                        <li class="sidebar-item menu-design"><a href="{{ route('users.') }}" class="sidebar-link"><i class="fas fa-bars"></i><span class="hide-menu"> View Users </span></a> </li>
                        <li class="sidebar-item menu-design"><a  href="{{ route('users.edit_user_password') }}" class="sidebar-link"><i class="fas fa-bars"></i><span class="hide-menu"> Change Password </span></a></li>
                    </ul>
                </li>
                
                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"> <i class="fas fa-users"aria-hidden="true"></i><span class="hide-menu"> CRM</span></a>
                    <ul aria-expanded="false" class="collapse  first-level">

                                <li class="sidebar-item menu-design"><a href="{{url('parties/view/Supplier')}}" class="sidebar-link"><i class="fa fa-bars"></i><span class="hide-menu"> Supplier </span></a></li>
                                <li class="sidebar-item menu-design"><a href="{{url('parties/view/Customer')}}" class="sidebar-link"><i class="fa fa-bars"></i><span class="hide-menu"> Customer </span></a></li>
                                <li class="sidebar-item menu-design"><a href="{{url('parties/view/Walkin_Customer')}}" class="sidebar-link"><i class="fa fa-bars"></i><span class="hide-menu"> Walkin Customer </span></a></li>
                                <li class="sidebar-item menu-design"><a href="{{ url('parties/view/Investor') }}" class="sidebar-link"><i class="fa fa-bars"></i><span class="hide-menu"> Investor </span></a></li>
                    </ul>
                </li>

                <!-- Acccounts module start -->
        
                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-calculator"></i><span class="hide-menu"> Accounts </span></a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item menu-design"><a href="{{route('chartOfAccounts') }}" class="sidebar-link"><i class="fa fa-bars"></i><span class="hide-menu"> Chart of accounts </span></a></li>
                            <li class="sidebar-item menu-design"><a href="{{ route('journalView') }}" class="sidebar-link"><i class="fa fa-bars"></i><span class="hide-menu"> Journal </span></a></li>
                            <li class="sidebar-item menu-design"><a href="{{ route('expenseView') }}" class="sidebar-link"><i class=" fa fa-bars"></i><span class="hide-menu"> Expense </span></a> </li>
                            <li class="sidebar-item menu-design"><a href="{{ route('billView') }}" class="sidebar-link"><i class="fa fa-bars"></i><span class="hide-menu"> Bill </span></a></li>
                            <li class="sidebar-item menu-design"><a href="{{ route('bankView') }}" class="sidebar-link"> <i class="fa fa-bars"></i><span class="hide-menu">Banks </span></a></li>
                        </ul>
                    </li>
                   
               



               
                <li class="sidebar-item"> 
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"> <i class="fas fa-paste"></i><span class="hide-menu"> Reports </span<></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        
                        <li class="sidebar-item menu-design d-none"><a href="{{ route('serviceSaleSUmmaryReport') }}" class="sidebar-link"> <i class="fa fa-bars"></i><span class="hide-menu">Net Profit Calculation</span></a></li>
                      
                        <li class="sidebar-item menu-design"><a href="{{ route('dailyAccountsLedger') }}" class="sidebar-link"> <i class="fa fa-bars"></i><span class="hide-menu">Daily  Ledger </span></a></li>
                       
                        <li class="sidebar-item menu-design"><a href="{{ route('expensesReportView') }}" class="sidebar-link"><i class="fa fa-bars"></i><span class="hide-menu"> Daily Ledger Report </span></a></li>
                    
                        <li class="sidebar-item menu-design d-none"><a href="{{ route('dailyServiceLedgerReport') }}" class="sidebar-link"><i class="fa fa-bars"></i><span class="hide-menu">Daily Service Report</span></a></li>

                        <li class="sidebar-item menu-design"><a href="{{ route('partyLedger') }}" class="sidebar-link"> <i class="fa fa-bars"></i><span class="hide-menu"> Party Ledger </span> </a></li>
                        
                        <li class="sidebar-item menu-design"><a href="{{ route('partyDues') }}" class="sidebar-link"> <i class="fa fa-bars"></i><span class="hide-menu"> Party Dues </span> </a></li>
        
                        <li class="sidebar-item menu-design"><a href="{{ route('bankLedger') }}" class="sidebar-link"> <i class="fa fa-bars"></i><span class="hide-menu"> Bank Ledger </span> </a></li>
                      
                        <li class="sidebar-item menu-design"><a href="{{ route('accountsLedgerDatewise') }}" class="sidebar-link">  <i class="fa fa-bars"></i> <span class="hide-menu"> Income & Expenditure</span> </a></li>

                        <li class="sidebar-item menu-design"><a href="{{ route('applicantWiseProfit','Real') }}" class="sidebar-link">  <i class="fa fa-bars"></i> <span class="hide-menu">Profit and Loss Report</span> </a></li>
                    </ul>
                </li>


                     <!-- Acccounts module end -->
                   

                
                     

                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark"
                        href="javascript:void(0)" aria-expanded="false"><i class="fa fa-calendar"
                            aria-hidden="true"></i><span class="hide-menu"> Calendar</span>
                    </a>
                    <ul aria-expanded="false" class="collapse  first-level">

                        <li class="sidebar-item"><a href="{{ route('calendar.view') }}" class="sidebar-link"><i
                                    class="fas fa-bars"></i><span class="hide-menu">View Calendar </span></a></li>
                        <li class="sidebar-item"><a href="{{ route('calendar.createCalendarForm') }}"
                                class="sidebar-link"><i class="fas fa-bars"></i><span class="hide-menu">Create
                                    Calendar </span></a></li>

                    </ul>
                </li>
                <!-- setting -->
                @if (Auth::guard('web')->user()->can('Setting'))
                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"> <i class="fa fa-cogs"aria-hidden="true"></i> <span class="hide-menu"> Setting</span></a>
                        <ul aria-expanded="false" class="collapse  first-level">
                       
                            @if (Auth::guard('web')->user()->can('companySetting.view'))
                                <li class="sidebar-item menu-design"><a href="{{ route('company.settings.view') }}" class="sidebar-link"><i class="fa fa-bars"></i><span class="hide-menu"> Company Settings </span></a></li>
                            @endif

                            @if (Auth::guard('web')->user()->can('companySetting.view'))
                                <li class="sidebar-item menu-design"><a href="{{ route('sisterConcern.view') }}" class="sidebar-link"><i class="fa fa-bars"></i><span class="hide-menu"> Sister Concern </span></a></li>
                            @endif

                            @if (Auth::guard('web')->user()->can('categories'))
                                <li class="sidebar-item menu-design"><a href="{{ route('categories.view') }}" class="sidebar-link"><i class="fa fa-bars"></i><span class="hide-menu"> Category </span></a></li>
                            @endif
                            
                            @if (Auth::guard('web')->user()->can('brands'))
                                <li class="sidebar-item menu-design"><a href="{{ route('brands.view') }}" class="sidebar-link"><i class="fa fa-bars"></i><span class="hide-menu"> Brand </span></a></li>
                            @endif

                            @if (Auth::guard('web')->user()->can('units.view'))
                                <li class="sidebar-item menu-design"><a href="{{ route('units.view') }}" class="sidebar-link"><i class="fa fa-bars"></i><span class="hide-menu"> Unit </span></a></li>
                            @endif

                            @if (Auth::guard('web')->user()->can('warehouse.view'))
                                <li class="sidebar-item menu-design"><a href="{{ route('warehouse.view') }}" class="sidebar-link"><i class="fa fa-bars"></i><span class="hide-menu"> Warehouse </span></a></li>
                            @endif

                            @if (Auth::guard('web')->user()->can('transport.view'))
                                <li class="sidebar-item menu-design d-none"><a href="{{ route('transport.view') }}"class="sidebar-link"><i class="fa fa-bars"></i><spanclass="hide-menu">Transport </span></a></li>
                            @endif

                            @if (Auth::guard('web')->user()->can('accounts.setting'))
                                <li class="sidebar-item menu-design"><a href="{{ route('accountSettingView') }}" class="sidebar-link"><i class="fa fa-bars"></i><span class="hide-menu"> Account Settings </span> </a></li>
                            @endif

                            @if (Auth::guard('web')->user()->can('payroll.settings'))
                                <li class="sidebar-item menu-design"><a href="{{Route('settingIndex')}}" class="sidebar-link"> <i class="fa fa-bars"></i> <span class="hide-menu">Payroll Setting</span> </a> </li>
                            @endif
                            </ul>
                    </li>
                @endif 



                {{-- End New Sidebar --}}

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<!-- modal -->
<div class="modal fade" id="modalUser">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header float-left">

                <h4 class="modal-title float-left"> Change User Password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                        class="fas fa-window-close"></i></button>
            </div>
            <div class="modal-body">
                <form id="userPasswordForm" method="POST" enctype="multipart/form-data" action="#">
                    @csrf

                    <input type="hidden" name="id">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>User Name <span class="text-danger"> * </span></label><br>
                            <select id="selectUser" name="selectUser" class="form-control input-sm">
                                <option value="" disabled selected>Select User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"> {{ $user->name }} - {{ $user->email }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label> Password : <span class="text-danger"> * </span></label>
                            <input class="form-control input-sm" id="userPassword" type="password"
                                name="userPassword">
                            <span class="text-danger" id="userPasswordError"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">x
                            Close</button>
                        <button type="submit" class="btn btn-primary btnSave" id="saveUserPassword">Save</button>
                </form>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<script>
    function ChangePasswordModal(id) {
        $("#modalUser").modal('show');
        $("#userPassword").val("");

        $(function() {
            $("#selectUser").select2({
                width: '100%'
            });

        });
    }

    $("#userPasswordForm").submit(function(e) {
        e.preventDefault();
        let userId = $("#selectUser").val();
        let userPassword = $("#userPassword").val();
        if (userPassword.length < 6) {
            $('#userPasswordError').text('password length must be greater than 6!');
            return 0;
        }

        let _token = $('input[name="_token"]').val();
        let fd = new FormData();
        fd.append('password', userPassword);
        fd.append('userId', userId);
        fd.append('_token', _token);
        $.ajax({
            url: "{{ route('changePassword') }}",
            method: "POST",
            data: fd,
            contentType: false,
            processData: false,
            success: function(result) {
                $("#modalUser").modal('hide');
                Swal.fire("Updated!", result.success, "success");
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
        })
    });
</script>
