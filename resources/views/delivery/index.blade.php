@extends('layouts.plane')
@section('body')
<?php $type=['area'=>'Define By Area','gmap'=>'  Define On Google Map'];?>
<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
@include('layouts.messages',['title'=>'Delivery Stores','path'=>['#'=>'Delivery Stores']])
        </div>    
        
<div class="row">
<div class="col-lg-12">
<div class="card-box">
<div class="row">
<div class="col-sm-8">
  
</div>
<div class="col-sm-4">
	<a href="javascript:void(0)" class="btn btn-default btn-md waves-effect waves-light m-b-30 pull-right" onclick="add();"><i class="md md-add"></i> Add Delivery Store</a>
</div>
</div>
<div class="table-responsive">
 @if(count($list)>0)  
	<table class="table table-hover m-0 table table-actions-bar">
		<thead>
		<tr>
			<th>#</th>
			<th>Area Type</th>
			<th>Store</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
		</thead>
		<tbody>
		 @foreach($list as $key=>$data)
		<tr>
			<td>{{$key+1}}</td>
			<td>{{$type[$data->type]}}</td>
			<td>{{$storelist[$data->store_id]}}</td>
			<td>
		@if($data->status=='enable')
			<input type="checkbox" checked data-plugin="switchery" data-color="#5d9cec" data-size="small" data-id="{{$data->id}}" class="status" onchange="status(this);"/>
		@else
			<input type="checkbox" data-plugin="switchery" data-color="#5d9cec" data-size="small" data-id="{{$data->id}}" class="status" onchange="status(this);"/>
		@endif
			</td>
			<td>
				<a href="javascript:void(0)" class="btn btn-sm btn-primary waves-effect waves-light" onclick="edit('{{$data->id}}');"><i class="md md-edit"></i></a>
				@if($data->type=='area')
				<a href="/delivery/delivery-area/{{$data->id}}" class="btn btn-sm btn-primary waves-effect waves-light">Area List</a>
				@else
				<a href="/delivery/delivery-area-gmap/{{$data->id}}" class="btn btn-sm btn-primary waves-effect waves-light">Area List</a>
				@endif
			</td>
		</tr>
		@endforeach
		</tbody>
	</table>
		@else
<div class="text-center text-danger">
	No Result Found
</div>
	@endif
</div>
</div>
</div> <!-- end col -->
</div>
@include('layouts.deleteconfirm')
</div> <!-- end Panel -->
</div> <!-- end container -->
 <!-- Modal -->
 <div class="modal" id="add_popup" tabindex="-1" role="dialog"  aria-hidden="false">
  <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
	<div class="modal-header">
	<h4 class="modal-title">Add</h4>
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
	</div>
	<div class="modal-body">		

{!! Form::open(array('url' => '#',"id"=>"add",'onsubmit'=>"savedata();return false;")) !!}
<div class="panel panel-default">
<div class="panel-body panel-body-nopadding">
	<div class="form-group row">
	<label class="col-2 col-form-label">Area Type</label>
	<div class="col-8">
		<label style="padding:10px" for="type-area">
		<input name="type" value="area" id="type-area" required="required" type="radio">  Define By Area</label><label style="padding:10px" for="type-gmap"><input name="type" value="gmap" id="type-gmap" required="required" type="radio"> Define On Google Map</label>
	</div>
	</div>
	<div class="form-group row">
	<label class="col-2 col-form-label">Store</label>
	<div class="col-8">
		<select name="store_id" class="form-control" required="required" id="store-id"><option value="">Select Store</option><option value="1">Test Store</option><option value="2">Business Bay</option><option value="3">Dubai Marina</option><option value="4">Motor City</option><option value="5">Noida</option></select>
	</div>
	</div>
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
<button id="save" class="btn btn-primary" type="submit">Save</button>
</div>
 </form>	
 </div>
	</div>
     </div>
 </div>
 
  <div class="modal" id="edit_popup" tabindex="-1" role="dialog">
  <div class="modal-dialog  modal-lg" role="document">
    <div  class="modal-content">
	<div class="modal-header">
	 <h4 class="modal-title">Edit Delivery Store</h4>
	 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	</div>
	<div class="modal-body"> 
		
	</div>
	</div>
     </div>
  </div>
  
 
 
 <script src="{{ asset('assets/plugins/switchery/js/switchery.min.js')}}"></script>
<link rel="stylesheet" href="{{ ('assets/plugins/switchery/css/switchery.min.css')}}" />

<style>
.mails td:last-of-type {
    width: auto;
}
</style>
<script>
var siteurl='<?php echo url('/');?>';
var crsf='{{csrf_token()}}';
function add(){
	$('#add_popup .modal-title').html('Add Delivery Store');
	$('#add_popup').modal('show');
}

var $btn;
function savedata(){
	var form=$('#add')[0];
	var formData = new FormData(form);
	$.ajax({
				method:'POST',
				url:siteurl+'/delivery/save-delivery-store',
				dataType: "JSON",
				data: formData,
				processData: false,
				contentType: false,
				cache: false,
				beforeSend:function(){
					$btn = $('#save').button('loading');
					$('.error-message').remove();
				},
				success:function(res){
					$btn.button('reset');
					if(res.status=='success'){
						$('#save').html(res.msg);
				window.location.href=siteurl+'/delivery-area';
					}
					if(res.status=='error'){
						$('#msg').html('<span class="error-message">'+res.msg+'</span>');
					}
				}
			});
}

function edit(id){
	$('#loader').removeClass('hide');
	$.get(siteurl+'/delivery/edit-delivery/'+id,function(data){
			$('#loader').addClass('hide');
			$('#edit_popup .modal-body').html(data);
			$('#edit_popup').modal('show');
	});
}
function saveEditdata(){
	var form=$('#edit')[0];
	var formData = new FormData(form);
	$.ajax({
				method:'POST',
				url:siteurl+'/delivery/save-edit-delivery-store',
				dataType: "JSON",
				data: formData,
				processData: false,
				contentType: false,
				cache: false,
				beforeSend:function(){
					$btn = $('#saveEdit').button('loading');
					$('.error-message').remove();
				},
				success:function(res){
					$btn.button('reset');
					if(res.status=='success'){
						$('#saveEdit').html(res.msg);
						window.location.href=siteurl+'/delivery-area';
					}
					if(res.status=='error'){
						$('#edit-msg').html('<span class="error-message">'+res.msg+'</span>');
					}
				}
			});
}

$('.toggles').each(function(ele){
			$(this).toggles({on:$(this).data('toggle-on')});
		});
		$('.toggles').on('toggle', function(e, active) {
			var elmId=$(this).data('id');
		  if (active) {
			var status='Active';
		  } else {
			var status='Inactive';
		  }
		  $.ajax({
			method:'POST',
			url:siteurl+'admin/stores/change-delivery-status',
			dataType: "JSON",
			data: {id:elmId,status:status,'_csrfToken':crsf},
			beforeSend:function(){
				$('#loader').removeClass('hide');
			},
			success:function(res){
				$('#loader').addClass('hide');
			}
		  });
		});
function status(obj){
	if(obj.checked==true){
		var status='enable';
	}else{
		var status='disable';
	}
	$.ajax({
			method:'POST',
			url:siteurl+'/delivery/change-delivery-status',
			dataType: "JSON",
			data: {id:$(obj).data('id'),status:status,_token:'{{ csrf_token()}}'},
			beforeSend:function(){
				//$('#loader').removeClass('hide');
			},
			success:function(res){
				//$('#loader').addClass('hide');
			}
		});
}
</script> 
 <!-- Modal -->
@stop
