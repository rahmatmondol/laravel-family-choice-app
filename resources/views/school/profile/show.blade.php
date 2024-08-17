@extends($masterLayout)
<?php
$page = 'profile';
$title = __('site.Show school');
?>
@section('title_page')
    {{ $title }}
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <!-- BEGIN: Breadcrumb -->
    <div class="mb-5">
        <ul class="m-0 p-0 list-none">
            <li class="inline-block relative top-[3px] text-base text-primary-500 font-Inter ">
                <a href="{{ route($mainRoutePrefix . '.profile.edit') }}">
                    <iconify-icon icon="heroicons-outline:home"></iconify-icon>
                    <iconify-icon icon="heroicons-outline:chevron-right"
                        class="relative text-slate-500 text-sm rtl:rotate-180"></iconify-icon>
                </a>
            </li>
            <li class="inline-block relative text-sm text-slate-500 font-Inter dark:text-white">
                {{ $title }}</li>
        </ul>
       
    </div>
    <!-- END: BreadCrumb -->
    <div class="space-y-5 profile-page">
      @include('school.partials._edit_btn',[
        'txt'=>__('site.Edit Profile'),
        'route'=>route($mainRoutePrefix.'.profile.edit'),
        ])
        <div
            class="profiel-wrap px-[35px] pb-10 md:pt-[84px] pt-10 rounded-lg bg-white dark:bg-slate-800 lg:flex lg:space-y-0 space-y-6 justify-between items-end relative z-[1]">
            <div style="background-image: url('{{ $school->cover_path }}');background-repeat: no-repeat;background-size: cover;background-position: center top;"
                class="bg-slate-900 dark:bg-slate-700 absolute left-0 top-0 md:h-1/2 h-[150px] w-full z-[-1] rounded-t-lg">
            </div>
            <div class="profile-box flex-none md:text-start text-center">
                <div class="md:flex items-end md:space-x-6 rtl:space-x-reverse">
                    <div class="flex-none">
                        <div
                            class="md:h-[186px] md:w-[186px] h-[140px] w-[140px] md:ml-0 md:mr-0 ml-auto mr-auto md:mb-0 mb-4 rounded-full ring-4
                ring-slate-100 relative">
                            <img src="{{ $school->image_path }}" alt=""
                                class="w-full h-full object-cover rounded-full">
                        </div>
                    </div>
                    <div class="flex-1">
                      @lang('site.Title')
                        <div class="text-2xl font-medium text-slate-900 dark:text-slate-200 mb-[3px]">
                            {{ $school->title }}
                        </div>
                    </div>
                   
                </div>
               
            </div>
           
        </div>

        <div class="grid grid-cols-12 gap-6">
            <div class="lg:col-span-4 col-span-12">
                <div class="card h-full">
                    <header class="card-header">
                        <h4 class="card-title">User Overview</h4>
                    </header>
                    <div class="card-body p-6">
                        <ul class="list space-y-8">
                            <li class="flex space-x-3 rtl:space-x-reverse">
                                <div class="flex-none text-2xl text-slate-600 dark:text-slate-300">
                                    <iconify-icon icon="heroicons:envelope"></iconify-icon>
                                </div>
                                <div class="flex-1">
                                    <div class="uppercase text-xs text-slate-500 dark:text-slate-300 mb-1 leading-[12px]">
                                        @lang('site.E-mail')
                                    </div>
                                    <a href="mailto:someone@example.com"
                                        class="text-base text-slate-600 dark:text-slate-50">
                                        {{ $school->email }}
                                    </a>
                                </div>
                            </li>
                            <!-- end single list -->
                            <li class="flex space-x-3 rtl:space-x-reverse">
                                <div class="flex-none text-2xl text-slate-600 dark:text-slate-300">
                                    <iconify-icon icon="cib:whatsapp"></iconify-icon>
                                </div>
                                <div class="flex-1">
                                    <div class="uppercase text-xs text-slate-500 dark:text-slate-300 mb-1 leading-[12px]">
                                        @lang('site.Whatsapp')
                                    </div>
                                    <a href="tel:{{ $school->whatsapp }}"
                                        class="text-base text-slate-600 dark:text-slate-50">
                                        {{ $school->whatsapp }}
                                    </a>
                                </div>
                            </li>
                            <li class="flex space-x-3 rtl:space-x-reverse">
                                <div class="flex-none text-2xl text-slate-600 dark:text-slate-300">
                                    <iconify-icon icon="heroicons:phone-arrow-up-right"></iconify-icon>
                                </div>
                                <div class="flex-1">
                                    <div class="uppercase text-xs text-slate-500 dark:text-slate-300 mb-1 leading-[12px]">
                                        @lang('site.Phone')
                                    </div>
                                    <a href="tel:{{ $school->phone }}" class="text-base text-slate-600 dark:text-slate-50">
                                        {{ $school->phone }}
                                    </a>
                                </div>
                            </li>
                            <!-- end single list -->
                            <li class="flex space-x-3 rtl:space-x-reverse">
                                <div class="flex-none text-2xl text-slate-600 dark:text-slate-300">
                                    <iconify-icon icon="heroicons:map"></iconify-icon>
                                </div>
                                <div class="flex-1">
                                    <div class="uppercase text-xs text-slate-500 dark:text-slate-300 mb-1 leading-[12px]">
                                        @lang('site.Address')
                                    </div>
                                    <div class="text-base text-slate-600 dark:text-slate-50">
                                        {{ $school->address }}
                                    </div>
                                </div>
                            </li>
                            <!-- end single list -->
                            <li class="flex space-x-3 rtl:space-x-reverse">
                                <div class="flex-none text-2xl text-slate-600 dark:text-slate-300">
                                    <iconify-icon icon="heroicons:cog-6-tooth"></iconify-icon>
                                </div>
                                <div class="flex-1">
                                    <div class="uppercase text-xs text-slate-500 dark:text-slate-300 mb-1 leading-[12px]">
                                        @lang('site.Status')
                                    </div>
                                    <div class="text-base text-slate-600 dark:text-slate-50">
                                        @if ($school->status)
                                            <span
                                                class="badge bg-success-500 text-white capitalize">@lang('site.Active')</span>
                                        @else
                                            <span class="badge bg-danger-500 text-white capitalize">@lang('site.In-Active')</span>
                                        @endif
                                    </div>
                                </div>
                            </li>
                            <!-- end single list -->
                            <li class="flex space-x-3 rtl:space-x-reverse">
                                <div class="flex-none text-2xl text-slate-600 dark:text-slate-300">
                                    <iconify-icon icon="heroicons:building-office-2"></iconify-icon>
                                </div>
                                <div class="flex-1">
                                    <div class="uppercase text-xs text-slate-500 dark:text-slate-300 mb-1 leading-[12px]">
                                        @lang('site.Available seats')
                                    </div>
                                    <div class="text-base text-slate-600 dark:text-slate-50">
                                        {{ $school->available_seats }}
                                    </div>
                                </div>
                            </li>
                            <!-- end single list -->
                            <li class="flex space-x-3 rtl:space-x-reverse">
                                <div class="flex-none text-2xl text-slate-600 dark:text-slate-300">
                                    <iconify-icon icon="heroicons:building-office"></iconify-icon>
                                </div>
                                <div class="flex-1">
                                    <div class="uppercase text-xs text-slate-500 dark:text-slate-300 mb-1 leading-[12px]">
                                        @lang('site.Total seats')
                                    </div>
                                    <div class="text-base text-slate-600 dark:text-slate-50">
                                        {{ $school->total_seats }}
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="lg:col-span-8 col-span-12">
                <div class="card ">
                    <header class="card-header">
                        <h4 class="card-title">@lang('site.Description')
                        </h4>
                    </header>
                    <div class="card-body">
                        <div class="card-body p-6">
                            {{ $school->description }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-10 gap-6">
            <div class="lg:col-span-3 col-span-10">
                <div class="card h-full">
                    <header class="card-header">
                        <h4 class="card-title">@lang('site.Types')</h4>
                    </header>
                    <div class="card-body p-6">
                        <ul class="list space-y-4">
                            <li class="flex space-x-3 rtl:space-x-reverse">
                                <span class="badge bg-primary-500 text-white capitalize rounded-3xl">
                                    {{ $school->type?->title }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="lg:col-span-3 col-span-12">
                <div class="card h-full">
                    <header class="card-header">
                        <h4 class="card-title">@lang('site.Services')</h4>
                    </header>
                    <div class="card-body p-6">
                        <ul class="list space-y-4">
                            @foreach ($school->services as $service)
                                <li class="flex space-x-3 rtl:space-x-reverse">
                                    <span
                                        class="badge bg-primary-500 text-white capitalize rounded-3xl">{{ $service->title }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="lg:col-span-2 col-span-10">
                <div class="card h-full">
                    <header class="card-header">
                        <h4 class="card-title">@lang('site.EducationTypes')</h4>
                    </header>
                    <div class="card-body p-6">
                        <ul class="list space-y-4">
                            @foreach ($school->educationTypes as $educationType)
                                <li class="flex space-x-3 rtl:space-x-reverse">
                                    <span
                                        class="badge bg-primary-500 text-white capitalize rounded-3xl">{{ $educationType->title }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="lg:col-span-2 col-span-10">
                <div class="card h-full">
                    <header class="card-header">
                        <h4 class="card-title">@lang('site.SchoolTypes')</h4>
                    </header>
                    <div class="card-body p-6">
                        <ul class="list space-y-4">
                            @foreach ($school->schoolTypes as $schoolType)
                                <li class="flex space-x-3 rtl:space-x-reverse">
                                    <span
                                        class="badge bg-primary-500 text-white capitalize rounded-3xl">{{ $schoolType->title }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 col-span-10">
                <div class="card h-full">
                    <header class="card-header">
                        <h4 class="card-title">@lang('site.Grades')</h4>
                    </header>
                    <div class="card-body p-6">
                        <ul class="list space-y-4">
                            @foreach ($school->grades as $grade)
                                <li class="flex space-x-3 rtl:space-x-reverse">
                                    <span
                                        class="badge bg-primary-500 text-white capitalize rounded-3xl">{{ $grade->title }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-12 col-span-12">
                <div class="card h-full">
                    <header class="card-header">
                        <h4 class="card-title">@lang('site.Attachments')</h4>
                    </header>
                    <div class="card-body p-6">
                        <div class="grid xl:grid-cols-6 lg:grid-cols-3 md:grid-cols-3 grid-cols-1 gap-5">
                            @foreach ($school->schoolImages as $img)
                                <img src="{{ $img->image_path }}"
                                    class="rounded-md border-4 border-slate-300 max-w-full w-full block" alt="image">
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- /.content-wrapper -->
@endsection
