@extends($masterLayout)
<?php
$page = 'courses';
$title = __('site.Courses');
?>
@section('title_page')
    {{ $title }}
@endsection
@section('content')
    <!-- BEGIN: Breadcrumb -->
    <div class="mb-5">
        <ul class="m-0 p-0 list-none">
            <li class="inline-block relative top-[3px] text-base text-primary-500 font-Inter ">
                <a href="{{ route('school.dashboard') }}">
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

    <div class=" space-y-5">

        <div class="card">
            <header class=" card-header noborder">
                <h4 class="card-title"> {{ $title }}
                </h4>
                @if (checkAdminPermission('create_courses'))
                    <a href="{{ route($mainRoutePrefix . '.courses.create') }}" class="btn btn-sm btn-primary">
                        <iconify-icon icon="heroicons:folder-plus"></iconify-icon>
                        @lang('site.Add')</a>
                @endif
            </header>
            <div class="card-body px-6 pb-6">
                <div class="overflow-x-auto -mx-6 dashcode-data-table">
                    <span class=" col-span-8  hidden"></span>
                    <span class="  col-span-4 hidden"></span>
                    <div class="inline-block min-w-full align-middle">
                        <div class="overflow-hidden ">
                            <table
                                class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700 data-table">
                                <thead class=" bg-slate-200 dark:bg-slate-700">
                                    <tr>
                                        <th scope="col" class=" table-th ">
                                            Id
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            @lang('site.Title')
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            @lang('site.Type')
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            @lang('site.Subscription')
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            @lang('site.From Date')
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            @lang('site.To Date')
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            @lang('site.Image')
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            @lang('site.Status')
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            @lang('site.table.Order Item')
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            @lang('site.Actions')
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                    @forelse ($courses as $course)
                                        <tr>
                                            <td class="table-td"> {{ $loop->iteration }}</td>
                                            <td class="table-td "> {{ $course->title }}</td>
                                            <td class="table-td "> @lang('site.' . ucfirst($course->type))</td>
                                            <td class="table-td "> {{ $course->subscription?->title }}</td>
                                            <td class="table-td "> {{ $course->from_date }}</td>
                                            <td class="table-td "> {{ $course->to_date }}</td>

                                            <td class="table-td">
                                                <a href="{{ $course->image_path }}">
                                                    <span class="flex">
                                                        <span class="w-7 h-7 rounded-full ltr:mr-3 rtl:ml-3 flex-none">
                                                            <img src="{{ $course->image_path }}" alt=""
                                                                class="object-cover w-full h-full rounded-full">
                                                        </span>
                                                    </span>
                                                </a>
                                            </td>

                                            <td class="table-td ">
                                                @if ($course->status)
                                                    <div
                                                        class="inline-block px-3 min-w-[90px] text-center mx-auto py-1 rounded-[999px] bg-opacity-25 text-success-500 bg-success-500">
                                                        @lang('site.Active')
                                                    </div>
                                                @else
                                                    <div
                                                        class="inline-block px-3 min-w-[90px] text-center mx-auto py-1 rounded-[999px] bg-opacity-25 text-danger-500 bg-danger-500">
                                                        @lang('site.In-Active')
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="table-td "> {{ $course->order_column }}</td>

                                            <td class="table-td ">
                                                <div class="flex space-x-3 rtl:space-x-reverse">
                                                    <a href="{{ route($mainRoutePrefix . '.courses.show', ['course' => $course->id]) }}"
                                                        class="action-btn">
                                                        <iconify-icon icon="heroicons:eye"></iconify-icon>
                                                    </a>
                                                    <a href="{{ route($mainRoutePrefix . '.courses.edit', ['course' => $course->id]) }}"
                                                        class="action-btn">
                                                        <iconify-icon icon="heroicons:pencil-square"></iconify-icon>
                                                    </a>
                                                    @include('school.partials._destroy_btn', [
                                                        'txt' => __('site.Delete'),
                                                        'route' => route(
                                                            $mainRoutePrefix . '.courses.destroy',
                                                            $course->id),
                                                    ])

                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td>
                                                @include('school.partials.no_data_found')
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $courses->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
