<?php

namespace App\Models\Location;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use \App\Helpers\Helper;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;


class Brands extends Eloquent {

    //use \Venturecraft\Revisionable\RevisionableTrait;
    use SoftDeletes;

    protected $table = 'brands';
    
    public static function getBrandsCount() {
        return self::where('status', 'enable')->count();
    }

    public static function getBrandsById($id) {

        return self::where('_id', $id)->where('status', 'enable')->get();
    }

    public static function getBrandsByIds($ids, $fields=[]) {

        return self::whereIn('_id', $ids)->where('status', 'enable')->get($fields)->toArray();
    }

    public static function scopeSearch($query, $keyword) {

        $finder = $query->Where('name', 'LIKE', "%{$keyword}%")->where('status', 'enabled')->orderBy('_id', 'asc');

        return $finder;
    }

    public static function getBrandsList($pageNo = 0, $count = 10, $sortOrderField = "_id", $sortDirection = 'desc', $search = array()) {

        $skip = ($pageNo - 1) * $count;
        $take = $count;
        $total = self::getBrandsCount();
        $data = self::orderBy($sortOrderField, $sortDirection)->skip($skip)->take($take)->get();
        $result = array('total' => "$total", 'curPage' => "$pageNo", 'perPage' => "$count", 'data' => $data);
        return $result;
    }

    public static function scopeBrandsList($query, $sortOrderField = "_id", $sortDirection = 'desc', $search = array(), $parent = null) {
        if (!empty($search)) {
            $query->where($search['key'], 'LIKE', "%{$search['value']}%");
        }
        //$query->where('status', 'enable');
        $data = $query->orderBy($sortOrderField, $sortDirection);
        return $data;
    }

    public static function getBrandByStoreId($id,$fields=['name']) {
        
        return self::where('status', 'enable')->whereraw(['stores._id'=>$id])->get($fields)->toArray();
    }
    public static function getBrandDropDownList($options= array()) {

        $column = array('_id', 'name');
        $query = self::where('status', 'enable');
        if(isset($options['parentId'])){
            $query = $query->whereraw(array('parent._id'=>$options['parentId']));
        }
        $result = $query->get($column);
        
        $list = NULL;
        foreach ($result as $item) {
            $list[$item->_id] = $item->name;
        }
        $helper = new Helper;
        $def_sel = $helper->getDefaultSel();
        $brandDropdown = (!empty($list)) ? array_merge($def_sel, $list) : $def_sel;
        return $brandDropdown;
    }
	
	

}
