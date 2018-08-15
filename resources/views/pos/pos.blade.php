@extends('posLayouts.pos')
@section('body')

<div class="pickup-page">
    <div class="container-fluid">
        <div class="col-lg-12">
        	<div class="row">
            		@include('pos.cart')
            		@include('pos.brand')
            		@include('pos.pos-item')
        	</div>
        </div> <!-- end col -->
    </div> <!-- end Panel -->
</div> <!-- end container -->
@section('custome_script')
<script>
$(function(){
	alert('gggg');
})
;(function() {
    'use strict';
    $(activate);
    function activate() {
        $('.catname-lists ul')
        .scrollingTabs({
            enableSwiping: true
        })
        .on('ready.scrtabs', function() {
            $('.tab-content').show();
        });
    }
    alert('hhh');
}());   
</script>
@yield('custome_script')
@overwrite
@stop
