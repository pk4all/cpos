@extends('layouts.plane')
@section('body')
<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row sub-tab-list">
@include('layouts.messages',['title'=>'Delivery Store Areas','path'=>['#'=>'Delivery Store Areas']])
@include('layouts.menu',['tabList'=>$tabList])
        </div>      
<div class="row">
<div class="col-lg-12">
<div class="card-box">
<div class="row">
<div class="col-sm-8">
  
</div>
<div class="col-sm-4">
	<a href="/delivery-area" class="btn btn-default btn-md waves-effect waves-light m-b-30 pull-right"><i class="md md-add"></i> Delivery Stores</a>
</div>
</div>
<div class="row">
	<div class="map-area col-sm-8 nopadding">
		@if(count($list)>0)
			<table class="table table-hover m-0 table table-actions-bar">
			<thead>
				<tr>
				<th>#</th>
				<th>Area Name</th><th>Street Name</th><th>Building Name</th>
				<th>Actions</th>
				</tr>
			</thead>
			<tbody >
				<?php
				$i=0; foreach($list as $item){ $i++;//pr($surc);?>
				<tr>
					<td ><?php echo $i;?></td>
					<td ><?php echo $item->area_name ?></td>
					<td ><?php echo $item->street_name ?></td>
					<td ><?php echo $item->building_name ?></td>
					
				<td >
				<a href="javascript:void(0)" class="btn btn-sm btn-danger" onclick="deleteArea('<?php echo $item->id?>')"><i class="fa fa-trash-o"></i></a>
					</td>
				</tr>
				<?php } ?>
				</tbody>
			</table>
			@else
			<div class="alert text-center text-danger">No record(s) found.</div>
		@endif
	</div>
	
	<div class="col-sm-4">
	{!! Form::open(array('url' => '#',"id"=>"add",'onsubmit'=>"savedata();return false;")) !!}
		{!! Form::hidden('delv_store_id',$id) !!}
	<div class="form-group">
			<label class="col-sm-8">Area Name</label>
			<div class="col-sm-8"><input name="area_name" class="form-control" required="required" id="area-name" type="text"></div>
		</div>
		<div class="form-group">
			<label class="col-sm-8">Street Name</label>
			<div class="col-sm-8"><input name="street_name" class="form-control" required="required" id="street-name" type="text"></div>
		</div>
		<div class="form-group">
			<label class="col-sm-8">Building Name</label>
			<div class="col-sm-8"><input name="building_name" class="form-control" required="required" id="building-name" type="text"></div>
		</div>
		<div class="form-group">
			<button id="save" class="btn btn-primary" type="submit" >Save</button>
		</div>
	{!! Form::close()!!}
	</div>
</div>
</div>
</div>
</div>
</div>
</div>
<script>
var siteurl='<?php echo url('/');?>';
var crsf='{{csrf_token()}}';
function savedata(){
	var form=$('#add')[0];
	var formData = new FormData(form);
	$.ajax({
				method:'POST',
				url:siteurl+'/delivery/save-delivery-area',
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
						form.reset();
						$('#save').html(res.msg);
						window.location.reload();
					}
					if(res.status=='error'){
						$('#msg').html('<span class="error-message">'+res.msg+'</span>');
					}
				}
			});
}
function deleteArea(Id){
	$.ajax({
		method:'POST',
		url:siteurl+'/delivery/delete-area',
		dataType: "JSON",
		data: {id:Id,'_token':crsf},
		beforeSend:function(){
			//$('#loader').removeClass('hide');
		},
		success:function(res){
			if(res.status=='success'){
				//$('#loader').addClass('hide');
				window.location.reload();
			}
		}
	  });
}
</script>
@stop