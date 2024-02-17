@extends('layouts.app')
@section('content')
    <div class="page-content-wrapper ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">{{__('Add a form question')}}</h4>
                            <p class="text-muted m-b-30 font-14"></p>
                            @if (Session::has('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ Session::get('success') }}
                                </div>
                            @endif
                            <div class="p-20">
                                <form action="{{ route('question.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>{{__('Question')}}</label>
                                                <textarea name="question" id="" class="form-control" cols="30" rows="2"
                                                    placeholder="{{__('Please fill in a question')}}"></textarea>
                                                     <div id="fb-editor"></div>
                                                @error('question')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                
                                            </div>
                                        </div>




                                       <!--  <div class="col-lg-12 text-center">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                    {{__('Submit')}}
                                                </button>
                                                <button type="reset" class="btn btn-secondary waves-effect m-l-5">
                                                    {{__('Cancel')}}
                                                </button>
                                            </div>
                                        </div> -->
                                </form>
                            </div>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div><!-- container-fluid -->


    </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
  <script src="{{ URL::asset('dashboard/assets/form-builder/form-builder.min.js') }}"></script>
<script>
    jQuery(function($) {
        $(document.getElementById('fb-editor')).formBuilder({
            onSave: function(evt, formData) {
                console.log(formData);
                saveForm(formData);
            },
        });
    });
function saveForm(form) {
    $.ajax({
        type: 'post',
        headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('token')
        },
        url: '{{ URL('/question') }}',
        data: {
            'form': form,
            'question': $("textarea[name='question']").val(), // Corrected to target by name attribute
            "_token": "{{ csrf_token() }}",
        },
        success: function(data) {
            location.href = "/questions";
            console.log(data);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

</script>
@endsection
