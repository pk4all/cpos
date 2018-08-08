@extends('layouts.plane')
@section('body')

<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            @include('layouts.messages',['title'=>'Tax','path'=>[]])
            @include('layouts.menu',['tabList'=>$tabList])

        </div>    
        @include('location.tax.table', array('class'=>'table-hover table-bordered table-striped', 'tbl_header'=>$tbl_header, 'tbl_data'=>$results))
        @include('layouts.deleteconfirm')
    </div> <!-- end Panel -->
</div> <!-- end container -->
@stop
