<?php
namespace App\Http\Controllers\Location;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Location\OrderTypes;
use App\Models\Location\Stores;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OrderTypeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
		 //'storelist'=>$storelist
		 $storesLists=Stores::where('status', 'enable')->orderBy('_id', 'asc')->get();
		 if($storesLists){
			 foreach($storesLists as $store){
				 $storeArr[$store->id]=$store->name;
			 }
		 }
		 $list = OrderTypes::paginate(20);
		 $view = view('location.orderType.index', ['stores'=>$storeArr,'list'=>$list]);
		 return $view;
    }
	
	public function save(Request $request){
		$orderType = new OrderTypes();
		//print_r($request->all());die;
		$orderType->name = $request->input('name');
		$orderType->type = $request->input('type');
        $orderType->store_id = $request->input('store_id');
        $orderType->status = 'enable';
		if($orderType->save())
		{
			return response()->json(["response" => 200,'status'=>'success', "msg" => 'Order Type has been saved']);
		}
		else
		{
			return response()->json(["response" => 400,'status'=>'error', "msg" => 'An internal error.']);
		}
		
		die;
	}
	
	public function changeStatus(Request $request){
		$status=$request->input('status');
		$id=$request->input('id');
		$data=OrderTypes::find($id);
		$data->status=$status;
		$data->change_at = Carbon::now();
        if($data->save()){
			return response()->json(["response" => 200,'status'=>'success', "msg" => 'Status has been changed']);
		}else{
			return response()->json(["response" => 400,'status'=>'error', "msg" => 'An internal error.']);
		}
		die;
	}
	
	public function edit(Request $request,$id=null){
		$ordType = OrderTypes::find($id); 
		 $storesLists=Stores::where('status', 'enable')->orderBy('_id', 'asc')->get();
		 if($storesLists){
			 foreach($storesLists as $store){
				 $storeArr[$store->id]=$store->name;
			 }
		 }
		$view = view('location.orderType.edit',['data'=>$ordType,'stores'=>$storeArr]);
         return $view;
	}
	
	public function saveEdit(Request $request){
		$ordType=OrderTypes::find($request->input('id'));
		$ordType->name = $request->input('name');
		$ordType->type = $request->input('type');
        $ordType->store_id = $request->input('store_id');
		if($ordType->save())
		{
			return response()->json(["response" => 200,'status'=>'success', "msg" => 'Order Type has been saved']);
		}
		else
		{
			return response()->json(["response" => 400,'status'=>'error', "msg" => 'An internal error.']);
		}
		die;
	}
	
}
