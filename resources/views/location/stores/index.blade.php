@extends('layouts.plane')
@section('body')

<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            @include('layouts.messages',['title'=>'Stores','path'=>['/setup'=>'Setup']])
            @include('layouts.menu',['tabList'=>$tabList])

        </div>  
        @include('location.stores.table', array('class'=>'table-hover table-bordered table-striped', 'tbl_header'=>$tbl_header, 'tbl_data'=>$results))
        @include('layouts.deleteconfirm')
    </div> <!-- end Panel -->
</div> <!-- end container -->
@stop
