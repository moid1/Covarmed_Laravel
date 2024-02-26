@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@section('content')
    <div class="page-content-wrapper ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">{{__('Add Company')}}</h4>
                            <p class="text-muted m-b-30 font-14">{{__('Fill This instructions Carefully')}}.</p>
                            @if (Session::has('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ Session::get('success') }}
                                </div>
                            @endif
                            <div class="p-20">
                                <form action="{{ route('company.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>{{__('Name')}}</label>
                                                <input id="name" type="text"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="{{ old('name') }}" autofocus>
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>



                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>{{__('Password')}}</label>
                                                <input id="password" type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password" value="{{ old('password') }}">
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>{{__('Location')}}</label>
                                                <input id="location" type="text"
                                                    class="form-control @error('location') is-invalid @enderror"
                                                    name="location" value="{{ old('location') }}">
                                                @error('location')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-lg-6">
                                            <div class="">
                                                <label>{{__('Logo')}}</label>
                                                <input id="logo" type="file" onchange="readURL(this);"
                                                    class=" @error('logo') is-invalid @enderror" name="logo">
                                                    <p class="text-danger">*{{__('Please upload a .PNG file no larger then 2 MB')}}</p>

                                                @error('logo')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <img style="float: right" src="" alt="" id="imagePlacement">

                                        </div>

                                        <div class="col-lg-12 mt-5">
                                            <div class="form-group">
                                                <label>{{__('Form Questions')}}</label>
                                                <select multiple="multiple" id="" name="questions[]"
                                                    class="js-example-basic-multiple form-control form-select form-select-lg mb-3"
                                                    aria-label=".form-select-lg example">
                                                    @foreach ($questions as $question)
                                                        <option value="{{ $question->id }}">{{ $question->question }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>

                                        {{-- <div class="col-lg-6">
                                            <a href="{{route('question.create')}}" class="btn btn-primary mb-5">{{__('Create a new Form Question')}}</a>&nbsp;

                                        </div> --}}





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
<script type="text/javascript"
    src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=places"></script>
@section('pageSpecificJs')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        google.maps.event.addDomListener(window, 'load', initialize);

        function initialize() {
            var input = document.getElementById('location');
            var autocomplete = new google.maps.places.Autocomplete(input);

            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
            });
        }
    </script>
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


    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>
@endsection
