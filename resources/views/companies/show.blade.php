@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@section('content')
    <div class="page-content-wrapper ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">{{ __('Update Company Here') }}</h4>
                            <p class="text-muted m-b-30 font-14">{{ __('Fill This instructions Carefully') }}.</p>
                            @if (Session::has('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ Session::get('success') }}
                                </div>
                            @endif
                            <div class="p-20">
                                <form action="{{ route('company.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <input type="hidden" name="company_id" id="" value="{{ $company->id }}">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>{{ __('Name') }}</label>
                                                <input id="name" type="text"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="{{ $company->name }}" autofocus>
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>



                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>{{ __('Password') }}</label>
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
                                                <label>{{ __('Location') }}</label>
                                                <input id="location" type="text"
                                                    class="form-control @error('location') is-invalid @enderror"
                                                    name="location" value="{{ $company->location }}">
                                                @error('location')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-lg-6">
                                            <div class="">
                                                <label>{{ __('Logo') }}</label>
                                                <input id="logo" type="file" onchange="readURL(this);"
                                                    class=" @error('logo') is-invalid @enderror" name="logo">

                                                @error('logo')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="col-lg-3 offset-md-3">
                                            <img class="img-fluid" style="float: right"
                                                src="{{ env('DO_CDN_ENDPOINT') . '/' . $company->logo }}" alt=""
                                                id="imagePlacement">

                                        </div>

                                        <div class="col-lg-12 mt-5">
                                            <div class="form-group">
                                                <label>{{ __('Form Questions') }}</label>
                                                <select name="question" class="form-control">
                                                    @foreach ($questions as $question)
                                                    <option value="{{ $question->id }}">
                                                        {{ $question->question }}
                                                    </option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>

                                        {{-- @php
                                            $alreadySelectedQuestions = explode(',', $company->questions);
                                        @endphp --}}

                                        {{-- <div class="col-lg-12 mt-5">
                                            <div class="form-group">
                                                <label>{{__('Form Questions')}}</label>
                                                <select multiple="multiple" id="mySelect2" name="questions[]"
                                                    class="js-example-basic-multiple form-control form-select form-select-lg mb-3"
                                                    aria-label=".form-select-lg example">
                                                    @foreach ($questions as $question)
                                                    $contentArray = json_decode($question->content, true);
                                                    if ($contentArray && is_array($contentArray) && !empty($contentArray)) {
                                                        foreach ($contentArray as $key => $labels) {
                                                            # code...
                                                        }
                                                        $label = $labels['label'];
                                                    }
                                                        <option value="{{ $question->id }}"
                                                            {{ in_array($question->id, $alreadySelectedQuestions) ? 'selected' : '' }}>
                                                            {{ $label }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div> --}}

                                        {{-- <div class="col-lg-6">
                                            <a href="{{ route('question.create') }}"
                                                class="btn btn-primary mb-5">{{ __('Create a new Form Question') }}</a>&nbsp;

                                        </div> --}}





                                        <div class="col-lg-12 text-center">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                    {{ __('Submit') }}
                                                </button>
                                                <button type="reset" class="btn btn-secondary waves-effect m-l-5">
                                                    {{ __('Cancel') }}
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
            $('#mySelect2').find(':selected');
        });
    </script>
@endsection
