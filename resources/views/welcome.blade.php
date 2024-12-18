<!-- resources/views/dashboard/index.blade.php -->
@extends('layouts.main')

@section('container')
<div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <h5 class="card-title fw-semibold mb-4 text-primary">Dashboard</h5>

                <!-- Chart -->
                <canvas id="vehicleUsageChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('vehicleUsageChart').getContext('2d');

    var vehicleUsageData = {!! json_encode($vehicleUsage) !!};

    var months = vehicleUsageData.map(function(item) {
        return item.month + '-' + item.year;
    });

    var usageCounts = vehicleUsageData.map(function(item) {
        return item.count;
    });

    var vehicleUsageChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Jumlah Pemakaian Kendaraan',
                data: usageCounts,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.raw + ' Pemakaian';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Pemakaian'
                    }
                }
            }
        }
    });
</script>
@endsection
