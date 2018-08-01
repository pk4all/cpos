<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use \App\Helpers\Helper;

class DeliveryStores extends Eloquent {

    protected $table = 'delivery_stores';
    
    public static function getStoreById($id) {

        return self::where('_id', $id)->where('status', 'enable')->first();
    }

    public static function getStoresByIds($ids) {

        return self::whereIn('_id', $ids)->where('status', 'enable')->get()->toArray();
    }

}
