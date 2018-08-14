<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Discounts;
use App\Models\Location\OrderTypes;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
        $dayArrs = [1 => ['key' => 'S', 'value' => 'Sunday'], 2 => ['key' => 'M', 'value' => 'Monday'], 3 => ['key' => 'T', 'value' => 'Tuesday'], 4 => ['key' => 'W', 'value' => 'Wednesday'], 5 => ['key' => 'TH', 'value' => 'Thursday'], 6 => ['key' => 'F', 'value' => 'Friday'], 7 => ['key' => 'S', 'value' => 'Saturday']];
        //$ordTypes = [1 => 'Delivery', 2 => 'Dine-In', 3 => 'Take Away', 4 => 'Online-Order'];
		$ordTypes=OrderTypes::where('status', 'enable')->get(['_id', 'name']);
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
		
		
		
		

        echo '[{"id":1,"parent_id":0,"store_id":1,"brand_id":4,"name":"Pizzas","slug":"pizza-new","short_description":"It’s all about you. Combine our all-natural and delicious ingredients to make your own slic","image":"1495912021.jpg","sort_order":1,"status":"Active","created":"2017-08-02T20:28:20+00:00","modified":"2018-07-20T13:38:15+00:00","added_by":1,"children":[{"id":25,"parent_id":1,"store_id":1,"brand_id":4,"name":"Pizza Sub Category","slug":"","short_description":"Sub category descriptions here edit","image":null,"sort_order":0,"status":"Active","created":"2018-07-20T13:13:34+00:00","modified":"2018-07-20T13:38:08+00:00","added_by":1,"children":[]}]},{"id":6,"parent_id":0,"store_id":1,"brand_id":1,"name":"Most Selling","slug":"Most-Selling","short_description":"It’s all about you. Combine our all-natural and delicious ingredients to make your own slic","image":"1495912021.jpg","sort_order":1,"status":"Active","created":"2017-08-02T20:28:20+00:00","modified":"2018-07-20T13:03:54+00:00","added_by":1,"children":[]},{"id":7,"parent_id":0,"store_id":1,"brand_id":1,"name":"Starters","slug":"Starters","short_description":"It’s all about you. Combine our all-natural and delicious ingredients to make your own slic","image":"1495912021.jpg","sort_order":1,"status":"Active","created":"2017-08-02T20:28:20+00:00","modified":"2017-08-02T20:28:20+00:00","added_by":1,"children":[]},{"id":8,"parent_id":0,"store_id":1,"brand_id":1,"name":"Soup","slug":"Soup","short_description":"It’s all about you. Combine our all-natural and delicious ingredients to make your own slic","image":"1495912021.jpg","sort_order":1,"status":"Active","created":"2017-08-02T20:28:20+00:00","modified":"2017-08-02T20:28:20+00:00","added_by":1,"children":[]},{"id":10,"parent_id":0,"store_id":1,"brand_id":1,"name":"Mains","slug":"Mains","short_description":"It’s all about you. Combine our all-natural and delicious ingredients to make your own slic","image":"1495912021.jpg","sort_order":1,"status":"Active","created":"2017-08-02T20:28:20+00:00","modified":"2017-08-02T20:28:20+00:00","added_by":1,"children":[]},{"id":11,"parent_id":0,"store_id":1,"brand_id":3,"name":"Chicken","slug":"chicken","short_description":"It’s all about you. Combine our all-natural and delicious ingredients to make your own slic","image":"1495912021.jpg","sort_order":1,"status":"Active","created":"2017-08-02T20:28:20+00:00","modified":"2017-08-02T20:28:20+00:00","added_by":1,"children":[]},{"id":12,"parent_id":0,"store_id":1,"brand_id":3,"name":"Burgers","slug":"burgers","short_description":"It’s all about you. Combine our all-natural and delicious ingredients to make your own slic","image":"1495912021.jpg","sort_order":1,"status":"Active","created":"2017-08-02T20:28:20+00:00","modified":"2017-08-02T20:28:20+00:00","added_by":1,"children":[]},{"id":13,"parent_id":0,"store_id":1,"brand_id":3,"name":"Rice Bowls","slug":"rice-bowls","short_description":"It’s all about you. Combine our all-natural and delicious ingredients to make your own slic","image":"1495912021.jpg","sort_order":1,"status":"Active","created":"2017-08-02T20:28:20+00:00","modified":"2017-08-02T20:28:20+00:00","added_by":1,"children":[]},{"id":14,"parent_id":0,"store_id":1,"brand_id":3,"name":"Snacks","slug":"snacks","short_description":"It’s all about you. Combine our all-natural and delicious ingredients to make your own slic","image":"1495912021.jpg","sort_order":1,"status":"Active","created":"2017-08-02T20:28:20+00:00","modified":"2017-08-02T20:28:20+00:00","added_by":1,"children":[]},{"id":15,"parent_id":0,"store_id":1,"brand_id":3,"name":"Beverages","slug":"beverages","short_description":"It’s all about you. Combine our all-natural and delicious ingredients to make your own slic","image":"1495912021.jpg","sort_order":1,"status":"Active","created":"2017-08-02T20:28:20+00:00","modified":"2017-08-02T20:28:20+00:00","added_by":1,"children":[]},{"id":16,"parent_id":0,"store_id":1,"brand_id":2,"name":"Everyday value offers","slug":"value-offers","short_description":"It’s all about you. Combine our all-natural and delicious ingredients to make your own slic","image":"1495912021.jpg","sort_order":1,"status":"Active","created":"2017-08-02T20:28:20+00:00","modified":"2017-08-02T20:28:20+00:00","added_by":1,"children":[]},{"id":17,"parent_id":0,"store_id":1,"brand_id":2,"name":"Pizza","slug":"pizza","short_description":"It’s all about you. Combine our all-natural and delicious ingredients to make your own slic","image":"1495912021.jpg","sort_order":1,"status":"Active","created":"2017-08-02T20:28:20+00:00","modified":"2017-08-02T20:28:20+00:00","added_by":1,"children":[]},{"id":18,"parent_id":0,"store_id":1,"brand_id":2,"name":"Chicken","slug":"chicken","short_description":"It’s all about you. Combine our all-natural and delicious ingredients to make your own slic","image":"1495912021.jpg","sort_order":1,"status":"Active","created":"2017-08-02T20:28:20+00:00","modified":"2017-08-02T20:28:20+00:00","added_by":1,"children":[]},{"id":19,"parent_id":0,"store_id":1,"brand_id":2,"name":"Sides","slug":"sides","short_description":"It’s all about you. Combine our all-natural and delicious ingredients to make your own slic","image":"1495912021.jpg","sort_order":1,"status":"Active","created":"2017-08-02T20:28:20+00:00","modified":"2017-08-02T20:28:20+00:00","added_by":1,"children":[]},{"id":20,"parent_id":0,"store_id":1,"brand_id":2,"name":"Pizza Mania","slug":"pizza-mania","short_description":"It’s all about you. Combine our all-natural and delicious ingredients to make your own slic","image":"1495912021.jpg","sort_order":1,"status":"Active","created":"2017-08-02T20:28:20+00:00","modified":"2017-08-02T20:28:20+00:00","added_by":1,"children":[]},{"id":21,"parent_id":0,"store_id":1,"brand_id":1,"name":"Burgers","slug":"Burgers","short_description":"It\'s all about you. Combine our all-natural and delicious ingredients to make your own slic","image":"1495912021.jpg","sort_order":1,"status":"Active","created":"2017-08-02T20:28:20+00:00","modified":"2018-07-20T13:12:28+00:00","added_by":1,"children":[]},{"id":22,"parent_id":0,"store_id":1,"brand_id":1,"name":"Sandwiches & Wraps","slug":"Sandwiches & Wraps","short_description":"It’s all about you. Combine our all-natural and delicious ingredients to make your own slic","image":"1495912021.jpg","sort_order":1,"status":"Active","created":"2017-08-02T20:28:20+00:00","modified":"2017-08-02T20:28:20+00:00","added_by":1,"children":[]},{"id":23,"parent_id":0,"store_id":1,"brand_id":1,"name":"Salads & Superbowls","slug":"Salads & Superbowls","short_description":"t’s all about you. Combine our all-natural and delicious ingredients to make your own slic","image":"1495912021.jpg","sort_order":1,"status":"Active","created":"2017-08-02T20:28:20+00:00","modified":"2017-08-02T20:28:20+00:00","added_by":1,"children":[]},{"id":24,"parent_id":0,"store_id":1,"brand_id":1,"name":"Dessert","slug":"Dessert","short_description":"It’s all about you. Combine our all-natural and delicious ingredients to make your own slic","image":"1495912021.jpg","sort_order":1,"status":"Active","created":"2017-08-02T20:28:20+00:00","modified":"2017-08-02T20:28:20+00:00","added_by":1,"children":[]},{"id":4,"parent_id":0,"store_id":1,"brand_id":4,"name":"Desserts","slug":"deserts","short_description":"Description about gluten free brownie will come here. .<\/p>\r\n","image":"1495912169.jpg","sort_order":4,"status":"Active","created":"2017-07-31T03:08:18+00:00","modified":"2018-07-20T13:03:51+00:00","added_by":1,"children":[]},{"id":2,"parent_id":0,"store_id":1,"brand_id":4,"name":"Salads","slug":"salads","short_description":"chicken, kale, iceberg klettuce, <\/p>\r\n","image":"1495912070.jpg","sort_order":2,"status":"Active","created":"2017-07-30T14:20:22+00:00","modified":"2018-07-20T13:03:52+00:00","added_by":1,"children":[]},{"id":5,"parent_id":0,"store_id":1,"brand_id":4,"name":"Beverages","slug":"beverages","short_description":"","image":"1495912211.jpg","sort_order":5,"status":"Active","created":"2017-07-30T14:19:33+00:00","modified":"2018-07-20T13:03:51+00:00","added_by":1,"children":[]},{"id":3,"parent_id":0,"store_id":1,"brand_id":4,"name":"Sides","slug":"sides","short_description":"all natural chicken tenders with ranch or bbq dipping sauce\r\n","image":"1495912124.jpg","sort_order":3,"status":"Active","created":"2017-07-30T14:18:43+00:00","modified":"2018-07-20T13:14:37+00:00","added_by":1,"children":[]}]';
        die;
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
		$ordTypes=OrderTypes::where('status', 'enable')->get(['_id', 'name']);
        $view = view('discount.edit', ['discount' => $discount,'ordTypes' => $ordTypes]);
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
