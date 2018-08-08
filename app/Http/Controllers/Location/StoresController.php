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
use App\Helpers\Helper;

class StoresController extends Controller {

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
        if (($return = UserRoles::hasAccess('stores_view', $request)) !== true) {
              return redirect()->action($return);
        }
        /* end permission code */
        $results = $this->getStoresListPaging($request);
        $total_page = Stores::getStoresCount();
        $table_header = array('Stores Name', 'Email', 'Notify Email', 'Label', 'Phone', 'Action');
        $return = view('location.stores.index', ['count' => $total_page, 'results' => $results, 'tbl_header' => $table_header]);
        return $return;
    }

    public function Create(Request $request) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('stores_create', $request)) !== true) {
            return redirect()->action($return);
        }
       $view = view('location.stores.create',['contryList'=>Stores::$contryList,'days'=>Stores::$days]);
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
            'email' => 'required|min:3|unique:stores',
            'print_label' => 'required|min:3',
            'tax_id' => 'required|min:3|unique:stores',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024'
        );
        //notification_email phone print_label tax_id image address  address state country zip_code radius latitude longitude 
        $this->validate($request, $rules);
        $stores = new Stores();
        $uploaded_file = $request->file('logo');
        if(!empty($uploaded_file)){
            $orgname= $uploaded_file->getClientOriginalName();
            $extension = $uploaded_file->getClientOriginalExtension();

            $name=  str_replace(".".$extension, '', $orgname);
            $logoFileName = str_slug($name) . '_' . uniqid().'.' . $extension;

            $dest = Helper::imageFileUploadPath('assets/images/',$dir_name='uploaded_image');

            $response = $uploaded_file->move($dest, $logoFileName);
            
            if($response){
                $stores->logo=$logoFileName;  
            }  
        }


        $stores->name = $request->input('name', null);
        $stores->email = $request->input('email', null);
        $stores->image = $request->input('image', null);
        $stores->notification_email = $request->input('notification_email', null);
        $stores->phone = $request->input('phone', null);
        $stores->print_label = $request->input('print_label', null);
        $stores->tax_id = $request->input('tax_id', null);
        $stores->address = $request->input('address', null);
        $stores->radius = $request->input('radius', null);
        $stores->latitude = $request->input('latitude', null);
        $stores->longitude = $request->input('longitude', null);

        //STORE TIMING*****************************************
        $storeTiming = array();
        $fromDay = $request->input('from_day', null);
        $toDay = $request->input('to_day', null);
        $fromTime = $request->input('from_time', null);
        $toTime = $request->input('to_time', null);
        foreach($fromDay as $index => $fromDay){
            if(!empty($fromDay) && !empty($toDay[$index]) && !empty($fromTime[$index]) && !empty($toTime[$index])){
                array_push($storeTiming, array(
                    'from_day' => $fromDay,
                    'to_day' => $toDay[$index],
                    'from_time' => $fromTime[$index],
                    'to_time' => $toTime[$index]
                ));
            }

        }
        $stores->store_timing = $storeTiming;
        //STORE TIMING*****************************************
        $stores->created_by = Auth::user()->_id;
        $stores->updated_by = Auth::user()->_id;
        $stores->status = 'disable';

        $stores->save();
        $request->session()->flash('status', 'Stores ' . $stores->name . ' created successfully!');
        return redirect()->action('Location\StoresController@getIndex');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function getEdit(Request $request, $id) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('stores_update', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */

        $stores_data = Stores::find($id);
       
        if (empty($stores_data)) {
            $msg_status = 'error';
            $message = "Invalid Request URL";
            $request->session()->flash($msg_status, $message);
            return redirect()->action('StoresController@getIndex');
        }

        if(count($stores_data->store_timing) < 1){
            $stores_data->store_timing[] = array(
                'from_day'=> '',
                'to_day'=> '',
                'from_time'=> '',
                'to_time'=> ''
            );
        }
        $view = view('location.stores.edit', ['stores_data' => $stores_data,'contryList'=>Stores::$contryList,'days'=>Stores::$days]);
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
            'email' => 'required|min:3|unique:stores,id,' . $id,
            'print_label' => 'required|min:3',
            'tax_id' => 'required|min:3|unique:stores,id,' . $id,
        );
        //notification_email phone print_label tax_id image address  address state country zip_code radius latitude longitude 
        $this->validate($request, $rules);
        $stores = Stores::find($id);
        //UPLOAD LOGO******************************
        $uploaded_file = $request->file('logo');
        if(!empty($uploaded_file)){
            $orgname= $uploaded_file->getClientOriginalName();
            $extension = $uploaded_file->getClientOriginalExtension();

            $name=  str_replace(".".$extension, '', $orgname);
            $logoFileName = str_slug($name) . '_' . uniqid().'.' . $extension;

            $dest = Helper::imageFileUploadPath('assets/images/',$dir_name='uploaded_image');

            $response = $uploaded_file->move($dest, $logoFileName);
            
            if($response){
                $stores->logo=$logoFileName;  
            } 
        }
        //UPLOAD LOGO******************************
        $stores->name = $request->input('name', null);
        $stores->email = $request->input('email', null);
        $stores->image = $request->input('image', null);
        $stores->notification_email = $request->input('notification_email', null);
        $stores->phone = $request->input('phone', null);
        $stores->print_label = $request->input('print_label', null);
        $stores->tax_id = $request->input('tax_id', null);
        $stores->address = $request->input('address', null);
        $stores->radius = $request->input('radius', null);
        $stores->latitude = $request->input('latitude', null);
        $stores->longitude = $request->input('longitude', null);
        //$stores->status = $request->input('status', 'disable');

        //STORE TIMING*****************************************
        $storeTiming = array();
        $fromDay = $request->input('from_day', null);
        $toDay = $request->input('to_day', null);
        $fromTime = $request->input('from_time', null);
        $toTime = $request->input('to_time', null);
        foreach($fromDay as $index => $fromDay){
            if(!empty($fromDay) && !empty($toDay[$index]) && !empty($fromTime[$index]) && !empty($toTime[$index])){
                array_push($storeTiming, array(
                    'from_day' => $fromDay,
                    'to_day' => $toDay[$index],
                    'from_time' => $fromTime[$index],
                    'to_time' => $toTime[$index]
                ));
            }

        }
        $stores->store_timing = $storeTiming;
        //STORE TIMING*****************************************

        $stores->updated_by = Auth::user()->_id;
        $stores->save();
        $request->session()->flash('status', 'Stores ' . $stores->name . ' Updated successfully!');
        return redirect()->action('Location\StoresController@getIndex');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function getDestroy(Request $request, $id) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('stores_delete', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */

        $stores = Stores::find($id);
        $stores->status = 'disable';
        $stores->deleted_at = Carbon::now();
        $stores->updated_by = Auth::user()->_id;
        $stores->save();
        $request->session()->flash('status', 'Successfully deleted the Stores!');
        return redirect()->action('Location\StoresController@getIndex');
    }

    public function getUpdateStatus(Request $request, $id) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('stores_update', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */
        $stores = Stores::find($id);
        $stores->updated_at = Carbon::now();
        $stores->updated_by = Auth::user()->_id;
        $stores->status = $stores->status == 'enable' ? 'disable' : 'enable';
        $stores->save();
        $request->session()->flash('status', $stores->name . ' Status changed to ' . $stores->status . ' Successfully!');
        return redirect()->action('Location\StoresController@getIndex');
    }

    public function getStoresListPaging(Request $request) {
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

        $results = Stores::storesList($sort_by, $sort_dir, $search, true)->paginate($limit);
        return $results;
    }

}
