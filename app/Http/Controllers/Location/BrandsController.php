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
use App\Models\Location\Brands;
use App\Helpers\Helper;


class BrandsController extends Controller {

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
        if (($return = UserRoles::hasAccess('brands_view', $request)) !== true) {
              return redirect()->action($return);
        }
        /* end permission code */
        $results = $this->getBrandsListPaging($request);
        
        $total_page = Brands::getBrandsCount();
        $table_header = array('Logo', 'Name', 'Stores', 'Action');
        $return = view('location.brands.index', ['count' => $total_page, 'results' => $results, 'tbl_header' => $table_header]);
        return $return;
    }

    public function Create(Request $request) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('brands_create', $request)) !== true) {
            return redirect()->action($return);
        }
        
        $storeCity= Stores::getStoreDropDownList();
        
        $data=[
            'storeCity'=>$storeCity
        ];
        $view = view('location.brands.create',$data);
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
            'description' => 'required|min:10',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        );
        //notification_email phone print_label tax_id image address  address state country zip_code radius latitude longitude 
        $this->validate($request, $rules);
        $brands = new Brands();
        $brands->name = $request->input('name', null);
        $brands->description = $request->input('description', null);
        $stores_id=$request->input('store_city', null);
        $stores_name=  Stores::getStoresByIds(array_values($stores_id),['name']);
        $brands->stores=$stores_name;
        $uploaded_file = $request->file('logo');

        $orgname= $uploaded_file->getClientOriginalName();
        
        
        $extension = $uploaded_file->getClientOriginalExtension();
        $name=  str_replace(".".$extension, '', $orgname);
        
        $newName = str_slug($name) . '_' . uniqid().'.' . $extension;

        $desc = Helper::imageFileUploadPath('assets/images/',$dir_name='uploaded_image');

        $response = $uploaded_file->move($desc, $newName);
        
        if($response){
            $brands->logo=$newName;  
        }    
        
        $brands->created_by = Auth::user()->_id;
        $brands->updated_by = Auth::user()->_id;
        $brands->status = 'disable';
        $brands->save();
        $request->session()->flash('status', 'Brands ' . $brands->name . ' created successfully!');
        return redirect()->action('Location\BrandsController@getIndex');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function getEdit(Request $request, $id) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('brands_update', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */

        $brands_data = Brands::find($id);

        $storeCity= Stores::getStoreDropDownList();
        if (empty($brands_data)) {
            $msg_status = 'error';
            $message = "Invalid Request URL";
            $request->session()->flash($msg_status, $message);
            return redirect()->action('BrandsController@getIndex');
        }
        //dd($brands_update);
        $view = view('location.brands.edit', ['brands_data' => $brands_data,'storeCity'=>$storeCity]);
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
            'description' => 'required|min:10',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        );
        //notification_email phone print_label tax_id image address  address state country zip_code radius latitude longitude 
        $this->validate($request, $rules);
        $brands = Brands::find($id);
        $brands->name = $request->input('name', null);
        $brands->description = $request->input('description', null);
        $stores_id=$request->input('store_city', null);
        $stores_name=  Stores::getStoresByIds(array_values($stores_id),['name']);
        $brands->stores=$stores_name;
        $uploaded_file = $request->file('logo');
        if(!empty($uploaded_file)){
            $orgname= $uploaded_file->getClientOriginalName();


            $extension = $uploaded_file->getClientOriginalExtension();
            $name=  str_replace(".".$extension, '', $orgname);

            $newName = str_slug($name) . '_' . uniqid().'.' . $extension;

            $desc = Helper::imageFileUploadPath('assets/images/',$dir_name='uploaded_image');

            $response = $uploaded_file->move($desc, $newName);

            if($response){
                $brands->logo=$newName;  
            }    
        }
        $brands->updated_by = Auth::user()->_id;
        $brands->save();
        $request->session()->flash('status', 'Brands ' . $brands->name . ' Updated successfully!');
        return redirect()->action('Location\BrandsController@getIndex');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function getDestroy(Request $request, $id) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('brands_delete', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */

        $brands = Brands::find($id);
        $brands->status = 'disable';
        $brands->deleted_at = Carbon::now();
        $brands->updated_by = Auth::user()->_id;
        $brands->save();
        $request->session()->flash('status', 'Successfully deleted the Brands!');
        return redirect()->action('Location\BrandsController@getIndex');
    }

    public function getUpdateStatus(Request $request, $id) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('brands_update', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */
        $brands = Brands::find($id);
        $brands->updated_at = Carbon::now();
        $brands->updated_by = Auth::user()->_id;
        $brands->status = $brands->status == 'enable' ? 'disable' : 'enable';
        $brands->save();
        $request->session()->flash('status', $brands->name . ' Status changed to ' . $brands->status . ' Successfully!');
        return redirect()->action('Location\BrandsController@getIndex');
    }

    public function getBrandsListPaging(Request $request) {
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

        $results = Brands::brandsList($sort_by, $sort_dir, $search, true)->paginate($limit);
        return $results;
    }

}
