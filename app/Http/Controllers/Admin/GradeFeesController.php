<?php

namespace App\Http\Controllers\Admin;

use App\Models\GradeFees;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\GradeFeesRepositoryInterface;
use App\Interfaces\SchoolRepositoryInterface;
use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Admin\GradeFeesFormRequest;
use App\Interfaces\GradeRepositoryInterface;
use App\Interfaces\SubscriptionRepositoryInterface;

class GradeFeesController extends BaseController
{
  public function __construct(
    private GradeRepositoryInterface $gradeRepository,
    private GradeFeesRepositoryInterface $gradeFeesRepository,
    private SchoolRepositoryInterface $schoolRepository,
    private SubscriptionRepositoryInterface $subscriptionRepository
  ) {
    parent::__construct();
    //create read update delete
    $this->middleware(['permission:read_gradeFees'])->only('index');
    $this->middleware(['permission:create_gradeFees'])->only('create');
    $this->middleware(['permission:update_gradeFees'])->only('edit');
    $this->middleware(['permission:delete_gradeFees'])->only('destroy');
  } //end of constructor

  public function index(Request $request)
  {
    session(['currentPage' => request('page', 1)]);

    $gradeFees = $this->gradeFeesRepository->getFilteredGradeFees($request);
    $schools = $this->schoolRepository->getAllSchools(true);
    $grades = $this->gradeRepository->getAllGrades();

    return view($this->mainViewPrefix.'.gradeFees.index', compact('gradeFees','schools','grades'));
  } // end of index

  public function create(Request $request)
  {
    $schools = $this->schoolRepository->getSchools($request,true);
    $grades = $this->gradeRepository->getAllGrades();

    return view($this->mainViewPrefix.'.gradeFees.create', compact('schools','grades'));
  } //end of create

  public function show($gradeFees)
  {
    $gradeFees = $this->gradeFeesRepository->getGradeFeesById($gradeFees);

    return view($this->mainViewPrefix.'.gradeFees.show', compact('gradeFees'));
  } //end of create

  public function store(GradeFeesFormRequest $request)
  {
    $this->gradeFeesRepository->createGradeFees($request);

    session()->flash('success', __('site.Data added successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix.'.gradeFees.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of store

  public function edit(Request $request,$gradeFees)
  {
    $gradeFees = $this->gradeFeesRepository->getGradeFeesById($gradeFees);
    $schools = $this->schoolRepository->getSchools($request,true);
    $grades = $this->gradeRepository->getAllGrades();

    return view($this->mainViewPrefix.'.gradeFees.edit', compact('gradeFees','schools','grades'));
  } //end of edit

  public function update(GradeFeesFormRequest $request, GradeFees $gradeFee)
  {
    $this->gradeFeesRepository->updateGradeFees($request, $gradeFee);

    session()->flash('success', __('Data updated successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix.'.gradeFees.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of update

  public function destroy(GradeFees $gradeFee)
  {
    if (!$gradeFee) {
      return redirect()->back();
    }
    $this->gradeFeesRepository->deleteGradeFees($gradeFee);

    session()->flash('success', __('site.Data deleted successfully'));
    return redirect()->route($this->mainRoutePrefix.'.gradeFees.index', ['page' => session('currentPage')]);
  } //end of destroy

}//end of controller
