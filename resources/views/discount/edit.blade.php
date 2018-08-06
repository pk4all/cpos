{!! Form::open(array('url' => '#',"id"=>"edit",'onsubmit'=>"editdata();return false;")) !!}
	 {!! Form::hidden('id',$discount->id) !!}
<div class="panel panel-default">
<div class="panel-body panel-body-nopadding">
	<div class="row">
	<div class="col-sm-8">
	<div class="form-group">
	<label class="col-sm-12 control-label">Discount Type</label>
	<div>
	<label style="padding:10px" for="disc-type-open"><input name="disc_type" value="Open" id="disc-type-open" required="required" onclick="discType(this);" type="radio" {{$discount->disc_type=='Open'?'checked':''}} >  Open Discount</label><label style="padding:10px" for="disc-type-close"><input name="disc_type" value="Close" id="disc-type-close" required="required" onclick="discType(this);" type="radio" {{$discount->disc_type=='Close'?'checked':''}}>  Close Discount</label>
	</div>
	
	</div>
	<div class="form-group"><label class="col-sm-12 control-label">Discount Name</label><div class="col-sm-8"><input name="name" class="form-control" required="required" id="name" type="text" value="{{$discount->name}}"></div></div>
	
	<div class="form-group"><label class="col-sm-12 control-label">Discount Amount Type</label>
	<div>
	<label style="padding:10px" class="selected" for="type-value"><input name="type" value="value" id="type-value" required="required" type="radio" {{$discount->type=='value'?'checked':''}}>  Flat Value</label><label style="padding:10px" for="type-percentage"><input name="type" value="percentage" id="type-percentage" required="required" type="radio" {{$discount->type=='percentage'?'checked':''}}>  Percentage</label>
	</div>
	</div>
	<div class="form-group">
	<label class="col-sm-12 control-label">Discount amount </label><div class="col-sm-8"><input name="amount" class="form-control" required="required" id="amount_1" type="text" value="{{$discount->amount}}" {{$discount->disc_type=='Open'?'disabled':''}}></div>	</div>
	<div class="form-group">
	<label class="col-sm-12 control-label">Discount Span</label>
	<div>
	<label style="padding:10px" class="selected" for="discount-on-all"><input name="discount_on" value="all" id="discount-on-all" required="required" onclick="selectSpanEdit(this);" type="radio" {{$discount->discount_on=='all'?'checked':''}}>  Order Value</label><label style="padding:10px" for="discount-on-category"><input name="discount_on" value="category" id="discount-on-category" required="required" onclick="selectSpanEdit(this);" type="radio" {{$discount->discount_on=='category'?'checked':''}}>  On Categories</label><label style="padding:10px" for="discount-on-item"><input name="discount_on" value="item" id="discount-on-item" required="required" onclick="selectSpanEdit(this);" type="radio" {{$discount->discount_on=='item'?'checked':''}}>  On Items</label>	<button id="disc_spans_edit" class="btn btn-primary col-sm-offset-4 hide" type="button" onclick="showPopup();">Select Categories</button>
	</div>
	</div>
	<div class="form-group">
	<label class="col-sm-12 control-label">Scheduled</label>
	<div>
	<label style="padding:10px" for="schedule-yes">
