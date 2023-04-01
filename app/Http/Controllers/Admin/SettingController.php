<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Traits\UploadFileTrait;
use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Admin\SettingFormRequest;

class SettingController extends BaseController
{
  use UploadFileTrait;

  public function __construct()
  {
    parent::__construct();
    //create read update delete
    // $this->middleware(['permission:read_settings'])->only('index');
    // $this->middleware(['permission:create_settings'])->only('create');
    // $this->middleware(['permission:update_settings'])->only('edit');
    // $this->middleware(['permission:delete_settings'])->only('destroy');
  } // end of constructor

  public function settings(Request $request)
  {
    return view('admin.settings.index');
  }

  public function update(SettingFormRequest $request)
  {
    $request_data = $request->only(['terms_conditions','privacy_policy','phone','email','partial_payment_percent','refund_fees_percent']);

    setting($request_data)->save();

    session()->flash('success', __('site.Data added successfully'));
    return redirect()->back();
  }
}
