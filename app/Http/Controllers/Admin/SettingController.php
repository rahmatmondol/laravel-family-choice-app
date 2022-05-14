<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Traits\UploadFileTrait;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
  use UploadFileTrait;

  public function __construct()
  {
    //create read update delete
    $this->middleware(['permission:read_settings'])->only('index');
    $this->middleware(['permission:create_settings'])->only('create');
    $this->middleware(['permission:update_settings'])->only('edit');
    $this->middleware(['permission:delete_settings'])->only('destroy');
  } // end of constructor


  public function edit()
  {
    return view('dashboard.settings.edit');
  }

  public function update(Request $request)
  {

    $request->validate([
      'logo' => validateImage(),
      'icon' => validateImage(),
    ]);

    $request_data = $request->except(['logo', 'icon']);

    foreach (['logo', 'icon'] as $img) {
      if ($request->$img) {
        $request_data[$img] = $this->uploadImages($request->$img, 'settings/', setting($img));
      } //end of external if
    }

    setting($request_data)->save();

    session()->flash('success', __('site.Data added successfully'));
    return redirect()->back();
  }
}
