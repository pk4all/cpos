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

	
    public static function getOrderTypesByIds($ids) {

        return self::whereIn('_id', $ids)->where('status', 'enable')->get()->toArray();
    }

}
