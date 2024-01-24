<!DOCTYPE html>
<html>

<!-- Mirrored from themesdesign.in/admiry/red/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 02 Sep 2019 06:00:28 GMT -->

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Covarmed</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('logo.svg') }}">
    <link href="{{ asset('dashboard/assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('dashboard/assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="{{ asset('dashboard/assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="{{ asset('dashboard/assets/plugins/morris/morris.css') }}">

    <link href="{{ asset('dashboard/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('dashboard/assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('dashboard/assets/css/style.css') }}" rel="stylesheet" type="text/css">
    <style>
        .form-holder {
            margin-top: 20%;
            margin-bottom: 20%;
        }
    </style>
</head>


<body>

    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner"></div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card form-holder">
                    <div class="card-body">
                        @if (Session::has('success'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('success') }}
                        </div>
                        @endif
                        <div class="w-100 text-center">
                            <img class="img-fluid " src="{{ env('DO_CDN_ENDPOINT') . "
                                /{$kit->preventionAdvisor->company->logo}" }}"
                            alt="">
                        </div>
                        <h3 class="text-center mt-3">{{ $kit->preventionAdvisor->company->name }}</h3>
                        <p class="text-center text-grey">Please enter the incident details</p>
                        <form action="{{ route('incident.submit') }}" method="post">
                            @csrf
                            <input type="hidden" name="prevention_advisor_id" id=""
                                value="{{ $kit->preventionAdvisor->id }}">
                            <input type="hidden" name="kit_id" id="" value="{{ $kit->id }}">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="employee_name" class="form-control" placeholder="Name"
                                    required />
                            </div>
                            @if(!empty($questions))
                                @foreach ($questions as $question)
                                    <div class="form-group">
                                        <label>{{ $question->question }}</label>
                                        <textarea rows="2" class="form-control" name="question_{{ $question->id }}" id=""
                                            cols="30" rows="10" required></textarea>
                                    </div>
                                @endforeach
                            @endif


                            <div class="w-100 text-center">
                                <button type="submit" class="w-100 btn btn-primary text-center">Submit</button>
                            </div>

                            <div class="w-100 text-center mt-5">
                                <img src="{{ asset('logo.svg') }}" alt="">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- jQuery  -->
    <script src="{{ asset('dashboard/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/tether.min.js') }}"></script><!-- Tether for Bootstrap -->
    <script src="{{ asset('dashboard/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/modernizr.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/detect.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/fastclick.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/jquery.blockUI.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/waves.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/jquery.nicescroll.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/jquery.scrollTo.min.js') }}"></script>

    <!--Morris Chart-->
    <script src="{{ asset('dashboard/assets/plugins/morris/morris.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/plugins/raphael/raphael-min.js') }}"></script>

    <script src="{{ asset('dashboard/assets/pages/dashborad.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('dashboard/assets/js/app.js') }}"></script>


    <!-- App js -->
    <script src="{{ asset('dashboard/') }}assets/js/app.js"></script>
    @yield('pageSpecificJs')
</body>

<script>
    let password = @json($companyPassword);

    let attempts = 0;
    let maxAttempts = 3;
    function blockAccess() {
        console.log('Maximum attempts reached. Blocking access.');
        // Redirect to a blocked page or show an error message
        window.location.href = '/blocked';
    }

    function authenticate() {
        var enteredPassword = window.prompt('Please enter the password:');
        
        if (enteredPassword !== null && enteredPassword === password) {
        } else {
            // Increment the attempts
            attempts++;

            // If attempts are less than maxAttempts, prompt again
            if (attempts < maxAttempts) {
                authenticate();
            } else {
                // Block access after maxAttempts
                blockAccess();
            }
        }
    }

    if(password != null){
        var enteredPassword = window.prompt('Please enter the password:');
            authenticate();
    }
</script>

</html>