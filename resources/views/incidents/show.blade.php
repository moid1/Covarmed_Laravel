@extends('layouts.app')
@section('content')
    <div class="page-content-wrapper ">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-12 ">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <p class="font-weight-bold">{{ $incident->created_at }}</p>
                            <div class="text-right">
                                <a class="btn btn-primary" href="{{ route('incident.export', $incident->id) }}">Export</a>
                            </div>
                            <div class="user-details">
                                <h4 class="mt-0 header-title">{{ __('User Details') }}</h4>
                                <div class="p-20 ">
                                    <div class="row ">
                                        <div class="col-6">
                                            <div class="employe-name">
                                                <p class="font-weight-bold">{{ __('Employee Name') }}</p>
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
                                                <p class="font-weight-bold">{{ __('Preventional Advisor Name') }}</p>
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
                                                <p class="font-weight-bold">{{ __('Company Name') }}</p>
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
                                <h4 class="mt-0 header-title">{{ __('First-aid Kit Details') }}</h4>
                                <div class="p-20 ">
                                    <div class="row ">
                                        <div class="col-6">
                                            <div class="employe-name">
                                                <p class="font-weight-bold">{{ __('Name') }}</p>
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
                                                <p class="font-weight-bold">{{ __('Code') }}</p>
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
                                                <img src="{{ env('DO_CDN_ENDPOINT') }}/{{ $incident->kit->qr_image }}"
                                                    alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            {{-- Questions Answers --}}

                            <div class="user-details">
                                <h4 class="mt-0 header-title">{{ __('Questions & Answers') }} </h4>
                                <div class="p-20 ">

                                    @foreach ($incident->questionAnswers as $questionAnswer)
                                        <?php
                                        $answersArray = json_decode($questionAnswer->answers, true);
                                        $contentArray = json_decode($questionAnswer->question->content, true);
                                        ?>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="employee-name">
                                                    @if ($contentArray && is_array($contentArray))
                                                        @foreach ($contentArray as $contentItem)
                                                            <p class="font-weight-bold">
                                                                {{ $contentItem['label'] ?? 'Label not found' }}</p>
                                                        @endforeach
                                                    @else
                                                        <p class="font-weight-bold">Label not found</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="employee-name">
                                                    @if ($answersArray && is_array($answersArray))
                                                        @foreach ($answersArray as $answer)
                                                            @if (is_array($answer))
                                                                <p>{{ json_encode($answer) }}</p>
                                                            @else
                                                                <p>{{ $answer }}</p>
                                                            @endif
                                                        @endforeach
                                                    @endif
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
