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
                                        <th>@lang('Form Name')</th>
                                        <th>@lang('Company Name')</th>
                                        <th>@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($companies as $company)
                                        @if (!empty($company->question))
                                            <tr>
                                                <td>{{ $company->question ? $company->question->question : 'N/A' }}</td>
                                                <td>{{ $company->name ?? 'N/A' }}</td>
                                                <td>
                                                    <a href="{{ route('question.delete', $company->id) }}"><i
                                                            class="mdi mdi-delete" style="color: red"></i></a> /

                                                            <a href="{{ route('question.show', $company->question->id) }}"><i
                                                                class="mdi mdi-eye" ></i></a>
                                                </td>
                                            </tr>
                                        @endif
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
