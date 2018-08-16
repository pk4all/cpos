<?php

namespace App\Models\Menu;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use \App\Helpers\Helper;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;


class Menu extends Eloquent {

    //use \Venturecraft\Revisionable\RevisionableTrait;
    use SoftDeletes;

    protected $table = 'menu';
    public static $groups = ['Protein'=>'Protein','Vegan'=>'Vegan', 'Hot' =>'Hot', 'Gluten-Free' =>'Gluten Free'];
    public static $choices = ['Single' => 'Single', 'Multiple' => 'Multiple'];
    public static $taxType = ['Inclusive'=>'Inclusive','Exclusive'=>'Exclusive', 'None' => 'None'];


    public static function getMenuCount() {
        return self::where('status', 'enable')->count();
    }

    public static function getMenuById($id) {

        return self::where('_id', $id)->where('status', 'enable')->get();
    }

    public static function getMenuByIds($ids, $fields=[]) {

        return self::whereIn('_id', $ids)->where('status', 'enable')->get($fields)->toArray();
    }

    public static function scopeSearch($query, $keyword) {

        $finder = $query->Where('name', 'LIKE', "%{$keyword}%")->where('status', 'enabled')->orderBy('_id', 'asc');

        return $finder;
    }

    public static function getMenuList($pageNo = 0, $count = 10, $sortOrderField = "_id", $sortDirection = 'desc', $search = array()) {
        //die('gggg');
        $skip = ($pageNo - 1) * $count;
        $take = $count;
        $total = self::getMenuCount();
        $data = self::orderBy($sortOrderField, $sortDirection)->skip($skip)->take($take)->get();
        $result = array('total' => "$total", 'curPage' => "$pageNo", 'perPage' => "$count", 'data' => $data);
        return $result;
    }

    public static function scopeMenuList($query, $sortOrderField = "_id", $sortDirection = 'desc', $search = array(), $parent = null) {
        if (!empty($search)) {
            $query->where($search['key'], 'LIKE', "%{$search['value']}%");
        }
        //$query->where('status', 'enable');
        $data = $query->orderBy($sortOrderField, $sortDirection);
        return $data;
    }
    /*  this function return the store list */
    public static function getMenuDropDownList($options= array()) {
        print_r($options); die;

        $column = array('_id', 'name');
        //$result = self::where('status', 'enable')->get($column);

        $query = self::where('status', 'enable');
        if(isset($options['in_id'])){
            $query = $query->where_in('_id', $options['in_id']);
        }
        $result = $query->get($column);
        
        $menu_list = NULL;
        foreach ($result as $item) {
            $menu_list[$item->_id] = $item->name;
        }
        $helper = new Helper;
        $def_sel = $helper->getDefaultSel();
        $menuDropdown = (!empty($menu_list)) ? array_merge($def_sel, $menu_list) : $def_sel;
        return $menuDropdown;
    }
    
     public static function getMenuByCategoryId($id,$fields=[]) {
        
        return self::where('status', 'enable')->whereraw(['category._id'=>$id])->get($fields)->toArray();
    }
    
}
