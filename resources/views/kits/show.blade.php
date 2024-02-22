@extends('layouts.app')
@section('content')
    <div class="page-content-wrapper ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <div class="w-100 d-flex" style="justify-content: space-between">
                                <h4 class="mt-0 header-title">{{__('Update First-aid Kit')}}</h4>
                                <a href="{{ route('kits.status', $kit->id) }}"
                                    class="btn btn-primary mb-3">{{ $kit->is_active ? 'Inactive Kit' : 'Active Kit' }} </a>
                            </div>

                            @if (Session::has('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ Session::get('success') }}
                                </div>
                            @endif
                            <div class="p-20">
                                <form action="{{ route('kits.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="kit_id" value="{{ $kit->id }}">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>{{__('Company Name')}}</label>
                                                <input id="company" type="text"
                                                    class="form-control @error('company') is-invalid @enderror"
                                                    name="company" value="{{ $kit->preventionAdvisor->company->name }}"
                                                    autofocus readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>{{__('Unique ID')}}</label>
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

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>{{__('Prevention Advisors')}}</label>
                                                <select id="" name="prevention_advisor_id"
                                                    class="form-control form-select form-select-lg mb-3"
                                                    aria-label=".form-select-lg example">

                                                    @foreach ($preventionAdvisors as $preventionAdvisor)
                                                        <option value="{{ $preventionAdvisor->id }}"
                                                            {{ $preventionAdvisor->id == $kit->prevention_advisor_id ? 'selected' : '' }}>
                                                            {{ ucfirst($preventionAdvisor->user->name) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>{{__('Name')}}</label>
                                                <input id="" type="text"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="{{ $kit->name }}" autofocus>
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>{{__('Address')}}</label>
                                                <input id="autocomplete" type="text"
                                                    class="form-control @error('address_1') is-invalid @enderror"
                                                    name="address_1" value="{{ $kit->address_1 }}" autofocus>
                                                @error('address_1')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>



                                        <div class="w-100">
                                            <div class="text-left">
                                            <div class="col-lg-12">
                                                <p>QR Code</p>
                                                <img src="{{ env('DO_CDN_ENDPOINT') }}/{{ $kit->qr_image }}"
                                                    alt="">
                                            </div>
                                            <a href="{{ route('kit.qr.download', $kit->id) }}"
                                                class=" btn btn-success mt-3 ml-5">{{__('Download')}}</a>
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

<script type="text/javascript"
    src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=places"></script>
@section('pageSpecificJs')
    <script>
        google.maps.event.addDomListener(window, 'load', initialize);

        function initialize() {
            var input = document.getElementById('autocomplete');
            var autocomplete = new google.maps.places.Autocomplete(input);

            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
            });
        }
    </script>
@endsection
