<?php

namespace App\Http\Controllers\Menu;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserRoles;
use App\Models\User;
use App\Models\Menu\Menu;
use App\Models\Menu\Category;
use App\Models\Menu\Modifier;
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
        $this->tabList['selected'] = 'item';
    }


    public function getIndex(Request $request) {

        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('menu_view', $request)) !== true) {
              return redirect()->action($return);
        }
        /* end permission code */
        $results = $this->getMenuListPaging($request);
        //print_r($results); die;
        
        $total_page = Menu::getMenuCount();
        $table_header = array('Menu Name', 'Category', 'PLU Code', 'Price', 'Image', 'Action');
        $return = view('menu.menu.index', ['tabList' => $this->tabList, 'count' => $total_page, 'results' => $results, 'tbl_header' => $table_header]);
        return $return;
    }

    public function Create(Request $request) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('modifier_create', $request)) !== true) {
            return redirect()->action($return);
        }
        $groups = Menu::$groups;
        $choices = Menu::$choices;
        $taxType = Menu::$taxType;
        $categories = Category::getCategoryDropDownList();
        $modifierGroups = ModifierGroup::getModifierGroupDropDownList();
        unset($modifierGroups[0]);
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
            'choices' =>$choices,
            'taxType' => $taxType
        ]);
        return $view;
    }

    public function postStore(Request $request) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('menu_create', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */
        $rules = array(
            'category' => 'required',
            'name' => 'required',
            'plu_code' => 'required |unique:menus',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'price' => 'required'
        );
        //notification_email phone print_label tax_id image address  address state country zip_code radius latitude longitude 
        $this->validate($request, $rules);
        $menu = new Menu();

        $uploaded_file = $request->file('image');
        if(!empty($uploaded_file)){
            $orgname= $uploaded_file->getClientOriginalName();
            $extension = $uploaded_file->getClientOriginalExtension();

            $name=  str_replace(".".$extension, '', $orgname);
            $imageFileName = str_slug($name) . '_' . uniqid().'.' . $extension;

            $dest = Helper::imageFileUploadPath('assets/images/',$dir_name='uploaded_image');

            $response = $uploaded_file->move($dest, $imageFileName);
            
            if($response){
                $menu->image=$imageFileName;  
            }  
        }

        $uploaded_file = $request->file('thumb_image');
        if(!empty($uploaded_file)){
            $orgname= $uploaded_file->getClientOriginalName();
            $extension = $uploaded_file->getClientOriginalExtension();

            $name=  str_replace(".".$extension, '', $orgname);
            $imageFileName = str_slug($name) . '_' . uniqid().'.' . $extension;

            $dest = Helper::imageFileUploadPath('assets/images/',$dir_name='uploaded_image');

            $response = $uploaded_file->move($dest, $imageFileName);
            
            if($response){
                $menu->thumb_image=$imageFileName;  
            }  
        }

        $menu->name = $request->input('name', null);
        $menu->plu_code = $request->input('plu_code', null);
        $menu->price_title = $request->input('price_title', null);
        $menu->price = $request->input('price', null);
        $menu->tax = $request->input('tax', null);
        $menu->groups = $request->input('groups', null);
        $menu->seo_title = $request->input('seo_title', null);
        $menu->short_description = $request->input('short_description', null);

        $categoryId = $request->input('category', null);
        $category = Category::getCategoryByIds(array($categoryId), ['name']);
        $menu->category = $category;

        $subCategoryId = $request->input('sub_category', null);
        $subCategory = Category::getCategoryByIds(array($subCategoryId), ['name']);
        $menu->sub_category = $subCategory;

        $includedModifierGroupsId = $request->input('included_modifier_groups', null);
        $includedModifierGroups = ModifierGroup::getModifierGroupByIds(array_values($includedModifierGroupsId), ['name']);
        $menu->included_modifier_groups = $includedModifierGroups;  

        $includedModifiersId = $request->input('included_modifiers', null);
        $includedModifiersId = is_array($includedModifiersId)? $includedModifiersId : array(0);
           
        $includedModifiers = Modifier::getModifierByIds(array_values($includedModifiersId), ['name']);
        $menu->included_modifiers = $includedModifiers;  

        $modifierGroupsId = $request->input('modifier_groups', null);
        $modifierGroups = ModifierGroup::getModifierGroupByIds(array_values($modifierGroupsId), ['name']);
        $menu->modifier_groups = $modifierGroups;  
        
        $modifiersId = $request->input('modifiers', null);
        $modifiersId = is_array($modifiersId)? $modifiersId : array(0);
        $modifiers = Modifier::getModifierByIds(array_values($modifiersId), ['name']);
        $menu->modifiers = $modifiers;

        //print_r($modifiers); die;
        $menu->modifiers = $modifiers;

        $menu->created_by = Auth::user()->_id;
        $menu->updated_by = Auth::user()->_id;
        $menu->status = 'disable';
        $menu->save();
        $request->session()->flash('status', 'Menu ' . $menu->name . ' created successfully!');
        return redirect()->action('Menu\MenuController@getIndex');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function getEdit(Request $request, $id) {
        //echo "<pre>";
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('menu_update', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */
        $groups = Menu::$groups;
        $choices = Menu::$choices;
        $taxType = Menu::$taxType;
        $categories = Category::getCategoryDropDownList();
        $modifierGroups = ModifierGroup::getModifierGroupDropDownList();
        $modifiers = $subCategories = [];

        $menu = Menu::find($id);
        //print_r($menu);

        $categoryId = $menu->category[0]['_id'];
        $subCategoriesOfselectcategory = [];
        if($categoryId){
            $options = array('parentId' => $categoryId);
            $subCategoriesOfselectcategory = Category::getCategoryDropDownList($options);
        }
        
        $includedModifiers = [];
        if(count($menu->included_modifier_groups)>0){
            foreach($menu->included_modifier_groups as $group){
                $modifierGroupId = $group['_id'];
                $modifiersOfGroup = ModifierGroup::getModifiersOfGroup($modifierGroupId);
                $includedModifiers = array_merge($includedModifiers, $modifiersOfGroup[0]['modifiers']);
            }
            $includedModifiersId = array_column($includedModifiers, '_id');
            if(count($includedModifiersId)>0){
                $options = array('in_id' => $includedModifiersId);
                $includedModifiers = Modifier::getModifierDropDownList($options);
            }
        }

        $groupModifiers = [];
        if(count($menu->modifier_groups)>0){
            foreach($menu->modifier_groups as $group){
                $modifierGroupId = $group['_id'];
                $modifiersOfGroup = ModifierGroup::getModifiersOfGroup($modifierGroupId);
                $groupModifiers = array_merge($groupModifiers, $modifiersOfGroup[0]['modifiers']);
            }
            $groupModifiersId = array_column($groupModifiers, '_id');
            if(count($groupModifiersId)>0){
                $options = array('in_id' => $groupModifiersId);
                $groupModifiers = Modifier::getModifierDropDownList($options);
            }

        }
                
        if (empty($menu)) {
            $msg_status = 'error';
            $message = "Invalid Request URL";
            $request->session()->flash($msg_status, $message);
            return redirect()->action('MenuController@getIndex');
        }
       // print_r($menu);
        //dd(array_column($menu->category,'_id'));
        $view = view('menu.menu.edit', [
            'tabList' => $this->tabList, 
            'menu_data' => $menu,
            'modifierGroups' => $modifierGroups,
            'includedModifiers' => $includedModifiers,
            'groupModifiers' => $groupModifiers,
            'categories' => $categories,
            'subCategories' => $subCategoriesOfselectcategory,
            'yesNoOptions' => array('Yes' =>'Yes', 'No' => 'No'),
            'groups' => $groups,
            'choices' =>$choices,
            'taxType' => $taxType
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
        if (($return = UserRoles::hasAccess('menu_update', $request)) !== true) {
            return redirect()->action($return);
        }

        $rules = array(
            'name' => 'required',
            'plu_code' => 'required |unique:menu,id,' . $id,
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024'
        );

        //notification_email phone print_label tax_id image address  address state country zip_code radius latitude longitude 
        $this->validate($request, $rules);
        $menu = Menu::find($id);
        //dd($rules);
        $uploaded_file = $request->file('image');
        if(!empty($uploaded_file)){
            $orgname= $uploaded_file->getClientOriginalName();
            $extension = $uploaded_file->getClientOriginalExtension();

            $name=  str_replace(".".$extension, '', $orgname);
            $imageFileName = str_slug($name) . '_' . uniqid().'.' . $extension;

            $dest = Helper::imageFileUploadPath('assets/images/',$dir_name='uploaded_image');

            $response = $uploaded_file->move($dest, $imageFileName);
            
            if($response){
                $menu->image=$imageFileName;  
            }  
        }

        $uploaded_file = $request->file('thumb_image');
        if(!empty($uploaded_file)){
            $orgname= $uploaded_file->getClientOriginalName();
            $extension = $uploaded_file->getClientOriginalExtension();

            $name=  str_replace(".".$extension, '', $orgname);
            $imageFileName = str_slug($name) . '_' . uniqid().'.' . $extension;

            $dest = Helper::imageFileUploadPath('assets/images/',$dir_name='uploaded_image');

            $response = $uploaded_file->move($dest, $imageFileName);
            
            if($response){
                $menu->thumb_image=$imageFileName;  
            }  
        }

        $menu->name = $request->input('name', null);
        $menu->plu_code = $request->input('plu_code', null);
        $menu->price_title = $request->input('price_title', null);
        $menu->price = $request->input('price', null);
        $menu->tax = $request->input('tax', null);
        $menu->groups = $request->input('groups', null);
        $menu->seo_title = $request->input('seo_title', null);
        $menu->short_description = $request->input('short_description', null);

        $categoryId = $request->input('category', null);
        $category = Category::getCategoryByIds(array($categoryId), ['name']);
        $menu->category = $category;

        $subCategoryId = $request->input('sub_category', null);
        $subCategory = Category::getCategoryByIds(array($subCategoryId), ['name']);
        $menu->sub_category = $subCategory;

        $includedModifierGroupsId = $request->input('included_modifier_groups', null);
        $includedModifierGroups = ModifierGroup::getModifierGroupByIds(array_values($includedModifierGroupsId), ['name']);
        
        //LOGIC TO MAINTAIN THE SORT ORDER OF OLD GOUPS
        $oldModifiers = $menu->included_modifier_groups;
        $oldModifiersOrder = array_column($oldModifiers, '_id');  
        $orderedExistingGroups = [];
        foreach($oldModifiersOrder as $groupId){
            foreach($includedModifierGroups as $index => $includedGroup){
                if($groupId == $includedGroup['_id']){
                    array_push($orderedExistingGroups, $includedGroup);
                    unset($includedModifierGroups[$index]);
                }

            }
        }
        $orderedGroups = array_merge($orderedExistingGroups, $includedModifierGroups);
        //LOGIC TO MAINTAIN THE SORT ORDER OF OLD GOUPS

        $menu->included_modifier_groups = $orderedGroups;  

        $includedModifiersId = $request->input('included_modifiers', null);
        $includedModifiersId = is_array($includedModifiersId)? $includedModifiersId : array(0);
          
        $includedModifiers = Modifier::getModifierByIds(array_values($includedModifiersId), ['name']);
        $menu->included_modifiers = $includedModifiers;  

        $modifierGroupsId = $request->input('modifier_groups', null);
        $modifierGroups = ModifierGroup::getModifierGroupByIds(array_values($modifierGroupsId), ['name']);
        $menu->modifier_groups = $modifierGroups;  
        
        $modifiersId = $request->input('modifiers', null);
        $modifiersId = is_array($modifiersId)? $modifiersId : array(0);
        $modifiers = Modifier::getModifierByIds(array_values($modifiersId), ['name']);
        $menu->modifiers = $modifiers;

        //print_r($modifiers); die;
        $menu->modifiers = $modifiers;

        $menu->updated_by = Auth::user()->_id;
        $menu->save();
        $request->session()->flash('status', 'Menu ' . $menu->name . ' Updated successfully!');
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
        if (($return = UserRoles::hasAccess('menu_delete', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */

        $menu = Menu::find($id);
        
        $menu->status = 'disable';
        $menu->deleted_at = Carbon::now();
        $menu->updated_by = Auth::user()->_id;
        $menu->save();
        $request->session()->flash('status', 'Successfully deleted the Menu!');
        return redirect()->action('Menu\MenuController@getIndex');
    }

    public function getUpdateStatus(Request $request, $id) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('menu_update', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */
        $menu = Menu::find($id);
        $menu->updated_at = Carbon::now();
        $menu->updated_by = Auth::user()->_id;
        $menu->status = $menu->status == 'enable' ? 'disable' : 'enable';
        $menu->save();
        $request->session()->flash('status', $menu->name . ' status changed to ' . $menu->status . ' Successfully!');
        return redirect()->action('Menu\MenuController@getIndex');
    }

    public function getMenuListPaging(Request $request) {

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
        $results = Menu::MenuList($sort_by, $sort_dir, $search, true)->paginate($limit);
        return $results;
    }

    public function getSortOrder(Request $request, $id) {
        //echo "<pre>";
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('menu_update', $request)) !== true) {
            return redirect()->action($return);
        }

        $menu = Menu::find($id);
        if (empty($menu)) {
            $msg_status = 'error';
            $message = "Invalid Request URL";
            $request->session()->flash($msg_status, $message);
            return redirect()->action('MenuController@getIndex');
        }
        $view = view('menu.menu.sort', [
            'tabList' => $this->tabList, 
            'data' => $menu
        ]);
        return $view;
    }
    
    
    public function postSortOrder(Request $request, $id) {
        if (($return = UserRoles::hasAccess('menu_update', $request)) !== true) {
            return redirect()->action($return);
        }
        $menu = Menu::find($id);
        $groupsInNewOrder = array();
        $groupIds = $request->input('newOrder');
        if(is_array($groupIds)){
            foreach($groupIds as $groupId){
                foreach($menu->included_modifier_groups as $modfierGroup){
                    if($groupId == $modfierGroup['_id']){
                        array_push($groupsInNewOrder, $modfierGroup);
                    }
                }
            }
        }
        $menu->included_modifier_groups = $groupsInNewOrder;
        $menu->updated_by = Auth::user()->_id;
        $menu->save();
        echo json_encode(array(
            'status' => 'success',
            'message' => 'Sorting order has been updated.'
        ));
    }


}
