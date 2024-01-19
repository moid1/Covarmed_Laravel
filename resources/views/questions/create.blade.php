@extends('layouts.app')
@section('content')
    <div class="page-content-wrapper ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">Add Questions Here</h4>
                            <p class="text-muted m-b-30 font-14"></p>
                            @if (Session::has('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ Session::get('success') }}
                                </div>
                            @endif
                            <div class="p-20">
                                <form action="{{ route('company.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Question</label>
                                                <input id="question" type="text"
                                                    class="form-control @error('question') is-invalid @enderror" name="question"
                                                    value="{{ old('question') }}" autofocus>
                                                @error('question')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
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

