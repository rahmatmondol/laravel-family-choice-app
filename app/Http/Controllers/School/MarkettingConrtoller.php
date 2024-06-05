<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Http\Controllers\School\BaseController;
use App\Interfaces\SubscriptionTypeRepositoryInterface;
use App\Interfaces\SchoolRepositoryInterface;
use App\Interfaces\SubscriptionRepositoryInterface;
use App\Models\Discount;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


use App\Http\Requests\Admin\SubscriptionTypeFormRequest;

use Illuminate\Http\Request;

class MarkettingConrtoller  extends BaseController
{
    public function __construct(
        private SubscriptionTypeRepositoryInterface $subscriptionTypeRepository,
        private SchoolRepositoryInterface $schoolRepository,
        private SubscriptionRepositoryInterface $subscriptionRepository
    ) {
        parent::__construct();
//        create read update delete
    }
    //
    public function moreOrderView(Request $request)
    {
        session(['currentPage' => request('page', 1)]);

        $searchTerm = $request->search;
        $status = $request->status;

        // Query discounts with schools
        $query = Discount::with('schools');

        // Apply search scope if search term is provided
        if ($searchTerm) {
            $query->whenSearch($searchTerm);
        }

        // Apply status scope if status is provided
        if ($status) {
            $query->whenStatus($status);
        }

        // Retrieve the data based on the query
        $data = $query->get();

        // Count the total records based on the current query
        $count = $query->count();

        // Pass the data and count to the view
        return view($this->mainViewPrefix.".marketing.order.index", compact('data', 'count'));
    }

    public function addOrderView(Request $request){
        session(['currentPage' => request('page', 1)]);

        return view($this->mainViewPrefix.".marketing.order.create");
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string',
            'discount_type' => ['required', Rule::in(['percentage', 'fixed'])],
            'discount_amount' => 'required_if:discount_type,fixed',
            'percentage_discount' => 'required_if:discount_type,percentage|numeric|min:0|max:100',
            'minimum_amount' => 'required|numeric|min:0',
            'starting_date' => 'required|date',
            'ending_date' => 'required|date|after_or_equal:starting_date',
            'status' => 'required',
        ]);

        try {



            $discount = new Discount();
            $discount->school_id = $request->school_id;
            $discount->title = $request->title;
            $discount->discount_type = $request->discount_type;
            if($request->discount_type == 'percentage'){
                $discount->percentage_discount = $request->percentage_discount;

            }elseif ($request->discount_type == 'fixed'){
                $discount->discount_amount = $request->discount_amount;

            }
            $discount->minimum_amount = $request->minimum_amount;
            $discount->starting_date = $request->starting_date;
            $discount->ending_date = $request->ending_date;
            $discount->status = $request->status;
            $discount->save();

            session()->flash('success', __('discount added successfully'));

            return redirect()->route('school.view-order-more')
                ->with('success', 'More order created successfully.');
        }catch (\Throwable $e){
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error occurred while creating more order: ' . $e->getMessage())
                ->withInput();
        }
    }


    public function edit($id)
    {
        $data = Discount::find($id);
        return view('school.marketing.order.edit',compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'discount_type' => ['required', Rule::in(['percentage', 'fixed'])],
            'discount_amount' => 'required_if:discount_type,fixed',
            'percentage_discount' => 'required_if:discount_type,percentage|numeric|min:0|max:100',
            'minimum_amount' => 'required|numeric|min:0',
            'starting_date' => 'required|date',
            'ending_date' => 'required|date|after_or_equal:starting_date',
            'status' => 'required',
        ]);

        try {
            $discount = Discount::findOrFail($id);
            $discount->title = $request->title;
            $discount->discount_type = $request->discount_type;

            if($request->discount_type == 'percentage') {
                $discount->percentage_discount = $request->percentage_discount;
                $discount->discount_amount = 0; // Reset fixed discount amount if present
            } elseif ($request->discount_type == 'fixed') {
                $discount->discount_amount = $request->discount_amount;
                $discount->percentage_discount = 0; // Reset percentage discount if present
            }

            $discount->minimum_amount = $request->minimum_amount;
            $discount->starting_date = $request->starting_date;
            $discount->ending_date = $request->ending_date;
            $discount->status = $request->status;
            $discount->save();

            session()->flash('success', __('Discount updated successfully'));

            return redirect()->route('school.view-order-more')
                ->with('success', 'Discount updated successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()
                ->with('error', 'Error occurred while updating discount: ' . $e->getMessage())
                ->withInput();
        }
    }


    public function distroy($id)
    {
        $data = Discount::find($id);
        $data->delete();
        session()->flash('success', __('discount deleted successfully'));
        return redirect()->route('school.discount.view')
            ->with('success', 'More order created successfully.');
    }
    public function discountView($id)
    {

          $discount =  Discount::with('schools')->find($id);

          return view($this->mainViewPrefix.'.marketing.order.show',compact('discount'));
    }
}
