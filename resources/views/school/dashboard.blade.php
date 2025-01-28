@extends($masterLayout)
<?php
$page = 'dashboard';
$title = __('site.Dashboard');
?>
@section('title_page')
    {{ $title }}
@endsection
@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <header class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">@lang('site.Dashboard')</h1>
                <p class="text-sm text-gray-500">@lang('Welcome back School')</p>
            </div>
        </header>

        <!-- Time Period Navigation -->
        <nav class="flex gap-4 mb-8">
            <button onclick="updateChartPeriod('today')"
                class="period-btn active px-4 py-2 bg-blue-600 text-white rounded-full text-sm font-medium"
                data-period="today">Today</button>
            <button onclick="updateChartPeriod('yesterday')"
                class="period-btn px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-full text-sm font-medium"
                data-period="yesterday">Yesterday</button>
            <button onclick="updateChartPeriod('7days')"
                class="period-btn px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-full text-sm font-medium"
                data-period="7days">7 Days</button>
            <button onclick="updateChartPeriod('30days')"
                class="period-btn px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-full text-sm font-medium"
                data-period="30days">30 Days</button>
        </nav>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Chart Section -->
            <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-sm">


                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Business Summary</h2>
                        <p class="text-sm text-gray-500">Chart View</p>
                    </div>
                    <button class="text-sm text-blue-600 hover:text-blue-700">More in Performance</button>
                </div>
                <div class="grid grid-cols-4 gap-4 mb-4">

                </div>

                <div class="flex justify-between items-center mb-6">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" checked class="data-filter w-4 h-4 text-blue-600" value="bookings"
                            onchange="updateDataVisibility()" checked>
                        <span class="text-sm text-gray-700">Total Bookings</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" checked class="data-filter w-4 h-4 text-blue-600" value="trend"
                            onchange="updateDataVisibility()" checked>
                        <span class="text-sm text-gray-700">Bookings Trend</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" checked class="data-filter w-4 h-4 text-blue-600" value="revenue"
                            onchange="updateDataVisibility()" checked>
                        <span class="text-sm text-gray-700">Revenue Summary</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" checked class="data-filter w-4 h-4 text-blue-600" value="seats"
                            onchange="updateDataVisibility()" checked>
                        <span class="text-sm text-gray-700">Seats</span>
                    </label>
                </div>

                <div id="chart" class="w-full h-[300px]"></div>

            </div>

            <!-- Status Cards -->
            <div class="space-y-4">
                <!-- Live Ops Monitor -->
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Live Ops Monitor</h3>
                    <p class="text-sm text-gray-500">Your restaurant is operating normally, bravo!</p>
                </div>

                <!-- Status Items -->
                <div class="space-y-3">
                    <div class="bg-white p-4 rounded-lg shadow-sm flex items-center hover:shadow">
                        <p class="text-2xl font-bold text-gray-900 pr-4">0</p>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Current Bookings</p>
                            <p class="text-xs text-gray-500">Current</p>
                        </div>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-700 ml-auto">></a>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm flex items-center hover:shadow">
                        <p class="text-2xl font-bold text-gray-900 pr-4">0</p>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Pending Bookings</p>
                            <p class="text-xs text-gray-500">Current</p>
                        </div>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-700 ml-auto">></a>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm flex items-center hover:shadow">
                        <p class="text-2xl font-bold text-gray-900 pr-4">0</p>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Cancellations</p>
                            <p class="text-xs text-gray-500">Current</p>
                        </div>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-700 ml-auto">></a>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm flex items-center hover:shadow">
                        <p class="text-2xl font-bold text-gray-900 pr-4">0</p>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Late Drop-offs or Pick-ups</p>
                            <p class="text-xs text-gray-500">Current</p>
                        </div>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-700 ml-auto">></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Operations Health Section -->
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">Operations Health</h2>
                    <div class="flex gap-4">
                        <button class="text-sm text-blue-600 hover:text-blue-700">More in Performance</button>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-2 gap-4">
                    <!-- countAllReservation -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex justify-between items-center">
                                <p class="text-lg font-semibold">@lang('site.Number Of Reservations')</p>
                            </div>
                            <div class="text-blue-500">{{ $countAllReservation }}</div>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <span>Vendor Cancelations</span>
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 16v-4" />
                                <path d="M12 8h.01" />
                            </svg>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Last 7 days</p>
                    </div>

                    <!-- Number Of Pending Reservations -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex justify-between items-center">
                                <p class="text-lg font-semibold"> @lang('site.Number Of Pending Reservations')</p>
                            </div>
                            <div class="text-blue-500"> {{ $countPendingReservations }}</div>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <span>Vendor Cancelations</span>
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 16v-4" />
                                <path d="M12 8h.01" />
                            </svg>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Last 7 days</p>
                    </div>

                    <!-- Number Of courses -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex justify-between items-center">
                                <p class="text-lg font-semibold"> @lang('site.Number Of courses')</p>
                            </div>
                            <div class="text-blue-500"> {{ $countOfCourses }}</div>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <span>Vendor Cancelations</span>
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 16v-4" />
                                <path d="M12 8h.01" />
                            </svg>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Last 7 days</p>
                    </div>

                    <!-- Number Of Grades -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex justify-between items-center">
                                <p class="text-lg font-semibold"> @lang('site.Number Of Grades')</p>
                            </div>
                            <div class="text-blue-500"> {{ $countOfGrades }}</div>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <span>Vendor Cancelations</span>
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 16v-4" />
                                <path d="M12 8h.01" />
                            </svg>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Last 7 days</p>
                    </div>

                    <!-- Add other metrics cards here -->
                </div>
            </div>
            <div class="col-span-4 bg-white p-6 rounded-lg shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg text-gray-900">Important</h2>
                    <div class="flex gap-4">
                        <button class="text-sm text-blue-600 hover:text-blue-700">More In Reviews</button>
                    </div>
                </div>

                <div class="grid grid-cols-1">
                    <!-- First Row -->
                    <div class="text-center p-6">
                        <img class="mx-auto" src="{{ asset('school/assets/images/reviews-icon.png') }}"
                            alt="Image Description" class="w-10 h-10 rounded-full">
                        <p class="text-lg font-semibold">No reviews yet</p>
                        <p class="text-sm text-gray-500">You haven't received any new reviews recently.
                            They would appear here, when you receive them.</p>
                    </div>
                    <!-- Add other metrics cards here -->
                </div>
            </div>
        </div>
    </div>
