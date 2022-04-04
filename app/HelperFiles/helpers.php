<?php

// // school types
// if (!function_exists('types')) {
//   function types($asStr = null)
//   {
//     if ($asStr == 'asString') {
//       return 'school,nursery,school_and_nursery';
//     }
//     return ['school', 'nursery', 'school_and_nursery'];
//   }
// }

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

if (!function_exists('background')) {
  function background($key = '')
  {
    $backgroud = App\Models\Background::where('key', $key)->first();
    return ($backgroud && $backgroud->image) ? $backgroud->image_path : asset('uploads/backgrounds/default.png');
  }
}
if (!function_exists('isTimeOverlapped')) {
  function isTimeOverlapped($periods)
  {
    if (count($periods) <= 1) {
      return;
    }
    // order periods by start_time
    usort($periods, function ($a, $b) {
      return strtotime($a['start_time']) <=> strtotime($b['start_time']);
    });

    // check two periods overlap
    foreach ($periods as $key => $period) {
      if ($key != 0) {

        $curr = $periods[$key];
        $prev = $periods[$key - 1];

        if (
          strtotime($curr['start_time']) < strtotime($prev['end_time'])
        ) {
          return true; // already overlaped
        }
      }
    }
    return false;
  }
}
if (!function_exists('getAdmin')) {
  function getAdmin()
  {
    return auth()->guard('admin')->user() ?? null;
  }
}
if (!function_exists('getCustomer')) {
  function getCustomer()
  {
    return auth()->guard('customer')->user() ?? auth()->guard('customer-api')->user();
  }
}
if (!function_exists('getPrincipal')) {
  function getPrincipal()
  {
    return auth()->guard('principal')->user() ?? null;
  }
}
if (!function_exists('weekDays')) {
  function weekDays()
  {
    return ['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
  }
}

if (!function_exists('communicationTypes')) {
  function communicationTypes()
  {
    return ['reserve_meeting', 'direct_contact'];
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

if (!function_exists('timeOldValue')) {
  function timeOldValue($value = null, $key = '0', $timeRange = null)
  {
    if (is_object($value)) { // from model
      $slot = $key == 0 ? $value->from_time : $value->to_time;
    } elseif ($value) { // from old value
      $value = explode('-', $value);
      $slot = $value[$key];
    } else {
      $slot = "00:00:00";
    }

    return $slot;
  }
}
