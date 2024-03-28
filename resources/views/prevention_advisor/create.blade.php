@extends('layouts.app')
@section('content')
    <div class="page-content-wrapper ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">{{__('Add Prevention Advisor')}}</h4>
                            <p class="text-muted m-b-30 font-14">{{__('Fill This instructions Carefully')}}.</p>
                            @if (Session::has('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ Session::get('success') }}
                                </div>
                            @endif
                            <div class="p-20">
                                <form action="{{ route('prevention.advisor.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                       

                                        

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>{{__('Company Name')}}</label>
                                                <select name="company_id" id="company" class="form-control">
                                                    @foreach ($companies as $company)
                                                        <option data-logo="{{ env('DO_CDN_ENDPOINT')."/".$company->logo }}"
                                                            value="{{ $company->id }}">{{ $company->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>{{__('Email')}}</label>
                                                <input id="email" type="text"
                                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                                    value="{{ old('email') }}" autofocus>
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                       


                                        @if(!empty($companies) && count($companies))
                                            <div class="col-lg-6 ">
                                                <img class="img-fluid" style="float: right"
                                                    src="{{ env('DO_CDN_ENDPOINT')."/".$companies[0]->logo }}" alt=""
                                                    id="imagePlacement">
                                            </div>
                                        @endif
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="is_seniour">{{__('Role')}} </label>
                                                <select name="pv_role" id="" class="form-control">
                                                        <option value="pv">{{__('Prevention Advisor')}}</option>
                                                        <option value="spv">{{__('Senior Prevention Advisor')}}</option>
                                                </select>
                                            </div>
                                        </div>




                                        <div class="col-lg-12 text-center">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                    {{__('Submit')}}
                                                </button>
                                                <button type="reset" class="btn btn-secondary waves-effect m-l-5">
                                                    {{__('Cancel')}}
                                                </button>
                                            </div>
                                        </div>
                                </form>
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
        $('#company').on('change', function() {
            var selectedOption = $(this).find(":selected");
            var logo = selectedOption.data("logo");
            $('#imagePlacement').attr('src', logo);

        })
    </script>
@endsection
