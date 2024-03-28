@extends('layouts.app')

@section('content')
    <div class="page-content-wrapper">
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
                                                <label for="language">{{ __('Select Language') }}</label>
                                                <select  class="form-control" id="language" name="language">
                                                    <option value="en">English</option>
                                                    <option value="fr">French</option>
                                                    <option value="nl">Netherland</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" id="saveData">Save</button>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script src="{{ URL::asset('dashboard/assets/form-builder/form-builder.min.js') }}"></script>
    <script src="{{ URL::asset('dashboard/assets/form-builder/form-render.min.js') }}"></script>

    <script>
    jQuery.noConflict();

    jQuery(function($) {
        var formBuilderInstance = null;

        function loadFormBuilder(locale) {
            var options = {
                i18n: {
                    locale: locale
                }
            };
            $('#fb-editor').empty();
            formBuilderInstance = $(document.getElementById('fb-editor')).formBuilder(options);
                        // Integration with onSave callback
            formBuilderInstance.on('save', function(formData) {
                saveForm(formData);
            });
            return formBuilderInstance;
        }

        function initializeFormBuilder() {
            loadFormBuilder('en-US');

            $('#language').change(function() {
                var selectedLanguage = $(this).val();
                switch (selectedLanguage) {
                    case 'en':
                        loadFormBuilder('en-US');
                        break;
                    case 'fr':
                        loadFormBuilder('fr-FR');
                        break;
                    case 'de':
                        loadFormBuilder('nl-NL');
                        break;
                    default:
                        loadFormBuilder('en-US');
                }
            });

    //         document
    // .getElementById("saveData")
    // .addEventListener("click", () => formBuilder.actions.save());



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

            setTimeout(removeLiElements, 1000);
        }

        initializeFormBuilder();

        function saveForm(form) {
            $.ajax({
                type: 'post',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                },
                url: '/question',
                data: {
                    'form': JSON.stringify(form),
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
    });
</script>

@endsection

