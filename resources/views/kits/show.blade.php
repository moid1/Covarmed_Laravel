@extends('layouts.app')
@section('content')
    <div class="page-content-wrapper ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">Update Kit</h4>
                            @if (Session::has('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ Session::get('success') }}
                                </div>
                            @endif
                            <div class="p-20">
                                <form action="{{ route('kits.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="kit_id"  value="{{$kit->id}}">
                                    <div class="row">
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
                                                <label>Prevention Advisors</label>
                                                <select id="" name="prevention_advisor_id"
                                                    class="form-control form-select form-select-lg mb-3"
                                                    aria-label=".form-select-lg example">
                                                    
                                                    @foreach ($preventionAdvisors as $preventionAdvisor)
                                                        <option
                                                            value="{{ $preventionAdvisor->id }}"  {{ $preventionAdvisor->id == $kit->prevention_advisor_id ? 'selected' : '' }}>
                                                            {{ ucfirst($preventionAdvisor->user->name) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input id="" type="text"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="{{$kit->name}}" autofocus>
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
                                                <input id="" type="text"
                                                    class="form-control @error('address_1') is-invalid @enderror"
                                                    name="address_1" value="{{$kit->address_1}}" autofocus>
                                                @error('address_1')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>City</label>
                                                <input id="" type="text"
                                                    class="form-control @error('city') is-invalid @enderror" name="city"
                                                    value="{{$kit->city}}" autofocus>
                                                @error('city')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Postal Code</label>
                                                <input id="" type="text"
                                                    class="form-control @error('postal_code') is-invalid @enderror"
                                                    name="postal_code" value="{{$kit->postal_code}}" autofocus>
                                                @error('postal_code')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Country</label>
                                                <input id="" type="text"
                                                    class="form-control @error('country') is-invalid @enderror"
                                                    name="country" value="{{$kit->country}}" autofocus>
                                                @error('country')
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


                                        <div class="col-lg-12 text-center">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                    Submit
                                                </button>
                                                <button type="reset" class="btn btn-secondary waves-effect m-l-5">
                                                    Cancel
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
