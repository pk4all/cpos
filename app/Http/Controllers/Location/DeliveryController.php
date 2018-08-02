<?php
namespace App\Http\Controllers\Location;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Location\DeliveryStores;
use App\Models\Location\GMapAreas;
use App\Models\Location\DeliveryAreas;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DeliveryController extends Controller {

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
		 $storelist=[1=>'Test Store',2=>'Business Bay',3=>'Dubai Marina',4=>'Motor City',5=>'Noida'];
		 $allDeliveryStores = DeliveryStores::paginate(20);
		 $view = view('delivery.index', ['storelist'=>$storelist,'list'=>$allDeliveryStores]);
		 return $view;
    }
	
	public function saveDeliveryStore(Request $request){
		$delivery = new DeliveryStores();
		//print_r($request->all());die;
		$delivery->type = $request->input('type');
        $delivery->store_id = $request->input('store_id');
        $delivery->status = 'enable';
		if($delivery->save())
		{
			return response()->json(["response" => 200,'status'=>'success', "msg" => 'Delivery Store has been saved']);
		}
		else
		{
			return response()->json(["response" => 400,'status'=>'error', "msg" => 'An internal error.']);
		}
		
		die;
	}
	
	
	
	public function changeDeliveryStatus(Request $request){
		$status=$request->input('status');
		$id=$request->input('id');
		$discount=DeliveryStores::find($id);
		$discount->status=$status;
		$discount->change_at = Carbon::now();
        if($discount->save()){
			return response()->json(["response" => 200,'status'=>'success', "msg" => 'Status has been changed']);
		}else{
			return response()->json(["response" => 400,'status'=>'error', "msg" => 'An internal error.']);
		}
		die;
	}
	
	public function getEdit(Request $request,$id=null){
		$delvStore = DeliveryStores::find($id); 
		$view = view('delivery.edit',['delvStore'=>$delvStore]);
         return $view;
	}
	
	public function saveEditDeliveryStore(Request $request){
		$delvStore=DeliveryStores::find($request->input('id'));
		$delvStore->type = $request->input('type');
        $delvStore->store_id = $request->input('store_id');
		if($delvStore->save())
		{
			return response()->json(["response" => 200,'status'=>'success', "msg" => 'Delivery Store has been saved']);
		}
		else
		{
			return response()->json(["response" => 400,'status'=>'error', "msg" => 'An internal error.']);
		}
		die;
	}
	
	public function deliveryAreaGmap(Request $request,$id=null){
		$areas=GMapAreas::where('delv_store_id','=',$id)->get();
		$view = view('delivery.gmap',['id'=>$id,'storeLat'=>28.625507,'storeLng'=>77.208287,'SelectedAreas'=>$areas]);
         return $view;
	}
	
	public function saveGmapData(Request $request){
		$area = new GMapAreas();
		$area->delv_store_id=$request->input('id');
		$area->map_data=$request->input('data');
		if($area->save())
		{
			return response()->json(["response" => 200,'status'=>'success', "msg" => 'Delivery Area has been saved']);
		}
		else
		{
			return response()->json(["response" => 400,'status'=>'error', "msg" => 'An internal error.']);
		}
		die;
	}
	
	public function deleteGmapArea(Request $request){
		
		if(GMapAreas::destroy($request->input('id'))){
			return response()->json(["response" => 200,'status'=>'success', "msg" => 'Delivery Area has been deleted']);
		}else
		{
			return response()->json(["response" => 400,'status'=>'error', "msg" => 'An internal error.']);
		}
		die;
	}
	
	public function deliveryArea(Request $request,$id){
		$areas=DeliveryAreas::where('delv_store_id','=',$id)->get();
		$view = view('delivery.area',['id'=>$id,'list'=>$areas]);
        return $view;
	}
	
	public function saveDeliveryArea(Request $request){
		$area=new DeliveryAreas();
		$area->delv_store_id=$request->input('delv_store_id');
		$area->area_name=$request->input('area_name');
		$area->street_name=$request->input('street_name');
		$area->building_name=$request->input('building_name');
		if($area->save())
		{
			return response()->json(["response" => 200,'status'=>'success', "msg" => 'Delivery Area has been saved']);
		}
		else
		{
			return response()->json(["response" => 400,'status'=>'error', "msg" => 'An internal error.']);
		}
		
		die;
	}
	
	public function deleteArea(Request $request){
		if(DeliveryAreas::destroy($request->input('id'))){
			return response()->json(["response" => 200,'status'=>'success', "msg" => 'Delivery Area has been deleted']);
		}else
		{
			return response()->json(["response" => 400,'status'=>'error', "msg" => 'An internal error.']);
		}
		die;
	}
}
