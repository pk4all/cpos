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
            $tmpCat=Category::getCategoryByBrandId($brand['_id'],['name','description','parent']);
            $category[$brand['_id']]= $tmpCat;
            foreach($tmpCat as $cat){
               $tmpproduct= Menu::getMenuByCategoryId($cat['_id']);
              if(!empty($tmpproduct)){
                $products[$cat['_id']]= $tmpproduct;
              }
            }
        }

        $return=['brands'=>$brands,'category'=>$category,'items'=>$products,'modifer'=>[]];
        return $return;
    }
    
     public static function getOrdersfromStoreId($id){
       $ord_sataus=['In Kitchen','Ready'];
       $return=self::whereIn('order_status', $ord_sataus)->where('store_id', $id)->get()->toArray();
        return $return;
    }
}
