@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-8 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title fw-semibold d-block mb-1">{{ Auth::user()->name }}
                                <p class="mb-4" style="color: #09570c">
                                    </span>
                                    Oromia Development Association<span class="fw-bold"> (ODA) </span>
                                    works to eradicate poverty, gender inequality, and health disparities.
                                </p>

                                <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Badges</a>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="../photo/1753261150907876.PNG" height="140" alt="View Badge User"
                                data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                data-app-light-img="illustrations/man-with-laptop-light.png" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 order-1">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="../assets/img/icons/unicons/chart-success.png" alt="chart success"
                                        class="rounded" />
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Total Members</span>
                            <h3 class="card-title mb-2"> {{ $all }} </h3>
                            <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> {{__('updates')}} </small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    {{-- <img src="../assets/img/icons/unicons/wallet-info.png" alt="Credit Card" class="rounded" /> --}}
                                    <i class="bx bxs-group" style="font-size: 60px; color: #3d12cd;"></i>

                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <span> {{ __('Member officers') }} </span>
                            <h3 class="card-title text-nowrap mb-1"> {{ $officers }} </h3>
                            <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> {{ __('updates') }} </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Total Reven --}}
        <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
            <div class="card">
                <h5 class="card-header m-0 pb-3">Members per Zone</h5>
                <div id="zoneMembersChart" class="px-2" style="min-height: 200px;"></div>
            </div>
        </div>



        <!--/ Total Revenue -->
        <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
            <div class="row">
                <div class="col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    {{-- <i class="bx bx-map" style="font-size: 70px; color: #4CAF50;"></i> --}}
                                    <i class="bx bx-map-alt" style="font-size: 60px; color: #4CAF50;"></i>
                                    {{-- <i class="bx bx-current-location" style="font-size: 70px; color: #FF9800;"></i> --}}
                                    {{-- <i class="bx bx-location-plus" style="font-size: 70px; color: #E91E63;"></i> --}}
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt4" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <span class="d-block mb-1">Woreda</span>
                            <h3 class="card-title text-nowrap mb-2"> {{ $woreda }} </h3>
                            <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> {{ __('live updates') }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    {{-- <img src="../assets/img/icons/unicons/cc-primary.png" alt="Credit Card"
                                    class="rounded" /> --}}
                                    <i class="bx bxs-group" style="font-size: 60px; color: #4CAF50;"></i>

                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="cardOpt1">
                                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Roles</span>
                            <h3 class="card-title mb-2"> {{ $roles }} </h3>
                            <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> {{ __('live updates') }}</small>
                        </div>
                    </div>
                </div>
                <!-- </div>
            <div class="row"> -->
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                                <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                    <div class="card-title">
                                        <h5 class="text-nowrap mb-2">Galii Miseensotaa</h5>
                                        <span class="badge bg-label-warning rounded-pill">Year 2025</span>
                                    </div>
                                    <div class="mt-sm-auto">
                                        <small class="text-success text-nowrap fw-semibold"><i
                                                class="bx bx-chevron-up"></i>galii</small>
                                        <h3 class="mb-0"> 1,154,362,754ETB</h3>
                                    </div>
                                </div>
                                <div id="profileReportChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- <div class="card mb-4">
    <h5 class="card-header">Position Distribution</h5>
    <div id="positionPieChart" style="min-height: 350px;"></div>
</div> --}}












    <div class="row">
        <!-- Order Statistics -->
        <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between pb-0">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Types Statistics</h5>
                        <small class="text-muted">119k Total Types</small>
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="orederStatistics" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                            <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                            <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                            <a class="dropdown-item" href="javascript:void(0);">Share</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex flex-column align-items-center gap-1">
                            <h2 class="mb-2">
                                {{ $positionCounts['Qonnaan Bulaa'] + $positionCounts['Daldala-C'] + $positionCounts['Daldala-B'] + $positionCounts['Daldala-A'] + $positionCounts['Hojjeta Motummaa'] }}
                            </h2>
                            <span>Total Types</span>
                        </div>
                        <div id="positionPieChart"></div>
                    </div>
                    <ul class="p-0 m-0">
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-primary"><i class="bx bxs-group"></i></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Qonnaan Bulaa</h6>
                                    <small class="text-muted">Farmers, Pastoralists</small>
                                </div>
                                <div class="user-progress">
                                    <small class="fw-semibold"> {{ $positionCounts['Qonnaan Bulaa'] }} </small>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-success"><i class="bx bxs-group"></i></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Daldalaa-C</h6>
                                    <small class="text-muted">C-Level Merchants</small>
                                </div>
                                <div class="user-progress">
                                    <small class="fw-semibold"> {{ $positionCounts['Daldala-C'] }} </small>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-info"><i class="bx bxs-group"></i></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Daldalaa-B + A</h6>
                                    <small class="text-muted">A+B</small>
                                </div>
                                <div class="user-progress">
                                    <small class="fw-semibold">
                                        {{ $positionCounts['Daldala-A'] + $positionCounts['Daldala-B'] }} </small>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-secondary"><i
                                        class="bx bxs-group"></i></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Hojjeta Motummaa</h6>
                                    <small class="text-muted">Government Workers</small>
                                </div>
                                <div class="user-progress">
                                    <small class="fw-semibold"> {{ $positionCounts['Hojjeta Motummaa'] }} </small>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--/ Order Statistics -->

        <!-- Expense Overview -->
        <div class="col-md-6 col-lg-4 order-1 mb-4">
            <div class="card h-100">
                {{-- <div class="card-header">
                    <ul class="nav nav-pills" role="tablist">
                        <li class="nav-item">
                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-tabs-line-card-income" aria-controls="navs-tabs-line-card-income"
                                aria-selected="true">
                                Income
                            </button>
                        </li>
                        {{-- <li class="nav-item">
                            <button type="button" class="nav-link" role="tab">Expenses</button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab">Profit</button>
                        </li>
                    </ul>
                </div> --}}
                <div class="card-body px-0">
                    <div class="tab-content p-0">
                        <div class="tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel">
                            <div class="d-flex p-4 pt-3">
                                <div class="avatar flex-shrink-0 me-3">
                                    <img src="../assets/img/icons/unicons/wallet.png" alt="User" />
                                </div>
                                <div>
                                    <small class="text-muted d-block">Officer Members</small>
                                    <div class="d-flex align-items-center">
                                        <h6 class="mb-0 me-1"> {{$officers}} </h6>
                                        <small class="text-success fw-semibold">
                                            <i class="bx bx-group"></i>
                                            Members
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div id="zoneBarChart"></div>
                            <div class="d-flex justify-content-center pt-4 gap-2">
                                <div class="flex-shrink-0">
                                    <div id="expensesOfWeek"></div>
                                </div>

                                <div>
                                    <p class="mb-n1 mt-1">Expenses This Week</p>
                                    <small class="text-muted">$39 less than last week</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Expense Overview -->

        <!-- Transactions -->
        <div class="col-md-6 col-lg-4 order-2 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Transactions</h5>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="transactionID" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                            <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                            <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                            <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="p-0 m-0">
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <img src="../assets/img/icons/unicons/paypal.png" alt="User" class="rounded" />
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="text-muted d-block mb-1">Paypal</small>
                                    <h6 class="mb-0">Send money</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                    <h6 class="mb-0">+82.6</h6>
                                    <span class="text-muted">USD</span>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <img src="../assets/img/icons/unicons/wallet.png" alt="User" class="rounded" />
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="text-muted d-block mb-1">Wallet</small>
                                    <h6 class="mb-0">Mac'D</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                    <h6 class="mb-0">+270.69</h6>
                                    <span class="text-muted">USD</span>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <img src="../assets/img/icons/unicons/chart.png" alt="User" class="rounded" />
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="text-muted d-block mb-1">Transfer</small>
                                    <h6 class="mb-0">Refund</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                    <h6 class="mb-0">+637.91</h6>
                                    <span class="text-muted">USD</span>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <img src="../assets/img/icons/unicons/cc-success.png" alt="User" class="rounded" />
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="text-muted d-block mb-1">Credit Card</small>
                                    <h6 class="mb-0">Ordered Food</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                    <h6 class="mb-0">-838.71</h6>
                                    <span class="text-muted">USD</span>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <img src="../assets/img/icons/unicons/wallet.png" alt="User" class="rounded" />
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="text-muted d-block mb-1">Wallet</small>
                                    <h6 class="mb-0">Starbucks</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                    <h6 class="mb-0">+203.33</h6>
                                    <span class="text-muted">USD</span>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex">
                            <div class="avatar flex-shrink-0 me-3">
                                <img src="../assets/img/icons/unicons/cc-warning.png" alt="User" class="rounded" />
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="text-muted d-block mb-1">Mastercard</small>
                                    <h6 class="mb-0">Ordered Food</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                    <h6 class="mb-0">-92.45</h6>
                                    <span class="text-muted">USD</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--/ Transactions -->
    </div>
@endsection
{{-- @push('Scripts') --}}
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var options = {
            chart: {
                type: 'bar',
                height: 300
            },
         stroke: {
        curve: 'smooth',
        width: 6,
        lineCap: 'round'
      },
      legend: {
        show: true,
        horizontalAlign: 'left',
        position: 'top',
        markers: {
          height: 8,
          width: 8,
          radius: 12,
          offsetX: -3
        },
       
        itemMargin: {
          horizontal: 10
        }
      },
      
            series: [{
                name: 'Members',
                data: @json(array_column($zoneCounts, 'members'))
            }],
            xaxis: {
                categories: @json(array_column($zoneCounts, 'zone'))
            },
            plotOptions: {
                bar: {
                    borderRadius: 20,
                    horizontal: false,
                }
            },
            stroke: {
                curve: 'smooth' // This makes the line smooth instead of jagged
            },
            dataLabels: {
                enabled: false
            },
            title: {
                text: 'Members in Each Zone',
                align: 'center'
            }
        };

        var chart = new ApexCharts(document.querySelector("#zoneMembersChart"), options);
        chart.render();
    });
