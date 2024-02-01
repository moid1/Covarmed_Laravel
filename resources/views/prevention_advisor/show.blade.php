@extends('layouts.app')
@section('content')
    <div class="page-content-wrapper ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">{{__('Update Prevention Advisor')}}</h4>
                            @if (Session::has('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ Session::get('success') }}
                                </div>
                            @endif
                            <div class="p-20">
                                <form action="{{ route('prevention.advisor.update', $preventionalAdvisor->id) }}" method="POST"
                                    >
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>{{__('Name')}}</label>
                                                <input id="name" type="text"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="{{ $preventionalAdvisor->user->name }}" autofocus>
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>{{__('Email')}}</label>
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
                                                <label>{{__('Phone number')}}</label>
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

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>{{__('Company Name')}}</label>
                                                <input id="company_name" readonly type="text"
                                                    class="form-control @error('company_name') is-invalid @enderror" name="company_name"
                                                    value="{{ $preventionalAdvisor->company->name }}">

                                                @error('company_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            </div>
                                        </div>



                                        <div class="col-lg-12 text-center mt-3" >
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                    {{__('Update')}}
                                                </button>
                                                <button type="reset" class="btn btn-secondary waves-effect m-l-5">
                                                    {{__('Cancel')}}
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
                            <h4 class="mt-0 header-title">{{__('First-aid Kits')}}</h4>
                            <p>{{__('All linked First-aid Kits')}}</p>
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

                                                <div class="w-100 d-flex " style="justify-content: space-between">
                                                    <p>Name</p>
                                                    <p class="">{{$kit->name}}</p>
                                                </div>
                                                <a href="{{route('kits.show', $kit->id)}}" class="w-100 btn btn-success">Update</a>
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
