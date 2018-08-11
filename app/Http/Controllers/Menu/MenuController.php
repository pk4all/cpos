<?php

namespace App\Http\Controllers\Menu;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserRoles;
use App\Models\User;
use App\Models\Menu\Menu;
use App\Models\Menu\Category;
use App\Models\Menu\ModifierChoice;
use App\Models\Menu\ModifierGroup;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;



class MenuController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public $tabList;

    function __construct() {
        $this->middleware('auth');
        $this->tabList['tab'] = Helper::$menutab;
        $this->tabList['selected'] = 'menu';
    }


    public function getIndex(Request $request) {

        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('modifier_view', $request)) !== true) {
              return redirect()->action($return);
        }
        /* end permission code */
        $results = $this->getMenuListPaging($request);
        //print_r($results); die;
        
        $total_page = Menu::getMenuCount();
        $table_header = array('Menu Name', 'PLU Code', 'Price','Choices','Image' , 'Action');
        $return = view('menu.modifier.index', ['tabList' => $this->tabList, 'count' => $total_page, 'results' => $results, 'tbl_header' => $table_header]);
        return $return;
    }

    public function Create(Request $request) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('modifier_create', $request)) !== true) {
            return redirect()->action($return);
        }
        $groups = Menu::$groups;
        $choices = Menu::$choices;
        $categories = Category::getCategoryDropDownList();
        $modifierGroups = ModifierGroup::getModifierGroupDropDownList();
        $modifiers = $subCategories = [];
        //print_r($categories); die;
        
        $view = view('menu.menu.create', [
            'tabList' => $this->tabList,
            'modifierGroups' => $modifierGroups,
            'modifiers' => $modifiers,
            'categories' => $categories,
            'subCategories' => $subCategories,
            'yesNoOptions' => array('Yes' =>'Yes', 'No' => 'No'),
            'groups' => $groups,
            'choices' =>$choices
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
        $modifier = new Menu();
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
        $dependentModifierGroupId = $request->input('dependent_modifier_group', null);
        $dependentModifierGroup = ModifierGroup::getModifierGroupByIds(array($dependentModifierGroupId), ['name']);
        
        $dependentModifierId = $request->input('dependent_modifier', null);
        $dependentModifier = Modifier::getModifierByIds(array($dependentModifierId), ['name']);
        
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
        $request->session()->flash('status', 'Menu ' . $modifier->name . ' created successfully!');
        return redirect()->action('Menu\MenuController@getIndex');
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
        $dependentModifierGroups = ModifierGroup::getModifierGroupDropDownList();
        $dependentModifiers = [];
        $modifierChoices = ModifierChoice::getModifierChoiceDropDownList();
        unset($modifierChoices[0]);
        $modifier = Menu::find($id);
        
        $selectGroupsModifiers = [];
        if(count($modifier->dependent_modifier_group) > 0){
            $depenedenGroupId = $modifier->dependent_modifier_group[0]['_id'];
            $selectGroupsDetails = ModifierGroup::getModifiersOfGroup($depenedenGroupId);
            $modifiers = $selectGroupsDetails[0]['modifiers'];
            foreach($modifiers as $m){
                $selectGroupsModifiers[$m['_id']] = $m['name'];
            }
        }

        
        if (empty($modifier)) {
            $msg_status = 'error';
            $message = "Invalid Request URL";
            $request->session()->flash($msg_status, $message);
            return redirect()->action('MenuController@getIndex');
        }
        //dd($modifier_update);
        $view = view('menu.modifier.edit', [
            'tabList' => $this->tabList, 
            'modifier_data' => $modifier,
            'dependentModifierGroups' => $dependentModifierGroups,
            'dependentModifiers' => $dependentModifiers,
            'modifierChoices' => $modifierChoices,
            'yesNoOptions' => array('Yes' =>'Yes', 'No' => 'No'),
            'selectGroupsModifiers' => $selectGroupsModifiers
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
        $modifier = Menu::find($id);
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
        $dependentModifierGroupId = $request->input('dependent_modifier_group', null);
        $dependentModifierGroup = ModifierGroup::getModifierGroupByIds([$dependentModifierGroupId], ['name']);
        
        $dependentModifierId = $request->input('dependent_modifier', null);
        $dependentModifier = Modifier::getModifierByIds([$dependentModifierId], ['name']);
        
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
        $request->session()->flash('status', 'Menu ' . $modifier->name . ' Updated successfully!');
        return redirect()->action('Menu\MenuController@getIndex');
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

        $modifier = Menu::find($id);
        
        $modifier->status = 'disable';
        $modifier->deleted_at = Carbon::now();
        $modifier->updated_by = Auth::user()->_id;
        $modifier->save();
        $request->session()->flash('status', 'Successfully deleted the Menu!');
        return redirect()->action('Menu\MenuController@getIndex');
    }

    public function getUpdateStatus(Request $request, $id) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('modifier_update', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */
        $modifier = Menu::find($id);
        $modifier->updated_at = Carbon::now();
        $modifier->updated_by = Auth::user()->_id;
        $modifier->status = $modifier->status == 'enable' ? 'disable' : 'enable';
        $modifier->save();
        $request->session()->flash('status', $modifier->name . ' status changed to ' . $modifier->status . ' Successfully!');
        return redirect()->action('Menu\MenuController@getIndex');
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
        $results = Menu::ModifierList($sort_by, $sort_dir, $search, true)->paginate($limit);
        return $results;
    }

}
