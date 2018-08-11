<?php

namespace App\Http\Controllers\Menu;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserRoles;
use App\Models\User;
use App\Models\Menu\Modifier;
use App\Models\Menu\ModifierGroup;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;



class ModifierGroupController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public $tabList;

    function __construct() {
        $this->middleware('auth');
        $this->tabList['tab'] = Helper::$menutab;
        $this->tabList['selected'] = 'modifier-group';
    }


    public function getIndex(Request $request) {

        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('modifier_view', $request)) !== true) {
              return redirect()->action($return);
        }
        /* end permission code */
        $results = $this->getModifierGroupListPaging($request);
        //print_r($results); die;
        
        $total_page = ModifierGroup::getModifierGroupCount();
        $table_header = array('Modifier Group Name', 'Image', 'Modifiers', 'Action');
        $return = view('menu.modifier_group.index', ['tabList' => $this->tabList, 'count' => $total_page, 'results' => $results, 'tbl_header' => $table_header]);
        return $return;
    }

    public function Create(Request $request) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('modifier_create', $request)) !== true) {
            return redirect()->action($return);
        }
        $modifiers = Modifier::getModifierDropDownList();
        unset($modifiers[0]);
        $view = view('menu.modifier_group.create', [
            'tabList' => $this->tabList,
            'modifiers' => $modifiers
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024'
        );
        //notification_email phone print_label tax_id image address  address state country zip_code radius latitude longitude 
        $this->validate($request, $rules);
        $modifierGroup = new ModifierGroup();
        $modifierGroup->name = $request->input('name', null);

        $uploaded_file = $request->file('image');
        if(!empty($uploaded_file)){
            $orgname= $uploaded_file->getClientOriginalName();
            $extension = $uploaded_file->getClientOriginalExtension();

            $name=  str_replace(".".$extension, '', $orgname);
            $imageFileName = str_slug($name) . '_' . uniqid().'.' . $extension;

            $dest = Helper::imageFileUploadPath('assets/images/',$dir_name='uploaded_image');

            $response = $uploaded_file->move($dest, $imageFileName);
            
            if($response){
                $modifierGroup->image=$imageFileName;  
            }  
        }
        $modifierGroup->description = $request->input('description', null);
        
        
        $modifiersId = $request->input('modifiers', null);
        $modifiers = Modifier::getModifierByIds(array_values($modifiersId), ['name']);

        $modifierGroup->modifiers = $modifiers;

        $modifierGroup->created_by = Auth::user()->_id;
        $modifierGroup->updated_by = Auth::user()->_id;
        $modifierGroup->status = 'disable';
        $modifierGroup->save();
        $request->session()->flash('status', 'Modifier Group' . $modifierGroup->name . ' created successfully!');
        return redirect()->action('Menu\ModifierGroupController@getIndex');
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
        
        $modifiers = Modifier::getModifierDropDownList();
        unset($modifiers[0]);
        $modifierGroup = ModifierGroup::find($id);
        
        if (empty($modifierGroup)) {
            $msg_status = 'error';
            $message = "Invalid Request URL";
            $request->session()->flash($msg_status, $message);
            return redirect()->action('ModifierGroupController@getIndex');
        }
        //dd($modifier_update);
        $view = view('menu.modifier_group.edit', [
            'tabList' => $this->tabList, 
            'modifier_group_data' => $modifierGroup,
            'modifiers' => $modifiers
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
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024'
        );
        //notification_email phone print_label tax_id image address  address state country zip_code radius latitude longitude 
        $this->validate($request, $rules);
        $modifierGroup = ModifierGroup::find($id);
        $modifierGroup->name = $request->input('name', null);

        $uploaded_file = $request->file('image');
        if(!empty($uploaded_file)){
            $orgname= $uploaded_file->getClientOriginalName();
            $extension = $uploaded_file->getClientOriginalExtension();

            $name=  str_replace(".".$extension, '', $orgname);
            $imageFileName = str_slug($name) . '_' . uniqid().'.' . $extension;

            $dest = Helper::imageFileUploadPath('assets/images/',$dir_name='uploaded_image');

            $response = $uploaded_file->move($dest, $imageFileName);
            
            if($response){
                $modifierGroup->image=$imageFileName;  
            }  
        }
        $modifierGroup->description = $request->input('description', null);
        
        
        $modifiersId = $request->input('modifiers', null);
        $modifiers = Modifier::getModifierByIds(array_values($modifiersId), ['name']);

        $modifierGroup->modifiers = $modifiers;

        $modifierGroup->updated_by = Auth::user()->_id;
        $modifierGroup->save();
        $request->session()->flash('status', 'Modifier Group ' . $modifierGroup->name . ' Updated successfully!');
        return redirect()->action('Menu\ModifierGroupController@getIndex');
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

        $modifierGroup = ModifierGroup::find($id);
        
        $modifierGroup->status = 'disable';
        $modifierGroup->deleted_at = Carbon::now();
        $modifierGroup->updated_by = Auth::user()->_id;
        $modifierGroup->save();
        $request->session()->flash('status', 'Successfully deleted the Modifier Group!');
        return redirect()->action('Menu\ModifierGroupController@getIndex');
    }

    public function getUpdateStatus(Request $request, $id) {
        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('modifier_update', $request)) !== true) {
            return redirect()->action($return);
        }
        /* end permission code */
        $modifierGroup = ModifierGroup::find($id);
        $modifierGroup->updated_at = Carbon::now();
        $modifierGroup->updated_by = Auth::user()->_id;
        $modifierGroup->status = $modifierGroup->status == 'enable' ? 'disable' : 'enable';
        $modifierGroup->save();
        $request->session()->flash('status', $modifierGroup->name . ' status changed to ' . $modifierGroup->status . ' Successfully!');
        return redirect()->action('Menu\ModifierGroupController@getIndex');
    }

    public function getModifierGroupListPaging(Request $request) {

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
        $results = ModifierGroup::ModifierGroupList($sort_by, $sort_dir, $search, true)->paginate($limit);
        return $results;
    }

    public function getGroupModifiers(Request $request, $id){
        //die($id);
        $modifiers = ModifierGroup::getModifiersOfGroup($id);
        if(isset($modifiers[0])){
            echo json_encode($modifiers[0]['modifiers']);
        }
    }

}
