@extends('layouts.app')
@section('content')
    <div class="page-content-wrapper ">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-12 ">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <p class="font-weight-bold">{{$incident->created_at}}</p>
                            <div class="text-right">
                                <a class="btn btn-primary" href="{{route('incident.export', $incident->id)}}">Export</a>
                            </div>
                            <div class="user-details">
                                <h4 class="mt-0 header-title">{{__('User Details')}}</h4>
                                <div class="p-20 ">
                                    <div class="row ">
                                        <div class="col-6">
                                            <div class="employe-name">
                                                <p class="font-weight-bold">{{__('Employee Name')}}</p>
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
                                                <p class="font-weight-bold">{{__('Preventional Advisor Name')}}</p>
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
                                                <p class="font-weight-bold">{{__('Company Name')}}</p>
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
                                <h4 class="mt-0 header-title">{{__('First-aid Kit Details')}}</h4>
                                <div class="p-20 ">
                                    <div class="row ">
                                        <div class="col-6">
                                            <div class="employe-name">
                                                <p class="font-weight-bold">{{__('Name')}}</p>
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
                                                <p class="font-weight-bold">{{__('Code')}}</p>
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
                                <h4 class="mt-0 header-title">{{__('Questions & Answers')}} </h4>
                                <div class="p-20 ">
                                    @foreach ($incident->questionAnswers as $question)
                                        <div class="row ">
                                            <div class="col-6">
                                                <div class="employe-name">
    <?php
    // Decode the JSON string into an array
    $contentArray = json_decode($question->question->content, true);

    // Check if decoding was successful and the array is not empty
    if ($contentArray && is_array($contentArray) && !empty($contentArray)) {
        // Access the "label" attribute of the first object in the array
        $label = $contentArray[0]['label'];

        // Output the label
        echo '<p class="font-weight-bold">' . $label . '</p>';
    } else {
        // Handle case where decoding failed or array is empty
        echo '<p class="font-weight-bold">Label not found</p>';
    }
    ?>
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
