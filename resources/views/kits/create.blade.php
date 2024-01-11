@extends('layouts.app')
@section('content')
    <div class="page-content-wrapper ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">Create Kit</h4>
                            @if (Session::has('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ Session::get('success') }}
                                </div>
                            @endif
                            <div class="p-20">
                                <form action="{{ route('kits.store') }}" method="POST"
                                  >
                                    @csrf
                                    <div class="row">
                                        <input type="hidden" name="qr_image" value="{{$qrCodeFilePath}}">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Unique ID</label>
                                                <input id="unique_code" type="text"
                                                    class="form-control @error('unique_code') is-invalid @enderror"
                                                    name="unique_code" value="{{ $unique_code }}" autofocus readonly>
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
                                                    <option value="" selected>Please select Prevention Advisor
                                                    </option>
                                                    @foreach ($preventionAdvisors as $preventionAdvisor)
                                                        <option value="{{ $preventionAdvisor->id }}">
                                                            {{ ucfirst($preventionAdvisor->name) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mt-5">
                                            <p>Here is your QR code for the KIT</p>
                                            <img src="{{ env('DO_CDN_ENDPOINT') }}/{{ $qrCodeFilePath }}" alt="">
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
