<?php

namespace App\Models\Location;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;
use App\Models\Location\Stores;

class DeliveryStores extends Eloquent {

    protected $table = 'delivery_stores';
    
	public function store()
	{
		return $this->belongsTo('App\Models\Location\Stores');
	}
	
	
    public static function getStoreById($id) {

        return self::where('_id', $id)->where('status', 'enable')->first();
    }

	
    public static function getStoresByIds($ids) {

        return self::whereIn('_id', $ids)->where('status', 'enable')->get()->toArray();
    }

}
