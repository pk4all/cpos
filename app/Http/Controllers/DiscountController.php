<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Discounts;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Location\OrderTypes;
use App\Models\Location\Stores;
use App\Models\Menu\Category;
class DiscountController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $dayArrs = Stores::$days;
        $ordTypes = OrderTypes::getOrderTypesList();
        $allDiscounts = Discounts::paginate(20);
        $view = view('discount.index', ['list' => $allDiscounts, 'days' => $dayArrs, 'ordTypes' => $ordTypes]);
        return $view;
    }

    public function saveDiscount(Request $request) {
        $discount = new Discounts();
        //print_r($request->all());die;
        if (empty($request->input('ord_typ_id'))) {
            return response()->json(["response" => 400, 'status' => 'error', "msg" => 'Please select order type(s)']);
            die;
        }
        $discount->disc_type = $request->input('disc_type');
        $discount->name = $request->input('name');
        $discount->type = $request->input('type');
        $discount->name = $request->input('name');
        $discount->amount = $request->input('amount');
        $discount->discount_on = $request->input('discount_on');
        $discount->schedule = $request->input('schedule');
        $discount->discount_days = $request->input('discount_days');
        $discount->from_date = $request->input('from_date');
        $discount->to_date = $request->input('to_date');
        $discount->from_time = $request->input('from_time');
        $discount->to_time = $request->input('to_time');
        $discount->ord_typ_id = $request->input('ord_typ_id');
        $discount->categories = explode(',', $request->input('categories'));
        $discount->items = explode(',', $request->input('items'));
        $discount->created_by = Auth::user()->_id;
        $discount->status = 'enable';
        if ($discount->save()) {
            return response()->json(["response" => 200, 'status' => 'success', "msg" => 'Discount has been saved']);
        } else {
            return response()->json(["response" => 400, 'status' => 'error', "msg" => 'An internal error.']);
        }

        die;
    }

    public function getCategories() {
        $list= Category::getCategoryListWithChild();
        return response()->json($list);
    }

    public function getItems() {
        $lists = [['id' => 1, 'name' => 'Pizzas'], ['id' => 2, 'name' => 'Most Selling'], ['id' => 3, 'name' => 'Starters'], ['id' => 4, 'name' => 'Soup'], ['id' => 5, 'name' => 'Mains'], ['id' => 6, 'name' => 'Chicken'], ['id' => 7, 'name' => 'Burgers'], ['id' => 8, 'name' => 'Rice Bowls'], ['id' => 9, 'name' => 'Snacks'], ['id' => 10, 'name' => 'Beverages']];
        if ($lists) {
            $out = '<div class="panel-group panel-group-dark" id="accordion" style="height:300px;overflow-y: auto;">';
            foreach ($lists as $key => $ls) {
                if ($key == 0) {
                    $in = ' show';
                    $cls = '';
                } else {
                    $in = '';
                    $cls = 'collapsed';
                }
                $out .= '<div class="card">
              <div class="card-header">
                <h4 class="m-0">
                  <a class="' . $cls . '" data-toggle="collapse" data-parent="#accordion" href="#collapseOne' . $ls['id'] . '">' . $ls['name'] . '</a>
                </h4>
              </div>
              <div id="collapseOne' . $ls['id'] . '" class="panel-collapse collapse' . $in . '">
                <div class="card-body">
                  <div class="ckbox ckbox-primary" >
					<input class="item" name="item_id[]" value="' . $ls['id'] . $key . '" id="icheckbox' . $ls['id'] . $key . '" type="checkbox">
					<label for="icheckbox' . $ls['id'] . $key . '" >Item</label>
				</div>
				 <div class="ckbox ckbox-primary" >
					<input class="item" name="item_id[]" value="' . $ls['id'] . $key . '2" id="icheckbox' . $ls['id'] . $key . '2" type="checkbox">
					<label for="icheckbox' . $ls['id'] . $key . '2" >Item 2</label>
				</div>
                </div>
              </div>
            </div>';
            }
            $out .= '</div>';
        }
        echo $out;
        die;
    }

    public function changeDiscountStatus(Request $request) {
        $status = $request->input('status');
        $id = $request->input('id');
        $discount = Discounts::find($id);
        $discount->status = $status;
        $discount->change_at = Carbon::now();
        if ($discount->save()) {
            return response()->json(["response" => 200, 'status' => 'success', "msg" => 'Status has been changed']);
        } else {
            return response()->json(["response" => 400, 'status' => 'error', "msg" => 'An internal error.']);
        }
        die;
    }

    public function getEdit(Request $request, $id = null) {
        $discount = Discounts::find($id);
        $dayArrs = Stores::$days;
        $ordTypes = OrderTypes::getOrderTypesList();
        $view = view('discount.edit', ['discount' => $discount,'days'=>$dayArrs,'ordTypes' => $ordTypes]);
        return $view;
    }

    public function saveEditDiscount(Request $request) {
        $discount = Discounts::find($request->input('id'));
        if (empty($request->input('ord_typ_id'))) {
            return response()->json(["response" => 400, 'status' => 'error', "msg" => 'Please select order type(s)']);
            die;
        }
        $discount->disc_type = $request->input('disc_type');
        $discount->name = $request->input('name');
        $discount->type = $request->input('type');
        $discount->name = $request->input('name');
        $discount->amount = $request->input('amount');
        $discount->discount_on = $request->input('discount_on');
        $discount->schedule = $request->input('schedule');
        $discount->discount_days = $request->input('discount_days');
        $discount->from_date = $request->input('from_date');
        $discount->to_date = $request->input('to_date');
        $discount->from_time = $request->input('from_time');
        $discount->to_time = $request->input('to_time');
        $discount->ord_typ_id = $request->input('ord_typ_id');
        $discount->categories = explode(',', $request->input('categories'));
        $discount->items = explode(',', $request->input('items'));
        if ($discount->save()) {
            return response()->json(["response" => 200, 'status' => 'success', "msg" => 'Discount has been saved']);
        } else {
            return response()->json(["response" => 400, 'status' => 'error', "msg" => 'An internal error.']);
        }
        die;
    }

}
