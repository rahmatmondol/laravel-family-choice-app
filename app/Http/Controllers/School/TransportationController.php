<?php
namespace App\Http\Controllers\School;


use App\Models\Transportation;
use Illuminate\Http\Request;
use App\Interfaces\TransportationRepositoryInterface;
use App\Interfaces\SchoolRepositoryInterface;
use App\Http\Controllers\School\BaseController;
use App\Http\Requests\Admin\TransportationFormRequest;
use App\Interfaces\SubscriptionRepositoryInterface;

class TransportationController extends BaseController
{
  public function __construct(
    private TransportationRepositoryInterface $transportationRepository,
    private SchoolRepositoryInterface $schoolRepository,
    private SubscriptionRepositoryInterface $subscriptionRepository
  ) {
    parent::__construct();
    //create read update delete
  } //end of constructor

  public function index(Request $request)
  {
    session(['currentPage' => request('page', 1)]);

    $transportations = $this->transportationRepository->getFilteredTransportations($request);
    $schools = $this->schoolRepository->getAllSchools();

    return view($this->mainViewPrefix.'.transportations.index', compact('transportations','schools'));
  } // end of index

  public function create(Request $request)
  {
    $schools = $this->schoolRepository->getAllSchools();

    return view($this->mainViewPrefix.'.transportations.create', compact('schools'));
  } //end of create

  public function show($transportation)
  {
    $transportation = $this->transportationRepository->getTransportationById($transportation);

    return view($this->mainViewPrefix.'.transportations.show', compact('transportation'));
  } //end of create

  public function store(TransportationFormRequest $request)
  {
    $this->transportationRepository->createTransportation($request);

    session()->flash('success', __('site.Data added successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix.'.transportations.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of store

  public function edit(Request $request,$transportation)
  {
    $transportation = $this->transportationRepository->getTransportationById($transportation);
    $schools = $this->schoolRepository->getAllSchools();

    return view($this->mainViewPrefix.'.transportations.edit', compact('transportation','schools'));
  } //end of edit

  public function update(TransportationFormRequest $request, Transportation $transportation)
  {
    $this->transportationRepository->updateTransportation($request, $transportation);

    session()->flash('success', __('Data updated successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix.'.transportations.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of update

  public function destroy(Transportation $transportation)
  {
    if (!$transportation) {
      return redirect()->back();
    }
    $this->transportationRepository->deleteTransportation($transportation);

    session()->flash('success', __('site.Data deleted successfully'));
    return redirect()->route($this->mainRoutePrefix.'.transportations.index', ['page' => session('currentPage')]);
  } //end of destroy

}//end of controller
