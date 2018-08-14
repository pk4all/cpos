@extends('layouts.plane')
@section('body')
<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            @include('layouts.messages',['title'=>'','path'=>[]])

        </div> 
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <a href="/stores" class="card-link"><h5 class="card-title"><i class="fa fa-users"></i><br/>
                                <span>Location</span></h5></a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <a href="/users" class="card-link"><h5 class="card-title"><i class="fa fa-users"></i><br/>
                                <span>Staff</span></h5></a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <a href="/category" class="card-link"><h5 class="card-title"><i class="fa fa-cutlery"></i><br/>
                                <span>Menu Setup</span></h5></a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <a href="admin/stores" class="card-link">
                            <h5 class="card-title"><i class="fa fa-briefcase"></i><br/>
                                <span>Inventory</span>
                            </h5>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-12 clearfix" style="padding-top:20px"></div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <a href="/discount" class="card-link">
                            <h5 class="card-title"><i class="fa fa-gift"></i><br/>
                                <span>Discounts</span>
                            </h5>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div> <!-- end container -->
</div>
<div class="clearfix" style="padding-top:20px"></div>
@stop

