<?php

namespace App\Models\Menu;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use \App\Helpers\Helper;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;


class PluCode extends Eloquent {

    //use \Venturecraft\Revisionable\RevisionableTrait;
    use SoftDeletes;

    protected $table = 'plu_codes';
    //public static $type=['Card'=>'Card','Cash'=>'Cash'];
    
    public static function getPlusCount() {
        return self::where('status', 'enable')->count();
    }

    public static function getPluCode($type=null) {
        $query=self::select('_id','plu');
        $defalt=['menu'=>'000001','modifier'=>'001001'];
        if($type){
           $query= $query->where('type',$type);
        }
         $query= $query->orderBy('created_at', 'desc')->first();
         if($query){
             return str_pad(($query->plu)+1, 6, '0', STR_PAD_LEFT);
         }else{
             return $defalt[$type];
         }
         
    }
    
}
