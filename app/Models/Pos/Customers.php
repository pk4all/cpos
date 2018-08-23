<?php

namespace App\Models\Pos;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use \App\Helpers\Helper;

class Customers extends Eloquent {

    protected $table = 'customers';
    
    public static function getCustomerById($id) {
        return self::where('_id', $id)->where('status', 'enable')->first();
    }

    public static function getCustomersByIds($ids) {
        return self::whereIn('_id', $ids)->where('status', 'enable')->get()->toArray();
    }
    
    public static function getCustomerByPhone($phone) {
        return self::where('phone', $phone)->first();
    }
    public static function getRawCustomerById($id) {
        return self::where('_id', $id)->first();
    }

}
