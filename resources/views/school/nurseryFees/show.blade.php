@extends($masterLayout)
<?php
$page = 'nurseryFees';
$title = __('site.Show NurseryFees');
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
                <a href="{{ route($mainRoutePrefix . '.nurseryFees.index') }}">
                    @lang('site.NurseryFees')
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
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            @lang('site.Title')</td>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            {{ $nurseryFees->school->title }}</td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            @lang('site.Price')</td>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            {{ $nurseryFees->price }}</td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            @lang('site.Order Item')</td>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            {{ $nurseryFees->order_column }}</td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            @lang('site.Status')</td>
                                        <td
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            @if ($nurseryFees->status)
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
