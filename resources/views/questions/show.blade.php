@extends('layouts.app')

@section('content')
    <div class="page-content-wrapper ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">{{ __('Update a form question') }}</h4>
                            <p class="text-muted m-b-30 font-14"></p>
                            @if (Session::has('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ Session::get('success') }}
                                </div>
                            @endif
                            <div class="p-20">
                                <form action="{{ route('question.update') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <input type="hidden" name="question_id" value="{{$question->id}}">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="text_field">{{__('English Translation')}}</label>
                                                <input  class="form-control" value="{{$label}}" type="text" id="" name="eng_value">
                                            </div>
                                            <div class="form-group">
                                                <label for="text_field">{{__('Dutch Translation')}}</label>
                                                <input class="form-control" type="text" id="" value="{{$deValue}}" name="de_value">
                                            </div>
                                            <div class="form-group">
                                                <label for="text_field">{{__('French Translation')}}</label>
                                                <input class="form-control" type="text" value="{{$frValue}}" id="" name="fr_value">
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>

  
@endsection
