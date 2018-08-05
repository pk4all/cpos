<?php

namespace App\Http\Controllers\Location;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Location\Stores;
use App\Models\UserRoles;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Location\Tax;
use App\Models\Location\OrderTypes;
use App\Helpers\Helper;

class TaxController extends Controller {

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
        if (($return = UserRoles::hasAccess('tax_view', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */
        $results = $this->getTaxListPaging($request);
        //echo "<pre>"; print_r($results); die;
        $total_page = Tax::getTaxCount();
        $table_header = array('Name', 'Type', 'Amount', 'Order Types', 'Store', 'Action');

        $return = view('location.tax.index', ['count' => $total_page, 'results' => $results, 'tbl_header' => $table_header]);
        return $return;
    }

    public function Create(Request $request) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('tax_create', $request)) !== true) {
            return redirect()->action($return);
        }

        $orderTypeList = OrderTypes::getOrderTypeDropDownList();
        $storeList = Stores::getStoreDropDownList();

        $data = [
            'order_type_list' => $orderTypeList, 
            'tax_type' => Tax::$type,
            'store_list' => $storeList
        ];
        $view = view('location.tax.create', $data);
        return $view;
    }

    public function postStore(Request $request) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('tax_create', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */

        $rules = array(
            'name' => 'required|min:3',
            'type' => 'required',
            'amount' => 'required|min:2',
            'store' => 'required',
            'order_type' => 'required'
        );
        //notification_email phone print_label tax_id image address  address state country zip_code radius latitude longitude 
        $this->validate($request, $rules);
        $tax = new Tax();
        $tax->name = $request->input('name', null);
        $tax->type = $request->input('type', null);
        $tax->amount = $request->input('amount', null);
        $order_id = $request->input('order_type', null);
        $store_id = $request->input('store', null);
        $order_type_name = OrderTypes::getOrderTypesByIds(array_values($order_id), ['name']);
        $stores = Stores::getStoresByIds(array_values($store_id), ['name']);
        $tax->order_type = $order_type_name;
        $tax->stores = $stores;
        $tax->created_by = Auth::user()->_id;
        $tax->updated_by = Auth::user()->_id;
        $tax->status = 'disable';
        //print_r($tax); die;
        $tax->save();
        $request->session()->flash('status', 'Tax ' . $tax->name . ' created successfully!');
        return redirect()->action('Location\TaxController@getIndex');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function getEdit(Request $request, $id) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('tax_update', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */

        $tax_data = Tax::find($id);

        $storeCity = Stores::getStoreDropDownList();
        if (empty($tax_data)) {
            $msg_status = 'error';
            $message = "Invalid Request URL";
            $request->session()->flash($msg_status, $message);
            return redirect()->action('TaxController@getIndex');
        }
        //dd($tax_update);
        $orderTypeList = OrderTypes::getOrderTypeDropDownList();
        $storeList = Stores::getStoreDropDownList();
        $view = view('location.tax.edit', ['tax_data' => $tax_data, 'order_type_list' => $orderTypeList, 'store_list' => $storeList,'tax_type' => Tax::$type]);
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
            'type' => 'required',
            'amount' => 'required|min:2',
            'store' => 'required',
            'order_type' => 'required'
        );
        //notification_email phone print_label tax_id image address  address state country zip_code radius latitude longitude 
        $this->validate($request, $rules);
        $tax = Tax::find($id);
        $tax->name = $request->input('name', null);
        $tax->type = $request->input('type', null);
        $tax->amount = $request->input('amount', null);
        $order_id = $request->input('order_type', null);
        $store_id = $request->input('store', null);
        $order_type_name = OrderTypes::getOrderTypesByIds(array_values($order_id), ['name']);
        $stores = Stores::getStoresByIds(array_values($store_id), ['name']);
        $tax->order_type = $order_type_name;
        $tax->stores = $stores;
        $tax->updated_by = Auth::user()->_id;
        $tax->save();
        $request->session()->flash('status', 'Tax ' . $tax->name . ' Updated successfully!');
        return redirect()->action('Location\TaxController@getIndex');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function getDestroy(Request $request, $id) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('tax_delete', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */

        $tax = Tax::find($id);
        //echo "<pre>"; print_r($tax);die;
        $tax->status = 'disable';
        $tax->deleted_at = Carbon::now();
        $tax->updated_by = Auth::user()->_id;
        $tax->save();
        $request->session()->flash('status', 'Successfully deleted the Tax!');
        return redirect()->action('Location\TaxController@getIndex');
    }

    public function getUpdateStatus(Request $request, $id) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('tax_update', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */
        $tax = Tax::find($id);
        $tax->updated_at = Carbon::now();
        $tax->updated_by = Auth::user()->_id;
        $tax->status = $tax->status == 'enable' ? 'disable' : 'enable';
        $tax->save();
        $request->session()->flash('status', $tax->name . ' Status changed to ' . $tax->status . ' Successfully!');
        return redirect()->action('Location\TaxController@getIndex');
    }

    public function getTaxListPaging(Request $request) {
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

        $results = Tax::taxList($sort_by, $sort_dir, $search, true)->paginate($limit);
        return $results;
    }

}
