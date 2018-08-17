<?php

namespace App\Http\Controllers\Pos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserRoles;
use App\Models\User;
use App\Models\Menu\Menu;
use App\Models\Menu\Category;
use App\Models\Menu\Modifier;
use App\Models\Menu\ModifierGroup;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;
use App\Models\Location\OrderTypes;
use App\Models\Pos\Order;
use App\Models\Pos\OrderHistory;


class KitchenController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public $tabList;

    function __construct() {
        $this->middleware('auth');
        $this->tabList['tab'] = Helper::$menutab;
        $this->tabList['selected'] = 'item';
    }


    public function getIndex(Request $request, $id) {
        

        /* code for check roles and redirect it on index method of current controller if has not access */
        if (($return = UserRoles::hasAccess('menu_view', $request)) !== true) {
              return redirect()->action($return);
        }
        /* end permission code */
        $orderData = OrderHistory::getOrdersHistory();

        $return = view('kitchen.kitchen', ['orderData' => $orderData]);

        return $return;
    }
    
    
}
