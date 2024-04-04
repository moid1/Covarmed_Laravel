@extends('layouts.app')

@section('content')
    <div class="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @if (Session::has('success'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                </div>
            </div>

        </div><!-- container-fluid -->
    </div>

    <div class="page-content-wrapper mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">@lang('All forms')</h4>
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('question.create') }}"
                                    class="btn btn-primary mb-5">@lang('Create a new Form Question')</a>&nbsp;
                                <a href="{{ route('translations.create') }}"
                                    class="btn btn-primary mb-5">@lang('Add Translation')</a>
                            </div>
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>@lang('Question')</th>
                                        <th>@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($questions as $question)
                                        <?php
                                        // Decode English content
                                        $contentArray = json_decode($question->content, true);
                                        
                                        $label = 'N/A';
                                        if (!empty($contentArray)) {
                                            $label = $contentArray[0]['label'];
                                        }
                                        
                                        // // Decode Dutch (nl) content
                                        // $nlContentArray = ($question->content_nl);
                                        // if (!empty($nlContentArray)) {
                                        //     $label = $nlContentArray[0]['label'];
                                        // }
                                        
                                        // $frContentArray = ($question->content_fr);
                                        // if (!empty($frContentArray)) {
                                        //     $label = $frContentArray[0]['label'];
                                        // }
                                        ?>

                                        <tr>
                                            <td>{{ $question->id }}</td>
                                            <td>{{ $label }}</td>
                                            <td>
                                                <a href="{{ route('question.delete', $question->id) }}"><i
                                                        class="mdi mdi-delete" style="color: red"></i></a>/
                                                <a href="{{ route('question.show', $question->id) }}"><i
                                                        class="fa fa-edit"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- container-fluid -->
    </div>
@endsection
