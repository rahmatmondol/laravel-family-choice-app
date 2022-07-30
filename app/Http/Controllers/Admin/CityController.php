<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\CityRepositoryInterface;
use App\Http\Requests\Admin\CityFormRequest;
use App\Http\Controllers\Admin\BaseController;

class CityController extends BaseController
{

  // use CityTrait, PermissionTrait;

  public function __construct(
    private CityRepositoryInterface $cityRepository
  ) {
    //create read update delete
    $this->middleware(['permission:read_cities'])->only('index');
    $this->middleware(['permission:create_cities'])->only('create');
    $this->middleware(['permission:update_cities'])->only('edit');
    $this->middleware(['permission:delete_cities'])->only('destroy');
  } //end of constructor

  public function index(Request $request)
  {
    session(['currentPage' => request('page', 1)]);

    $cities = $this->cityRepository->getFilteredCities($request);

    return view('admin.cities.index', compact('cities'));
  } // end of index

  public function create(Request $request)
  {
    // $roles = $this->roleRepository->getAllRoles();
    $roles = '';
    return view('admin.cities.create', compact('roles'));
  } //end of create

  public function show($city)
  {
    $city = $this->cityRepository->getCityById($city);

    return view('admin.cities.show', compact('city'));
  } //end of create

  public function store(CityFormRequest $request)
  {
    $this->cityRepository->createCity($request);

    session()->flash('success', __('site.Data added successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix.'.cities.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of store

  public function edit($city)
  {

    $city = $this->cityRepository->getCityById($city);

    // $roles = $this->roleRepository->getAllRoles();

    return view('admin.cities.edit', compact('city',));
  } //end of edit

  public function update(CityFormRequest $request, City $city)
  {
    $this->cityRepository->updateCity($request, $city);

    session()->flash('success', __('Data updated successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix.'.cities.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of update

  public function destroy(City $city)
  {
    if (!$city) {
      return redirect()->back();
    }
    $this->cityRepository->deleteCity($city);

    session()->flash('success', __('Data deleted successfully'));
    return redirect()->route($this->mainRoutePrefix.'.cities.index', ['page' => session('currentPage')]);
  } //end of destroy

}//end of controller
