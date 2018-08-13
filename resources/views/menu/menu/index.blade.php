@extends('layouts.plane')
@section('body')

<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            @include('layouts.messages',['title'=>'Brands','path'=>[]])
            @include('layouts.menu',['tabList'=>$tabList])

        </div>    
        @include('menu.menu.table', array('class'=>'table-hover table-bordered table-striped', 'tbl_header'=>$tbl_header, 'tbl_data'=>$results))
        @include('layouts.deleteconfirm')
    </div> <!-- end Panel -->
</div> <!-- end container -->
@section('custome_script')
<script src="/assets/js/jquery-ui.js"></script>
<script src="/assets/js/jquery.ui.touch-punch.js"></script>
<script>
$(function(){
	$(document).on('click', '.sort-now', function(){
		var itemId = $(this).attr('data-item-id');
		$.ajax({
			url : '/item/sort/'+itemId,
			type :'GET',
			success : function(data){
				$('#groups').html(data);
			},
			error : function(err){

			}

		});
		$('#sortModalCenter').modal('show');
	})
});
</script>
@yield('custome_script')
@overwrite
@stop

