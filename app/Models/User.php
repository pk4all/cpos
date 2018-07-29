<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Eloquent implements
AuthenticatableContract, AuthorizableContract, CanResetPasswordContract {

    use Authenticatable,
        Authorizable,
        CanResetPassword;

    //use \Venturecraft\Revisionable\RevisionableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    protected $connection = 'mongodb';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //protected $hidden = ['password', 'remember_token'];
    public static $user_status = array('enable' => 'Active', 'disable' => 'Blocked');

    public function scopeManagerName() {
        return $this->hasOne(self::class, '_id', 'manager_id')->select('first_name', 'last_name');
    }

//    public function setConnection($conn){
//        if($conn)
//            $this->connection=$conn;
//    }

    public static function getUserDropDownList($options = []) {

        $column = array('_id', 'first_name', 'last_name');
        $result = User::where('status', 'enable')->orderBy('first_name')->get($column);
        $cat = NULL;
        $cat[0] = "--select--";
        foreach ($result as $item) {
            $cat[$item->_id] = $item->first_name . "  " . $item->last_name;
        }
        return $cat;
    }

    public static function scopeSearch($query, $keyword, $options = []) {

        $finder = $query->Where('first_name', 'LIKE', "%{$keyword}%")->orderBy('_id', 'asc');

        return $finder;
    }

    public static function getUserList($pageNo = 0, $count = 10, $sortOrderField = "_id", $sortDirection = 'desc', $search = array(), $options = []) {

        $skip = ($pageNo - 1) * $count;
        $take = $count;
        $total = self::getUserCount($options);
        $data = self::orderBy($sortOrderField, $sortDirection)->skip($skip)->take($take)->get();
        $result = array('total' => "$total", 'curPage' => "$pageNo", 'perPage' => "$count", 'data' => $data);
        return $result;
    }

    public static function scopeUserList($query, $sortOrderField = "_id", $sortDirection = 'desc', $search = array(), $parent = null, $options = []) {
        if (!empty($search)) {
            $query->where($search['key'], 'LIKE', "%{$search['value']}%");
        }

        if (!empty($parent)) {
            $query->with('managerName');
        }
        //$query->where('status', 'enable');
        $data = $query->where('status', 'enable')->orderBy($sortOrderField, $sortDirection);
        //$result = array('total'=>"$total",'curPage'=>"$pageNo",'perPage'=>"$count", 'data'=>$data);
        return $data;
    }

    public static function getUserCount($options = []) {
        return self::count();
    }

    public static function getUserCountByCondition($param = []) {
        //added raw query to get count cuase eloquent count hang for large query
        $count = User::raw(function($collection) use ($param) {
                    return $collection->find($param)->count();
                });
        return $count;
    }

    public static function getUserById($id, $is_object = false, $options = []) {
        $result = array();
        $memcache = getMemcacheKey(func_get_args(), __METHOD__, true);
        if (!$is_object && isset($memcache['data']) && !empty($memcache['data'])) {
            return $memcache['data'];
        }

        $result = self::where('_id', $id)->first();


        if (!$is_object && isset($memcache['key']) && !empty($result)) {
            if (is_object($result)) {
                $result = $result->toArray();
            }
            putDataMemcached($memcache['key'], $result);
        }
        return $result;
    }

    public static function getUserBySlug($slug, $is_object = false, $options = []) {
        $result = array();
        $memcache = getMemcacheKey(func_get_args(), __METHOD__, true);
        if (!$is_object && isset($memcache['data']) && !empty($memcache['data'])) {
            return $memcache['data'];
        }
        $result = self::where('slug', $slug)->first();
        if (!$is_object && isset($memcache['key']) && !empty($result)) {
            if (is_object($result)) {
                $result = $result->toArray();
            }
            putDataMemcached($memcache['key'], $result);
        }
        return $result;
    }

    public static function getUserListByUser($user_id) {

        return self::where('created_by', $user_id)->get();
    }

    //write raw queries
    public static function getCustomQueryResult($param = array()) {

        $models = User::raw(function($collection) {
                    if (empty($param)) {
                        $regex = new \MongoRegex('/Gur/');
                        $param = array('title' => $regex); //get all category having title like Gur%
                    }
                    return $collection->find($param)->limit(2);
                });
        return $models;
    }

    public static function getUserByIds($ids) {
        $result = array();
        $memcache = getMemcacheKey(func_get_args(), __METHOD__, true);
        if (isset($memcache['data']) && !empty($memcache['data'])) {
            return $memcache['data'];
        }

        if (is_array($ids) && count($ids) <= 0) {
            return FALSE;
        }
        $result = self::whereIn('_id', $ids)->get();
        if (is_object($result)) {
            $result = $result->toArray();
        }
        if (isset($memcache['key']) && !empty($result)) {
            putDataMemcached($memcache['key'], $result, 24 * 60);
        }
        return Helper::validateResult($result);
    }

    public static function getUserByEmail($email, $is_object = false) {
        $result = array();
        $memcache = getMemcacheKey(func_get_args(), __METHOD__, true);
        if (!$is_object && isset($memcache['data']) && !empty($memcache['data'])) {
            return $memcache['data'];
        }

        $result = self::where('email', $email)->where('status', 'enable')->first();


        if (!$is_object && isset($memcache['key']) && !empty($result)) {
            if (is_object($result)) {
                $result = $result->toArray();
            }
            putDataMemcached($memcache['key'], $result);
        }
        return $result;
    }

}
