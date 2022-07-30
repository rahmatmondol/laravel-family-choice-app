<?php

if (!function_exists('appName')) {
  function appName()
  {
    return "Family Choice App";
  }
}

if (!function_exists('appCurrency')) {
  function appCurrency()
  {
    return __('site.app.Currency');
  }
}

if (!function_exists('checkAdminPermission')) {
  function checkAdminPermission($permission)
  {
    return getAdmin()->hasPermission($permission) ? true : false;
  }
}

if (!function_exists('getModules')) {
  function getModules()
  {
    return array_keys(config('application_modules.modules'));
  }
}

if (!function_exists('getAdmin')) {
  function getAdmin()
  {
    return auth()->guard('admin')->user() ?? null;
  }
}

if (!function_exists('getAuthSchool')) {
  function getAuthSchool()
  {
    return auth()->guard('school')->user() ?? null;
  }
}

if (!function_exists('getCustomer')) {
  function getCustomer()
  {
    return auth()->guard('customer')->user() ?? auth()->guard('customer-api')->user();
  }
}
#validate helper function
if (!function_exists('validateImage')) {
  function validateImage($ext = null)
  {

    if ($ext == null) {
      return 'image|mimes:jpg,jpeg,png,bmp,JPG,JPEG,PNG';
    } else {
      return 'image|mimes:' . $ext;
    }

    // $return = [
    //   'image',
    //   'max:2048',
    // ];

    // if ($ext == null) {
    //   $return[]  = 'mimes:jpg,jpeg,png,bmp,JPG,JPEG,PNG,BMP';
    // } else {
    //   $return[]  = 'mimes:' . $ext;
    // }

    // return $return;
  }
}

if (!function_exists('tables')) {
  function tables()
  {
    return ['admins'];
  }
}

if (!function_exists('modelStatus')) {
  function modelStatus($active)
  {

    $html = '';
    if ($active == 1) {
      $html = '<i class="far fa-check-square"></i>';
      // $html = "<small class='btn-xs btn-success'>" . __('site.Active') . "</small>";
    } else {
      $html = '<i class="fas fa-times"></i>';
      // $html = "<small class='btn-xs btn-danger'>" . __('site.In-Active') . "</small>";
    }
    return $html;
  }
}

if (!function_exists('fillAllRequiredData')) {
  function fillAllRequiredData()
  {
    return "<span style='color:red'>" . __('site.please fill all required fields') . "</span>";
  }
}


if (!function_exists('setPreviousUrl')) {
  function setPreviousUrl()
  {

    $urlPrevious = url()->previous();
    $urlBase = url()->to('/');

    // Set the previous url that we came from to redirect to after successful login but only if is internal
    if (($urlPrevious != $urlBase . '/login') && (substr($urlPrevious, 0, strlen($urlBase)) === $urlBase)) {
      session()->put('url.intended', $urlPrevious);
    }

    return true;
  }
}

if (!function_exists('perPage')) {
  function perPage()
  {
    return [1, 10, 20, 30, 40, 50];
  }
}
