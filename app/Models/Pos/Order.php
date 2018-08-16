<?php

namespace App\Models\Pos;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use \App\Helpers\Helper;
use App\Models\Menu\Menu;
use App\Models\Menu\Modifier;
use App\Models\Menu\ModifierChoice;
use App\Models\Location\Brands;
use App\Models\Menu\Category;


class Order extends Eloquent {

    protected $table = 'orders';
    
    public static function getOrdersById($id) {
        return self::where('_id', $id)->where('status', 'enable')->first();
    }

    public static function getOrderssByIds($ids) {
        return self::whereIn('_id', $ids)->where('status', 'enable')->get()->toArray();
    }
    
    public static function getOrdersByPhone($phone) {
        return self::where('phone', $phone)->where('status', 'enable')->first();
    }
    
    public static function getPosDatafromStoreId($id){
        $brands= Brands::getBrandByStoreId($id,['name','logo']);
        $category=[];
        $products=[];
        foreach($brands as $key=>$brand){
            $category[$brand['_id']][]= Category::getCategoryByBrandId($brand['_id'],['name','description','parent']);
            foreach($category[$brand['_id']] as $cat){
               $products[$cat['_id']][]= Menu::getMenuByCategoryId($cat['_id']);
            }
        }
        
        
        $return=['brands'=>$brands,'category'=>$category,'items'=>$products,'modifer'=>[]];
        return $return;
    }
}
