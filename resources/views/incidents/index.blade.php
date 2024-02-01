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
                            <h4 class="mt-0 header-title">{{__('All Incidents')}}</h4>
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>

                                        <th>ID</th>
                                        <th>{{__('Company name')}}</th>
                                        <th>{{__('First-aid Kit Name')}}</th>
                                        <th>{{__('Prevention Advisor')}}</th>
                                        <th>{{__('Actions')}}</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach ($incidents as $incident)
                                        <tr>
                                            <td>{{ $incident->id }}</td>
                                            <td>{{ $incident->preventionAdvisor->company->name }}</td>
                                            <td>{{ $incident->kit->name }}</td>
                                            <td>{{ $incident->preventionAdvisor->user->name }}</td>
                                            <td><a href="{{route('incident.export', $incident->id)}}"><i class="mdi mdi-download text-primary"></i></a> / <a
                                                    href="{{ route('incident.show', $incident->id) }}"><i
                                                        class="mdi mdi-eye"></i></a></td>
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
