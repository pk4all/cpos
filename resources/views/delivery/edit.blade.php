{!! Form::open(array('url' => '#',"id"=>"edit",'onsubmit'=>"saveEditdata();return false;")) !!}
 {!! Form::hidden('id',$delvStore->id) !!}
<div class="panel panel-default">
<div class="panel-body panel-body-nopadding">
	<div class="form-group row">
	<label class="col-2 col-form-label">Area Type</label>
	<div class="col-8">
		<label style="padding:10px" for="type-area">
		<input name="type" value="area" id="type-area" required="required" type="radio" {{$delvStore->type=='area'?'checked':''}}>  Define By Area</label><label style="padding:10px" for="type-gmap"><input name="type" value="gmap" id="type-gmap" required="required" type="radio" {{$delvStore->type=='gmap'?'checked':''}}> Define On Google Map</label>
	</div>
	</div>
	<div class="form-group row">
	<label class="col-2 col-form-label">Store</label>
	<div class="col-8">
		<select name="store_id" class="form-control" required="required" id="store-id">
		<option value="">Select Store</option>
		<option value="1" {{$delvStore->store_id==1?'selected':''}}> Test Store</option>
		<option value="2" {{$delvStore->store_id==2?'selected':''}}> Business Bay</option>
		<option value="3" {{$delvStore->store_id==3?'selected':''}}> Dubai Marina</option>
		<option value="4" {{$delvStore->store_id==4?'selected':''}}> Motor City</option>
		<option value="5" {{$delvStore->store_id==5?'selected':''}}> Noida</option>
		</select>
	</div>
	</div>
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
<button id="save" class="btn btn-primary" type="submit">Save</button>
</div>	 
</form>	 
