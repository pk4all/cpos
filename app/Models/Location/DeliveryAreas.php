<?php

namespace App\Models\Location;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use \App\Helpers\Helper;

class DeliveryAreas extends Eloquent {

    protected $table = 'delivery_areas';
    
}
