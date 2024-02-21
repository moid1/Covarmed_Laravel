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
                            <a href="#" class="btn btn-secondary float-right" id="downloadButton">{{__('Download Sample File')}}</a>
                           <a href="{{route('export.kits')}}" class="btn btn-primary float-right">{{__('Export First-aid Kits')}}</a>
                           <form action="{{ route('import.kits') }}" method="POST" enctype="multipart/form-data" >
                                @csrf
                                <input type="file" name="file" class="form-control-file" style="display: none;" id="importFile">
                                <button type="button" class="btn btn-primary float-right" onclick="document.getElementById('importFile').click();">{{ __('Import First-aid Kits') }}</button>
                                
                            </form>
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
<script>
document.getElementById('downloadButton').addEventListener('click', function() {
    // Create an anchor element
    var link = document.createElement('a');
    // Set the href attribute to the URL of your sample Excel file
    link.href = '{{asset('kits.xlsx')}}';
    // Set the download attribute to prompt the browser to download the file instead of navigating to it
    link.download = 'kits.xlsx';
    // Append the anchor element to the document body
    document.body.appendChild(link);
    // Trigger a click event on the anchor element to start the download
    link.click();
    // Clean up by removing the anchor element from the document body
    document.body.removeChild(link);
});
</script>
@endsection
