<?php

namespace App\Http\Controllers\Location;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Location\Stores;
use App\Models\UserRoles;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Location\Surcharge;
use App\Models\Location\OrderTypes;
use App\Helpers\Helper;

class SurchargeController extends Controller {

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
        if (($return = UserRoles::hasAccess('surcharge_view', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */
        $results = $this->getSurchargeListPaging($request);
        $total_page = Surcharge::getSurchargeCount();
        $table_header = array('Name', 'Type', 'Amount', 'Order Types', 'Action');
        $return = view('location.surcharge.index', ['count' => $total_page, 'results' => $results, 'tbl_header' => $table_header]);
        return $return;
    }

    public function Create(Request $request) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('surcharge_create', $request)) !== true) {
            return redirect()->action($return);
        }

        $orderTypeList = OrderTypes::getOrderTypeDropDownList();

        $data = [
            'order_type_list' => $orderTypeList, 'surcharge_type' => Surcharge::$type
        ];
        $view = view('location.surcharge.create', $data);
        return $view;
    }

    public function postStore(Request $request) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('stores_create', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */

        $rules = array(
            'name' => 'required|min:3',
            'type' => 'required|min:10',
            'amount' => 'required|min:2',
        );
        //notification_email phone print_label tax_id image address  address state country zip_code radius latitude longitude 
        $this->validate($request, $rules);
        $surcharge = new Surcharge();
        $surcharge->name = $request->input('name', null);
        $surcharge->type = $request->input('type', null);
        $surcharge->amount = $request->input('amount', null);
        $order_id = $request->input('order_type', null);
        $order_type_name = OrderTypes::getOrderTypesByIds(array_values($order_id), ['name']);
        $surcharge->order_type = $order_type_name;
        $surcharge->created_by = Auth::user()->_id;
        $surcharge->updated_by = Auth::user()->_id;
        $surcharge->status = 'disable';
        $surcharge->save();
        $request->session()->flash('status', 'Surcharge ' . $surcharge->name . ' created successfully!');
        return redirect()->action('Location\SurchargeController@getIndex');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function getEdit(Request $request, $id) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('surcharge_update', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */

        $surcharge_data = Surcharge::find($id);

        $storeCity = Stores::getStoreDropDownList();
        if (empty($surcharge_data)) {
            $msg_status = 'error';
            $message = "Invalid Request URL";
            $request->session()->flash($msg_status, $message);
            return redirect()->action('SurchargeController@getIndex');
        }
        //dd($surcharge_update);
        $orderTypeList = OrderTypes::getOrderTypeDropDownList();
        $view = view('location.surcharge.edit', ['surcharge_data' => $surcharge_data, 'order_type_list' => $orderTypeList, 'surcharge_type' => Surcharge::$type]);
        return $view;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function postUpdate(Request $request, $id) {
        if (($return = UserRoles::hasAccess('stores_update', $request)) !== true) {
            return redirect()->action($return);
        }

        $rules = array(
            'name' => 'required|min:3',
            'type' => 'required|min:10',
            'amount' => 'required|min:2',
        );
        //notification_email phone print_label tax_id image address  address state country zip_code radius latitude longitude 
        $this->validate($request, $rules);
        $surcharge = Surcharge::find($id);
        $surcharge->name = $request->input('name', null);
        $surcharge->type = $request->input('type', null);
        $surcharge->amount = $request->input('amount', null);
        $order_id = $request->input('order_type', null);
        $order_type_name = OrderTypes::getOrderTypesByIds(array_values($order_id), ['name']);
        $surcharge->order_type = $order_type_name;
        $surcharge->updated_by = Auth::user()->_id;
        $surcharge->save();
        $request->session()->flash('status', 'Surcharge ' . $surcharge->name . ' Updated successfully!');
        return redirect()->action('Location\SurchargeController@getIndex');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function getDestroy(Request $request, $id) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('surcharge_delete', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */

        $surcharge = Surcharge::find($id);
        $surcharge->status = 'disable';
        $surcharge->deleted_at = Carbon::now();
        $surcharge->updated_by = Auth::user()->_id;
        $surcharge->save();
        $request->session()->flash('status', 'Successfully deleted the Surcharge!');
        return redirect()->action('Location\SurchargeController@getIndex');
    }

    public function getUpdateStatus(Request $request, $id) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('surcharge_update', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */
        $surcharge = Surcharge::find($id);
        $surcharge->updated_at = Carbon::now();
        $surcharge->updated_by = Auth::user()->_id;
        $surcharge->status = $surcharge->status == 'enable' ? 'disable' : 'enable';
        $surcharge->save();
        $request->session()->flash('status', $surcharge->name . ' Status changed to ' . $surcharge->status . ' Successfully!');
        return redirect()->action('Location\SurchargeController@getIndex');
    }

    public function getSurchargeListPaging(Request $request) {
        $page_no = $request->has('page') ? $request->input('page') : 1;
        $search_value = $request->has('search') ? $request->input('search') : '';
        $search_field = $request->has('search_by') ? $request->input('search_by') : 'name';
        $limit = $request->has('limit') ? (int) $request->input('limit') : 10;
        $search = array(); //this have  as Key=search field and value= search value
        if (!is_numeric($limit)) {
            return "limit should be numeric";
        }
        if (!empty($search_value)) {
            $search['key'] = $search_field;
            $search['value'] = $search_value;
        }
        $sort_by = $request->has('sort_by') ? $request->input('sort_by') : '_id';
        $sort_dir = $request->has('sort_dir') ? $request->input('sort_dir') : 'desc';

        $results = Surcharge::surchargeList($sort_by, $sort_dir, $search, true)->paginate($limit);
        return $results;
    }

}
