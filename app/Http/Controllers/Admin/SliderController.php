<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\SchoolRepositoryInterface;
use App\Interfaces\SliderRepositoryInterface;
use App\Http\Requests\Admin\SliderFormRequest;

class SliderController extends Controller
{

  public function __construct(

    private SchoolRepositoryInterface $schoolRepository,
    private SliderRepositoryInterface $sliderRepository
  ) {
    //create read update delete
    $this->middleware(['permission:read_sliders'])->only('index');
    $this->middleware(['permission:create_sliders'])->only('create');
    $this->middleware(['permission:update_sliders'])->only('edit');
    $this->middleware(['permission:delete_sliders'])->only('destroy');
  } //end of constructor

  public function index(Request $request)
  {
    session(['currentPage' => request('page', 1)]);

    $sliders = $this->sliderRepository->getFilteredSliders($request);

    return view('admin.sliders.index', compact('sliders'));
  } // end of index

  public function create(Request $request)
  {
    $schools = $this->schoolRepository->getAllSchools();

    return view('admin.sliders.create', compact('schools'));
  } //end of create

  public function show($slider)
  {
    $slider = $this->sliderRepository->getSliderById($slider);

    return view('admin.sliders.show', compact('slider'));
  } //end of create

  public function store(SliderFormRequest $request)
  {
    $this->sliderRepository->createSlider($request);

    session()->flash('success', __('site.Data added successfully'));

    if ($request->continue) {
      return redirect()->route($mainRoutePrefix.'.sliders.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of store

  public function edit($slider)
  {

    $slider = $this->sliderRepository->getSliderById($slider);
    $schools = $this->schoolRepository->getAllSchools();


    return view('admin.sliders.edit', compact('slider','schools'));
  } //end of edit

  public function update(SliderFormRequest $request, Slider $slider)
  {
    $this->sliderRepository->updateSlider($request, $slider);

    session()->flash('success', __('Data updated successfully'));

    if ($request->continue) {
      return redirect()->route($mainRoutePrefix.'.sliders.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of update

  public function destroy(Slider $slider)
  {
    if (!$slider) {
      return redirect()->back();
    }
    $this->sliderRepository->deleteSlider($slider);

    session()->flash('success', __('Data deleted successfully'));
    return redirect()->route($mainRoutePrefix.'.sliders.index', ['page' => session('currentPage')]);
  } //end of destroy

}//end of controller
