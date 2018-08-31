<?php

namespace App\Models\Location;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;
use App\Models\Location\Stores;

class OrderTypes extends Eloquent {

    protected $table = 'order_types';

    public static function getOrderTypeById($id) {

        return self::where('_id', $id)->where('status', 'enable')->first();
    }

    public static function getOrderTypesByIds($ids,$fields=[]) {

        return self::whereIn('_id', $ids)->where('status', 'enable')->get($fields)->toArray();
    }

    public static function getOrderTypeDropDownList() {

        $column = array('_id', 'name');
        $result = self::get($column);

        $store_list = NULL;
        foreach ($result as $item) {
            $store_list[$item->_id] = $item->name;
        }
        $helper = new Helper;
        $def_sel = $helper->getDefaultSel();
        $storesDropdown = (!empty($store_list)) ? array_merge($def_sel, $store_list) : $def_sel;
        return $storesDropdown;
    }
     public static function getOrderTypesByStoreId($id) {
        $column = array('_id', 'name','type');
        return self::whereraw(['store_id'=>$id])->where('status', 'enable')->get($column)->toArray();
    }
    
    public static function getOrderTypesList() {
        $column = array('_id', 'name');
        $lists=self::where('status', 'enable')->get($column)->toArray();
        if($lists){
            foreach($lists as $data){
                $arrList[$data['_id']]=$data['name'];
            }
        }else{
            $arrList=[];
        }
        return $arrList;
    }
}
