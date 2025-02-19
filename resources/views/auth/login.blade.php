<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('backend/assets/images/atDuronto.png')}}">
    <title>{{Session::get('companySettings')[0]['name']}} Login</title>
    <!-- Custom CSS -->
    <link href="{{asset('backend/dist/css/style.min.css')}}" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{asset('public/backend/')}}https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="{{asset('public/backend/')}}https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <div class="main-wrapper">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center bg-dark">
            <div class="auth-box bg-dark border-top border-secondary">
                <div id="loginform">
                    <div class="text-center p-b-20">
                        <span class="db"><img src="{{url('upload/images/hotel.png')}}" alt="logo" style="width:100%; max-height:120px;" /></span>
                    </div>
                    <!-- Form -->
                    <form class="form-horizontal m-t-20" method="post" action="{{url('login')}}">
                      @csrf

                          @if($errors->any())
                          <div class="alert alert-danger">
                              @foreach($errors->all() as $error)
                              <strong>{{$error}}</strong>
                              @endforeach
                          </div>
                          @endif
                        <div class="row p-b-30">
                            <div class="col-12">
                                <!--div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-success text-white" id="basic-addon1"><i class="ti-user"></i></span>
                                    </div>
                                    <input id="email" type="email" placeholder="Enter Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"
                                     autocomplete="email" autofocus>


                                </div-->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-success text-white" id="basic-addon1"><i class="ti-user"></i></span>
                                    </div>
                                    <input id="username" type="username" placeholder="Enter Username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}"
                                     autocomplete="username" autofocus>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-warning text-white" id="basic-addon2"><i class="ti-pencil"></i></span>
                                    </div>
                                    <input id="password" type="password" placeholder="Enter Password" class="form-control @error('password') is-invalid @enderror" name="password"
                                      autocomplete="current-password">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-info text-white" id="basic-addon2"><i class="ti-hand-point-right"></i></span>
                                    </div>
                                    <select class="form-control" name="sisterConcern_id" id="sisterConcern_id">
                                        <option value="">Select Branch</option>
                                        @foreach($sisterConcerns as $sisterConcern)
                                        <option value="{{$sisterConcern->id}}">{{$sisterConcern->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="sisterConcern_idError"></span>
                                </div>


                                @php 
                                    $min  = 1;
                                    $max  = 20;
                                    $num1 = rand( $min, $max );
                                    $num2 = rand( $min, $max );
                                    $sum  = $num1 + $num2;
                                @endphp
                                <div style="margin: 1% 0% 2% 0%;font-weight: 800;color: black;">
                                    <span>Validation code : {{$num1 }} + {{$num2}}</span>
                                </div>
                                <div class="input-group mb-3">
                                    <input id="validation_number"  name="validation_number" type="number" placeholder="I am not a robot" class="form-control quiz-control" >
                                </div>
                                    
                                
                            </div>
                        </div>
                        <div class="row border-top border-secondary">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="p-t-20">
                                        <button class="btn btn-success float-center" style="width: 100%;" type="submit" data-res="{{$sum}}" disabled> <i class="ti-key"></i> Login</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper scss in scafholding.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper scss in scafholding.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right Sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right Sidebar -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- All Required js -->
    <!-- ============================================================== -->
    <script src="{{asset('backend/assets/libs/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{asset('backend/assets/libs/popper.js/dist/umd/popper.min.js')}}"></script>
    <script src="{{asset('backend/assets/libs/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!-- ============================================================== -->
    <!-- This page plugin js -->
    <!-- ============================================================== -->
    <script>
        const submitButton = document.querySelector('[type="submit"]');
            const quizInput = document.querySelector(".quiz-control");
            quizInput.addEventListener("input", function(e) {
                const res = submitButton.getAttribute("data-res");
                if ( this.value == res ) {
                    submitButton.removeAttribute("disabled");
                } else {
                    submitButton.setAttribute("disabled", "");
                }
            });
    
    $('[data-toggle="tooltip"]').tooltip();
    $(".preloader").fadeOut();
    // ==============================================================
    // Login and Recover Password
    // ==============================================================
    $('#to-recover').on("click", function() {
        $("#loginform").slideUp();
        $("#recoverform").fadeIn();
    });
    $('#to-login').click(function(){

        $("#recoverform").hide();
        $("#loginform").fadeIn();
    });
    </script>

</body>

</html>
