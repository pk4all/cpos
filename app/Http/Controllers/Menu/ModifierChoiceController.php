<?php

namespace App\Http\Controllers\Menu;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserRoles;
use App\Models\User;
use App\Models\Menu\ModifierChoice;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;



class ModifierChoiceController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public $tabList;

    function __construct() {
        $this->middleware('auth');
        $this->tabList['tab'] = Helper::$menutab;
        $this->tabList['selected'] = 'modifier-choice';
    }


    public function getIndex(Request $request) {

        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('modifier_view', $request)) !== true) {
              return redirect()->action($return);
        }
        /* end permission code */
        $results = $this->getModifierChoiceListPaging($request);
        //print_r($results); die;
        
        $total_page = ModifierChoice::getModifierChoiceCount();
        $table_header = array('Name', 'Multiplied By', 'Action');
        $return = view('menu.modifier_choice.index', ['tabList' => $this->tabList, 'count' => $total_page, 'results' => $results, 'tbl_header' => $table_header]);
        return $return;
    }

    public function Create(Request $request) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('modifier_create', $request)) !== true) {
            return redirect()->action($return);
        }
        
        $view = view('menu.modifier_choice.create', ['tabList' => $this->tabList]);
        return $view;
    }

    public function postStore(Request $request) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('modifier_create', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */
        $rules = array(
            'name' => 'required'
        );
        //notification_email phone print_label tax_id image address  address state country zip_code radius latitude longitude 
        $this->validate($request, $rules);
        $modifierChoice = new ModifierChoice();
        $modifierChoice->name = $request->input('name', null);
        $modifierChoice->multiplied_by = $request->input('multiplied_by', null);
        $modifierChoice->description = $request->input('description', null);
        $modifierChoice->created_by = Auth::user()->_id;
        $modifierChoice->updated_by = Auth::user()->_id;
        $modifierChoice->status = 'disable';
        $modifierChoice->save();
        $request->session()->flash('status', 'Modifier Choice ' . $modifierChoice->name . ' created successfully!');
        return redirect()->action('Menu\ModifierChoiceController@getIndex');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function getEdit(Request $request, $id) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('modifier_update', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */

        $modifierChoice = ModifierChoice::find($id);
        
        if (empty($modifierChoice)) {
            $msg_status = 'error';
            $message = "Invalid Request URL";
            $request->session()->flash($msg_status, $message);
            return redirect()->action('ModifierChoiceController@getIndex');
        }
        //dd($modifier_choice_update);
        $view = view('menu.modifier_choice.edit', ['tabList' => $this->tabList, 'choice_data' => $modifierChoice,'tabList' => $this->tabList]);
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
        if (($return = UserRoles::hasAccess('modifier_update', $request)) !== true) {
            return redirect()->action($return);
        }

        $rules = array(
            'name' => 'required'
        );
        //notification_email phone print_label tax_id image address  address state country zip_code radius latitude longitude 
        $this->validate($request, $rules);
        $modifierChoice = ModifierChoice::find($id);
        $modifierChoice->name = $request->input('name', null);
        $modifierChoice->multiplied_by = $request->input('multiplied_by', null);
        $modifierChoice->description = $request->input('description', null);
        $modifierChoice->updated_by = Auth::user()->_id;
        $modifierChoice->save();
        $request->session()->flash('status', 'ModifierChoice ' . $modifierChoice->name . ' Updated successfully!');
        return redirect()->action('Menu\ModifierChoiceController@getIndex');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function getDestroy(Request $request, $id) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('modifier_delete', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */

        $modifierChoice = ModifierChoice::find($id);
        
        $modifierChoice->status = 'disable';
        $modifierChoice->deleted_at = Carbon::now();
        $modifierChoice->updated_by = Auth::user()->_id;
        $modifierChoice->save();
        $request->session()->flash('status', 'Successfully deleted the Modifier Choice!');
        return redirect()->action('Menu\ModifierChoiceController@getIndex');
    }

    public function getUpdateStatus(Request $request, $id) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('modifier_update', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */
        $modifierChoice = ModifierChoice::find($id);
        $modifierChoice->updated_at = Carbon::now();
        $modifierChoice->updated_by = Auth::user()->_id;
        $modifierChoice->status = $modifierChoice->status == 'enable' ? 'disable' : 'enable';
        $modifierChoice->save();
        $request->session()->flash('status', $modifierChoice->name . ' status changed to ' . $modifierChoice->status . ' Successfully!');
        return redirect()->action('Menu\ModifierChoiceController@getIndex');
    }

    public function getModifierChoiceListPaging(Request $request) {

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
        $results = ModifierChoice::ModifierChoiceList($sort_by, $sort_dir, $search, true)->paginate($limit);
        return $results;
    }

}
