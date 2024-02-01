<!DOCTYPE html>
<html>

<!-- Mirrored from themesdesign.in/admiry/red/pages-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 02 Sep 2019 06:02:13 GMT -->

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Covarmed</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <link href="{{ asset('dashboard/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('dashboard/assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('dashboard/assets/css/style.css') }}" rel="stylesheet" type="text/css">

</head>


<body>
   
    <!-- Begin page -->
    {{-- <div class="accountbg"></div> --}}
    <div class="mr-3" >
        <div class="row justify-content-end mt-3">
            @include('partials/language_switcher')
        </div>
    </div>
    <div class="wrapper-page">
       
        <div class="card">
            <div class="card-body">

                <h3 class="text-center mt-0 m-b-15">
                    <a href="{{ url('/') }}" class="logo logo-admin"><img src="{{ asset('logo.svg') }}"
                            height="54" alt="logo"></a>
                </h3>

                <h4 class="text-muted text-center font-18"><b>{{__('Sign In')}}</b></h4>

                <div class="p-3">
                    <form class="form-horizontal m-t-20" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group row">
                            <div class="col-12">
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" placeholder="{{__('Enter Email')}}" required autocomplete="email"
                                    autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    placeholder="{{__('Enter Password')}}" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- <div class="form-group row">
                            <div class="col-12">
                                <label class="custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Remember me</span>
                                </label>
                            </div>
                        </div> --}}

                        <div class="form-group row">
                            <div class="col-md-4 offset-md-8">
                                <div class="checkbox">
                                    <label>
                                        <a href="{{ route('forget.password.get') }}">{{__('Forgot Password')}}</a>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center row m-t-20">
                            <div class="col-12">
                                <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">{{__('Sign In')}}</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</body>

</html>
