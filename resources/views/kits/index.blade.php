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
                            <h4 class="mt-0 header-title">All Kits</h4>
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>

                                        <th>ID</th>
                                        <th>Unique Code</th>
                                        <th>Name</th>
                                        <th>Company</th>
                                        <th>Prevention Advisor</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach ($kits as $kit)
                                        <tr>
                                            <td>10000{{ $kit->id }}</td>
                                            <td>{{ $kit->unique_code }}</td>
                                            <td>{{ $kit->name }}</td>
                                            <td>{{ $kit->preventionAdvisor->company->name }}</td>
                                            <td>{{ $kit->preventionAdvisor->user->name }}</td>
                                            @if($kit->is_active)
                                                <td><span class="badge badge-primary">Active</span></td>
                                            @else
                                                <td><span class="badge badge-secondary">In-Active</span></td>
                                            @endif
                                            <td><a href="{{route('kits.show', $kit->id)}}"> <i class="mdi mdi-eye"></i></a> /
                                                <a href="{{ env('DO_CDN_ENDPOINT') . '/' . $kit->qr_image }}" target="_blank" download>
                                                    <i class="fa fa-qrcode"></i>
                                                </a>
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