<input name="schedule" value="Yes" id="schedule-yes" required="required" onclick="scheType(this,'scheduled-1');" type="radio" {{$discount->schedule=='Yes'?'checked':''}} > Yes</label>
	<label style="padding:10px" class="selected" for="schedule-no"><input name="schedule" value="No" id="schedule-no"  required="required" onclick="scheType(this,'scheduled-1');" type="radio" {{$discount->schedule=='No'?'checked':''}}> No</label>	
	</div>
	</div>
	
	<div class="{{$discount->schedule=='No'?'hide':''}}" id="scheduled-1">
	<div class="form-group">
	<h4>Discount Schedule</h4>
	<div class="col-sm-offset-4">
			<div class="ckbox ckbox-primary" style="float: left;margin-right: 15px;">
			<input name="discount_days[]" value="1" id="eday_checkbox1" type="checkbox" @if ($discount->discount_days && in_array(1, $discount->discount_days)) checked @endif >
			<label for="eday_checkbox1">S</label>
		 </div>
				<div class="ckbox ckbox-primary" style="float: left;margin-right: 15px;">
			<input name="discount_days[]" value="2" id="eday_checkbox2" type="checkbox" @if ($discount->discount_days && in_array(2, $discount->discount_days)) checked @endif>
			<label for="eday_checkbox2">M</label>
		 </div>
				<div class="ckbox ckbox-primary" style="float: left;margin-right: 15px;">
			<input name="discount_days[]" value="3" id="eday_checkbox3" type="checkbox" @if ($discount->discount_days && in_array(3, $discount->discount_days)) checked @endif>
			<label for="eday_checkbox3">T</label>
		 </div>
				<div class="ckbox ckbox-primary" style="float: left;margin-right: 15px;">
			<input name="discount_days[]" value="4" id="eday_checkbox4" type="checkbox" @if ($discount->discount_days && in_array(4, $discount->discount_days)) checked @endif>
			<label for="eday_checkbox4">W</label>
		 </div>
				<div class="ckbox ckbox-primary" style="float: left;margin-right: 15px;">
			<input name="discount_days[]" value="5" id="eday_checkbox5" type="checkbox" @if ($discount->discount_days && in_array(5, $discount->discount_days)) checked @endif>
			<label for="eday_checkbox5">TH</label>
		 </div>
		<div class="ckbox ckbox-primary" style="float: left;margin-right: 15px;">
			<input name="discount_days[]" value="6" id="eday_checkbox6" type="checkbox" @if ($discount->discount_days && in_array(6, $discount->discount_days)) checked @endif>
			<label for="eday_checkbox6">F</label>
		 </div>
				<div class="ckbox ckbox-primary" style="float: left;margin-right: 15px;">
			<input name="discount_days[]" value="7" id="eday_checkbox7" type="checkbox" @if ($discount->discount_days && in_array(7, $discount->discount_days)) checked @endif>
			<label for="eday_checkbox7">S</label>
		 </div>
			</div>	
	</div>
	<div class="form-group">
	
	<div class="col-sm-6" style="float:left">
	<label >From Date </label>
	<div class="bootstrap-timepicker">
	<input name="from_date" class="form-control hasDatepicker" id="from-date-1" type="text" value="{{$discount->from_date}}"></div>
	</div>
	<div class="col-sm-6" style="float:left">
	<label>To Date </label>
	<div class=" bootstrap-timepicker"><input name="to_date" class="form-control hasDatepicker" id="to-date-1" type="text" value="{{$discount->to_date}}">
	</div>	
	</div>	
	</div>
	<div class="form-group">
	<div class="col-sm-6" style="float:left">
	<label class=" control-label">From Time </label>
	<div class="bootstrap-timepicker">
	<input name="from_time" class="form-control time" id="from-time-1" type="text" value="{{$discount->from_time}}">
	</div>	
	</div>
<div class="col-sm-6" style="float:left">	
	<label class="control-label">To Time </label>
	<div class=" bootstrap-timepicker"><input name="to_time" class="form-control time" id="to-time-1" type="text" value="{{$discount->to_time}}">
	</div>	
	</div>
	</div>
	
	</div>
	</div>
	
	<div class="col-sm-4">
		<h4>Enable For</h4>
		<div class="form-group">
		<div class="ckbox ckbox-primary">
			<input name="ord_typ_id[]" value="0" id="echeckbox0" onclick="checkAll(this);" type="checkbox">
			<label for="echeckbox0">All Order Type</label>
		</div>
				<div class="ckbox ckbox-primary">
			<input name="ord_typ_id[]" value="1" id="echeckbox1" type="checkbox" @if ($discount->ord_typ_id && in_array(1, $discount->ord_typ_id)) checked @endif >
			<label for="echeckbox1">Delivery</label>
		 </div>
				<div class="ckbox ckbox-primary">
			<input name="ord_typ_id[]" value="2" id="echeckbox2" type="checkbox" @if ($discount->ord_typ_id && in_array(2, $discount->ord_typ_id)) checked @endif>
			<label for="echeckbox2">Dine-In</label>
		 </div>
				<div class="ckbox ckbox-primary">
			<input name="ord_typ_id[]" value="3" id="echeckbox3" type="checkbox" @if ($discount->ord_typ_id && in_array(3, $discount->ord_typ_id)) checked @endif>
			<label for="echeckbox3">Take Away</label>
		 </div>
				<div class="ckbox ckbox-primary">
			<input name="ord_typ_id[]" value="4" id="echeckbox4" type="checkbox" @if ($discount->ord_typ_id && in_array(4, $discount->ord_typ_id)) checked @endif>
			<label for="echeckbox4">Online-Order</label>
		 </div>
	</div>
		<div id="edit-msg"></div>
	</div>
	
	</div>
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
<button id="saveEdit" class="btn btn-primary" type="submit">Save</button>
</div>
</form>	
<?php 
if($discount->categories){
		foreach($discount->categories as $cat){
			$catArr[]=(int)$cat;
		}
	}else{
		$catArr=[];
	}
if($discount->items){
		foreach($discount->items as $item){
			$itemsArr[]=(int)$item;
		}
	}else{
		$itemsArr=[];
	}	
?>
<script>
var selectedCats=<?php echo json_encode($catArr);?>;
var selectedItems=<?php echo json_encode($itemsArr);?>;
$(function(){
	<?php if($discount->discount_on=='category' || $discount->discount_on=='item'){?>
		selectSpanEdit();
	<?php }?>
});
 </script>
