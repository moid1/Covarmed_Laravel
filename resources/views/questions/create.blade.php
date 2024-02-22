@extends('layouts.app')

@section('content')
    <div class="page-content-wrapper ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">{{ __('Add a form question') }}</h4>
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

                                                <div id="fb-editor"></div>
                                                @error('question')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

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
    <script src="{{ URL::asset('dashboard/assets/form-builder/form-builder.min.js') }}"></script>

    <script>
        jQuery(function($) {
            $(document.getElementById('fb-editor')).formBuilder({
                onSave: function(evt, formData) {
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
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function removeLiElements() {
            var ulElements = document.querySelectorAll('ul.frmb-control');
            ulElements.forEach(function(ulElement) {
                var liElements = ulElement.getElementsByTagName('li');
                var indicesToRemove = [0, 1, 3, 4, 5, 6, 7, 8, 9, 12];
                for (var i = indicesToRemove.length - 1; i >= 0; i--) {
                    var index = indicesToRemove[i];
                    ulElement.removeChild(liElements[index]);
                }
            });
        }

        setTimeout(removeLiElements, 1000);
    </script>
@endsection
