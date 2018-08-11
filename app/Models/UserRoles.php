<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use \App\Helpers\Helper;

class UserRoles extends Eloquent {

    //use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'roles';
    //'company_view'=>'Company View','company_create'=>'Company Create','company_delete'=>'Compnay Delete','company_update'=>'Company update',
    public static $permission = [
    'category_view'=>'Category View',
    'category_create'=>'Category Create',
    'category_delete'=>'Category Delete',
    'category_update'=>'Category update',
    'payments_view'=>'payment View',
    'payments_create'=>'payment Create',
    'payments_delete'=>'payment Delete',
    'payments_update'=>'payment Update',
    'tax_view'=>'tax View',
    'tax_create'=>'tax Create',
    'tax_delete'=>'tax Delete',
    'tax_update'=>'tax Update',
    'users_view'=>'Users View',
    'users_create'=>'Users Create',
    'users_delete'=>'Users Delete',
    'users_update'=>'Users Update',
    'roles_view'=>'Roles View',
    'roles_create'=>'Roles Create',
    'roles_delete'=>'Roles Delete',
    'roles_update'=>'Roles Update',
    'stores_view'=>'Stores View',
    'stores_create'=>'Stores Create',
    'stores_delete'=>'Stores Delete',
    'stores_update'=>'Stores Update',
    'brands_view'=>'brands View',
    'brands_create'=>'brands Create',
    'brands_delete'=>'brands Delete',
    'brands_update'=>'brands Update',
    'surcharge_view'=>'surcharge View',
    'surcharge_create'=>'surcharge Create',
    'surcharge_delete'=>'surcharge Delete',
    'surcharge_update'=>'surcharge Update',
    'modifier_view' => 'Modifiers View',
    'modifier_create' => 'Modifiers Create',
    'modifier_update' => 'Modifiers Update',
    'modifier_cdelete' => 'Modifiers Delete',
    'menu_view' => 'Item View',
    'menu_create' => 'Item Create',
    'menu_update' => 'Item Update',
    'menu_cdelete' => 'Item Delete'
    ];

    public static function getRolesDropDownList() {

        $column = array('_id', 'role_name');
        $result = self::orderBy('role_name')->where('status', 'enable')->get($column);
        $cat = NULL;
        $cat[0] = "--select--";
        foreach ($result as $item) {
            $cat[$item->_id] = $item->role_name;
        }
        return $cat;
    }

    public static function getUserRolesCount() {
        return self::where('status', 'enable')->count();
    }

    public static function getUserRolesById($id) {

        return self::where('_id', $id)->where('status', 'enable')->first();
    }

    public static function getUserRolesByIds($ids) {

        return self::whereIn('_id', $ids)->where('status', 'enable')->get()->toArray();
    }

    public static function getUserRoleByRole($slug) {

        return self::where('role-name', $slug)->get();
    }

    public static function scopeSearch($query, $keyword) {

        $finder = $query->Where('role_name', 'LIKE', "%{$keyword}%")->where('status', 'enabled')->orderBy('_id', 'asc');

        return $finder;
    }

    public static function getUserRolesList($pageNo = 0, $count = 10, $sortOrderField = "_id", $sortDirection = 'desc', $search = array()) {

        $skip = ($pageNo - 1) * $count;
        $take = $count;
        $total = self::getUserRolesCount();
        $data = self::where('status', 'enable')->orderBy($sortOrderField, $sortDirection)->skip($skip)->take($take)->get();
        $result = array('total' => "$total", 'curPage' => "$pageNo", 'perPage' => "$count", 'data' => $data);
        return $result;
    }

    public static function scopeUserRolesList($query, $sortOrderField = "_id", $sortDirection = 'desc', $search = array(), $parent = null) {
        if (!empty($search)) {
            $query->where($search['key'], 'LIKE', "%{$search['value']}%");
        }
        $query->where('status', 'enable');
        $data = $query->orderBy($sortOrderField, $sortDirection);
        return $data;
    }

    /**
     * 
     * @param type $permisson permission need to check
     * @param type $request Http laravel request object 
     * @return boolean true if permission pass otherwise false , this method redirect if request if set
     * and permission not pass
     */
    public static function hasAccess($permisson, $request = null) {
        $return = false;
        if (env('CHECK_PERMISSIONS') === 'No') {
            return TRUE;
        }
        if (!isset(Auth::user()->permissions)) {
           abort(401);
        } 
       
        $user_permissions = Auth::user()->permissions;
            // code for define master access 
        if (key_exists('demon', $user_permissions) && $user_permissions['demon']=='yes') {
            return true;
        }

            $getController=false;
            if (!empty($user_permissions) && is_array($user_permissions)) {
                $permisson = strtolower(str_replace(' ', '_', $permisson));
                if (is_array($user_permissions) && in_array($permisson, $user_permissions)) {
                    $return = true;
                }else if(strpos($permisson,'view')!==false || strpos($permisson,'demon')!==false){
                    $getController='HomeController@getIndex';
                }
            }
      
        /* redirect on current controller view page if $request(this is request object of laravel) is set 
          other wise return status(true or false) of permossions */
        if ($return === false && $request) {
            $request->session()->flash('error', 'Permisson Denied');
            if (!$getController) {
                return Helper::getCurrentController();
            } else {
                return $getController;
            }
        } else {
            return $return;
        }
    }

}
