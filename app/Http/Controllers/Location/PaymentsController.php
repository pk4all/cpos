<?php

namespace App\Http\Controllers\Location;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Location\Stores;
use App\Models\UserRoles;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Models\Location\Payment;
use App\Helpers\Helper;


class PaymentsController extends Controller {

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
        if (($return = UserRoles::hasAccess('payments_view', $request)) !== true) {
              return redirect()->action($return);
        }
        /* end permission code */
        $results = $this->getPaymentListPaging($request);
        
        $total_page = Payment::getPaymentCount();
        $table_header = array('Payment Icon', 'Name', 'Type', 'Action');
        $return = view('location.payments.index', ['count' => $total_page, 'results' => $results, 'tbl_header' => $table_header]);
        return $return;
    }

    public function Create(Request $request) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('payments_create', $request)) !== true) {
            return redirect()->action($return);
        }
        
        $storeCity= Stores::getStoreDropDownList();
        
        $data=[
            'storeCity'=>$storeCity,
            'paymentTypes' => Payment::$type
        ];
        $view = view('location.payments.create',$data);
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
            'payment_type' => 'required',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024'
        );
        //notification_email phone print_label tax_id image address  address state country zip_code radius latitude longitude 
        $this->validate($request, $rules);
        $payments = new Payment();
        $payments->name = $request->input('name', null);
        $paymentType=$request->input('payment_type', null);
        $payments->type = $paymentType;
        $uploaded_file = $request->file('logo');
        //print_r($uploaded_file); die;
        $orgname= $uploaded_file->getClientOriginalName();
        $extension = $uploaded_file->getClientOriginalExtension();

        $name=  str_replace(".".$extension, '', $orgname);
        $newName = str_slug($name) . '_' . uniqid().'.' . $extension;

        $dest = Helper::imageFileUploadPath('assets/images/',$dir_name='uploaded_image');

        $response = $uploaded_file->move($dest, $newName);
        
        if($response){
            $payments->logo=$newName;  
        }    
        
        $payments->created_by = Auth::user()->_id;
        $payments->updated_by = Auth::user()->_id;
        $payments->status = 'disable';
        $payments->save();
        $request->session()->flash('status', 'Payment ' . $payments->name . ' created successfully!');
        return redirect()->action('Location\PaymentsController@getIndex');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function getEdit(Request $request, $id) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('payments_update', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */

        $payment_data = Payment::find($id);
        if(count($payment_data->quick_options) < 1){
            $payment_data->quick_options = array('NA'=> 'NA');
        }
        $paymentType= Payment::$type;
        if (empty($payment_data)) {
            $msg_status = 'error';
            $message = "Invalid Request URL";
            $request->session()->flash($msg_status, $message);
            return redirect()->action('PaymentsController@getIndex');
        }
        //dd($payments_update);
        $view = view('location.payments.edit', ['payment_data' => $payment_data,'paymentType'=>$paymentType]);
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
            'payment_type' => 'required',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024'
        );
        //notification_email phone print_label tax_id image address  address state country zip_code radius latitude longitude 
        $this->validate($request, $rules);
        $payment = Payment::find($id);
        $payment->name = $request->input('name', null);
        $payment->type = $request->input('payment_type', null);
        $uploaded_file = $request->file('logo');
        if(!empty($uploaded_file)){
            $orgname= $uploaded_file->getClientOriginalName();
            $extension = $uploaded_file->getClientOriginalExtension();
            $name=  str_replace(".".$extension, '', $orgname);
            $newName = str_slug($name) . '_' . uniqid().'.' . $extension;
            $dest = Helper::imageFileUploadPath('assets/images/',$dir_name='uploaded_image');
            $response = $uploaded_file->move($dest, $newName);

            if($response){
                if(file_exists($dest.$payment->logo)){
                    @unlink($dest.$payment->logo);
                }
                $payment->logo=$newName;  
            }    
        }

        $labels = $request->input('label', null);
        $values = $request->input('value', null);

        $customOptions = array();
        if($payment->type == 'Cash'){
            foreach($labels as $index => $label){
                if($values[$index] != '' &&  $label != ''){
                    $customOptions[$label] = $values[$index];
                }
            }
        }
        $payment->quick_options = $customOptions;
        $payment->updated_by = Auth::user()->_id;
        $payment->save();
        $request->session()->flash('status', 'Payment ' . $payment->name . ' Updated successfully!');
        return redirect()->action('Location\PaymentsController@getIndex');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function getDestroy(Request $request, $id) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('payments_delete', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */

        $payment = Payment::find($id);
        $dest = Helper::imageFileUploadPath('assets/images/',$dir_name='uploaded_image');
        if(file_exists($dest.$payment->logo)){
            @unlink($dest.$payment->logo);
        }
        $payment->status = 'disable';
        $payment->deleted_at = Carbon::now();
        $payment->updated_by = Auth::user()->_id;
        $payment->save();
        $request->session()->flash('status', 'Successfully deleted the Payment!');
        return redirect()->action('Location\PaymentsController@getIndex');
    }

    public function getUpdateStatus(Request $request, $id) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('payments_update', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */
        $payment = Payment::find($id);
        $payment->updated_at = Carbon::now();
        $payment->updated_by = Auth::user()->_id;
        $payment->status = $payment->status == 'enable' ? 'disable' : 'enable';
        $payment->save();
        $request->session()->flash('status', $payment->name . ' status changed to ' . $payment->status . ' Successfully!');
        return redirect()->action('Location\PaymentsController@getIndex');
    }

    public function getPaymentListPaging(Request $request) {

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
        $results = Payment::paymentList($sort_by, $sort_dir, $search, true)->paginate($limit);
        return $results;
    }

}
