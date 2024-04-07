<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css">

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css"
        rel="stylesheet">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <title>Covarmed - Incident Report</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
        }
    </style>
</head>

<body>
    <div class="page-content-wrapper ">
        <div class="container">
            <div class="row ">
                <div class="col-12 ">
                    <div class="employe-name text-center mt-3">
                        <img src="https://covarmed.sfo3.cdn.digitaloceanspaces.com/logo.png" height="42"
                            alt="">
                        <p>Incident Report Export</p>
                    </div>
                    <hr>
                    <div class=" m-b-20 mt-3">
                        <div class="">
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
                                                <img src="{{ env('DO_CDN_ENDPOINT') }}/{{ $incident->kit->qr_image }}"
                                                    height="42" alt="">
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
                                    @foreach ($incident->questionAnswers as $questionAnswer)
                                        <?php
                                        $answersArray = json_decode($questionAnswer->answers, true);
                                        $contentArray = json_decode($questionAnswer->question->content, true);
                                        ?>
                                        <div class="row" style="">
                                            <div class="col-6">
                                                <div class="employee-name">
                                                    @if ($contentArray && is_array($contentArray))
                                                        @foreach ($contentArray as $key => $contentItem)
                                                            <p class="font-weight-bold">
                                                                {{ $contentItem['label'] ?? 'Label not found' }} &nbsp;
                                                                @if ($answersArray && is_array($answersArray))
                                                                    @if (is_array($answersArray['question_' . $key]))
                                                                        <p>{{ json_encode($answersArray['question_' . $key]) }}
                                                                        </p>
                                                                    @else
                                                                        <p>{{ $answersArray['question_' . $key] }}</p>
                                                                    @endif
                                                                @endif
                                                            </p>
                                                        @endforeach
                                                    @else
                                                        <p class="font-weight-bold">Label not found</p>
                                                    @endif
                                                </div>
                                            </div>
                                            {{-- <div class="col-6" style="display: flex">
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
                                            </div> --}}
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

</body>

</html>
