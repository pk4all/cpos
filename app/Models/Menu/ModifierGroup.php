<?php

namespace App\Models\Menu;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use \App\Helpers\Helper;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;


class ModifierGroup extends Eloquent {

    //use \Venturecraft\Revisionable\RevisionableTrait;
    use SoftDeletes;

    protected $table = 'modifier_groups';
    public static $type=['Card'=>'Card','Cash'=>'Cash'];
    
    public static function getModifierGroupCount() {
        return self::where('status', 'enable')->count();
    }

    public static function getModifierGroupById($id) {

        return self::where('_id', $id)->where('status', 'enable')->get();
    }

    public static function getModifierGroupByIds($ids) {

        return self::whereIn('_id', $ids)->where('status', 'enable')->get()->toArray();
    }

    public static function scopeSearch($query, $keyword) {

        $finder = $query->Where('name', 'LIKE', "%{$keyword}%")->where('status', 'enabled')->orderBy('_id', 'asc');

        return $finder;
    }

    public static function getModifierGroupList($pageNo = 0, $count = 10, $sortOrderField = "_id", $sortDirection = 'desc', $search = array()) {
        //die('gggg');
        $skip = ($pageNo - 1) * $count;
        $take = $count;
        $total = self::getModifierGroupCount();
        $data = self::orderBy($sortOrderField, $sortDirection)->skip($skip)->take($take)->get();
        $result = array('total' => "$total", 'curPage' => "$pageNo", 'perPage' => "$count", 'data' => $data);
        return $result;
    }

    public static function scopeModifierGroupList($query, $sortOrderField = "_id", $sortDirection = 'desc', $search = array(), $parent = null) {
        if (!empty($search)) {
            $query->where($search['key'], 'LIKE', "%{$search['value']}%");
        }
        //$query->where('status', 'enable');
        $data = $query->orderBy($sortOrderField, $sortDirection);
        return $data;
    }

    /*  this function return the store list */
    public static function getModifierGroupDropDownList() {

        $column = array('_id', 'name');
        $result = self::where('status', 'enable')->get($column);
        
        $choice_list = NULL;
        foreach ($result as $item) {
            $choice_list[$item->_id] = $item->name;
        }
        $helper = new Helper;
        $def_sel = $helper->getDefaultSel();
        $modifierGroupDropdown = (!empty($choice_list)) ? array_merge($def_sel, $choice_list) : $def_sel;
        return $modifierGroupDropdown;
    }
}
