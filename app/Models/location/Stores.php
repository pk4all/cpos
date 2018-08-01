<?php

namespace App\Models\location;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use \App\Helpers\Helper;

class Stores extends Eloquent {

    //use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'stores';
   
    public static function getCompanyCount() {
        return self::where('status', 'enable')->count();
    }

    public static function getCompanyById($id) {

        return self::where('_id', $id)->where('status', 'enable')->get();
    }

    public static function getCompanyByIds($ids) {

        return self::whereIn('_id', $ids)->where('status', 'enable')->get()->toArray();
    }

    public static function scopeSearch($query, $keyword) {

        $finder = $query->Where('name', 'LIKE', "%{$keyword}%")->where('status', 'enabled')->orderBy('_id', 'asc');

        return $finder;
    }

    public static function getCompanyList($pageNo = 0, $count = 10, $sortOrderField = "_id", $sortDirection = 'desc', $search = array()) {

        $skip = ($pageNo - 1) * $count;
        $take = $count;
        $total = self::getCompanyCount();
        $data = self::where('status', 'enable')->orderBy($sortOrderField, $sortDirection)->skip($skip)->take($take)->get();
        $result = array('total' => "$total", 'curPage' => "$pageNo", 'perPage' => "$count", 'data' => $data);
        return $result;
    }

    public static function scopeCompanyList($query, $sortOrderField = "_id", $sortDirection = 'desc', $search = array(), $parent = null) {
        if (!empty($search)) {
            $query->where($search['key'], 'LIKE', "%{$search['value']}%");
        }
        $query->where('status', 'enable');
        $data = $query->orderBy($sortOrderField, $sortDirection);
        return $data;
    }

}
