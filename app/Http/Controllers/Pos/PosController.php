<?php

namespace App\Http\Controllers\Pos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserRoles;
use App\Models\User;
use App\Models\Menu\Menu;
use App\Models\Menu\Category;
use App\Models\Menu\Modifier;
use App\Models\Menu\ModifierGroup;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;
use App\Models\Location\OrderTypes;
use App\Models\Pos\Order;

class PosController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    function __construct() {
        $this->middleware('auth');
    }

    public function getIndex(Request $request) {

        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('menu_view', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */

        // dd($request->session()->get('order_type'));
        // dd($request->session()->get('store'));
        $customer = $request->session()->get('customer');
        $ordTypes = OrderTypes::getOrderTypesByStoreId($customer['store_id']);
        $return = view('pos.pos', ['orderTypes' => $ordTypes]);

        return $return;
    }

    public function getPosData($id) {
        return response()->json(["response" => 200, 'status' => 'success', "data" => Order::getPosDatafromStoreId($id)]);
    }

    public function addOrder(Request $request) {
        $customer = $request->session()->get('customer');

        if ($request->input('data')) {
            $cart_items = $request->input('data.cart_items');
            foreach ($cart_items as $item) {
                $brand_status[$item['brand']['_id']] = ['status' => 'In Kitchen', '_id' => $item['brand']['_id'], 'name' => $item['brand']['name']];
            }
            $brand_status = array_values($brand_status);
            $order = new Order();
            $order->store_id = $request->input('data.store_id');
            $order->cart_items = $request->input('data.cart_items');
            $order->sub_cart_total = $request->input('data.sub_cart_total');
            $order->total_pay = $request->input('data.total_pay');
            $order->discount = $request->input('data.discount');
            $order->shipping = $request->input('data.shipping');
            $order->order_status = 'In Kitchen';
            $order->brand_status = $brand_status;
            $order->order_id = rand(100,999);
            $order->customer = $customer;
            if ($order->save()) {
                $request->session()->forget('customer');
                //$request->session()->forget('store');
                $request->session()->forget('order_type');
                return response()->json(["response" => 200, 'status' => 'success', "action" => '/pos']);
            } else {
                return response()->json(["response" => 400, 'status' => 'error', "errors" => ['An internal error.']]);
            }
        }
    }

}
