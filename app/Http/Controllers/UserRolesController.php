<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserRoles;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserRolesController extends Controller {

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
        if (($return = UserRoles::hasAccess('roles_view', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */
        $results = $this->getUserRolesListPaging($request);
        $total_page = UserRoles::getUserRolesCount();
        $table_header = array('Roles Name', 'Permissions', 'Action');
        $return = view('userRoles.index', ['count' => $total_page, 'results' => $results, 'tbl_header' => $table_header]);
        return $return;
    }

    public function Create(Request $request) {
       /*code for check roles and redirect it on index method of current controller if has not access */
        if(($return=UserRoles::hasAccess('roles_create',$request))!==true){
           //return redirect()->action($return);
        } 
        /*end permission code */
        $view = view('userRoles.create', ['permissions' => UserRoles::$permission]);
        return $view;
    }

    public function postStore(Request $request) {
        /*code for check roles and redirect it on index method of current controller if has not access */
        if(($return=UserRoles::hasAccess('roles_create',$request))!==true){
           return redirect()->action($return);
        } 
        /*end permission code */
        
        $rules = array(
            'role_name' => 'required|min:3|unique:roles',
            'permissions' => 'required',
        );
        //return $request->all();
        $this->validate($request, $rules);
        $user = new UserRoles();
        $user->role_name = $request->input('role_name');
        $user->permission = $request->input('permissions');
        $user->created_by = Auth::user()->_id;
        $user->status = 'enable';
        $user->save();
        $request->session()->flash('status', 'Role ' . $user->title . ' created successfully!');
        return redirect()->action('UserRolesController@getIndex');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function getEdit(Request $request,$id) {
        /*code for check roles and redirect it on index method of current controller if has not access */
        if(($return=UserRoles::hasAccess('roles_update',$request))!==true){
           return redirect()->action($return);
        } 
        /*end permission code */
        
        $role_data = UserRoles::find($id);
        if(empty($role_data)){
            $msg_status = 'error';
            $message = "Invalid Request URL";
            $request->session()->flash($msg_status, $message);
            return redirect()->action('UserRolesController@getIndex');
        }
        $view = view('userRoles.edit', ['permissions' => UserRoles::$permission, 'role_data' => $role_data]);
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
        if(($return=UserRoles::hasAccess('roles_update',$request))!==true){
           return redirect()->action($return);
        } 
        
        $rules = array(
            'role_name' => 'required|min:3,id,'.$id,
            'permissions' => 'required',
        );
        $this->validate($request, $rules);
        $user = UserRoles::find($id);
        $user->role_name = $request->input('role_name');
        $user->permission = $request->input('permissions');
        $user->created_by = Auth::user()->_id;
        $user->status = 'enable';
        $user->save();
        $request->session()->flash('status', 'Role ' . $user->role_name . ' Updated successfully!');
        return redirect()->action('UserRolesController@getIndex');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function getDestroy(Request $request, $id) {
        /*code for check roles and redirect it on index method of current controller if has not access */
        if(($return=UserRoles::hasAccess('roles_delete',$request))!==true){
           return redirect()->action($return);
        } 
        /*end permission code */
        
        $user = UserRoles::find($id);
        $user->status = 'disable';
        $user->deleted_at = Carbon::now();
        $user->save();
        $request->session()->flash('status', 'Successfully deleted the Role!');
        return redirect()->action('UserRolesController@getIndex');
    }

    public function getUserRolesListPaging(Request $request) {
        $page_no = $request->has('page') ? $request->input('page') : 1;
        $search_value = $request->has('search') ? $request->input('search') : '';
        $search_field = $request->has('search_by') ? $request->input('search_by') : 'role_name';
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

        $results = UserRoles::userRolesList($sort_by, $sort_dir, $search, true)->paginate($limit);
        return $results;
    }

//    public function getAjaxUserRolesList(Request $request) {
//        $user = $this->getUserRolesListPaging($request);
//        $table_header = array('Roles Name', 'Permissions', 'Action');
//
//        $view = view('userRoles.table', ['class' => 'table-hover table-bordered table-striped', 'tbl_header' => $table_header, 'tbl_data' => $user]);
//        return $view;
//        //return "paginationfunction";
//    }
}
