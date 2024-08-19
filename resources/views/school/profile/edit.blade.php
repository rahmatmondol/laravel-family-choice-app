@extends($masterLayout)
<?php
$page = 'schools';
$title = __('site.Edit Profile');
$latitude = old('lat', $school->lat) ?? 24.713552;
$longitude = old('lng', $school->lng) ?? 46.675297;
?>
@section('title_page')
    {{ $title }}
@endsection


@section('content')
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
                {{ $title }}</li>
        </ul>
    </div>
    <!-- END: BreadCrumb -->
    <form method="post" action="{{ route($mainRoutePrefix . '.profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('put')
        @include('admin.partials._errors')
        <div class="grid xl:grid-cols-2 grid-cols-1 gap-6">
            @foreach (LaravelLocalization::getSupportedLocales() as $locale => $properties)
                <div class="card">
                    <div class="card-body flex flex-col p-6">
                        <header
                            class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                            <div class="flex-1">
                                <div class="card-title text-slate-900 dark:text-white">{{ $properties['name'] }}</div>
                            </div>
                        </header>
                        <div class="card-text h-full space-y-4">
                            {{-- title --}}
                            <div class="input-area">
                                <label class="form-label">@lang('site.Title')</label>
                                <input required="required" name="{{ $locale }}[title]"
                                    value="{{ old($locale . '.title', $school->translate($locale)->title) }}" type="text"
                                    class="form-control">
                            </div>

                            {{-- address --}}
                            <div class="input-area">
                                <label class="form-label">@lang('site.Address')</label>
                                <input required="required" name="{{ $locale }}[address]"
                                    value="{{ old($locale . '.address', $school->translate($locale)->address) }}"
                                    type="text" class="form-control">
                            </div>

                            {{-- address --}}
                            <div class="input-area">
                                <label class="form-label">@lang('site.Description')</label>
                                <textarea rows="10" name="{{ $locale }}[description]" class="form-control">{{ old($locale . '.description', $school->translate($locale)->description) }}</textarea>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
            <div class="card">
                <div class="card-body flex flex-col p-6">
                    <div class="card-text h-full space-y-4">
                        <div class="input-area">
                            <label for="email" class="form-label">@lang('site.E-mail')</label>
                            <input type="email" name="email" value="{{ old('email', $school->email) }}" required
                                class="form-control">
                        </div>

                        <div class="input-area">
                            <label>@lang('site.Phone')</label>
                            <input required="required" type="text" name="phone" class="form-control"
                                value="{{ old('phone', $school->phone) }}"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                        </div>

                        <div class="input-area">
                            <label>@lang('site.Whatsapp')</label>
                            <input required="required" type="text" name="whatsapp" class="form-control"
                                value="{{ old('whatsapp', $school->whatsapp) }}"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                        </div>

                        <div class="input-area">
                            <label>@lang('site.Address')</label>
                            <input type="text" name='address' class="form-control" id="address">
                        </div>
                        {{-- <input type="hidden" class="form-control" id="lat" name="lat"
                        value="{!! $lat !!}">

                    <input type="hidden" class="form-control" id="lng" name="lng"
                        value="{!! $lng !!}"> --}}
                        <div class="input-area">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d29355.007391381256!2d{{ $longitude }}!3d{{ $latitude }}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sbd!4v1723961144046!5m2!1sen!2sbd"
                                width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body flex flex-col p-6">
                    <div class="card-text h-full space-y-4">
                        {{-- types --}}
                        <div class="input-area">
                            <label for="inputType">@lang('site.Types')</label>
                            <select name="type_id" class="form-control mt-2" required>
                                <option value="">@lang('site.Types') </option>
                                @foreach ($types as $value)
                                    <option value="{{ $value->id }}" @selected(old('type_id') == $value->id || $school->type_id == $value->id)>
                                        {{ $value->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- educationalSubjects --}}
                        <div class="input-area">
                            <label for="inputType">@lang('site.EducationalSubjects')</label>
                            <select name="educationalSubjects[]" class="select2 form-control w-full mt-2 py-2"
                                multiple="multiple" data-live-search="true" required>
                                <option value="">@lang('site.EducationalSubjects') </option>
                                @foreach ($educationalSubjects as $value)
                                    <option value="{{ $value->id }}" @if (in_array($value->id, $school->educationalSubjects->pluck('id')->toArray()) ||
                                            in_array($value->id, (array) old('educationalSubjects'))) selected @endif>
                                        {{ $value->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- educationTypes --}}
                        <div class="input-area">
                            <label for="inputType">@lang('site.EducationTypes')</label>
                            <select name="educationTypes[]" class="select2 form-control w-full mt-2 py-2"
                                multiple="multiple" data-live-search="true" required>
                                <option value="">@lang('site.EducationTypes') </option>
                                @foreach ($educationTypes as $value)
                                    <option value="{{ $value->id }}" @if (in_array($value->id, $school->educationTypes->pluck('id')->toArray()) ||
                                            in_array($value->id, (array) old('educationTypes'))) selected @endif>
                                        {{ $value->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- schoolTypes --}}
                        <div class="input-area">
                            <label for="inputType">@lang('site.SchoolTypes')</label>
                            <select name="schoolTypes[]" class="select2 form-control w-full mt-2 py-2"
                                multiple="multiple" data-live-search="true" required>
                                <option value="">@lang('site.SchoolTypes') </option>
                                @foreach ($schoolTypes as $value)
                                    <option value="{{ $value->id }}" @if (in_array($value->id, $school->schoolTypes->pluck('id')->toArray()) ||
                                            in_array($value->id, (array) old('schoolTypes'))) selected @endif>
                                        {{ $value->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- services --}}
                        <div class="input-area">
                            <label for="inputType">@lang('site.Services')</label>
                            <select name="services[]" class="select2 form-control w-full mt-2 py-2" multiple
                                data-live-search="true" required>
                                <option value="">@lang('site.Services') </option>
                                @foreach ($services as $value)
                                    <option value="{{ $value->id }}" @if (in_array($value->id, $school->services->pluck('id')->toArray()) || in_array($value->id, (array) old('services'))) selected @endif>
                                        {{ $value->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- available_seats --}}
                        <div class="input-area">
                            <label>@lang('site.Available seats')</label>
                            <input required="required" type="text" name="available_seats" class="form-control mt-2"
                                value="{{ old('available_seats', $school->available_seats) }}"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                        </div>

                        {{-- total_seats --}}
                        <div class="input-area">
                            <label>@lang('site.Total seats')</label>
                            <input required="required" type="text" name="total_seats" class="form-control mt-2"
                                value="{{ old('total_seats', $school->total_seats) }}"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                        </div>

                        {{-- status --}}
                        <div class="input-area">
                            <label for="inputStatus">@lang('site.Status')</label>
                            <select id="inputStatus" name="status" required class="form-control custom-select">
                                <option value='' selected disabled>@lang('site.Status')</option>
                                <option value="1" @if (old('status', $school->status) == 1) selected @endif>@lang('site.Active')
                                </option>
                                <option value="0" @if (old('status', $school->status) == 0) selected @endif>@lang('site.In-Active')
                                </option>
                            </select>
                        </div>

                        {{-- passwrod --}}
                        <div class="input-area">
                            <label>@lang('site.Password')</label>
                            <input type="password" name="password" class="form-control mt-2">
                        </div>

                        {{-- password_confirmation --}}
                        <div class="input-area">
                            <label>@lang('site.Password Confirmation')</label>
                            <input type="password" name="password_confirmation" class="form-control mt-2">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid xl:grid-cols-2 grid-cols-1 gap-6 mt-6">
            {{-- image --}}
            <div class="card rounded-md bg-white dark:bg-slate-800 lg:h-full shadow-base">
                <div class="card-body flex flex-col p-6">
                    <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                        <div class="flex-1">
                            <div class="card-title text-slate-900 dark:text-white">@lang('site.Image')</div>
                        </div>
                    </header>
                    <div class="card-text h-full space-y-6">
                        <div class="input-area">
                            <div class="filePreview-image">
                                <label>
                                    <input type="file" class=" w-full hidden" id='image' name="image">
                                    <span class="w-full h-[40px] file-control flex items-center custom-class">
                                        <span class="flex-1 overflow-hidden text-ellipsis whitespace-nowrap">
                                            <span id="placeholder" class="text-slate-400">Choose a file or drop it
                                                here...</span>
                                        </span>
                                        <span
                                            class="file-name flex-none cursor-pointer border-l px-4 border-slate-200 dark:border-slate-700 h-full inline-flex items-center bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400 text-sm rounded-tr rounded-br font-normal">Browse</span>
                                    </span>
                                </label>
                                <div class="file-preview">
                                    <img src="{{ $school->image_path }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- cover --}}
            <div class="card rounded-md bg-white dark:bg-slate-800 lg:h-full shadow-base">
                <div class="card-body flex flex-col p-6">
                    <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                        <div class="flex-1">
                            <div class="card-title text-slate-900 dark:text-white">@lang('site.Cover')</div>
                        </div>
                    </header>
                    <div class="card-text h-full space-y-6">
                        <div class="input-area">
                            <div class="filePreview-cover">
                                <label>
                                    <input type="file" class=" w-full hidden" id='cover' name="cover">
                                    <span class="w-full h-[40px] file-control flex items-center custom-class">
                                        <span class="flex-1 overflow-hidden text-ellipsis whitespace-nowrap">
                                            <span id="placeholder" class="text-slate-400">Choose a file or drop it
                                                here...</span>
                                        </span>
                                        <span
                                            class="file-name flex-none cursor-pointer border-l px-4 border-slate-200 dark:border-slate-700 h-full inline-flex items-center bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400 text-sm rounded-tr rounded-br font-normal">Browse</span>
                                    </span>
                                </label>
                                <div class="file-preview">
                                    <img src="{{ $school->cover_path }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- attachments --}}
        <div class="grid xl:grid-cols-1 grid-cols-1 gap-6 mt-6">
            <div class="card rounded-md bg-white dark:bg-slate-800 lg:h-full shadow-base">
                <div class="card-body flex flex-col p-6">
                    <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                        <div class="flex-1">
                            <div class="card-title text-slate-900 dark:text-white">@lang('site.Attachments')</div>
                        </div>
                    </header>
                    <div class="card-text h-full space-y-6">
                        <div class="input-area">
                            <div class="filePreview-attachments">
                                <label>
                                    <input type="file" class="w-full hidden" id='attachments' name="attachments[]"
                                        multiple />
                                    <span class="w-full h-[40px] file-control flex items-center custom-class">
                                        <span class="flex-1 overflow-hidden text-ellipsis whitespace-nowrap">
                                            <span id="placeholder" class="text-slate-400">Choose a file or drop it
                                                here...</span>
                                        </span>
                                        <span
                                            class="file-name flex-none cursor-pointer border-l px-4 border-slate-200 dark:border-slate-700 h-full inline-flex items-center bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400 text-sm rounded-tr rounded-br font-normal">Browse</span>
                                    </span>
                                </label>
                                <div class="file-preview">
                                    @foreach ($school->schoolImages as $imgs)
                                        <img src="{{ $imgs->image_path }}">
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- save --}}
        <div class="grid xl:grid-cols-1 grid-cols-1 gap-6 mt-6">
            <div class="card rounded-md bg-white dark:bg-slate-800 lg:h-full shadow-base">
                <div class="card-body flex flex-col p-6">
                    <div class="card-text h-full space-y-6">
                        <div class="input-area">
                            <button class="btn inline-flex justify-center btn-primary" type="submit" name='continue' value='continue'><i
                                    class="fas fa-save"></i>
                                @lang('site.Save & Continue')</button>
                            <button class="btn inline-flex justify-center btn-primary" type="submit"><i class="fas fa-save"></i>
                                @lang('site.Save')</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
@endsection
