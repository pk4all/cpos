<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Helpers;

use Illuminate\Support\Str;
use Jenssegers\Mongodb\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AssetsController;

class Helper {

    protected $default_sel = array('0' => 'Select');
        public function getDefaultSel() {
        return $this->default_sel;
    }
    
    public static $stafftab=[['name'=>'Users','link'=>'users'],['name'=>'Roles','link'=>'user-roles']];
     public static $menutab=[['name'=>'Menu','link'=>'menu'],['name'=>'Categories','link'=>'category',],['name'=>'Modifiers','link'=>'modifiers',]];
    public static $locationtab=[['name'=>'Stores','link'=>'stores'],['name'=>'Brands','link'=>'brands'],['name'=>'Order Type','link'=>'order-type'],['name'=>'Surcharge','link'=>'surcharge'],['name'=>'Tax Rates','link'=>'tax'],['name'=>'Payment Option','link'=>'payment'],['name'=>'Delivery Area','link'=>'delivery-area']];
    
    public static function getCurrentController($onlyName = false) {
      $currentAction = \Route::currentRouteAction();
      list($controller, $method) = explode('@', $currentAction);
      //$controller = preg_replace('/.*\\\/', '', $controller);
      $controller=explode("Controllers\\",$controller);
      $controller = $controller[1];
      $controller = $controller . '@getIndex';
      if ($onlyName) {
          $controller = str_replace('Controller@getIndex', '', $controller);
      }
        return $controller;
    }

     public static function imageFileUploadPath($start_path = 'assets/images/',$dir_name=null) {
        $path = public_path($start_path);
        $img_path = $path.$dir_name.'/';
        if (!is_dir($img_path)) {
            mkdir($img_path, 0777, true);
        }
        return $img_path;
    }
}
