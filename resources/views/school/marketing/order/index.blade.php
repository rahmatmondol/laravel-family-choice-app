@extends($masterLayout)
<?php
$page = 'Discount';
$title = 'Discount';
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
            <div class="card-body px-6 pb-6">
                <form action="{{ route($mainRoutePrefix . '.discount.view') }}" method="get">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pt-4">
                        <div class="input-area">
                            <select name="status" class="form-control custom-select">
                                <option value="active">Active </option>
                                <option value="inactive">In Active </option>
                            </select>
                        </div>
                        <div class="input-area">
                            <button type="submit" class="btn btn-sm btn-primary"><iconify-icon
                                    icon="heroicons-outline:search"></iconify-icon>
                                @lang('site.Search')</button>
                            @if (checkAdminPermission('create_courses'))
                                <a href="{{ route($mainRoutePrefix . '.discount.add') }}" class="btn btn-sm btn-primary"><i
                                        class="fa fa-plus"></i>
                                    @lang('site.Add')</a>
                            @endif
                        </div>
                    </div>
                </form><!-- end of form -->
            </div>
        </div>
    </div>
    {{-- table --}}
    <div class="card mt-4">
        <div class="card-body px-6 pb-6">
            <div class="overflow-x-auto -mx-6 dashcode-data-table">

                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden ">
                        <table class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700 data-table">
                            <thead class=" bg-slate-200 dark:bg-slate-700">
                                <tr>
                                    <th scope="col" class=" table-th " style="width: 1%">
                                        #
                                    </th>
                                    <th scope="col" class=" table-th " style="width: 20%">
                                        @lang('site.Title')
                                    </th>
                                    <th scope="col" class=" table-th " style="width: 20%">
                                        @lang('site.Type')
                                    </th>
                                    <th scope="col" class=" table-th " style="width: 20%">
                                        Discount Amount
                                    </th>
                                    <th scope="col" class=" table-th " style="width: 20%">
                                        Discount Percentage
                                    </th>
                                    <th scope="col" class=" table-th " style="width: 20%">
                                        Minimum Amount
                                    </th>
                                    <th scope="col" class=" table-th " style="width: 20%">
                                        Starting Date
                                    </th>
                                    <th scope="col" class=" table-th " style="width: 20%">
                                        Ending Date
                                    </th>
                                    <th scope="col" class=" table-th " style="width: 20%">
                                        Status
                                    </th>

                                    <th scope="col" class=" table-th " style="width: 20%">
                                        @lang('site.Actions')
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                @forelse($data as $discount)
                                    <tr>
                                        <td class="table-td text-center">{{ $loop->iteration }}</td>
                                        <td class="table-td text-center">{{ $discount->title }}</td>
                                        <td class="table-td text-center">{{ ucfirst($discount->discount_type) }}</td>
                                        <td class="table-td text-center">{{ $discount->discount_amount ?? 0 }} EAD</td>
                                        <td class="table-td text-center">{{ $discount->percentage_discount ?? 0 }} %</td>
                                        <td class="table-td text-center">{{ $discount->minimum_amount }} EAD</td>
                                        <td class="table-td text-center">{{ $discount->starting_date->format('F j, Y') }}
                                        </td>
                                        <td class="table-td text-center">{{ $discount->ending_date->format('F j, Y') }}
                                        </td>
                                        <td class="table-td text-center">{{ ucfirst($discount->status) }}</td>
                                        <td class="table-td ">
                                            <div class="flex space-x-3 rtl:space-x-reverse">
                                                <a href="{{ route($mainRoutePrefix . '.discount.show', ['id' => $discount->id]) }}"
                                                    class="action-btn">
                                                    <iconify-icon icon="heroicons:eye"></iconify-icon>
                                                </a>
                                                @include('school.partials._destroy_btn', [
                                                    'txt' => __('site.Delete'),
                                                    'route' => route('school.discount.delete', [
                                                        'id' => $discount->id,
                                                    ]),
                                                ])
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            @include('school.partials.no_data_found')
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
