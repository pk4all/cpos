<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use \App\Helpers\Helper;

class Discounts extends Eloquent {

    protected $table = 'discounts';
    
    public static function getDiscountById($id) {

        return self::where('_id', $id)->where('status', 'enable')->first();
    }

    public static function getDiscountsByIds($ids) {

        return self::whereIn('_id', $ids)->where('status', 'enable')->get()->toArray();
    }

}
