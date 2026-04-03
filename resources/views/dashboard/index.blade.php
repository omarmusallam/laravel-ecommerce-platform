@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Dashboard</li>
@endsection
@section('content')
    @push('styles')
        <style>
            .dashboard-subtitle {
                color: #667085;
                margin-bottom: 1.25rem;
                font-size: 1rem;
            }

            .dashboard-stat {
                border-radius: 18px;
                overflow: hidden;
                box-shadow: 0 16px 35px rgba(15, 23, 42, 0.08);
                margin-bottom: 1.25rem;
            }

            .dashboard-stat .inner {
                padding: 1.25rem 1.25rem 1rem;
            }

            .dashboard-stat .inner h3 {
                font-size: 2.1rem;
                font-weight: 800;
                margin-bottom: 0.35rem;
            }

            .dashboard-stat .inner p {
                font-size: 1rem;
                margin: 0;
                opacity: 0.95;
            }

            .dashboard-stat .icon {
                top: 14px;
                right: 16px;
                font-size: 54px;
                opacity: 0.16;
            }

            .dashboard-stat .small-box-footer {
                padding: 0.8rem 1rem;
                font-weight: 600;
            }

            .dashboard-panel {
                background: #fff;
                border-radius: 18px;
                box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
                padding: 1.25rem;
                margin-top: 1rem;
            }

            .dashboard-panel-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 1rem;
                flex-wrap: wrap;
                margin-bottom: 1rem;
            }

            .dashboard-panel-title {
                margin: 0;
                font-size: 1.05rem;
                font-weight: 700;
                color: #142033;
            }

            .chart-filter-group .btn {
                border-radius: 999px !important;
                padding: 0.45rem 0.95rem;
                font-weight: 600;
            }

            .chart-filter-group .btn.active {
                background: #1f7aff;
                border-color: #1f7aff;
                color: #fff;
            }
        </style>
    @endpush

    <p class="dashboard-subtitle">Monitor orders, products, categories, and registrations from one clean overview.</p>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger dashboard-stat">
                        <div class="inner">
                            <h3>{{ $totalOrder }}</h3>

                            <p>Total Orders</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('dashboard.orders.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success dashboard-stat">
                        <div class="inner">
                            <h3>{{ $todayOrder }}</h3>

                            <p>Today Orders</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('dashboard.orders.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning dashboard-stat">
                        <div class="inner">
                            <h3>{{ $thisMonthOrder }}</h3>

                            <p>This Month Orders</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{ route('dashboard.orders.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box dashboard-stat" style="color: white; background-color: rgb(63, 57, 57)">
                        <div class="inner">
                            <h3>{{ $thisYearOrder }}</h3>

                            <p>This Year Orders</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="{{ route('dashboard.orders.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-primary dashboard-stat">
                        <div class="inner">
                            <h3>{{ $totalProduct }}</h3>

                            <p>Total Products</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('dashboard.products.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box dashboard-stat" style="background-color: rgb(143, 67, 150); color: white">
                        <div class="inner">
                            <h3>{{ $totalCategory }}</h3>

                            <p>Total Categories</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('dashboard.categories.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-secondary dashboard-stat">
                        <div class="inner">
                            <h3>{{ $totalUser }}</h3>

                            <p>Users Registration</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{ route('dashboard.users.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info dashboard-stat">
                        <div class="inner">
                            <h3>{{ $totalAdmin }}</h3>

                            <p>Admins Registration</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="{{ route('dashboard.admins.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>

            <div class="dashboard-panel">
                <div class="dashboard-panel-header">
                    <h2 class="dashboard-panel-title">Orders Analytics</h2>
                    <div class="btn-group chart-filter-group" role="group" aria-label="Chart filters">
                        <button type="button" data-group="day" class="btn btn-outline-secondary">Day</button>
                        <button type="button" data-group="week" class="btn btn-outline-secondary">Week</button>
                        <button type="button" data-group="month" class="btn btn-outline-secondary active">Month</button>
                        <button type="button" data-group="year" class="btn btn-outline-secondary">Year</button>
                    </div>
                </div>

                <canvas id="myChart" height="110"></canvas>
            </div>

            <div class="dashboard-panel">
                <div class="dashboard-panel-header">
                    <h2 class="dashboard-panel-title">Calendar</h2>
                </div>
                <div class="card-body pt-0 px-0 pb-0">
                    <div id="calendar" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdnjs.com/libraries/Chart.js"></script>

        <script>
            const ctx = document.getElementById('myChart');
            const myChart = new Chart(ctx, {
                type: 'line',
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            function displayChart(group = 'month') {
                fetch("{{ route('dashboard.charts.orders') }}?group=" + group)
                    .then(res => res.json())
                    .then(json => {
                        myChart.data.labels = json.labels;
                        myChart.data.datasets = json.datasets;
                        myChart.update()
                    });
            }

            $('.btn-group .btn').on('click', function(e) {
                e.preventDefault();
                $('.chart-filter-group .btn').removeClass('active');
                $(this).addClass('active');
                displayChart($(this).data('group'));
            });
            displayChart();
        </script>
    @endpush
@endsection
