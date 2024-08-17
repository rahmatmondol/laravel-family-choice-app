 <!-- BEGIN: Header -->
 <div class="z-[9]" id="app_header">
     <div
         class="app-header z-[999] ltr:ml-[248px] rtl:mr-[248px] bg-white dark:bg-slate-800 shadow-sm dark:shadow-slate-700">
         <div class="flex justify-between items-center h-full">
             <div class="flex items-center md:space-x-4 space-x-2 xl:space-x-0 rtl:space-x-reverse vertical-box">
                
                 <button class="smallDeviceMenuController hidden md:inline-block xl:hidden">
                     <iconify-icon
                         class="leading-none bg-transparent relative text-xl top-[2px] text-slate-900 dark:text-white"
                         icon="heroicons-outline:menu-alt-3"></iconify-icon>
                 </button>
                 <button
                     class="flex items-center xl:text-sm text-lg xl:text-slate-400 text-slate-800 dark:text-slate-300 px-1 rtl:space-x-reverse search-modal"
                     data-bs-toggle="modal" data-bs-target="#searchModal">
                     <iconify-icon icon="heroicons-outline:search"></iconify-icon>
                     <span class="xl:inline-block hidden ml-3">Search...
                     </span>
                 </button>
             </div>
             <!-- end vertcial -->

             <div class="items-center space-x-4 rtl:space-x-reverse horizental-box">
                 <button class="smallDeviceMenuController  open-sdiebar-controller xl:hidden inline-block">
                     <iconify-icon
                         class="leading-none bg-transparent relative text-xl top-[2px] text-slate-900 dark:text-white"
                         icon="heroicons-outline:menu-alt-3"></iconify-icon>
                 </button>
             </div>
             <!-- end horizental -->

             <div class="nav-tools flex items-center lg:space-x-5 space-x-3 rtl:space-x-reverse leading-0">

                 <!-- BEGIN: Language Dropdown  -->
                 <div class="relative">
                     <?php
                     $language = '';
                     $language_code = '';
                     foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
                         if (app()->getLocale() == $localeCode) {
                             $language = $properties['native'];
                             $language_code = $localeCode;
                         }
                     }
                     ?>
                     <button
                         class="text-slate-800 dark:text-white focus:ring-0 focus:outline-none font-medium rounded-lg text-sm text-center inline-flex items-center"
                         type="button" data-bs-toggle="dropdown" aria-expanded="false">
                         <iconify-icon icon="circle-flags:{{ $language_code }}"
                             class="mr-0 md:mr-2 rtl:ml-2 text-xl"></iconify-icon>
                         <span class="text-sm md:block hidden font-medium text-slate-600 dark:text-slate-300">
                             {{ $language }}</span>
                     </button>
                     <!-- Language Dropdown menu -->
                     <div
                         class="dropdown-menu z-10 hidden bg-white divide-y divide-slate-100 shadow w-44 dark:bg-slate-800 border dark:border-slate-900 !top-[25px] rounded-md overflow-hidden">
                         <ul class="py-1 text-sm text-slate-800 dark:text-slate-200">
                             @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                 @if (app()->getLocale() != $localeCode)
                                     <li>
                                         <a hreflang="{{ $localeCode }}"
                                             href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                                             class="flex items-center px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-white">
                                             <iconify-icon icon="circle-flags:{{ $localeCode }}"
                                                 class="ltr:mr-2 rtl:ml-2 text-xl"></iconify-icon>
                                             <span class="font-medium"> {{ $properties['native'] }}</span>
                                         </a>
                                     </li>
                                 @endif
                             @endforeach

                         </ul>
                     </div>

                 </div>
                 <!-- END: Language Dropdown -->

                 <!-- BEGIN: Profile Dropdown -->
                 <!-- Profile DropDown Area -->
                 <div class="md:block hidden w-full">
                     <button
                         class="text-slate-800 dark:text-white focus:ring-0 focus:outline-none font-medium rounded-lg text-sm text-center inline-flex items-center"
                         type="button" data-bs-toggle="dropdown" aria-expanded="false">
                         <span
                             class="flex-none text-slate-600 dark:text-white text-sm font-normal items-center lg:flex hidden overflow-hidden text-ellipsis whitespace-nowrap">
                             {{ auth()->user()->title }}</span>
                         <svg class="w-[16px] h-[16px] dark:text-white hidden lg:inline-block text-base inline-block ml-[10px] rtl:mr-[10px]"
                             aria-hidden="true" fill="none" stroke="currentColor" viewbox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                 d="M19 9l-7 7-7-7"></path>
                         </svg>
                     </button>
                     <!-- Dropdown menu -->
                     <div
                         class="dropdown-menu z-10 hidden bg-white divide-y divide-slate-100 shadow w-44 dark:bg-slate-800 border dark:border-slate-700 !top-[23px] rounded-md overflow-hidden">
                         <ul class="py-1 text-sm text-slate-800 dark:text-slate-200">
                             <li>
                                 <a href="{{ route($mainRoutePrefix . '.dashboard') }}"
                                     class="block px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-white font-inter text-sm text-slate-600 dark:text-white font-normal">
                                     <iconify-icon icon="heroicons-outline:home"
                                         class="relative top-[2px] text-lg ltr:mr-1 rtl:ml-1"></iconify-icon>
                                     <span class="font-Inter"> {{ ucfirst(__('site.Dashboard')) }}</span>
                                 </a>
                             </li>

                             <li>
                                 <a href="s{{ route($mainRoutePrefix . '.profile.change-password') }}"
                                     class="block px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-white font-inter text-sm text-slate-600 dark:text-white font-normal">
                                     <iconify-icon icon="heroicons-outline:key"
                                         class="relative top-[2px] text-lg ltr:mr-1 rtl:ml-1"></iconify-icon>
                                     <span class="font-Inter">{{ ucfirst(__('site.Change Password')) }}</span>
                                 </a>
                             </li>

                             <li>
                                 <a href="{{ route('school.logout') }}"
                                     onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();"
                                     class="block px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-white font-inter text-sm text-slate-600 dark:text-white font-normal">
                                     <iconify-icon icon="heroicons-outline:login"
                                         class="relative top-[2px] text-lg ltr:mr-1 rtl:ml-1"></iconify-icon>
                                     <span class="font-Inter">@lang('site.Logout')</span>
                                     <form id="logout-form" action="{{ route('school.logout') }}" method="get"
                                         style="display: none;">
                                         @csrf
                                     </form>
                                 </a>
                             </li>
                         </ul>
                     </div>
                 </div>
                 <!-- END: Header -->
                 <button class="smallDeviceMenuController md:hidden block leading-0">
                     <iconify-icon class="cursor-pointer text-slate-900 dark:text-white text-2xl"
                         icon="heroicons-outline:menu-alt-3"></iconify-icon>
                 </button>
                 <!-- end mobile menu -->
             </div>
             <!-- end nav tools -->
         </div>
     </div>
 </div>

 <!-- BEGIN: Search Modal -->
 <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
     id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
     <div class="modal-dialog relative w-auto pointer-events-none top-1/4">
         <div
             class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white dark:bg-slate-900 bg-clip-padding rounded-md outline-none text-current">
             <form>
                 <div class="relative">
                     <input type="text" class="form-control !py-3 !pr-12" placeholder="Search">
                     <button
                         class="absolute right-0 top-1/2 -translate-y-1/2 w-9 h-full border-l text-xl border-l-slate-200 dark:border-l-slate-600 dark:text-slate-300 flex items-center justify-center">
                         <iconify-icon icon="heroicons-solid:search"></iconify-icon>
                     </button>
                 </div>
             </form>
         </div>
     </div>
 </div>
 <!-- END: Search Modal -->
