@extends('layouts.app')

@section('content')
    <div class="page-content-wrapper ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">{{ __('Add a Translation') }}</h4>
                            <p class="text-muted m-b-30 font-14"></p>
                            @if (Session::has('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ Session::get('success') }}
                                </div>
                            @endif
                            <div class="p-20">

                                <form method="POST" action="{{ route('translations.store') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="text_field">KEY</label>
                                                <input class="form-control" type="text" id="data" name="data">
                                            </div>
                                            <div class="form-group">
                                                <label for="text_field">Value</label>
                                                <input class="form-control" type="text" id="" name="value">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="language">Select Language:</label>
                                                <select class="form-control" id="language" name="language">
                                                    <option value="de">Dutch</option>
                                                    <option value="fr">French</option>
                                                </select>

                                            </div>
                                        </div>
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
