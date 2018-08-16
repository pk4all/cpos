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


class OrderTrack extends Eloquent {

    protected $table = 'orderTrack';
    
    public static function getOrdersTrackingById($id) {
        return array(
            ['order_id' => $id,
            'brand' => 
            ['_id' => 'abcd',
            'name' => 'Brand 1'],
            'status' => 'In Kitchen'],
            ['order_id' => $id,
            'brand' => ['_id' => 'xyzw',
            'name' => 'Brand 2'],
            'status' => 'In Kitchen']            
        );
    }

    
    
    
}