@endsection
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    // Initialize Google Charts
    google.charts.load('current', {
        packages: ['corechart']
    });
    google.charts.setOnLoadCallback(initializeChart);

    let currentChart = null;
    let currentPeriod = 'today';

    // Sample data for different time periods
    const chartData = {
        today: [
            ['Hour', 'Total Bookings', 'Bookings Trend', 'Revenue Summary', 'Seats'],
            ['09:00', 50, 500, 1000, 40],
            ['12:00', 80, 750, 1500, 60],
            ['15:00', 120, 1000, 2000, 90],
            ['18:00', 90, 850, 1800, 70],
            ['21:00', 60, 600, 1200, 45]
        ],
        yesterday: [
            ['Hour', 'Total Bookings', 'Bookings Trend', 'Revenue Summary', 'Seats'],
            ['09:00', 45, 450, 900, 35],
            ['12:00', 75, 700, 1400, 55],
            ['15:00', 110, 950, 1900, 85],
            ['18:00', 85, 800, 1600, 65],
            ['21:00', 55, 550, 1100, 40]
        ],
        '7days': [
            ['Day', 'Total Bookings', 'Bookings Trend', 'Revenue Summary', 'Seats'],
            ['Mon', 150, 1500, 3000, 120],
            ['Tue', 180, 1800, 3600, 150],
            ['Wed', 200, 2000, 4000, 170],
            ['Thu', 170, 1700, 3400, 140],
            ['Fri', 220, 2200, 4400, 190],
            ['Sat', 250, 2500, 5000, 220],
            ['Sun', 190, 1900, 3800, 160]
        ],
        '30days': generateMonthData()
    };

    function generateMonthData() {
        const data = [
            ['Day', 'Total Bookings', 'Bookings Trend', 'Revenue Summary', 'Seats']
        ];
        for (let i = 1; i <= 30; i++) {
            data.push([
                `Day ${i}`,
                Math.floor(Math.random() * 200) + 100,
                Math.floor(Math.random() * 2000) + 1000,
                Math.floor(Math.random() * 4000) + 2000,
                Math.floor(Math.random() * 150) + 80
            ]);
        }
        return data;
    }

    function initializeChart() {
        drawChart('today');
    }

    function updateChartPeriod(period) {
        currentPeriod = period;
        // Update button states
        const buttons = document.querySelectorAll('.period-btn');
        buttons.forEach(btn => {
            btn.classList.remove('bg-blue-600', 'text-white');
            btn.classList.add('text-gray-600', 'hover:bg-gray-100');
        });

        const activeButton = document.querySelector(`[data-period="${period}"]`);
        activeButton.classList.remove('text-gray-600', 'hover:bg-gray-100');
        activeButton.classList.add('bg-blue-600', 'text-white');

        // Update chart
        drawChart(period);
    }

    function updateDataVisibility() {
        drawChart(currentPeriod);
    }

    function getVisibleColumns() {
        const filters = document.querySelectorAll('.data-filter');
        const visibleColumns = [0]; // Always include the first column (time/date)

        filters.forEach((filter, index) => {
            if (filter.checked) {
                visibleColumns.push(index + 1);
            }
        });

        return visibleColumns;
    }

    function drawChart(period) {
        const rawData = chartData[period];
        const visibleColumns = getVisibleColumns();

        // Create a view with only the visible columns
        const fullDataTable = google.visualization.arrayToDataTable(rawData);
        const view = new google.visualization.DataView(fullDataTable);
        view.setColumns(visibleColumns);

        const options = {
            curveType: 'function',
            legend: {
                position: 'bottom'
            },
            chartArea: {
                width: '85%',
                height: '70%'
            },
            backgroundColor: 'transparent',
            colors: ['#34d399', '#fbbf24', '#60a5fa', '#f472b6'],
            hAxis: {
                textStyle: {
                    color: '#6b7280'
                },
                gridlines: {
                    color: 'transparent'
                },
                baselineColor: '#e5e7eb'
            },
            vAxis: {
                textStyle: {
                    color: '#6b7280'
                },
                gridlines: {
                    color: '#f3f4f6'
                },
                baselineColor: '#e5e7eb'
            },
            lineWidth: 2,
            pointSize: 4
        };

        if (!currentChart) {
            currentChart = new google.visualization.LineChart(
                document.getElementById('chart')
            );
        }

        currentChart.draw(view, options);
    }

    // Handle window resize
    window.addEventListener('resize', () => {
        drawChart(currentPeriod);
    });
</script>
