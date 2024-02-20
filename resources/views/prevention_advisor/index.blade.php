@extends('layouts.app')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

@section('content')
<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if (Session::has('success'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('success') }}
                </div>
                @endif
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div><!-- container-fluid -->
</div>



{{-- DATATABLE --}}


<div class="page-content-wrapper mt-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card m-b-20">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4 class="header-title">{{__('All Prevention Advisors')}}</h4>
                            <a href="{{route('prevention.advisor.create')}}" class="btn btn-primary mb-5">{{__('Create a new advisor')}}</a>
                        </div>
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>

                                    <th>{{__('ID')}}</th>
                                    <th>{{__('Name')}}</th>
                                    <th>{{__('Company Name')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th>{{__('Actions')}}</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($preventionAdvisors as $preventionAdvisor)
                                <tr>
                                    <td>{{ $preventionAdvisor->id }}</td>
                                    <td>{{ $preventionAdvisor->user->name }}</td>
                                    <td>{{ $preventionAdvisor->company->name ?? 'N/A' }}</td>
                                    <td><span class="badge badge-primary">Active</span></td>
                                    <td><a href="{{route('prevention.advisor.show', $preventionAdvisor->id)}}"> <i class="mdi mdi-eye"></i> </a> / <a href="{{route('prevention.advisor.delete', $preventionAdvisor->id)}}" class="text-red"
                                            style="text-decoration: none;color:red"> <i class="fa fa-trash "></i></a>
                                    </td>
                                </tr>
                                @endforeach


                            </tbody>
                        </table>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div><!-- container-fluid -->
</div>
@endsection