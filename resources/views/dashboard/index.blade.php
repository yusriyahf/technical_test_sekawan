@extends('layouts.main')

@section('container')
<div class="row">
    <div class="col-lg-8 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                    <div class="mb-3 mb-sm-0">
                        <h5 class="card-title fw-semibold">Bookings Overview</h5>
                    </div>
                    <div>
                        <select class="form-select" id="monthFilter">
                            @foreach ($months as $month)
                                <option value="{{ $month['value'] }}" {{ request('month') == $month['value'] ? 'selected' : '' }}>
                                    {{ $month['name'] }}
                                </option>
                            @endforeach
                        </select>
                        
                    </div>
                    
                </div>
                <div id="chart"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
      <div class="row">
        <div class="col-lg-12">
            <!-- Monthly Earnings -->
            <div class="card">
              <div class="card-body">
                <div class="row alig n-items-start">
                  <div class="col-8">
                    <h5 class="card-title mb-9 fw-semibold"> Total Bookings </h5>
                    <h4 class="fw-semibold mb-3">{{ $totalBookings }}</h4>
                    <div class="d-flex align-items-center pb-1">
                    
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="d-flex justify-content-end">
                        <div class="text-white bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; padding: 0;">
                        <i class="bi bi-calendar4"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              {{-- <div id="earning"></div> --}}
            </div>
          </div>
        <div class="col-lg-12">
            <!-- Monthly Earnings -->
            <div class="card">
              <div class="card-body">
                <div class="row alig n-items-start">
                  <div class="col-8">
                    <h5 class="card-title mb-9 fw-semibold"> Total Drivers </h5>
                    <h4 class="fw-semibold mb-3">{{ $totalDrivers }}</h4>
                    <div class="d-flex align-items-center pb-1">
                    
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="d-flex justify-content-end">
                      <div class="text-white bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; padding: 0;">
                        <i class="bi bi-person"></i>
                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
              {{-- <div id="earning"></div> --}}
            </div>
          </div>
        <div class="col-lg-12">
          <!-- Monthly Earnings -->
          <div class="card">
            <div class="card-body">
              <div class="row alig n-items-start">
                <div class="col-8">
                  <h5 class="card-title mb-9 fw-semibold"> Total Vehicles </h5>
                  <h4 class="fw-semibold mb-3">{{ $totalVehicles }}</h4>
                  <div class="d-flex align-items-center pb-1">
                  
                  </div>
                </div>
                <div class="col-4">
                  <div class="d-flex justify-content-end">
                    <div class="text-white bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; padding: 0;">
                        <i class="bi bi-truck"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            {{-- <div id="earning"></div> --}}
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script>
    document.getElementById('monthFilter').addEventListener('change', function() {
        const selectedMonth = this.value; // Ambil nilai bulan yang dipilih
        window.location.href = `{{ route('dashboard') }}?month=${selectedMonth}`; // Redirect dengan parameter bulan
    });
</script>

<script>
    // Data dari Laravel
    const dates = @json($dates); // ['2023-03-01', '2023-03-02', ...]
    const rentalData = @json($rentalData); // [10, 15, ...]
    const personalData = @json($personalData); // [8, 12, ...]

    // Konfigurasi ApexCharts
    var chart = {
        series: [
            {
                name: "Rental",
                data: rentalData, // Data rental berdasarkan tanggal
            },
            {
                name: "Personal",
                data: personalData, // Data personal berdasarkan tanggal
            },
        ],

        chart: {
            type: "bar",
            height: 345,
            offsetX: -15,
            toolbar: { show: true },
            foreColor: "#adb0bb",
            fontFamily: "inherit",
            sparkline: { enabled: false },
        },

        colors: ["#5D87FF", "#49BEFF"],

        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: "35%",
                borderRadius: [6],
                borderRadiusApplication: 'end',
                borderRadiusWhenStacked: 'all'
            },
        },
        markers: { size: 0 },

        dataLabels: {
            enabled: false,
        },

        xaxis: {
            type: "category",
            categories: dates, // Tanggal sebagai x-axis
            labels: {
                style: { cssClass: "grey--text lighten-2--text fill-color" },
            },
        },

        yaxis: {
            min: 0,
            labels: {
                style: {
                    cssClass: "grey--text lighten-2--text fill-color",
                },
            },
        },

        legend: {
            show: false, // Menampilkan legenda untuk Rental dan Personal
        },

        tooltip: { theme: "light" },
        stroke: {
            show: true,
            width: 3,
            lineCap: "butt",
            colors: ["transparent"],
            },
    };
    

    // Render chart
    var chartInstance = new ApexCharts(document.querySelector("#chart"), chart);
    chartInstance.render();
</script>
@endsection
