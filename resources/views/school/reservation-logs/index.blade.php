@extends($masterLayout)
<?php
$page = 'logs';
$title = __('site.Logs');
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
                                            #
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            @lang('site.Reservation Number')
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            @lang('site.Description')
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            @lang('site.User Name')
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            @lang('site.User Type')
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            @lang('site.Created At')
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                    @forelse ($logs as $log)
                                        <tr>
                                            <td class="table-td"> {{ $loop->iteration }}</td>
                                            <td class="table-td ">{{ $log->subject_id }}</td>
                                            <td class="table-td "> {{ $log->description }}</td>
                                            <td class="table-td "> {{ $log->causer_full_name }}</td>
                                            <td class="table-td "> {{ $log->causer_model_type }}</td>
                                            <td class="table-td ">{{ $log->created_at }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                          <td></td>
                                          <td></td>
                                            <td>
                                                @include('school.partials.no_data_found')
                                            </td>
                                          <td></td>
                                          <td></td>
                                          <td></td>

                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $logs->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
