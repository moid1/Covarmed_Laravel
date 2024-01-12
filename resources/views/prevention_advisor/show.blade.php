@extends('layouts.app')
@section('content')
    <div class="page-content-wrapper ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">Prevention Advisor Details</h4>
                            @if (Session::has('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ Session::get('success') }}
                                </div>
                            @endif
                            <div class="p-20">
                                <form action="{{ route('prevention.advisor.update', $preventionalAdvisor->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input id="name" type="text"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="{{ $preventionalAdvisor->name }}" autofocus>
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input id="email" type="text" readonly
                                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                                    value="{{ $preventionalAdvisor->user->email }}" autofocus>
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Location</label>
                                                <input id="location" type="text"
                                                    class="form-control @error('location') is-invalid @enderror"
                                                    name="location" value="{{ $preventionalAdvisor->location }}">
                                                @error('location')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>




                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Phone #</label>
                                                <input id="phone" type="text"
                                                    class="form-control @error('phone') is-invalid @enderror" name="phone"
                                                    value="{{ $preventionalAdvisor->phone }}">

                                                @error('phone')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Company Name</label>
                                                <input id="company_name" type="text"
                                                    class="form-control @error('company_name') is-invalid @enderror" name="company_name"
                                                    value="{{ $preventionalAdvisor->company_name }}">

                                                @error('company_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="">
                                                <label>Logo</label>
                                                <input id="logo" type="file" onchange="readURL(this);"
                                                    class=" @error('logo') is-invalid @enderror" name="logo">

                                                @error('logo')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="logo">Logo</label>
                                            <img class="img-fluid "
                                                src="{{ env('DO_CDN_ENDPOINT') . "/{$preventionalAdvisor->logo}" }}"
                                                alt="" id="imagePlacement">
                                        </div>


                                        





                                        <div class="col-lg-12 text-center mt-3" >
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                    Update
                                                </button>
                                                <button type="reset" class="btn btn-secondary waves-effect m-l-5">
                                                    Cancel
                                                </button>
                                            </div>
                                        </div>
                                </form>
                            </div>

                            <hr>



                        </div>
                    </div>

                    <div class="">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">Kits</h4>
                            <p>All Kits of this Preventional Advisor Listed Below</p>
                            <div class="p-20">
                                <div class="row">
                                    @foreach ($preventionalAdvisor->kits as $kit)
                                    <div class="col-lg-4 mb-5 ">
                                        <div class="card" style="width: 18rem;">
                                            <img class="card-img-top" src="{{env('DO_CDN_ENDPOINT')."/{$kit->qr_image}"}}" alt="Card image cap">
                                            <div class="card-body">
                                                <div class="w-100 d-flex " style="justify-content: space-between">
                                                    <p>Unique Code</p>
                                                    <p class="badge badge-primary">{{$kit->unique_code}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div><!-- container-fluid -->


    </div>
@endsection

@section('pageSpecificJs')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#imagePlacement').attr('src', e.target.result).width(150).height(200);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
