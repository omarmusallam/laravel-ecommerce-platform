@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Dashboard</li>
@endsection
@section('content')
    @push('styles')
        <style>
            .dashboard-shell {
                padding-bottom: 1rem;
            }

            .dashboard-hero {
                position: relative;
                overflow: hidden;
                padding: 1.6rem 1.6rem 1.4rem;
                border-radius: 24px;
                background: linear-gradient(135deg, #0f1f35 0%, #17314e 55%, #225fca 100%);
                color: #fff;
                box-shadow: 0 24px 55px rgba(15, 23, 42, 0.16);
                margin-bottom: 1.5rem;
            }

            .dashboard-hero::after {
                content: "";
                position: absolute;
                right: -70px;
                bottom: -90px;
                width: 260px;
                height: 260px;
                border-radius: 50%;
                background: radial-gradient(circle, rgba(255, 255, 255, 0.24), transparent 68%);
                pointer-events: none;
            }

            .dashboard-hero > * {
                position: relative;
                z-index: 1;
            }

            .dashboard-kicker {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 8px 14px;
                border-radius: 999px;
                background: rgba(255, 255, 255, 0.12);
                border: 1px solid rgba(255, 255, 255, 0.14);
                font-size: 12px;
                font-weight: 700;
                letter-spacing: 0.06em;
                text-transform: uppercase;
                margin-bottom: 16px;
            }

            .dashboard-hero h2 {
                font-size: clamp(1.8rem, 3vw, 2.5rem);
                font-weight: 800;
                margin-bottom: 10px;
            }

            .dashboard-subtitle {
                color: rgba(255, 255, 255, 0.82);
                max-width: 640px;
                margin-bottom: 0;
                font-size: 0.98rem;
                line-height: 1.8;
            }

            .dashboard-stat-card {
                position: relative;
                overflow: hidden;
                height: 100%;
                border-radius: 20px;
                border: 1px solid #e6edf7;
                background: #fff;
                box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06);
                padding: 1.2rem 1.2rem 1rem;
            }

            .dashboard-stat-card::before {
                content: "";
                position: absolute;
                inset: 0 auto 0 0;
                width: 4px;
                border-radius: 20px 0 0 20px;
                background: var(--accent, #1f7aff);
            }

            .dashboard-stat-card .stat-top {
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                gap: 1rem;
                margin-bottom: 1rem;
            }

            .dashboard-stat-card .stat-label {
                color: #667085;
                font-size: 0.9rem;
                font-weight: 600;
                margin-bottom: 0.35rem;
            }

            .dashboard-stat-card .stat-value {
                font-size: 2rem;
                line-height: 1;
                font-weight: 800;
                color: #142033;
                margin: 0;
            }

            .dashboard-stat-card .stat-icon {
                width: 46px;
                height: 46px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 16px;
                background: color-mix(in srgb, var(--accent, #1f7aff) 12%, white);
                color: var(--accent, #1f7aff);
                font-size: 1.2rem;
            }

            .dashboard-stat-card .stat-link {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                color: #344054;
                font-weight: 600;
            }

            .dashboard-grid {
                row-gap: 1.25rem;
            }

            .dashboard-panel {
                background: #fff;
                border-radius: 22px;
                box-shadow: 0 18px 40px rgba(15, 23, 42, 0.07);
                border: 1px solid #e6edf7;
                padding: 1.25rem;
                margin-top: 1.4rem;
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

            .dashboard-panel-subtitle {
                margin: 0.2rem 0 0;
                color: #667085;
                font-size: 0.92rem;
            }

            .chart-shell {
                min-height: 380px;
            }

            .chart-filter-group {
                background: #f8fbff;
                border: 1px solid #e4ecf7;
                border-radius: 999px;
                padding: 4px;
            }

            .chart-filter-group .btn {
                border-radius: 999px !important;
                padding: 0.45rem 0.95rem;
                font-weight: 700;
                border: 0;
                color: #667085;
            }

            .chart-filter-group .btn.active {
                background: #142c47;
                color: #fff;
                box-shadow: 0 10px 20px rgba(20, 44, 71, 0.18);
            }

            .calendar-shell {
                min-height: 320px;
            }

            .calendar-placeholder {
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 240px;
                border-radius: 18px;
                background: linear-gradient(180deg, #fbfdff 0%, #f5f8fc 100%);
                border: 1px dashed #d8e2ef;
                color: #98a2b3;
                font-weight: 600;
            }
        </style>
    @endpush

    <div class="dashboard-shell">
        <section class="dashboard-hero">
            <span class="dashboard-kicker"><i class="fas fa-chart-line"></i> ShopGrids Overview</span>
            <h2>Store performance at a glance</h2>
            <p class="dashboard-subtitle">Track orders, products, categories, customers, and administrators from one calm and polished dashboard designed for faster daily review.</p>
        </section>

        <div class="row dashboard-grid">
            <div class="col-xl-3 col-md-6">
                <div class="dashboard-stat-card" style="--accent:#d9485f;">
                    <div class="stat-top">
                        <div>
                            <div class="stat-label">Total Orders</div>
                            <h3 class="stat-value">{{ $totalOrder }}</h3>
                        </div>
                        <span class="stat-icon"><i class="fas fa-shopping-bag"></i></span>
                    </div>
                    <a href="{{ route('dashboard.orders.index') }}" class="stat-link">View orders <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="dashboard-stat-card" style="--accent:#1fa971;">
                    <div class="stat-top">
                        <div>
                            <div class="stat-label">Today Orders</div>
                            <h3 class="stat-value">{{ $todayOrder }}</h3>
                        </div>
                        <span class="stat-icon"><i class="fas fa-bolt"></i></span>
                    </div>
                    <a href="{{ route('dashboard.orders.index') }}" class="stat-link">Review today <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="dashboard-stat-card" style="--accent:#d59b16;">
                    <div class="stat-top">
                        <div>
                            <div class="stat-label">This Month</div>
                            <h3 class="stat-value">{{ $thisMonthOrder }}</h3>
                        </div>
                        <span class="stat-icon"><i class="fas fa-calendar-alt"></i></span>
                    </div>
                    <a href="{{ route('dashboard.orders.index') }}" class="stat-link">Monthly activity <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="dashboard-stat-card" style="--accent:#475467;">
                    <div class="stat-top">
                        <div>
                            <div class="stat-label">This Year</div>
                            <h3 class="stat-value">{{ $thisYearOrder }}</h3>
                        </div>
                        <span class="stat-icon"><i class="fas fa-chart-pie"></i></span>
                    </div>
                    <a href="{{ route('dashboard.orders.index') }}" class="stat-link">Yearly summary <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="dashboard-stat-card" style="--accent:#1f7aff;">
                    <div class="stat-top">
                        <div>
                            <div class="stat-label">Products</div>
                            <h3 class="stat-value">{{ $totalProduct }}</h3>
                        </div>
                        <span class="stat-icon"><i class="fas fa-box-open"></i></span>
                    </div>
                    <a href="{{ route('dashboard.products.index') }}" class="stat-link">Manage products <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="dashboard-stat-card" style="--accent:#7c4dff;">
                    <div class="stat-top">
                        <div>
                            <div class="stat-label">Categories</div>
                            <h3 class="stat-value">{{ $totalCategory }}</h3>
                        </div>
                        <span class="stat-icon"><i class="fas fa-layer-group"></i></span>
                    </div>
                    <a href="{{ route('dashboard.categories.index') }}" class="stat-link">Browse categories <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="dashboard-stat-card" style="--accent:#667085;">
                    <div class="stat-top">
                        <div>
                            <div class="stat-label">Users</div>
                            <h3 class="stat-value">{{ $totalUser }}</h3>
                        </div>
                        <span class="stat-icon"><i class="fas fa-users"></i></span>
                    </div>
                    <a href="{{ route('dashboard.users.index') }}" class="stat-link">Customer accounts <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="dashboard-stat-card" style="--accent:#1697a6;">
                    <div class="stat-top">
                        <div>
                            <div class="stat-label">Admins</div>
                            <h3 class="stat-value">{{ $totalAdmin }}</h3>
                        </div>
                        <span class="stat-icon"><i class="fas fa-user-shield"></i></span>
                    </div>
                    <a href="{{ route('dashboard.admins.index') }}" class="stat-link">Admin accounts <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <div class="dashboard-panel chart-shell">
            <div class="dashboard-panel-header">
                <div>
                    <h2 class="dashboard-panel-title">Orders Analytics</h2>
                    <p class="dashboard-panel-subtitle">Compare total sales with order volume across different time ranges.</p>
                </div>
                <div class="btn-group chart-filter-group" role="group" aria-label="Chart filters">
                    <button type="button" data-group="day" class="btn">Day</button>
                    <button type="button" data-group="week" class="btn">Week</button>
                    <button type="button" data-group="month" class="btn active">Month</button>
                    <button type="button" data-group="year" class="btn">Year</button>
                </div>
            </div>

            <canvas id="myChart" height="110"></canvas>
        </div>

        <div class="dashboard-panel calendar-shell">
            <div class="dashboard-panel-header">
                <div>
                    <h2 class="dashboard-panel-title">Calendar</h2>
                    <p class="dashboard-panel-subtitle">Keep an eye on your store schedule and operational activity.</p>
                </div>
            </div>
            <div class="card-body pt-0 px-0 pb-0">
                <div id="calendar" style="width: 100%"></div>
                <div class="calendar-placeholder d-none">Calendar events will appear here.</div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdnjs.com/libraries/Chart.js"></script>

        <script>
            const ctx = document.getElementById('myChart');
            const myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: []
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    plugins: {
                        legend: {
                            labels: {
                                usePointStyle: true,
                                boxWidth: 10,
                                color: '#344054',
                                font: {
                                    weight: '600'
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#667085'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(148, 163, 184, 0.16)'
                            },
                            ticks: {
                                color: '#667085'
                            }
                        }
                    }
                }
            });

            function displayChart(group = 'month') {
                fetch("{{ route('dashboard.charts.orders') }}?group=" + group)
                    .then(res => res.json())
                    .then(json => {
                        const colors = ['#1f7aff', '#1fa971'];
                        myChart.data.labels = json.labels;
                        myChart.data.datasets = json.datasets.map((dataset, index) => ({
                            ...dataset,
                            borderColor: colors[index] || '#1f7aff',
                            backgroundColor: colors[index] || '#1f7aff',
                            borderWidth: 3,
                            fill: false,
                            tension: 0.35,
                            pointRadius: 4,
                            pointHoverRadius: 5
                        }));
                        myChart.update();
                    });
            }

            $('.chart-filter-group .btn').on('click', function(e) {
                e.preventDefault();
                $('.chart-filter-group .btn').removeClass('active');
                $(this).addClass('active');
                displayChart($(this).data('group'));
            });

            displayChart();
        </script>
    @endpush
@endsection
