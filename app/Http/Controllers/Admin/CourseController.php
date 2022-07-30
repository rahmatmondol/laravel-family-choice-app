<?php

namespace App\Http\Controllers\Admin;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\CourseRepositoryInterface;
use App\Interfaces\SchoolRepositoryInterface;
use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Admin\CourseFormRequest;

class CourseController extends BaseController
{

  public function __construct(
    private CourseRepositoryInterface $courseRepository,
    private SchoolRepositoryInterface $schoolRepository
  ) {
    //create read update delete
    $this->middleware(['permission:read_courses'])->only('index');
    $this->middleware(['permission:create_courses'])->only('create');
    $this->middleware(['permission:update_courses'])->only('edit');
    $this->middleware(['permission:delete_courses'])->only('destroy');
  } //end of constructor

  public function index(Request $request)
  {
    session(['currentPage' => request('page', 1)]);

    $courses = $this->courseRepository->getFilteredCourses($request);
    $schools = $this->schoolRepository->getSchools($request);

    return view('admin.courses.index', compact('courses','schools'));
  } // end of index

  public function create(Request $request)
  {
    $schools = $this->schoolRepository->getAllSchools();
    return view('admin.courses.create', compact('schools'));
  } //end of create

  public function show($course)
  {
    $course = $this->courseRepository->getCourseById($course);

    return view('admin.courses.show', compact('course'));
  } //end of create

  public function store(CourseFormRequest $request)
  {
    $this->courseRepository->createCourse($request);

    session()->flash('success', __('site.Data added successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix.'.courses.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of store

  public function edit($course)
  {

    $course = $this->courseRepository->getCourseById($course);
    $schools = $this->schoolRepository->getAllSchools();

    return view('admin.courses.edit', compact('course','schools'));
  } //end of edit

  public function update(CourseFormRequest $request, Course $course)
  {
    $this->courseRepository->updateCourse($request, $course);

    session()->flash('success', __('Data updated successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix.'.courses.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of update

  public function destroy(Course $course)
  {
    if (!$course) {
      return redirect()->back();
    }
    $this->courseRepository->deleteCourse($course);

    session()->flash('success', __('Data deleted successfully'));
    return redirect()->route($this->mainRoutePrefix.'.courses.index', ['page' => session('currentPage')]);
  } //end of destroy

}//end of controller
