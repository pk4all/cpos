@extends('layouts.plane')
@section('body')

<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row sub-tab-list">
            @include('layouts.messages',['title'=>'Brands','path'=>[]])
            @include('layouts.menu',['tabList'=>$tabList])

        </div>    
        @include('location.brands.table', array('class'=>'table-hover table-bordered table-striped', 'tbl_header'=>$tbl_header, 'tbl_data'=>$results))
        @include('layouts.deleteconfirm')
    </div> <!-- end Panel -->
</div> <!-- end container -->
@stop
