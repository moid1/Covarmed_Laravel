@extends('layouts.app')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">
                <div class="col-md-6 col-lg-6 col-xl-4">
                    <div class="mini-stat clearfix bg-primary">
                        <span class="mini-stat-icon"><i class="mdi mdi-account"></i></span>
                        <div class="mini-stat-info text-right text-white">
                            <span class="counter">{{ $dashboardStats['totalPreventionalAdvisors'] }}</span>
                            Total Prevention Advisors
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-4">
                    <div class="mini-stat clearfix bg-primary">
                        <span class="mini-stat-icon"><i class="mdi mdi-hospital"></i></span>
                        <div class="mini-stat-info text-right text-white">
                            <span class="counter">{{ $dashboardStats['totalKits'] }}</span>
                            Total Kits
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-4">
                    <div class="mini-stat clearfix bg-primary">
                        <span class="mini-stat-icon"><i class="mdi mdi-file"></i></span>
                        <div class="mini-stat-info text-right text-white">
                            <span class="counter">{{ $dashboardStats['totalIncidents'] }}</span>
                            Total Incidents
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <div style="margin: auto;">
                                <select class="" name="year" id="year" style="float: right"
                                    onchange="updateChart(this.value)">
                                    <!-- Populate dropdown with available years -->
                                    @foreach ($distinctYears as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>

                                <canvas id="barChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <select style="width: 20%" class="form-control " name="companies" id="companies"
                                style="float: right" onchange="updatePieChart(this.value)">
                                <option value="" disabled selected>Company</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                            <div style="width: 50%; margin: auto;">

                                <canvas id="pieChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <h4 class="mt-0 m-b-15 header-title">Recent Users</h4>
                            <div class="table-responsive">
                                <table class="table table-hover m-b-0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        @foreach ($preventionalAdvisors as $preventionalAdvisor)
                                            <tr>
                                                <td>{{ $preventionalAdvisor->user->name }}</td>
                                                <td>{{ $preventionalAdvisor->user->email }}</td>
                                            </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- end row -->

        </div><!-- container-fluid -->


    </div>
@endsection

@section('pageSpecificJs')
    <script>
        var ctx = document.getElementById('barChart').getContext('2d');
        var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($data['labels']),
                datasets: [{
                    label: 'Total Reports',
                    data: @json($data['data']),
                    backgroundColor: 'rgba(17, 145, 194, 0.6)',
                    borderColor: 'rgba(33, 66, 106, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        function updateChart(selectedYear) {
            // Make an AJAX request to fetch data for the selected year
            // Replace 'your-api-endpoint' with the actual endpoint to retrieve data based on the selected year
            fetch(`/chart-filter/${selectedYear}`)
                .then(response => response.json())
                .then(data => {
                    // Update chart labels and data
                    myBarChart.data.labels = data.labels;
                    myBarChart.data.datasets[0].data = data.data;

                    // Update the chart
                    myBarChart.update();
                })
                .catch(error => console.error('Error fetching data:', error));
        }
    </script>

    <script>
        var ctx = document.getElementById('pieChart').getContext('2d');
        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: @json($pieChartData['labels']),
                datasets: [{
                    data: @json($pieChartData['data']),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                    ],
                    borderWidth: 1
                }]
            },
        });

        function updatePieChart(companyId) {
            // Make an AJAX request to fetch data for the selected year
            // Replace 'your-api-endpoint' with the actual endpoint to retrieve data based on the selected year
            fetch(`/pie-chart-filter/${companyId}`)
                .then(response => response.json())
                .then(data => {
                    // Update chart labels and data
                    myPieChart.data.labels = data.labels;
                    myPieChart.data.datasets[0].data = data.data;

                    // Update the chart
                    myPieChart.update();
                })
                .catch(error => console.error('Error fetching data:', error));
        }
    </script>
@endsection
