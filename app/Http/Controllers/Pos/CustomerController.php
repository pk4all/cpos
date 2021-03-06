<?php
namespace App\Http\Controllers\Pos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Location\Stores;
use App\Models\Pos\Customers;
use App\Models\Location\OrderTypes;
use Carbon\Carbon;
use App\Models\Pos\Order;
class CustomerController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        //$this->middleware('auth');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex() {
         $view = view('pos.index', ['orderTypes'=>'']);
        return $view;
    }
	
    public function getCustomer(Request $request) {
        $customer=Customers::getCustomerByPhone($request->input('phone'));
        if($customer){
            if($customer->status=='disable'){
                return response()->json(["response" => 400, 'status' => 'blocked','id'=>$customer->_id]);
            }
           $store=Stores::getStoresById($customer->store_id)->first();
           $ordTypes=OrderTypes::getOrderTypesByStoreId($customer->store_id);
           $request->session()->put('store', $store->toArray());
           $request->session()->put('customer', $customer->toArray());
           return response()->json(["response" => 200, 'status' => 'success', "customer" =>$customer,'store'=>$store,'orderTypes'=>$ordTypes]);
        }else{
           return response()->json(["response" => 200, 'status' => 'new','phone'=>$request->input('phone')]);
        }
        die;
    }

    public function saveCustomer(Request $request){
         $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required|unique:customers',
            'city' => 'required',
            'apartment_no' => 'required',
            'street_no' => 'required',
            'street_name' => 'required',
        ]);
        
        if ($validator->fails())
        {
            return response()->json(["response" => 400,'status' => 'error','errors'=>$validator->errors()->all()]);
            die;
        }
        $customer=new Customers();
        $customer->name=$request->input('name');
        $customer->phone=$request->input('phone');
        $customer->city=$request->input('city');
        $customer->apartment_no=$request->input('apartment_no');
        $customer->street_no=$request->input('street_no');
        $customer->street_name=$request->input('street_name');
        $customer->store_id=Stores::getCustomerStore();
        $customer->status = 'enable';
        if ($customer->save()) {
            $store=Stores::getStoresById($customer->store_id)->first();
            $ordTypes=OrderTypes::getOrderTypesByStoreId($customer->store_id);
            $request->session()->put('store', $store->toArray());
            $request->session()->put('customer', $customer->toArray());
            return response()->json(["response" => 200, 'status' => 'success', "msg" => 'Customer has been saved', "customer" =>$customer,'store'=>$store->first(),'orderTypes'=>$ordTypes]);
        } else {
            return response()->json(["response" => 400, 'status' => 'error', "errors" => ['An internal error.']]);
        }
        die;
    }
    public function saveEditCustomer(Request $request){
         $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required|unique:customers,'.$request->input('_id'),
            'city' => 'required',
            'apartment_no' => 'required',
            'street_no' => 'required',
            'street_name' => 'required',
        ]);
        
        if ($validator->fails())
        {
            return response()->json(["response" => 400,'status' => 'error','errors'=>$validator->errors()->all()]);
            die;
        }
        $customer=Customers::getCustomerById($request->input('_id'));
        $customer->name=$request->input('name');
        $customer->phone=$request->input('phone');
        $customer->city=$request->input('city');
        $customer->apartment_no=$request->input('apartment_no');
        $customer->street_no=$request->input('street_no');
        $customer->street_name=$request->input('street_name');
        $customer->store_id=Stores::getCustomerStore();
       // $customer->status = 'enable';
        if ($customer->save()) {
            $store=Stores::getStoresById($customer->store_id)->first();
            $ordTypes=OrderTypes::getOrderTypesByStoreId($customer->store_id);
            $request->session()->put('store', $store->toArray());
            $request->session()->put('customer', $customer->toArray());
            return response()->json(["response" => 200, 'status' => 'success', "msg" => 'Customer has been saved', "customer" =>$customer,'store'=>$store,'orderTypes'=>$ordTypes]);
        } else {
            return response()->json(["response" => 400, 'status' => 'error', "errors" => ['An internal error.']]);
        }
        die;
    }
    
    public static function blockCustomer(Request $request){
        
       $customer=Customers::getCustomerById($request->input('_id'));
       $customer->status = 'disable';
        if ($customer->save()) {
            return response()->json(["response" => 200, 'status' => 'success']);
        }
    }
    public static function restoreCustomer(Request $request){
       // print_r($request->input('_id'));die;
       $customer=Customers::getRawCustomerById($request->input('_id'));
       $customer->status = 'enable';
        if ($customer->save()) {
           $store=Stores::getStoresById($customer->store_id)->first();
            $ordTypes=OrderTypes::getOrderTypesByStoreId($customer->store_id);
            $request->session()->put('store', $store->toArray());
            $request->session()->put('customer', $customer->toArray());
            return response()->json(["response" => 200, 'status' => 'success', "msg" => 'Customer has been restored', "customer" =>$customer,'store'=>$store,'orderTypes'=>$ordTypes]);
        }
    }
    public static function order(Request $request){
        if($request->input('ordertype')){
            $request->session()->put('order_type', $request->input('ordertype'));
            return response()->json(["response" => 200, 'status' => 'success','action'=>'/pos/itemlist' ]);
            die;
        }
    }

}
