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

        <div class="grid grid-cols-12 gap-5">

            <div class="xl:col-span-12 lg:col-span-12 col-span-12">
                <div class="card">
                    <header class=" card-header">
                        <h4 class="card-title">@lang('site.Sales Graph')
                        </h4>
                    </header>
                    <div class="card-body px-6 pb-6">
                        <div id="areaChart"></div>
                    </div>
                </div>
            </div>

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
