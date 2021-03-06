<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class HomeController extends Controller {

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
    public function getIndex() {
         $view = view('dashboard', []);
        return $view;
    }
	
	 public function setup() {
         $view = view('setup', []);
        return $view;
    }

}
