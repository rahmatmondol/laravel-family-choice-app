<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\School\BaseController;
use App\Interfaces\SubscriptionTypeRepositoryInterface;
use App\Interfaces\SchoolRepositoryInterface;
use App\Interfaces\SubscriptionRepositoryInterface;
use App\Models\City;
use App\Models\boost;
use App\Models\SchoolBoosting;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BoostController  extends BaseController
{
    //
    public function __construct(
        private SubscriptionTypeRepositoryInterface $subscriptionTypeRepository,
        private SchoolRepositoryInterface $schoolRepository,
        private SubscriptionRepositoryInterface $subscriptionRepository
    ) {
        parent::__construct();
//        create read update delete
    }
    //
    public function moreOrderView(Request $request){
        session(['currentPage' => request('page', 1)]);

        $schoolId = Auth::user()->id;




        $searchTerm = $request->search;
        $status = $request->status;

//         Query boosts with schools
        $query = SchoolBoosting::with('citys')->where('school_id',$schoolId);

       $currentDate = getCurrentDate();

        // Apply status scope if status is provided
        if ($status === 'active') {
            $query->where('starting', '>=', $currentDate);
        }
        if ($status === 'inactive') {
            $query->where('ending','<=' , $currentDate);
        }

        // Retrieve the data based on the query
        $data = $query->get();
        $count = $data->count();



        return view($this->mainViewPrefix.".marketing.boost.index",compact('data','count'));
    }

    public function addOrderView(Request $request){
        session(['currentPage' => request('page', 1)]);
        $local = ($request->hasHeader('X-localization')) ? $request->header('X-localization') : 'en';
        $city  = City::where('status',1)->get();

        return view($this->mainViewPrefix.".marketing.boost.create",compact('city','local'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'city_id' => 'required|string',
            'monthly_budget' => 'required|numeric|min:441',
            'cost_per_click' => 'required|numeric|min:2.4|max:6.5',
            'starting' => 'required|date',
        ]);
        $currentDate = getCurrentDateTime();

        $extendedDate = getExtendedDateTime($request->starting);



        try {
            $counter = SchoolBoosting::where('city_id',$request->city_id)->where('ending','>=',$currentDate)->exists();
            if ($counter) {
                session()->flash('error_message','city has already been boosted');
                return redirect()->back()->with('error','city has already been boosted');
            }

            $boost = new SchoolBoosting();
            $boost->school_id = $request->school_id;
            $boost->city_id = $request->city_id;
            $boost->monthly_budget = $request->monthly_budget;
            $boost->cost_per_click = $request->cost_per_click;
            $boost->starting = $request->starting;
            $boost->ending = $extendedDate;
            $boost->save();

            session()->flash('success', __('boost added successfully'));

            return redirect()->route('school.view-boost-more')
                ->with('success', 'More order created successfully.');
        }catch (\Throwable $e){
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error occurred while creating more order: ' . $e->getMessage())
                ->withInput();
        }
    }


    public function edit(Request $request,$id)
    {
        $boostData = SchoolBoosting::find($id);
        $local = ($request->hasHeader('X-localization')) ? $request->header('X-localization') : 'en';
        $city  = City::where('status',1)->get();
        return view('school.marketing.boost.edit',compact('boostData','city','local'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'city_id' => 'required|string',
            'monthly_budget' => 'required|numeric|min:441',
            'cost_per_click' => 'required|numeric',
            
        ]);

//        $extendedDate = getExtendedDateTime($request->starting);


        try {
            $boost =  SchoolBoosting::findOrFail($id);
            $boost->city_id = $request->city_id;
            $boost->monthly_budget = $request->monthly_budget;
            $boost->cost_per_click = $request->cost_per_click;
            $boost->save();

            session()->flash('success', __('boost updated successfully'));

            return redirect()->route('school.view-boost-more')
                ->with('success', 'boost updated successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()
                ->with('error', 'Error occurred while updating boost: ' . $e->getMessage())
                ->withInput();
        }
    }




    public function distroy($id)
    {
        $data = SchoolBoosting::find($id);
        $data->delete();
        session()->flash('success', __('boost deleted successfully'));
        return redirect()->route('school.boost.list')
            ->with('success', 'Boost delete successfully.');
    }
    public function boostView($id)
    {

        $currentDate = getCurrentDate();

        $boost =  SchoolBoosting::find($id);

//        if( $boost->start_date >= $currentDate && Carbon::parse($boost->end_date) <= $currentDate){
//            $boost['status'] = 'active';
//        }else{
//            $boost['status'] = 'inactive';
//        }




        return view($this->mainViewPrefix.'.marketing.boost.show',compact('boost'));
    }


}
