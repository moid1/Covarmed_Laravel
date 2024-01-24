@extends('layouts.app')
@section('content')
<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card m-b-20">
                    <div class="card-body">
                        <div class="w-100 d-flex" style="justify-content: space-between">
                            <h4 class="mt-0 header-title">Kit Details</h4>
                           
                        </div>

                        @if (Session::has('success'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('success') }}
                        </div>
                        @endif
                        <div class="p-20">

                            <input type="hidden" name="kit_id" value="{{$kit->id}}">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Company Name</label>
                                        <input id="company" type="text"
                                            class="form-control @error('company') is-invalid @enderror" name="company"
                                            value="{{ $kit->preventionAdvisor->company->name }}" autofocus readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Unique ID</label>
                                        <input id="unique_code" type="text"
                                            class="form-control @error('unique_code') is-invalid @enderror"
                                            name="unique_code" value="{{ $kit->unique_code }}" autofocus readonly>
                                        @error('unique_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input id="" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{$kit->name}}" autofocus readonly>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input id="autocomplete" type="text"
                                            class="form-control @error('address_1') is-invalid @enderror"
                                            name="address_1" value="{{$kit->address_1}}" autofocus readonly>
                                        @error('address_1')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>





                                <div class="col-lg-12 mt-5">
                                    <p>Here is your QR code for the KIT</p>
                                    <img src="{{ env('DO_CDN_ENDPOINT') }}/{{ $kit->qr_image }}" alt="">
                                </div>


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
    <script>
        google.maps.event.addDomListener(window, 'load', initialize);

    function initialize() {
        var input = document.getElementById('autocomplete');
        var autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.addListener('place_changed', function () {
            var place = autocomplete.getPlace();
        });
    }
    </script>
    @endsection