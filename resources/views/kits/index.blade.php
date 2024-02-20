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
                            <h4 class="mt-0 header-title">{{__('All First-aid Kits')}}</h4>
                            
                           <div class="d-flex justify-content-end">
                                <a href="{{route('kits.create')}}" class="btn btn-primary mb-5">{{__('Create a new First-Aid kit')}}</a>&nbsp;
                                <a href="{{route('export.kits')}}" class="btn btn-primary mb-5">{{__('Export First-aid Kits')}}</a>&nbsp;
                                <form action="{{ route('import.kits') }}" method="POST" enctype="multipart/form-data" >
                                    @csrf
                                    <input type="file" name="file" class="form-control-file" style="display: none;" id="importFile">
                                    <button type="button" class="btn btn-primary float-right" onclick="document.getElementById('importFile').click();">{{ __('Import First-aid Kits') }}</button>
                                </form>
                                
                            </div>
                           <table id="datatable" class="table table-bordered dt-responsive nowrap" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>

                                        <th>{{__('ID')}}</th>
                                        <th>{{__('Unique Code')}}</th>
                                        <th>{{__('Name')}}</th>
                                        <th>{{__('Company')}}</th>
                                        <th>{{__('Prevention Advisor')}}</th>
                                        <th>{{__('Status')}}</th>
                                        <th>{{__('Actions')}}</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach ($kits as $kit)
                                        <tr>
                                            <td>{{ $kit->id }}</td>
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
                                                <a href="{{route('kit.qr.download', $kit->id)}}" >
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
@section('pageSpecificJs')
<script>
    document.getElementById('importFile').addEventListener('change', function () {
        this.form.submit();
    });
</script>
@endsection
