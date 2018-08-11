<?php

namespace App\Models\Location;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use \App\Helpers\Helper;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;


class Tax extends Eloquent {

    //use \Venturecraft\Revisionable\RevisionableTrait;
    use SoftDeletes;

    protected $table = 'taxes';
    public static $type=['Inclusive'=>'Inclusive','Exclusive'=>'Exclusive', 'None' => 'None'];

    


    public static function getTaxCount() {
        return self::where('status', 'enable')->count();
    }

    public static function getTaxById($id) {

        return self::where('_id', $id)->where('status', 'enable')->get();
    }

    public static function getTaxByIds($ids) {

        return self::whereIn('_id', $ids)->where('status', 'enable')->get()->toArray();
    }

    public static function scopeSearch($query, $keyword) {

        $finder = $query->Where('name', 'LIKE', "%{$keyword}%")->where('status', 'enabled')->orderBy('_id', 'asc');

        return $finder;
    }

    public static function getTaxList($pageNo = 0, $count = 10, $sortOrderField = "_id", $sortDirection = 'desc', $search = array()) {

        $skip = ($pageNo - 1) * $count;
        $take = $count;
        $total = self::getTaxCount();
        $data = self::orderBy($sortOrderField, $sortDirection)->skip($skip)->take($take)->get();
        $result = array('total' => "$total", 'curPage' => "$pageNo", 'perPage' => "$count", 'data' => $data);
        return $result;
    }

    public static function scopeTaxList($query, $sortOrderField = "_id", $sortDirection = 'desc', $search = array(), $parent = null) {
        if (!empty($search)) {
            $query->where($search['key'], 'LIKE', "%{$search['value']}%");
        }
        //$query->where('status', 'enable');
        $data = $query->orderBy($sortOrderField, $sortDirection);
        return $data;
    }
}
