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
            <button class="px-4 py-2 bg-blue-600 text-white rounded-full text-sm font-medium">Today</button>
            <button class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-full text-sm font-medium">Yesterday</button>
            <button class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-full text-sm font-medium">7 Days</button>
            <button class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-full text-sm font-medium">30 Days</button>
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
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <p class="text-3xl font-bold text-gray-900">0</p>
                        <p class="text-sm text-gray-500">Total Order</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-gray-900">0</p>
                        <p class="text-sm text-gray-500">Total Order</p>
                    </div>
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
                            <p class="text-sm font-medium text-gray-900">Offline Outlets</p>
                            <p class="text-xs text-gray-500">Current</p>
                        </div>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-700 ml-auto">></a>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm flex items-center hover:shadow">
                        <p class="text-2xl font-bold text-gray-900 pr-4">0</p>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Cancelled Orders</p>
                            <p class="text-xs text-gray-500">Current</p>
                        </div>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-700 ml-auto">></a>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm flex items-center hover:shadow">
                        <p class="text-2xl font-bold text-gray-900 pr-4">0</p>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Delayed Orders</p>
                            <p class="text-xs text-gray-500">Current</p>
                        </div>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-700 ml-auto">></a>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm flex items-center hover:shadow">
                        <p class="text-2xl font-bold text-gray-900 pr-4">0</p>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Rating</p>
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
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        const data = new google.visualization.DataTable();
        data.addColumn('string', 'Time');
        data.addColumn('number', 'Today');
        data.addColumn('number', 'Yesterday');

        data.addRows([
            ['01', 1, 2],
            ['02', 2, 3],
            ['03', 3, 4],
            ['04', 4, 5],
            ['05', 6, 7],
            ['06', 5, 6],
            ['07', 4, 5],
            ['08', 3, 4],
            ['09', 4, 3],
            ['10', 3, 2],
            ['11', 2, 3],
            ['12', 3, 4],
            ['13', 4, 5],
            ['14', 5, 6],
            ['15', 4, 5],
            ['16', 3, 4],
            ['17', 2, 3],
            ['18', 3, 2],
            ['19', 2, 1],
            ['20', 1, 0]
        ]);

        const options = {
            curveType: 'function',
            legend: {
                position: 'none'
            },
            chartArea: {
                width: '90%',
                height: '80%'
            },
            backgroundColor: 'transparent',
            colors: ['#4ade80', '#f87171'],
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
            pointSize: 4,
            series: {
                0: {
                    areaOpacity: 0.1
                },
                1: {
                    areaOpacity: 0.1
                }
            }
        };

        const chart = new google.visualization.AreaChart(
            document.getElementById('chart')
        );
        chart.draw(data, options);

        // Handle window resize
        window.addEventListener('resize', () => {
            chart.draw(data, options);
        });
    }
</script>
