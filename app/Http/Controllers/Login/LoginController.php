<?php

namespace App\Http\Controllers\Login;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\UserRoles;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;



class LoginController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    //public $tabList;

    function __construct() {
       // $this->middleware('auth');
        
    }


    public function index(Request $request) {
        if(isset($_COOKIE['savedUsers'])){
             $getSavedUser= unserialize($_COOKIE['savedUsers']);
        }else{
            $getSavedUser=[];
        }
        $return = view('login.index', ['users'=> json_encode($getSavedUser)]);
        return $return;
    }
    public function checkUser(Request $request) {
        $credentials = $request->only('email', 'password');
        if (Auth::once($credentials)) {
            $user=Auth::user();
            //$user;die;
            return response()->json(["response" => 200, 'status' => 'success', "user" =>$user['_id']]);
        }else{
           return response()->json(["response" => 400, 'status' => 'error','msg'=>'Your credentials did not work']);
        }
         
    }
    
    public function setPin(Request $request) {
        $user=User::getUserById($request->input('id'));
        if($user){
            $user->pin=$request->input('pin');
            if($user->save()){
                //setcookie('savedUsers', null, -1, '/', NULL, 0 );
                if(isset($_COOKIE['savedUsers'])){
                    $getSavedUser= unserialize($_COOKIE['savedUsers']);
                }else{
                    $getSavedUser=[];
                }
                if(!in_array($user->email, $getSavedUser)){
                    $getSavedUser[]=$user->email;
                }
                $minutes=(60*60*24*365);
                setcookie('savedUsers',serialize($getSavedUser), time()+365*24*60*60,'/', NULL, 0 );
                //print_r($getSavedUser);
                return response()->json(["response" => 200, 'status' => 'success', "users" =>$getSavedUser,'user'=>$user->email]);
            }
        }
    }
    
    public function login(Request $request){
        $user = User::where('email', $request->input('user'))
                ->where('pin', $request->input('pin'))
                ->where('status', 'enable')
                ->first();
        if(isset($user) && Auth::loginUsingId($user->id)){
            return response()->json(["response" => 200, 'status' => 'success', "action" =>'/home']);
        }else{
           return response()->json(["response" => 400, 'status' => 'error','msg'=>'Invalid PIN']);
        }
        
    }
}
