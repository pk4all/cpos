<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserRoles;
use Carbon\Carbon;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class UserController extends Controller {

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
        if (($return = UserRoles::hasAccess('users_view', $request)) !== true) {
             return redirect()->action($return);
        }
        /* end permission code */
        $results = $this->getUserListPaging($request);
        $total_page = $results->total(); 
        $table_header = array('First Name', 'Last Name', 'Email', 'Role', 'Action');
        $per_page_limit = 10;
        $return = view('user.index', ['count' => $total_page, 'results' => $results, 'tbl_header' => $table_header, 'per_page_limit' => $per_page_limit]);
        return $return;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate(Request $request) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('users_createaa', $request)) !== true) {
             return redirect()->action($return);
        }

        /* end permission code */
        $data['user'] = User::getUserDropDownList();
        $data['user_status'] = User::$user_status;
        $data['user_role'] = UserRoles::getRolesDropDownList();
        $data['permissions'] = UserRoles::$permission;
        $data['user_status'] = User::$user_status;
        $view = view('user.create', $data);
        return $view;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function postStore(Request $request) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('users_create', $request)) !== true) {
            return redirect()->action($return);
        }

        $rules = array(
            'first_name' => 'required|min:1|max:250',
            'last_name' => 'min:1|max:250',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:50',
        );
        $this->validate($request, $rules);

        $user = new User;
        $user->first_name = $request->input('first_name', null);
        $user->last_name = $request->input('last_name', null);
        $user->email = $request->input('email', null);
        $user->password = bcrypt($request->input('password'));
        $user->manager_id = $request->input('manager_id', null);
        $user->user_role = $request->input('user_role', null);
        $permissions = UserRoles::getUserRolesById($user->user_role);
        $user->role_name = $permissions['role_name'];
        $user->permissions = $permissions['permission'];
        $user->status = 'enable';
        $login = Auth::user();
        $user->created_by = $login->_id;
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();
        $user->save();
        $request->session()->flash('status', 'User ' . $user->email . ' created successfully!');
        return redirect()->action('UserController@getIndex');
    }

    public function getEdit(Request $request, $id) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('users_update', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */
        $data['user'] = User::getUserDropDownList();
        $data['user_status'] = User::$user_status;
        $data['user_role'] = UserRoles::getRolesDropDownList();
        $data['permissions'] = UserRoles::$permission;
        $data['user_status'] = User::$user_status;
        $data['user_role'] = UserRoles::getRolesDropDownList();
        $data['user_data'] = User::find($id);

        if (empty($data['user_data'])) {
            $msg_status = 'error';
            $message = "Invalid Request URL";
            $request->session()->flash($msg_status, $message);
            return redirect()->action('UserController@getIndex');
        }

        $view = view('user.edit', $data);
        return $view;
    }

    
    public function postUpdate(Request $request, $id) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('users_update', $request)) !== true) {
             return redirect()->action($return);
        }
        $user = User::find($id);
        $login = Auth::user();
        $selfPermisson=($user->email == $login->email)?false:true;

        $rules = array(
            'first_name' => 'required|min:1|max:250',
            'last_name' => 'min:1|max:250',
            'email' => 'required|email|unique:users,id,' . $id,
            'password' => 'max:250',
        );
        $this->validate($request, $rules);
        $user = User::find($id);
        $user->first_name = $request->input('first_name', null);
        $user->last_name = $request->input('last_name', null);
        $user->email = $request->input('email');
        if (!empty($request->input('password')))
            $user->password = bcrypt($request->input('password'));
        if ($selfPermisson) {
            $user->user_role = $request->input('user_role', null);
            $user->manager_id = $request->input('manager_id', null);
            $permissions = UserRoles::getUserRolesById($user->user_role);
            $user->role_name = $permissions['role_name'];
            $user->permissions = empty($request->input('custom_permissions', [])) ? $permissions['permission'] : $request->input('custom_permissions');
        }
        $user->status = $request->input('user_status', null);
        $user->updated_by = $login->_id;
        $user->updated_at = Carbon::now();
        $user->save();
        $request->session()->flash('status', 'User ' . $user->email . ' updated successfully!');
        return redirect()->action('UserController@getIndex');
    }

    
    public function getDestroy(Request $request, $id) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('users_delete', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */
        $user = User::find($id);
        $user->status = 'disable';
        $user->deleted_at = Carbon::now();
        $user->save();
        $request->session()->flash('status', 'Successfully deleted!');
        return redirect()->action('UserController@getIndex');
    }

    public function getUserList(Request $request) {
        $pageNo = $request->has('page') ? $request->input('page') : 1;
        $count = $request->has('count') ? $request->input('count') : 10;
        $sortOrderField = $request->has('sortBy') ? $request->input('sortBy') : '_id';
        $sortDirection = $request->has('sortDir') ? $request->input('sortDir') : 'desc';

        $results = User::getUserList($pageNo, $count, $sortOrderField, $sortDirection, $search = array());
        //dd($results);
        return $results;
    }

    public function getUserListPaging(Request $request) {
        $page_no = $request->has('page') ? $request->input('page') : 1;
        $search_value = $request->has('search') ? $request->input('search') : '';
        $search_field = $request->has('search_by') ? $request->input('search_by') : 'email';
        $limit = $request->has('limit') ? (int) $request->input('limit') : 10;
        if (!is_numeric($limit)) {
            return "limit should be numeric";
        }

        $sort_by = $request->has('sort_by') ? $request->input('sort_by') : 'updated_at';
        $sort_dir = $request->has('sort_dir') ? $request->input('sort_dir') : 'desc';
        $offset = ($page_no * $limit) - $limit;
        $results = User::userList($sort_by, $sort_dir, [], true)->paginate($limit);
        return $results;
    }

    public function getAjaxUserList(Request $request) {
        $user = $this->getUserListPaging($request);
        $table_header = array('User Name', 'Manager', 'Role', 'Status', 'Action');
        $view = view('user.table', ['class' => 'table-hover table-bordered table-striped', 'tbl_header' => $table_header, 'tbl_data' => $user]);
        return $view;
    }

    public function getClearLoginAttempts($email) {

        Cache::forget('login:attempts:' . md5($email));

        Cache::forget('login:expiration:' . md5($email));

        return Redirect::back();
    }  
    
}
