<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use \App\Helpers\Helper;

class UserRoles extends Eloquent {

    //use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'roles';
    public static $permission = array('create_user' => 'Create User',
        'delete_user' => 'Delete User',
        'update_user' => 'Update User',
        'create_category' => 'Create Category',
        'delete_category' => 'Delete Category',
        'update_category' => 'Update Category',
        'create_store' => 'Create Store',
        'update_store' => 'Update Store',
        'delete_store' => 'Delete Store'
    );

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
    public static function hasAccess($permisson, $request = null, $created_by = null) {
        $return = false;
        if (env('CHECK_PERMISSIONS') === 'No') {
            return TRUE;
        }
	if(!isset(Auth::user()->permissions)){
           return false;
       }
        $user_permissions = Auth::user()->permissions;
        // code for define global access 
        if(key_exists('demon', $user_permissions) && is_array($user_permissions['demon']) && in_array('yes',$user_permissions['demon'])){
           return true;
        }
        
        
        
        // code end for property access
        $getController = false;
        if (strpos($permisson, 'view') !== false) {
            $return = (Auth::user()->user_type == 'normal') ? true : false;
            // this will redirect ion story page if permission denied for any view page for city users
            $getController = $return ? false : 'HomeController@Index';
        } elseif (!empty($user_permissions) && is_array($user_permissions)) {
            $permisson = strtolower(str_replace(' ', '_', $permisson));
            if (is_array($user_permissions) && in_array($permisson, $user_permissions)) {
                $return = true;
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
