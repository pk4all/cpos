<?php

namespace App\Http\Controllers\location;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\UserRoles;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class StoresController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    function __construct() {
        $this->middleware('auth');
    }

    public function Index(Request $request) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('userroles_view', $request)) !== true) {
            //  return redirect()->action($return);
        }
        /* end permission code */
        $results = $this->getCompanyListPaging($request);
        $total_page = Company::getCompanyCount();
        $table_header = array('Company Name', 'Email', 'Domain', 'Plan', 'Validity', 'Action');
        $return = view('company.index', ['count' => $total_page, 'results' => $results, 'tbl_header' => $table_header]);
        return $return;
    }

    public function Create(Request $request) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('create user', $request)) !== true) {
            return redirect()->action($return);
        }
        $users = User::getUserDropDownList();
        $view = view('company.create', ['users' => $users]);
        return $view;
    }

    public function postStore(Request $request) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('create user', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */

        $rules = array(
            'name' => 'required|min:3',
            'database' => 'required|min:3|unique:company',
            'plan' => 'required|min:3',
            'validity' => 'required|min:3',
            'email' => 'required|email|min:3|unique:company',
            'domain' => 'required|max:256|unique:company',
        );
        //return $request->all();
        $this->validate($request, $rules);
        $company = new Company();
        $company->name = $request->input('name');
        $company->email = $request->input('email');
        $company->plan = $request->input('plan');
        $company->database = $request->input('database');
        $company->user_id = $request->input('user_id');
        $company->validity = $request->input('validity');
        $company->domain = $request->input('domain');
        $company->created_by = Auth::user()->_id;
        $this->setUserOtherDB($company->database, $company->user_id);
        $company->status = 'enable';
        $company->save();
        $request->session()->flash('status', 'Company ' . $company->title . ' created successfully!');
        return redirect()->action('CompanyController@Index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function getEdit(Request $request, $id) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('update user', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */

        $company_data = Company::find($id);
        if (empty($company_data)) {
            $msg_status = 'error';
            $message = "Invalid Request URL";
            $request->session()->flash($msg_status, $message);
            return redirect()->action('CompanyController@Index');
        }
        $users = User::getUserDropDownList();
        $view = view('company.edit', ['company_data' => $company_data, 'users' => $users]);
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
        if (($return = UserRoles::hasAccess('update user', $request)) !== true) {
            return redirect()->action($return);
        }

        $rules = array(
            'name' => 'required|min:3',
            'plan' => 'required|min:3',
            'validity' => 'required|min:3',
            'email' => 'required|email|min:3|unique:company,id,' . $id,
            'domain' => 'required|max:256|unique:company,id,' . $id,
        );
        $this->validate($request, $rules);
        $company = Company::find($id);
        $company->name = $request->input('name');
        $company->email = $request->input('email');
        $company->plan = $request->input('plan');
        $company->validity = $request->input('validity');
        $company->domain = $request->input('domain');
        $company->user_id = $request->input('user_id');
        $this->setUserOtherDB($company->database, $company->user_id);
        $company->updated_by = Auth::user()->_id;
        $company->status = 'enable';
        $company->save();
        $request->session()->flash('status', 'Company ' . $company->role_name . ' Updated successfully!');
        return redirect()->action('CompanyController@Index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function getDestroy(Request $request, $id) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('delete user', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */

        $company = Company::find($id);
        $company->status = 'disable';
        $company->deleted_at = Carbon::now();
        $company->save();
        $request->session()->flash('status', 'Successfully deleted the Company!');
        return redirect()->action('CompanyController@Index');
    }

    public function getCompanyListPaging(Request $request) {
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

        $results = Company::companyList($sort_by, $sort_dir, $search, true)->paginate($limit);
        return $results;
    }

    public function setUserOtherDB($database, $user_id) {
        if ($database && $user_id) {
            $userData=User::find($user_id);
            $userData=$userData->toArray();
            Config::set('database.connections.mongodb.database', $database); //new database name, you want to connect to.
            DB::purge('mongodb');
            DB::reconnect('mongodb');
           
            $user = User::firstOrNew(['email'=>$userData['email']]);
            unset($userData['_id']);
            foreach($userData as $key=>$data){
             $user->{$key}=$data;
            }
            $user->save();
            
            Config::set('database.connections.mongodb.database', env('DB_DATABASE')); //new database name, you want to connect to.
            DB::purge('mongodb');
            DB::reconnect('mongodb');
        }
        return false;
    }

}
