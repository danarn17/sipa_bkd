@extends('layouts.app')
@section('title')
    Dashboard Pencairan
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">DASHBOARD</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>TAHUN</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <select class="form-control" id="filterTahun" required>
                                    @foreach ($years as $year)

                                        <option value="{{ $year->year }}">{{ $year->year }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        {{-- <div class="card-header">
                            <h4>TRIWULAN 1</h4>
                        </div> --}}
                        <div class="card-body" style="height: 350px">
                            <canvas id="triwulan_1"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        {{-- <div class="card-header">
                            <h4>TRIWULAN 2</h4>
                        </div> --}}
                        <div class="card-body" style="height: 350px">
                            <canvas id="triwulan_2"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        {{-- <div class="card-header">
                            <h4>TRIWULAN 3</h4>
                        </div> --}}
                        <div class="card-body" style="height: 350px">
                            <canvas id="triwulan_3"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        {{-- <div class="card-header">
                            <h4>TRIWULAN 4</h4>
                        </div> --}}
                        <div class="card-body" style="height: 350px">
                            <canvas id="triwulan_4"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/chart.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            var year = $("#filterTahun").val();
            $("#filterTahun").change(function() {
                var val = this.value;
                ajax_chart(val);
            });
            ajax_chart(year);
        });

        function ajax_chart(tahun) {
            $.ajax({
                url: '{{ url()->current() }}',
                type: 'GET',
                data: {
                    tahun: tahun
                },
                success: function(data) {
                    // console.log(JSON.parse(data));
                    make_chart(data);
                }
            });
        }

        function make_chart(data) {
            let dataset_json = JSON.parse(data);

            var ctx = document.getElementById("triwulan_1").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: dataset_json.triwulan_1.data,
                        backgroundColor: [
                            '#0e0e52',
                            '#0683D7',
                        ],
                        label: 'Triwulan 1'
                    }],
                    labels: dataset_json.triwulan_1.label,
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'TRIWULAN 1',
                        fontColor: '#6777ef',
                        fontStyle: 'bold',
                        fontSize: 20
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                var dataLabel = data.labels[tooltipItem.index];
                                var value = ': Rp. ' + data.datasets[tooltipItem.datasetIndex].data[tooltipItem
                                    .index].toString().replace(/\B(?=(\d{3})+(?!\d))/g,
                                    ".");
                                if (Chart.helpers.isArray(dataLabel)) {
                                    dataLabel = dataLabel.slice();
                                    dataLabel[0] += value;
                                } else {
                                    dataLabel += value;
                                }
                                return dataLabel;
                            }
                        }
                    }
                }
            });
            var ctx = document.getElementById("triwulan_2").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: dataset_json.triwulan_2.data,
                        backgroundColor: [
                            // '#0e0e52',
                            '#0683D7',
                            '#150578',
                        ],
                        label: 'Triwulan 2'
                    }],
                    labels: dataset_json.triwulan_2.label,
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'TRIWULAN 2',
                        fontColor: '#6777ef',
                        fontStyle: 'bold',
                        fontSize: 20
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                var dataLabel = data.labels[tooltipItem.index];
                                var value = ': Rp. ' + data.datasets[tooltipItem.datasetIndex].data[tooltipItem
                                    .index].toString().replace(/\B(?=(\d{3})+(?!\d))/g,
                                    ".");
                                if (Chart.helpers.isArray(dataLabel)) {
                                    dataLabel = dataLabel.slice();
                                    dataLabel[0] += value;
                                } else {
                                    dataLabel += value;
                                }
                                return dataLabel;
                            }
                        }
                    }
                }
            });
            var ctx = document.getElementById("triwulan_3").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: dataset_json.triwulan_3.data,
                        backgroundColor: [
                            '#0e0e52',
                            '#0683D7',
                            // '#150578',
                        ],
                        label: 'Triwulan 3'
                    }],
                    labels: dataset_json.triwulan_3.label,
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'TRIWULAN 3',
                        fontColor: '#6777ef',
                        fontStyle: 'bold',
                        fontSize: 20
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                var dataLabel = data.labels[tooltipItem.index];
                                var value = ': Rp. ' + data.datasets[tooltipItem.datasetIndex].data[tooltipItem
                                    .index].toString().replace(/\B(?=(\d{3})+(?!\d))/g,
                                    ".");
                                if (Chart.helpers.isArray(dataLabel)) {
                                    dataLabel = dataLabel.slice();
                                    dataLabel[0] += value;
                                } else {
                                    dataLabel += value;
                                }
                                return dataLabel;
                            }
                        }
                    }
                }
            });
            var ctx = document.getElementById("triwulan_4").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: dataset_json.triwulan_4.data,
                        backgroundColor: [
                            // '#0e0e52',
                            '#0683D7',
                            '#150578',
                        ],
                        label: 'Triwulan 4'
                    }],
                    labels: dataset_json.triwulan_4.label,
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'TRIWULAN 4',
                        fontColor: '#6777ef',
                        fontStyle: 'bold',
                        fontSize: 20
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                var dataLabel = data.labels[tooltipItem.index];
                                var value = ': Rp. ' + data.datasets[tooltipItem.datasetIndex].data[tooltipItem
                                    .index].toString().replace(/\B(?=(\d{3})+(?!\d))/g,
                                    ".");
                                if (Chart.helpers.isArray(dataLabel)) {
                                    dataLabel = dataLabel.slice();
                                    dataLabel[0] += value;
                                } else {
                                    dataLabel += value;
                                }
                                return dataLabel;
                            }
                        }
                    }
                }
            });
        }
    </script>
@endsection
