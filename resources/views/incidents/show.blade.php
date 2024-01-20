@extends('layouts.app')
@section('content')
    <div class="page-content-wrapper ">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-12 ">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <div class="user-details">
                                <h4 class="mt-0 header-title">User Details</h4>
                                <div class="p-20 ">
                                    <div class="row ">
                                        <div class="col-6">
                                            <div class="employe-name">
                                                <p class="font-weight-bold">Employee Name</p>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="employe-name">
                                                <p>{{ $incident->employee_name }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="employe-name">
                                                <p class="font-weight-bold">Preventional Advisor Name</p>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="employe-name">
                                                <p>{{ $incident->preventionAdvisor->user->name }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="employe-name">
                                                <p class="font-weight-bold">Company Name</p>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="employe-name">
                                                <p>{{ $incident->preventionAdvisor->company->name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            {{-- Kit details --}}

                            <div class="user-details">
                                <h4 class="mt-0 header-title">Kit Details</h4>
                                <div class="p-20 ">
                                    <div class="row ">
                                        <div class="col-6">
                                            <div class="employe-name">
                                                <p class="font-weight-bold">Name</p>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="employe-name">
                                                <p>{{ $incident->kit->name }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="employe-name">
                                                <p class="font-weight-bold">Code</p>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="employe-name">
                                                <p>{{ $incident->kit->unique_code }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="employe-name">
                                                <p class="font-weight-bold">QR Code</p>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="employe-name">
                                                <img src="{{ env('DO_CDN_ENDPOINT') }}/{{ $incident->kit->qr_image }}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            {{-- Questions Answers --}}

                            <div class="user-details">
                                <h4 class="mt-0 header-title">Questions & Answers </h4>
                                <div class="p-20 ">
                                    @foreach ($incident->questionAnswers as $question)
                                        <div class="row ">
                                            <div class="col-6">
                                                <div class="employe-name">
                                                    <p class="font-weight-bold">{{$question->question->question}}</p>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="employe-name">
                                                    <p>{{ $question->answers }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div><!-- container-fluid -->


    </div>
@endsection