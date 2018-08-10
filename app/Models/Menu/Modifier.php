<?php

namespace App\Models\Menu;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use \App\Helpers\Helper;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;


class Modifier extends Eloquent {

    //use \Venturecraft\Revisionable\RevisionableTrait;
    use SoftDeletes;

    protected $table = 'modifiers';
    public static $type=['Card'=>'Card','Cash'=>'Cash'];
    
    public static function getModifierCount() {
        return self::where('status', 'enable')->count();
    }

    public static function getModifierById($id) {

        return self::where('_id', $id)->where('status', 'enable')->get();
    }

    public static function getModifierByIds($ids, $fields=[]) {

        return self::whereIn('_id', $ids)->where('status', 'enable')->get($fields)->toArray();
    }

    public static function scopeSearch($query, $keyword) {

        $finder = $query->Where('name', 'LIKE', "%{$keyword}%")->where('status', 'enabled')->orderBy('_id', 'asc');

        return $finder;
    }

    public static function getModifierList($pageNo = 0, $count = 10, $sortOrderField = "_id", $sortDirection = 'desc', $search = array()) {
        //die('gggg');
        $skip = ($pageNo - 1) * $count;
        $take = $count;
        $total = self::getModifierCount();
        $data = self::orderBy($sortOrderField, $sortDirection)->skip($skip)->take($take)->get();
        $result = array('total' => "$total", 'curPage' => "$pageNo", 'perPage' => "$count", 'data' => $data);
        return $result;
    }

    public static function scopeModifierList($query, $sortOrderField = "_id", $sortDirection = 'desc', $search = array(), $parent = null) {
        if (!empty($search)) {
            $query->where($search['key'], 'LIKE', "%{$search['value']}%");
        }
        //$query->where('status', 'enable');
        $data = $query->orderBy($sortOrderField, $sortDirection);
        return $data;
    }
    /*  this function return the store list */
    public static function getModifierDropDownList() {

        $column = array('_id', 'name');
        $result = self::where('status', 'enable')->get($column);
        
        $choice_list = NULL;
        foreach ($result as $item) {
            $choice_list[$item->_id] = $item->name;
        }
        $helper = new Helper;
        $def_sel = $helper->getDefaultSel();
        $modifierChoiceDropdown = (!empty($choice_list)) ? array_merge($def_sel, $choice_list) : $def_sel;
        return $modifierChoiceDropdown;
    }
}
