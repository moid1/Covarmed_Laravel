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
                                <h4 class="header-title">{{__('All Companies')}}</h4>
                                <a href="{{route('company.create')}}" class="btn btn-primary mb-5">{{__('Create a new company')}}</a>
                            </div>
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>

                                        <th>{{__('Company Name')}}</th>
                                        <th>{{__('Location')}}</th>
                                        <th>{{__('Active PV')}}</th>
                                        <th>{{__('Active QRs')}}</th>
                                        <th>{{__('Status')}}</th>
                                        <th>{{__('Actions')}}</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach ($companiesWithTotalActiveKits as $company)
                                        <tr>
                                            <td>{{ $company['company_name'] }}</td>
                                            <td>{{ $company['location'] }}</td>
                                            <td>{{ $company['total_preventional_advisors'] }}</td>
                                            <td>{{ $company['total_active_kits'] }}</td>
                                            @if ($company['is_active'])
                                                <td> <span class="badge badge-primary">Active</span></td>
                                            @else
                                                <td> <span class="badge badge-warning">Deactive</span></td>
                                            @endif

                                                <td><a href="{{route('company.show', $company['id'])}}"> <i class="mdi mdi-eye"></i></a>
                                                    / <a style="text-decoration: none;color:blue" href="{{route('company.update.status', $company['id'])}}" title="Change Company Status"> <i class="mdi mdi-note"></i></a>
                                                    
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
