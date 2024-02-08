@extends('layouts.app')
@section('content')
    <div class="page-content-wrapper ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">{{__('Add First-aid Kit')}}</h4>
                            @if (Session::has('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ Session::get('success') }}
                                </div>
                            @endif
                            <div class="p-20">
                                <p class="font-weight-bold">{{__('First-aid Kit Details')}}</p>
                                <form action="{{ route('kits.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <input type="hidden" name="qr_image" value="{{ $qrCodeFilePath }}">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>{{__('Unique ID')}}</label>
                                                <input id="unique_code" type="text"
                                                    class="form-control @error('unique_code') is-invalid @enderror"
                                                    name="unique_code" value="{{ $unique_code }}" autofocus readonly>
                                                @error('unique_code')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>{{__('Company')}}</label>
                                                <select id="" name="company"
                                                    class="form-control form-select form-select-lg mb-3"
                                                    aria-label=".form-select-lg example"
                                                    onchange="updatePreventionalAdvisors(this.value)">
                                                    <option value="" selected>{{__('Please select a company')}}
                                                    </option>
                                                    @foreach ($companies as $company)
                                                        <option value="{{ $company->id }}">
                                                            {{ ucfirst($company->name) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 " id="preventionalAdvisorSelection">
                                            <div class="form-group">
                                                <label>{{__('Prevention Advisors')}}</label>
                                                <select id="sss" name="prevention_advisor_id"
                                                    class="form-control form-select form-select-lg mb-3"
                                                    aria-label=".form-select-lg example">
                                                    <option value="" selected>{{__('Please select a prevention advisor')}}
                                                    </option>
                                                   
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>{{__('Name')}}</label>
                                                <input id="" type="text"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="" autofocus>
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div> 
                                        <div class="col-lg-12">
                                            <p class="font-weight-bold">{{__('Location')}}</p>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>{{__('Address')}}</label>
                                                <input id="autocomplete" type="text"
                                                    class="form-control @error('address_1') is-invalid @enderror"
                                                    name="address_1" value="" autofocus>
                                                @error('address_1')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-lg-12 mt-5">
                                            <p>QR Code</p>
                                            <img src="{{ env('DO_CDN_ENDPOINT') }}/{{ $qrCodeFilePath }}" alt="">
                                        </div>


                                        <div class="col-lg-12 text-center">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                    {{__('Submit')}}
                                                </button>
                                                <button type="reset" class="btn btn-secondary waves-effect m-l-5">
                                                    {{__('Cancel')}}
                                                </button>
                                            </div>
                                        </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div><!-- container-fluid -->


    </div>
@endsection
<script type="text/javascript"
src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=places" ></script>
@section('pageSpecificJs')
<script>
    google.maps.event.addDomListener(window, 'load', initialize);

    function initialize() {
        var input = document.getElementById('autocomplete');
        var autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.addListener('place_changed', function () {
            var place = autocomplete.getPlace();
        });
    }
</script>
    <script>
        function updatePreventionalAdvisors(companyId) {
            // Make an AJAX request to fetch data for the selected year
            // Replace 'your-api-endpoint' with the actual endpoint to retrieve data based on the selected year
            fetch(`/preventional-advisors/${companyId}`)
                .then(response => response.json())
                .then(data => {
                    $('#preventionalAdvisorSelection').removeClass('d-none')
                    const selectElement = document.getElementById('sss');

                    // Check if the select element exists
                    if (selectElement) {
                        // Clear existing options
                        selectElement.innerHTML = '';

                        // Add new options based on the data received
                        data.forEach(preventionAdvisor => {
                            const option = document.createElement('option');
                            option.value = preventionAdvisor.id;
                            option.text = preventionAdvisor.user.name;
                            selectElement.appendChild(option);
                        });
                    } else {
                        console.error('Select element not found.');
                    }
                })
                .catch(error => console.error('Error fetching data:', error));
        }
    </script>
@endsection
