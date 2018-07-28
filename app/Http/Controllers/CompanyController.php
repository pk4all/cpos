<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\UserRoles;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CompanyController extends Controller {

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
            //return redirect()->action($return);
        }

        $view = view('company.create');
        return $view;
    }

    public function postStore(Request $request) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('create user', $request)) !== true) {
            //return redirect()->action($return);
        }
        /* end permission code */

        $rules = array(
            'name' => 'required|min:3|unique:company',
            'plan' => 'required|min:3',
            'validity' => 'required|min:3',
            'email' => 'required|email|min:3',
            'domain' => 'required|max:256||unique:company',
        );
        //return $request->all();
        $this->validate($request, $rules);
        $user = new Company();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->plan = $request->input('plan');
        $user->validity = $request->input('validity');
        $user->domain = $request->input('domain');
        $user->created_by = Auth::user()->_id;
        $user->status = 'enable';
        $user->save();
        $request->session()->flash('status', 'Company ' . $user->title . ' created successfully!');
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
            //return redirect()->action($return);
        }
        /* end permission code */

        $company_data = Company::find($id);
        if (empty($company_data)) {
            $msg_status = 'error';
            $message = "Invalid Request URL";
            $request->session()->flash($msg_status, $message);
            return redirect()->action('CompanyController@Index');
        }
        $view = view('company.edit', ['company_data' => $company_data]);
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
            //return redirect()->action($return);
        }

        $rules = array(
            'name' => 'required|min:3|unique:company,id,' . $id,
            'plan' => 'required|min:3',
            'validity' => 'required|min:3',
            'email' => 'required|email|min:3',
            'domain' => 'required|max:256|unique:company,id,' . $id,
        );
        $this->validate($request, $rules);
        $user = Company::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->plan = $request->input('plan');
        $user->validity = $request->input('validity');
        $user->domain = $request->input('domain');
        $user->updated_by = Auth::user()->_id;
        $user->status = 'enable';
        $user->save();
        $request->session()->flash('status', 'Company ' . $user->role_name . ' Updated successfully!');
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
            // return redirect()->action($return);
        }
        /* end permission code */

        $user = Company::find($id);
        $user->status = 'disable';
        $user->deleted_at = Carbon::now();
        $user->save();
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

}
