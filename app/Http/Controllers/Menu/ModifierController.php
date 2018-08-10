<?php

namespace App\Http\Controllers\Menu;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserRoles;
use App\Models\User;
use App\Models\Menu\Modifier;
use App\Models\Menu\ModifierChoice;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;



class ModifierController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public $tabList;

    function __construct() {
        $this->middleware('auth');
        $this->tabList['tab'] = Helper::$menutab;
        $this->tabList['selected'] = 'modifier';
    }


    public function getIndex(Request $request) {

        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('modifier_view', $request)) !== true) {
              return redirect()->action($return);
        }
        /* end permission code */
        $results = $this->getModifierListPaging($request);
        //print_r($results); die;
        
        $total_page = Modifier::getModifierCount();
        $table_header = array('Modifier Name', 'PLU Code', 'Image', 'Action');
        $return = view('menu.modifier.index', ['tabList' => $this->tabList, 'count' => $total_page, 'results' => $results, 'tbl_header' => $table_header]);
        return $return;
    }

    public function Create(Request $request) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('modifier_create', $request)) !== true) {
            return redirect()->action($return);
        }
        $modifierChoices = ModifierChoice::getModifierChoiceDropDownList();
        $dependentModifierGroups = [];
        $dependentModifiers = [];
        unset($modifierChoices[0]);
        
        $view = view('menu.modifier.create', [
            'tabList' => $this->tabList,
            'dependentModifierGroups' => $dependentModifierGroups,
            'dependentModifiers' => $dependentModifiers,
            'yesNoOptions' => array('Yes' =>'Yes', 'No' => 'No'),
            'modifierChoices' => $modifierChoices
        ]);
        return $view;
    }

    public function postStore(Request $request) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('modifier_create', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */
        $rules = array(
            'name' => 'required',
            'plu_code' => 'required |unique:modifiers',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024'
        );
        //notification_email phone print_label tax_id image address  address state country zip_code radius latitude longitude 
        $this->validate($request, $rules);
        $modifier = new Modifier();
        $modifier->name = $request->input('name', null);

        $uploaded_file = $request->file('image');
        if(!empty($uploaded_file)){
            $orgname= $uploaded_file->getClientOriginalName();
            $extension = $uploaded_file->getClientOriginalExtension();

            $name=  str_replace(".".$extension, '', $orgname);
            $imageFileName = str_slug($name) . '_' . uniqid().'.' . $extension;

            $dest = Helper::imageFileUploadPath('assets/images/',$dir_name='uploaded_image');

            $response = $uploaded_file->move($dest, $imageFileName);
            
            if($response){
                $modifier->image=$imageFileName;  
            }  
        }
        $modifier->plu_code = $request->input('plu_code', null);
        $modifier->price = $request->input('price', null);
        $modifier->choice_charge = $request->input('choice_charge', null);
        $dependentModifierGroup = $dependentModifier = [];
        /*$dependentModifierGroupId = $request->input('dependent_modifier_group', null);
        $dependentModifierGroup = ModifierGroup::getModifierGroupByIds(array_values($dependentModifierGroupId), ['name']);
        
        $dependentModifierId = $request->input('dependent_modifier', null);
        $dependentModifier = ModifierGroup::getModifierByIds(array_values($dependentModifierId), ['name']);
        */
        $modifierChoicesId = $request->input('modifier_choices', null);
        $modifierChoices = ModifierChoice::getModifierChoiceByIds(array_values($modifierChoicesId), ['name']);

        $modifier->dependent_modifier_group = $dependentModifierGroup;
        $modifier->dependent_modifier = $dependentModifier;
        $modifier->modifier_choices = $modifierChoices;
        $modifier->dependent_modifier_count = $request->input('dependent_modifier_count', null);
        $modifier->no_modifier = $request->input('no_modifier', null);

        $modifier->created_by = Auth::user()->_id;
        $modifier->updated_by = Auth::user()->_id;
        $modifier->status = 'disable';
        $modifier->save();
        $request->session()->flash('status', 'Modifier ' . $modifier->name . ' created successfully!');
        return redirect()->action('Menu\ModifierController@getIndex');
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
        $dependentModifierGroups = $dependentModifiers = [];
        $modifierChoices = ModifierChoice::getModifierChoiceDropDownList();
        unset($modifierChoices[0]);
        $modifier = Modifier::find($id);
        
        if (empty($modifier)) {
            $msg_status = 'error';
            $message = "Invalid Request URL";
            $request->session()->flash($msg_status, $message);
            return redirect()->action('ModifierController@getIndex');
        }
        //dd($modifier_update);
        $view = view('menu.modifier.edit', [
            'tabList' => $this->tabList, 
            'modifier_data' => $modifier,
            'dependentModifierGroups' => $dependentModifierGroups,
            'dependentModifiers' => $dependentModifiers,
            'modifierChoices' => $modifierChoices,
            'yesNoOptions' => array('Yes' =>'Yes', 'No' => 'No')
        ]);
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
            'name' => 'required',
            'plu_code' => 'required |unique:modifier',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024'
        );
        //notification_email phone print_label tax_id image address  address state country zip_code radius latitude longitude 
        $this->validate($request, $rules);
        $modifier = Modifier::find($id);
        $modifier->name = $request->input('name', null);
        $uploaded_file = $request->file('image');
        if(!empty($uploaded_file)){
            $orgname= $uploaded_file->getClientOriginalName();
            $extension = $uploaded_file->getClientOriginalExtension();

            $name=  str_replace(".".$extension, '', $orgname);
            $imageFileName = str_slug($name) . '_' . uniqid().'.' . $extension;

            $dest = Helper::imageFileUploadPath('assets/images/',$dir_name='uploaded_image');

            $response = $uploaded_file->move($dest, $imageFileName);
            
            if($response){
                $modifier->image=$imageFileName;  
            }  
        }
        $modifier->plu_code = $request->input('plu_code', null);
        $modifier->price = $request->input('price', null);
        $modifier->choice_charge = $request->input('choice_charge', null);
        $dependentModifierGroup = $dependentModifier = [];
        /*$dependentModifierGroupId = $request->input('dependent_modifier_group', null);
        $dependentModifierGroup = ModifierGroup::getModifierGroupByIds(array_values($dependentModifierGroupId), ['name']);
        
        $dependentModifierId = $request->input('dependent_modifier', null);
        $dependentModifier = ModifierGroup::getModifierByIds(array_values($dependentModifierId), ['name']);
        */
        $modifierChoicesId = $request->input('modifier_choices', null);
        $modifierChoices = ModifierChoice::getModifierChoiceByIds(array_values($modifierChoicesId), ['name']);

        $modifier->dependent_modifier_group = $dependentModifierGroup;
        $modifier->dependent_modifier = $dependentModifier;
        $modifier->modifier_choices = $modifierChoices;
        $modifier->dependent_modifier_count = $request->input('dependent_modifier_count', null);
        $modifier->no_modifier = $request->input('no_modifier', null);
        $modifier->price = $request->input('price', null);

        $modifier->updated_by = Auth::user()->_id;
        $modifier->save();
        $request->session()->flash('status', 'Modifier ' . $modifier->name . ' Updated successfully!');
        return redirect()->action('Menu\ModifierController@getIndex');
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

        $modifier = Modifier::find($id);
        
        $modifier->status = 'disable';
        $modifier->deleted_at = Carbon::now();
        $modifier->updated_by = Auth::user()->_id;
        $modifier->save();
        $request->session()->flash('status', 'Successfully deleted the Modifier Choice!');
        return redirect()->action('Menu\ModifierController@getIndex');
    }

    public function getUpdateStatus(Request $request, $id) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('modifier_update', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */
        $modifier = Modifier::find($id);
        $modifier->updated_at = Carbon::now();
        $modifier->updated_by = Auth::user()->_id;
        $modifier->status = $modifier->status == 'enable' ? 'disable' : 'enable';
        $modifier->save();
        $request->session()->flash('status', $modifier->name . ' status changed to ' . $modifier->status . ' Successfully!');
        return redirect()->action('Menu\ModifierController@getIndex');
    }

    public function getModifierListPaging(Request $request) {

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
        $results = Modifier::ModifierList($sort_by, $sort_dir, $search, true)->paginate($limit);
        return $results;
    }

}
