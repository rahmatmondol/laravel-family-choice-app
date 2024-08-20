@extends($masterLayout)
<?php
$page = 'customers';
$title = __('site.Show Customer');
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
                <a href="index.html">
                    <iconify-icon icon="heroicons-outline:home"></iconify-icon>
                    <iconify-icon icon="heroicons-outline:chevron-right"
                        class="relative text-slate-500 text-sm rtl:rotate-180"></iconify-icon>
                </a>
            </li>
            <li class="inline-block relative text-sm text-slate-500 font-Inter dark:text-white">
                <a href="{{ route($mainRoutePrefix . '.reservations.index') }}">
                    @lang('site.Reservations')
                    <iconify-icon icon="heroicons-outline:chevron-right"
                        class="relative text-slate-500 text-sm rtl:rotate-180"></iconify-icon>
                </a>
            </li>
            <li class="inline-block relative text-sm text-slate-500 font-Inter dark:text-white">
                {{ $title }}</li>
        </ul>
    </div>
    <!-- END: BreadCrumb -->


    <div class="grid xl:grid-cols-1 grid-cols-1 gap-5">
        <!-- BEGIN: Bordered Table -->
        <div class="card">
            <header class=" card-header noborder">
                <h4 class="card-title">
                    {{ $title }}
                </h4>
            </header>
            <div class="card-body px-6 pb-6">
                <div class="overflow-x-auto ">
                    <div class="inline-block min-w-full align-middle">
                        <div class="overflow-hidden ">
                            <table class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700">
                                <tbody class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">

                                    <tr>
                                        <td style="width: 40%;"
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            @lang('site.Name')</td>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            {{ $customer->full_name }}</td>
                                    </tr>

                                    <tr>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            @lang('site.E-mail')</td>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            {{ $customer->email }}</td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            @lang('site.Phone')</td>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            {{ $customer->phone }}</td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            @lang('site.Date of birth')</td>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            {{ $customer->date_of_birth }}</td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            @lang('site.Gender')</td>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            @lang('site.' . ucfirst($customer->gender))</td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            @lang('site.Status')</td>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            @include('admin.partials._render_status', [
                                                'status' => $customer->status,
                                            ])
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            @lang('site.Verified')</td>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            @include('admin.partials._render_status', [
                                                'status' => $customer->verified,
                                            ])
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            @lang('site.Image')</td>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            <img src="{{ $customer->image_path }}" style="width: 100px"
                                                class="img-thumbnail image-preview1" alt="">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Bordered Table -->
    </div>
    <!-- /.content-wrapper -->
@endsection
