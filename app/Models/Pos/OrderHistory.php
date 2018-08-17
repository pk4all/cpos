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
use App\Models\Pos\OrderTrack;


class OrderHistory extends Eloquent {

    protected $table = 'orderHistories';
    
    public static function getOrdersHistory() {
        //return self::where('_id', $id)->where('status', 'enable')->first();
        $itemData = array();
        $item1 = Menu::getMenuById('5b75988b71add856b95fefe4');
        $item1 = $item2 = $item1[0]->attributes;
        $item1['Brand'] = [
            '_id' => 'abcd',
            'name' => 'Brand 1'
        ];
        $item1['name'] = 'ITEM 1';
        $item2['Brand'] = [
            '_id' => 'xyzw',
            'name' => 'Brand 2'
        ];
        array_push($itemData, $item1, $item2);
        //dd($itemData);

        $orderData1 = array(
            'order_id' => '123456768',
            'order_status' => 'In Kitchen',
            'customer' => [
                '_id' => 'erttertretretert',
                'name' => 'TEST'
            ],
            'store' => [
                '_id' => 'erttertretretert',
                'name' => 'TEST'
            ],
            'products' => $itemData,
            'orderTracking' => OrderTrack::getOrdersTrackingById('123456768')
        );

        $orderData2 = array(
            'order_id' => '23451234',
            'order_status' => 'In Kitchen',
            'customer' => [
                '_id' => 'erttertretretert',
                'name' => 'TEST'
            ],
            'store' => [
                '_id' => 'erttertretretert',
                'name' => 'TEST'
            ],
            'products' => $itemData,
            'orderTracking' => OrderTrack::getOrdersTrackingById('23451234')
        );

        $orderData3 = array(
            'order_id' => '456789',
            'order_status' => 'In Kitchen',
            'customer' => [
                '_id' => 'erttertretretert',
                'name' => 'TEST'
            ],
            'store' => [
                '_id' => 'erttertretretert',
                'name' => 'TEST'
            ],
            'products' => $itemData,
            'orderTracking' => OrderTrack::getOrdersTrackingById('456789')
        );
        //dd($orderData1);
        return array($orderData1, $orderData2, $orderData3);
        
    }

    
    
    
}
