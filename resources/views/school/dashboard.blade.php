@extends($masterLayout)
<?php
$page = 'dashboard';
$title = __('site.Dashboard');
?>
@section('title_page')
    {{ $title }}
@endsection
@section('content')
    <div>
        <div class="flex justify-between flex-wrap items-center mb-6">
            <h4
                class="font-medium lg:text-2xl text-xl capitalize text-slate-900 inline-block ltr:pr-4 rtl:pl-4 mb-1 sm:mb-0">
                {{ $page }}</h4>
        </div>

        <div class="grid lg:grid-cols-1 grid-cols-1 mb-4">
                <div class="flex flex-col">
                    <div class="card-text h-full gap-4">
                        <button class="btn inline-flex justify-center bg-white rounded-full min-w-10">Today</button>
                        <button class="btn inline-flex justify-center bg-white rounded-full min-w-10">Yesterday </button>
                        <button class="btn inline-flex justify-center bg-white rounded-full min-w-10">7 Days</button>
                        <button class="btn inline-flex justify-center bg-white rounded-full min-w-32">30 Days</button>
                    </div>
                </div>
        </div>

        <div class="grid lg:grid-cols-1 grid-cols-1 mb-4">
            <div class="card">
                <div class="card-body flex flex-col p-6">
                    <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                        <div class="flex-1">
                            <div class="card-title text-slate-900 dark:text-white">@lang('Business Summary')</div>
                            <span class="block mb-6 text-sm text-slate-900 dark:text-white font-medium">
                                @lang('Chart View ')
                            </span>
                        </div>
                        <div class="flex-1 text-right">
                            <div class="card-title text-slate-900 dark:text-white">@lang('More In Performance ')</div>
                            <div class=" text-right">
                                <div class="card-title text-slate-900 dark:text-white">0</div>
                                <span class="block mb-6 text-sm text-slate-900 dark:text-white font-medium">

                                    @lang('Total order')
                                </span>
                            </div>
                        </div>
                    </header>
                    <div class="card-text h-full">
                        <div class="tab-pane fade active show" id="pills-settingsHorizontal" role="tabpanel"
                            aria-labelledby="pills-settings-tabHorizontal">
                            <div class="legend-ring4">
                                <div id="account-receivable-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- widgets --}}
        <div class="grid md:grid-cols-4 sm:grid-cols-2 grid-cols-1 gap-3 mb-4">

            <!-- BEGIN: Group Chart5 -->

            <div class=" bg-info-500 rounded-md p-4 bg-opacity-[0.15] dark:bg-opacity-50 text-center">
                <div
                    class="text-info-500 mx-auto h-10 w-10 flex flex-col items-center justify-center rounded-full bg-white text-2xl mb-4">
                    <iconify-icon class=" nav-icon" icon="heroicons-outline:adjustments-horizontal"></iconify-icon>
                </div>
                <span class="block text-sm text-slate-600 font-medium dark:text-white mb-1">
                    @lang('site.Number Of Reservations')
                </span>
                <span class="block mb- text-2xl text-slate-900 dark:text-white font-medium">
                    {{ $countAllReservation }}
                </span>
                <a href="{{ route($mainRoutePrefix . '.reservations.index') }}"
                    class="btn btn-secondary dark:bg-slate-800 dark:hover:bg-slate-600 block w-full text-center btn-sm">
                    @lang('site.More info')
                </a>
            </div>

            <div class=" bg-warning-500 rounded-md p-4 bg-opacity-[0.15] dark:bg-opacity-50 text-center">
                <div
                    class="text-warning-500 mx-auto h-10 w-10 flex flex-col items-center justify-center rounded-full bg-white text-2xl mb-4">
                    <iconify-icon class=" nav-icon" icon="heroicons-outline:adjustments-horizontal"></iconify-icon>
                </div>
                <span class="block text-sm text-slate-600 font-medium dark:text-white mb-1">
                    @lang('site.Number Of Pending Reservations')
                </span>
                <span class="block mb- text-2xl text-slate-900 dark:text-white font-medium">
                    {{ $countPendingReservations }}
                </span>
                <a href="{{ route($mainRoutePrefix . '.reservations.index', ['status' => 'pending']) }}"
                    class="btn btn-secondary dark:bg-slate-800 dark:hover:bg-slate-600 block w-full text-center btn-sm">
                    @lang('site.More info')
                </a>
            </div>

            <div class=" bg-primary-500 rounded-md p-4 bg-opacity-[0.15] dark:bg-opacity-50 text-center">
                <div
                    class="text-primary-500 mx-auto h-10 w-10 flex flex-col items-center justify-center rounded-full bg-white text-2xl mb-4">
                    <iconify-icon class=" nav-icon" icon="heroicons:academic-cap"></iconify-icon>
                </div>
                <span class="block text-sm text-slate-600 font-medium dark:text-white mb-1">
                    @lang('site.Number Of courses')
                </span>
                <span class="block mb- text-2xl text-slate-900 dark:text-white font-medium">
                    {{ $countOfCourses }}
                </span>
                <a href="{{ route($mainRoutePrefix . '.courses.index') }}"
                    class="btn btn-secondary dark:bg-slate-800 dark:hover:bg-slate-600 block w-full text-center btn-sm">
                    @lang('site.More info')
                </a>
            </div>

            <div class=" bg-success-500 rounded-md p-4 bg-opacity-[0.15] dark:bg-opacity-50 text-center">
                <div
                    class="text-success-500 mx-auto h-10 w-10 flex flex-col items-center justify-center rounded-full bg-white text-2xl mb-4">
                    <iconify-icon class=" nav-icon" icon="heroicons:academic-cap"></iconify-icon>
                </div>
                <span class="block text-sm text-slate-600 font-medium dark:text-white mb-1">
                    @lang('site.Number Of Grades')
                </span>
                <span class="block mb- text-2xl text-slate-900 dark:text-white font-medium">
                    {{ $countOfGrades }}
                </span>
                <a href="{{ route($mainRoutePrefix . '.grades.index') }}"
                    class="btn btn-secondary dark:bg-slate-800 dark:hover:bg-slate-600 block w-full text-center btn-sm">
                    @lang('site.More info')
                </a>
            </div>

            <!-- END: Group Chart5 -->
        </div>
    </div>

    <div class="grid grid-cols-12 gap-5 mt-4">
        <div class="xl:col-span-12 col-span-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('site.Latest Reservations')</h4>
                </div>
                <div class="card-body p-6">
                    <!-- BEGIN: Products -->
                    <div class="grid md:grid-cols-4 grid-cols-1 gap-5">
                        @foreach ($latestReservations as $reservation)
                            @if ($reservation->customer)
                                <div class="bg-slate-50 dark:bg-slate-900 p-4 rounded text-center">
                                    <div class="h-12 w-12 rounded-full mb-4 mx-auto">
                                        <img src="{{ $reservation->customer->image_path }}" alt=""
                                            class="w-full h-full rounded-full">
                                    </div>
                                    <span class="text-slate-500 dark:text-slate-300 text-sm mb-1 block font-normal">
                                        {{ $reservation->parent_name }}
                                    </span>
                                    <span class="text-slate-600 dark:text-slate-300 text-sm mb-4 block">
                                        {{ $reservation->created_at }}
                                    </span>
                                    <a href="{{ route('school.reservations.show', ['reservation' => $reservation->id]) }}"
                                        class="btn btn-secondary dark:bg-slate-800 dark:hover:bg-slate-600 block w-full text-center btn-sm">
                                        @lang('site.More info')
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <!-- END: Product -->
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
