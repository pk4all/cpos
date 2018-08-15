@extends('posLayouts.pos')
@section('body')

<div class="pickup-page">
    <div class="container-fluid">
    		@include('pos.cart')
    		@include('pos.brand')
    		@include('pos.pos-item')
    </div> 
</div>

<script>
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
}());   
</script>
@stop
