@extends('layouts.app')
@section('content')
    <div class="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">{{ __('Add a form') }}</h4>
                            <p class="text-muted m-b-30 font-14"></p>
                            @if (Session::has('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ Session::get('success') }}
                                </div>
                            @endif
                            <div class="p-20">
                                <form action="{{ route('question.store') }}" method="POST" id="questionForm">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="language">{{ __('Select Language') }}</label>
                                                <select class="form-control" id="language" name="language">
                                                    <option value="en">English</option>
                                                    <option value="fr">French</option>
                                                    <option value="nl">Netherlands</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-lg-12">
                                            <label for="name">{{__('Form Name')}}</label>
                                            <input type="text" name="form_name" class="form-control" id="form_name" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="language">{{ __('Select Company') }}</label>
                                                <select class="form-control" id="company" name="company">
                                                  @foreach ($companies as $company)
                                                    <option selected value="{{$company->id}}">{{$company->name}}</option>
                                                  @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="language">{{ __('Select Form If you want to add translation') }}</label>
                                                <select class="form-control" id="question_available" name="question_available">
                                                    <option value="" selected>Not Available</option>
                                                    @if(!empty($questions) && count($questions))
                                                        @foreach ($questions as $question)
                                                            <option value="{{ $question->id }}">{{ $question->question }}</option>
                                                        @endforeach
                                                    @endif


                                                </select>
                                            </div>
                                        </div>
                                    </div>



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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script src="{{ URL::asset('dashboard/assets/form-builder/form-builder.min.js') }}"></script>
    <script src="{{ URL::asset('dashboard/assets/form-builder/form-render.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            var formBuilderInstance = null;

            function loadFormBuilder(locale) {
                var options = {
                    i18n: {
                        locale: locale
                    },
                    onSave: function(evt, formData) {
                        saveForm(formData);
                    }
                };
                $('#fb-editor').empty();
                formBuilderInstance = $(document.getElementById('fb-editor')).formBuilder(options);
                setTimeout(removeLiElements, 1000);
            }

            function removeLiElements() {
                var ulElements = $('ul.frmb-control');
                ulElements.each(function() {
                    var liElements = $(this).find('li');
                    var indicesToRemove = [0, 1, 3, 4, 5, 6, 7, 8, 9, 12];
                    indicesToRemove.reverse();
                    for (var i = 0; i < indicesToRemove.length; i++) {
                        var index = indicesToRemove[i];
                        liElements.eq(index).remove();
                    }
                });
            }

            function saveForm(form) {
                if ($('#form_name').val().trim() === '') {
        alert('Please enter form name');
       return;
    }
                $.ajax({
                    type: 'post',
                    url: '{{ route('question.store') }}',
                    data: {
                        'form': form,
                        'language': $('#language').val(),
                        'question_available': $('#question_available').val(),
                        "_token": "{{ csrf_token() }}",
                        "company":$('#company').val(),
                        "form_name":$('#form_name').val(),
                    },
                    success: function(data) {
                        // Redirect or show success message
                        location.href = "/questions";
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        // Handle error
                    }
                });
            }

            $('#language').change(function() {
                var selectedLanguage = $(this).val();
                switch (selectedLanguage) {
                    case 'en':
                        loadFormBuilder('en-US');
                        break;
                    case 'fr':
                        loadFormBuilder('fr-FR');
                        break;
                    case 'nl':
                        loadFormBuilder('nl-NL');
                        break;
                    default:
                        loadFormBuilder('en-US');
                }
            });

            // Call the form builder loader function initially
            loadFormBuilder('en-US');

            // Call removeLiElements after a delay to ensure the form builder is fully loaded
        });
    </script>
@endsection
