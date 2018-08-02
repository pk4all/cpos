{!! Form::open(array('url' => '#',"id"=>"edit",'onsubmit'=>"saveEditdata();return false;")) !!}
 {!! Form::hidden('id',$data->id) !!}
<div class="panel panel-default">
<div class="panel-body panel-body-nopadding row">
	<div class="col-8">
	<div class="form-group row">
	<label class="col-4 col-form-label">Order Type Label</label>
	<div class="col-8">
		<div class="input text required"><input name="name" class="form-control required" required="required" maxlength="255" id="name" type="text" value="{{$data->name}}"></div>
	</div>
	</div>
	<div class="form-group row">
	<label class="col-sm-4 control-label">Order Type</label>
	<div class="col-sm-8">
		<label style="padding:10px" for="order-type-pickup"><input name="type" value="Pickup" id="order-type-pickup" type="radio" @if($data->type=='Pickup') checked @endif>  Pickup</label><label style="padding:10px" for="order-type-delivery"><input name="type" value="Delivery" id="order-type-delivery" type="radio" @if($data->type=='Delivery') checked @endif>  Delivery</label><label style="padding:10px" for="order-type-dining"><input name="type" value="Dining" id="order-type-dining" type="radio" @if($data->type=='Dining') checked @endif>  Dining</label>
	</div>
</div>
	
	</div>
	<div class="col-4">
	<div class="form-group row">
	<h4>Stores</h4>
	<div class="col-12">
		
		@if($stores)
			<div class="ckbox ckbox-primary">
				<input name="store_id[]" value="0" id="checkbox0" onclick="checkAll(this);" type="checkbox">
				<label for="checkbox0">All Stores</label>
			</div>
			@foreach($stores as $key=>$store)
		<div class="ckbox ckbox-primary">
			<input name="store_id[]" value="{{$key}}" id="{{$key}}" type="checkbox" @if(in_array($key,$data->store_id)) checked @endif >
			<label for="{{$key}}">{{$store}}</label>
		</div>
			@endforeach
		@endif
		
	</div>
	</div>

	
	</div>
	</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
<button id="save" class="btn btn-primary" type="submit">Save</button>
</div>	 
</form>	 