</script>



<script>
document.addEventListener("DOMContentLoaded", function () {

    var positionCounts = @json($positionCounts);

    var options = {
        chart: {
            type: 'donut',
            height: 200
        },
               grid: {
            padding: {
                top: 0,
                bottom: 0,
                right: 15
            }
        },
         

      
        series: Object.values(positionCounts),
        labels: Object.keys(positionCounts),
        legend: {
            show: false
        },
        dataLabels: {
            enabled: false
        }
    };

    

    var chart = new ApexCharts(
        document.querySelector("#positionPieChart"),
        options
    );

    chart.render();
});
</script>




<script>
document.addEventListener("DOMContentLoaded", function() {

    const typeMemberChart = document.querySelector('#zoneBarChart');

    if (!typeMemberChart) {
        console.error("Chart container #typeMember not found!");
        return;
    }

    const zoneLabels = @json(array_keys($zoneCounter));
    const zoneValues = @json(array_values($zoneCounter));

    const chartConfig = {
        chart: {
            type: 'bar',
            height: 250
        },
          dataLabels: {
            enabled: false
        },
        series: [{
            name: 'Officers',
            data: zoneValues
        }],
        xaxis: {
            categories: zoneLabels
        },
        colors: [config.colors.primary]
    };

    const chart = new ApexCharts(typeMemberChart, chartConfig);
    chart.render();

});
</script>




{{-- @endpush --}}
