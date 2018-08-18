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
use App\Models\Location\Brands;
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
       // $orderData = OrderHistory::getOrdersHistory();
        $orderData=Order::getOrdersfromStoreId($id);
		$barnds= Brands::getBrandByStoreId($id);
        //echo '<pre>';
       // print_r($orderData);die;
      $return = view('pos.kitchen', ['orderData' => $orderData,'barnds'=>$barnds]);
        return $return;
    }
    
	public function completeOrder($ord_id,$brand_id){
		$orderData=Order::getOrdersById($ord_id);
		//echo '<pre>';
		$bd_data=$orderData->brand_status;
		$sts=false;
		foreach($bd_data as $bd){
			if($bd['_id']==$brand_id){
				$bd['status']='Ready';
			}
			if($bd['status']=='Ready'){
				$sts=true;
			}else{
				$sts=false;
			}
			$ourBd[]=$bd;
		}
		if($sts){
			$orderData->order_status='Ready';
		}
		$orderData->brand_status=$ourBd;
		if($orderData->save()){
			return response()->json(["response" => 200, 'status' => 'success']);
		}else{
			return response()->json(["response" => 400, 'status' => 'error', "errors" => ['An internal error.']]);
		}
	}
    public function dispatchOrder($ord_id){
		$orderData=Order::getOrdersById($ord_id);
		
		$bd_data=$orderData->brand_status;
		$sts=false;
		foreach($bd_data as $bd){
			if($bd['status']=='In Kitchen'){
				$sts=true;
			}
		}
		if(!$sts){
			$ord_items='';
			foreach($orderData->cart_items as $item){
				$ord_items.=$item['item']['name'].', ';
			}
			//print_r($orderData->customer);die;
			/*--------------- Code for delv--------------*/
			header('Access-Control-Allow-Origin: *');
			header('Access-Control-Allow-Headers: X-Requested-With');
			header('Access-Control-Allow-Headers: Content-Type');
			$fields=(array(
			  'store_id' => 'MARINA',
			  'order_no' => $orderData->order_id,
			  'order_description' => $ord_items,
			  'customer_first_name' => $orderData->customer['name'],
			  'customer_last_name' => '',
			  'customer_contact_no' => $orderData->customer['phone'],
			  'customer_address' => $orderData->customer['apartment_no'].','.$orderData->customer['street_no'].', '.$orderData->customer['street_name'].', '.$orderData->customer['city'],
			  'customer_email' => '',
			  'device_androidKey' => '',
			  'device_appleKey' => ''
			));
			$url='http://demo.delivertrac.com/orders/create';
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array(
				'CONTENT_TYPE: application/x-wwww-form-urlencoded'
				));
			curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($fields));
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($curl);
			curl_close($curl);
			//print_r($response);
			/*--------------- Code for delv--------------*/
			$orderData->order_status='Dispatch';
			if($orderData->save()){
				return response()->json(["response" => 200, 'status' => 'success','msg'=>$response]);
			}else{
				return response()->json(["response" => 400, 'status' => 'error', "errors" => 'An internal error.']);
			}
		}else{
			return response()->json(["response" => 400, 'status' => 'error', "errors" =>'Order is not ready.']);
		}
		die;
	}
}
