@extends('layouts.plane')
@section('body')
<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
@include('layouts.messages',['title'=>'Discount','path'=>['#'=>'Discount']])
        </div>    
     @if($ordTypes)
		 @foreach($ordTypes as $ordTyp)
		<?php $oTyps[$ordTyp->id]=$ordTyp->name; ?>
		@endforeach
	 @endif
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <div class="row">
                                <div class="col-sm-8">
                                  
                                </div>
                                <div class="col-sm-4">
                                    <a href="javascript:void(0)" class="btn btn-default btn-md waves-effect waves-light m-b-30 pull-right" onclick="add();"><i class="md md-add"></i> Add Discount</a>
                                </div>
                            </div>
                            <div class="table-responsive">
							 @if(count($list)>0)  
							
                                <table class="table table-hover mails m-0 table table-actions-bar">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Discount Name</th>
										<th>Type</th>
										<th>Amount</th>
										<th>Order Types</th>
										<th>Discount Days</th>
										<th>Discount Categories</th>
										<th>Discount Items</th>
										<th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>

                                    <tbody>
									
									 @foreach($list as $key=>$data)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$data->name}}</td>
                                        <td>{{$data->type}}</td>
										<td>{{$data->amount?$data->amount:'Open Amount'}}</td>
										<td>@if($data->ord_typ_id)
											@foreach($data->ord_typ_id as $ord_id)
											@if($ord_id !=0)
											<span class="badge">{{$oTyps[$ord_id]}}</span>&nbsp;&nbsp;
											@endif
											@endforeach
											@endif
										</td>
                                        <td>
										@if($data->discount_days)
										@foreach($data->discount_days as $day)
											<span class="badge">{{$days[$day]['value']}}</span>&nbsp;&nbsp;
											@endforeach
										@else
											<span class="badge">All Days</span>&nbsp;&nbsp;
										@endif
										</td>
										<td>
										@if($data->categories)
										@foreach($data->categories as $cat)
									<span class="badge">{{$cat}}</span>&nbsp;&nbsp;
									@endforeach
									@else
										NA
									@endif
										</td>
										<td>NA</td>
                                        <td>
									@if($data->status=='enable')
										<input type="checkbox" checked data-plugin="switchery" data-color="#5d9cec" data-size="small" data-id="{{$data->id}}" class="status" onchange="status(this);"/>
									@else
										<input type="checkbox" data-plugin="switchery" data-color="#5d9cec" data-size="small" data-id="{{$data->id}}" class="status" onchange="status(this);"/>
									@endif
										</td>
                                        <td>
                                            <a href="javascript:void(0)" class="table-action-btn" onclick="edit('{{$data->id}}');"><i class="md md-edit"></i></a>
                                      
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
	<h4 class="modal-title">Add Discount</h4>
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
	</div>
	<div class="modal-body">		

{!! Form::open(array('url' => '#',"id"=>"add",'onsubmit'=>"savedata();return false;")) !!}
<div class="panel panel-default">
<div class="panel-body panel-body-nopadding">
	<div class="row">
	<div class="col-sm-8">
	<div class="form-group row">
	<label class="col-4 col-form-label">Discount Type</label>
	<div class="col-8">
	<input name="disc_type" value="" type="hidden"><label style="padding:10px" for="disc-type-open"><input name="disc_type" value="Open" id="disc-type-open" required="required" onclick="discType(this);" type="radio">  Open Discount</label><label style="padding:10px" for="disc-type-close"><input name="disc_type" value="Close" id="disc-type-close" required="required" onclick="discType(this);" type="radio">  Close Discount</label>
	</div>
	
	</div>
	<div class="form-group row"><label class="col-4 col-form-label">Discount Name</label><div class="col-8"><input name="name" class="form-control" required="required" id="name" type="text"></div></div>
	
	<div class="form-group row"><label class="col-4 col-form-label">Discount Amount Type</label>
	<div class="col-8">
	<label style="padding:10px" class="selected" for="type-value"><input name="type" value="value" id="type-value" checked="checked" required="required" type="radio">  Flat Value</label><label style="padding:10px" for="type-percentage"><input name="type" value="percentage" id="type-percentage" required="required" type="radio">  Percentage</label>
	</div>
	</div>
	<div class="form-group row">
	<label class="col-4 col-form-label">Discount amount </label><div class="col-8"><input name="amount" class="form-control" required="required" id="amount" type="text"></div>	</div>
	<div class="form-group row">
	<label class="col-4 col-form-label">Discount Span</label>
	<div class="col-8">
	<label style="padding:10px" class="selected" for="discount-on-all"><input name="discount_on" value="all" id="discount-on-all" checked="checked" required="required" onclick="selectSpan(this);" type="radio">  Order Value</label><label style="padding:10px" for="discount-on-category"><input name="discount_on" value="category" id="discount-on-category" required="required" onclick="selectSpan(this);" type="radio">  On Categories</label><label style="padding:10px" for="discount-on-item"><input name="discount_on" value="item" id="discount-on-item" required="required" onclick="selectSpan(this);" type="radio">  On Items</label>	<button id="disc_spans" class="btn btn-primary col-sm-offset-4 hide" type="button" onclick="showPopup();">Select Categories</button>
	</div>
	</div>
	
	
	<div class="form-group row">
	<label class="col-4 col-form-label">Scheduled</label>
	<div class="col-8">
	<label style="padding:10px" for="schedule-yes">
	<input name="schedule" value="Yes" id="schedule-yes" required="required" onclick="scheType(this,'scheduled');" type="radio">  Yes</label>
	<label style="padding:10px" class="selected" for="schedule-no"><input name="schedule" value="No" id="schedule-no" checked="checked" required="required" onclick="scheType(this,'scheduled');" type="radio"> No</label>	
	</div>
	</div>
	
	<div class="hide" id="scheduled">
	<div class="form-group row">
	<h4>Discount Schedule</h4>
	<div class="col-sm-offset-4">
			<div class="ckbox ckbox-primary" style="float: left;margin-right: 15px;">
			<input name="discount_days[]" value="1" id="day_checkbox1" type="checkbox">
			<label for="day_checkbox1">S</label>
		 </div>
				<div class="ckbox ckbox-primary" style="float: left;margin-right: 15px;">
			<input name="discount_days[]" value="2" id="day_checkbox2" type="checkbox">
			<label for="day_checkbox2">M</label>
		 </div>
				<div class="ckbox ckbox-primary" style="float: left;margin-right: 15px;">
			<input name="discount_days[]" value="3" id="day_checkbox3" type="checkbox">
			<label for="day_checkbox3">T</label>
		 </div>
				<div class="ckbox ckbox-primary" style="float: left;margin-right: 15px;">
			<input name="discount_days[]" value="4" id="day_checkbox4" type="checkbox">
			<label for="day_checkbox4">W</label>
		 </div>
				<div class="ckbox ckbox-primary" style="float: left;margin-right: 15px;">
			<input name="discount_days[]" value="5" id="day_checkbox5" type="checkbox">
			<label for="day_checkbox5">TH</label>
		 </div>
		<div class="ckbox ckbox-primary" style="float: left;margin-right: 15px;">
			<input name="discount_days[]" value="6" id="day_checkbox6" type="checkbox">
			<label for="day_checkbox6">F</label>
		 </div>
				<div class="ckbox ckbox-primary" style="float: left;margin-right: 15px;">
			<input name="discount_days[]" value="7" id="day_checkbox7" type="checkbox">
			<label for="day_checkbox7">S</label>
		 </div>
			</div>	
	</div>
	<div class="form-group row">
	
	<div class="col-sm-6" style="float:left">
	<label >From Date </label>
	<div class="bootstrap-timepicker">
	<input name="from_date" class="form-control hasDatepicker" id="from-date" type="text"></div>
	</div>
	<div class="col-sm-6" style="float:left">
	<label>To Date </label>
	<div class=" bootstrap-timepicker"><input name="to_date" class="form-control hasDatepicker" id="to-date" type="text">
	</div>	
	</div>	
	</div>
	<div class="form-group row">
	<div class="col-sm-6" style="float:left">
	<label class=" control-label">From Time </label>
	<div class="bootstrap-timepicker">
	<input name="from_time" class="form-control time" id="from-time" type="text">
	</div>	
	</div>
<div class="col-sm-6" style="float:left">	
	<label class="control-label">To Time </label>
	<div class=" bootstrap-timepicker"><input name="to_time" class="form-control time" id="to-time" type="text">
	</div>	
	</div>
	</div>
	
	</div>
	</div>
	
	<div class="col-sm-4">
		<h4>Enable For</h4>
		<div class="form-group">
		@if($ordTypes)
		<div class="ckbox ckbox-primary">
			<input name="ord_typ_id[]" value="0" id="checkbox0" onclick="checkAll(this);" type="checkbox">
			<label for="checkbox0">All Order Type</label>
		</div>
		@foreach($ordTypes as $ordTyp)
		<div class="ckbox ckbox-primary">
			<input name="ord_typ_id[]" value="{{$ordTyp->id}}" id="checkbox{{$ordTyp->id}}" type="checkbox">
			<label for="checkbox{{$ordTyp->id}}">{{$ordTyp->name}}</label>
		 </div>
		@endforeach
		@endif 
				
	</div>
		<div id="msg"></div>
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
 
 <div class="modal" id="disc_span_popup" tabindex="-1" role="dialog">
  <div class="modal-dialog  modal-lg" role="document">
    <div  class="modal-content">
	<div class="modal-header">
		<h4 class="modal-title"></h4>
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		 
	</div>
	<div class="modal-body"> 
	
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button id="disc_save" class="btn btn-primary" type="button" data-dismiss="modal">Ok</button>
	</div>
	</div>
     </div>
  </div> 
 
  <div class="modal" id="edit_popup" tabindex="-1" role="dialog">
  <div class="modal-dialog  modal-lg" role="document">
    <div  class="modal-content">
	<div class="modal-header">
	 <h4 class="modal-title">Edit Discount</h4>
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		
	</div>
	<div class="modal-body"> 
		
	</div>
	</div>
     </div>
  </div>
  
 
 
 <script src="{{ asset('assets/plugins/switchery/js/switchery.min.js')}}"></script>
 <script src="https://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<link rel="stylesheet" href="{{ ('assets/plugins/timepicker/bootstrap-timepicker.min.css')}}" /> 

<link rel="stylesheet" href="{{ ('assets/plugins/switchery/css/switchery.min.css')}}" />
<script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{ asset('assets/plugins/timepicker/bootstrap-timepicker.js')}}"></script>
<link type="text/css" rel="stylesheet" href="{{ asset('assets/plugins/tree/jqtree.css')}}">
<script src="{{ asset('assets/plugins/tree/tree.jquery.js')}}"></script>

<script>
var siteurl='<?php echo url('/');?>';
var editpop=false;
$(function(){
	$('.time').timepicker({
		minuteStep: 15,
		icons: {
			up: 'md md-expand-less',
			down: 'md md-expand-more'
		}});	
	var dateFormat = "mm/dd/yyyy";
	var fromd =$('#from-date').datepicker({ minDate:0}).on( "change", function() {
          tod.datepicker( "option", "minDate", getDate( this ) );
        });
	var tod =$('#to-date').datepicker().on( "change", function() {
        fromd.datepicker( "option", "maxDate", getDate( this ) );
      });
	function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate(dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
      return date;
    };
	
	$('#disc_span_popup').on('hidden.bs.modal', function (e) {
		$('#disc_span_popup').modal('hide');
		if(editpop==true){
			$('#edit_popup').modal('show');
		}else{
			$('#add_popup').modal('show');
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
			url:siteurl+'/discount/change-discount-status',
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
function add(){
	$('#add_popup .modal-title').html('Add Discount');
	$('#add_popup').modal('show');
}

function savedata(){
	var form=$('#add')[0];
	var formData = new FormData(form);
	if($('#add input[name="discount_on"]:checked').val()=='category'){
		var categories = [];
		$.each($("input[name='category_id[]']:checked"), function(){     if($(this).val()!=0){     
				categories.push($(this).val());
			}
		});
		formData.append('categories',categories);
	}else if($('#add input[name="discount_on"]:checked').val()=='item'){
		var items = [];
		$.each($("input[name='item_id[]']:checked"), function(){      
			if($(this).val()!=0){     
				items.push($(this).val());
			}
		});
		formData.append('items',items);
	}
	$.ajax({
				method:'POST',
				url:siteurl+'/discount/save-discount',
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
						$('#msg').html(res.msg);
						window.location.href=siteurl+'/discount';
					}
					if(res.status=='error'){
						$('#msg').html('<span class="error-message">'+res.msg+'</span>');
					}
				}
			});
}

function edit(id){
	//$('#loader').removeClass('hide');
	$.get(siteurl+'/discount/edit/'+id,function(data){
			$('#loader').addClass('hide');
			$('#edit_popup .modal-body').html(data);
			$('#edit_popup').modal('show');
			$('[data-toggle="tooltip"]').tooltip({html:true});
			$('.time').timepicker({minuteStep: 15,
									icons: {
										up: 'md md-expand-less',
										down: 'md md-expand-more'
									}});
			var dateFormat = "mm/dd/yyyy";
			var fromd =$('#from-date-1').datepicker({ minDate:0}).on( "change", function() {
				  tod.datepicker( "option", "minDate", getDate( this ) );
				});
			var tod =$('#to-date-1').datepicker().on( "change", function() {
				fromd.datepicker( "option", "maxDate", getDate( this ) );
			  });
			function getDate( element ) {
			  var date;
			  try {
				date = $.datepicker.parseDate(dateFormat, element.value );
			  } catch( error ) {
				date = null;
			  }
			  return date;
			};
	});
}

function editdata(){
	var form=$('#edit')[0];
	var formData = new FormData(form);
	if($('#edit input[name="discount_on"]:checked').val()=='category'){
		var categories = [];
			$.each($("input[name='category_id[]']:checked"), function(){ if($(this).val()!=0){     
				categories.push($(this).val());
			}
		});
		formData.append('categories',categories);
	}else if($('#edit input[name="discount_on"]:checked').val()=='item'){
		var items = [];
		$.each($("input[name='item_id[]']:checked"), function(){      
			if($(this).val()!=0){      
				items.push($(this).val());
			}
		});
		formData.append('items',items);
	}
	$.ajax({
				method:'POST',
				url:siteurl+'/discount/save-edit-discount',
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
						window.location.href=siteurl+'/discount';
					}
					if(res.status=='error'){
						$('#edit-msg').html('<span class="error-message">'+res.msg+'</span>');
					}
				}
			});
}

function checkAll(obj){
	if($(obj).prop("checked") == true){
         $('input[name="ord_typ_id[]"]').prop('checked', true);   
	}
	else if($(obj).prop("checked") == false){
		$('input[name="ord_typ_id[]"]').prop('checked', false);
	}
}
function discType(obj){
	if($(obj).val()=='Open'){
		$('#amount').val('');
		$('#amount').attr('disabled',true);
		$('#amount_1').val('');
		$('#amount_1').attr('disabled',true);
	}else{
		$('#amount').attr('disabled',false);
		$('#amount_1').attr('disabled',false);
	}
}
function scheType(obj,$elm){
	if($(obj).val()=='Yes'){
		$('#'+$elm).removeClass('hide');
	}else{
		$('#'+$elm).addClass('hide');
	}
}

function selectSpan(obj){
	//var spn=$(obj).val();
	var spn=$('#add input[name="discount_on"]:checked').val();
	//alert(spn);
	editpop=false;
	if(spn=='category'){
		$('#disc_span_popup .modal-body').html('<div id="tree" style="height:300px;overflow-y: auto;margin-left: 50px;"><i class="fa fa-spinner fa-spin"></i></div>');
		$('#disc_span_popup .modal-title').html('Select category');
		var $tree=$('#tree');
		$tree.tree({
			dataUrl: siteurl+'/discount/get-categories',
			autoOpen: true,
			selectable: true,
			onCreateLi: function(node, $li, is_selected) {
				$li.find('.jqtree-title').before('<input id="cat'+node.id+'" class="cat-input" type="checkbox" name="category_id[]" value="'+node.id+'">');
			}
		});
	  $tree.on('tree.click',function(e) {
            e.preventDefault();
            var selected_node = e.node;
            if (selected_node.id == undefined) {
                //console.log('The multiple selection functions require that nodes have an id');
            }
            if ($tree.tree('isNodeSelected', selected_node)) {
                $tree.tree('removeFromSelection', selected_node);
				$('#cat'+selected_node.id).attr('checked',false);
            }else{
                $tree.tree('addToSelection',selected_node);
				$('#cat'+selected_node.id).attr('checked',true);
            }
        });
		$('#disc_spans').html('Select category').removeClass('hide');
		//$('#disc_span_popup').modal('show');
		//$('#add_popup').modal('hide');
	}else if(spn=='item'){
		$.get(siteurl+'/discount/get-items',function(data){
			$('#disc_span_popup .modal-body').html(data);
			$('#disc_span_popup .modal-title').html('Select Items');
			$('#disc_spans').html('Select Items').removeClass('hide');
			//$('#disc_span_popup').modal('show');
			//$('#add_popup').modal('hide');
		});
	}else{
		$('#disc_spans').addClass('hide');
	}
}

function selectSpanEdit(obj){
	var spn=$('#edit input[name="discount_on"]:checked').val();
	if(spn=='category'){
		$('#disc_span_popup .modal-body').html('<div id="tree" style="height:300px;overflow-y: auto;margin-left: 50px;"><i class="fa fa-spinner fa-spin"></i></div>');
		$('#disc_span_popup .modal-title').html('Select category');
		var $tree=$('#tree');
		$tree.tree({
			dataUrl: siteurl+'/discount/get-categories',
			autoOpen: true,
			selectable: true,
			onCreateLi: function(node, $li, is_selected) {
				var s = selectedCats.indexOf(node.id);
				if(s==-1){
					$li.find('.jqtree-title').before('<input id="cat'+node.id+'" class="cat-input" type="checkbox" name="category_id[]" value="'+node.id+'">');
				}else{
					$li.find('.jqtree-title').before('<input id="cat'+node.id+'" class="cat-input" type="checkbox" name="category_id[]" value="'+node.id+'" checked="checked">');
					$li.addClass('jqtree-selected');
					$li.attr('aria-selected',true);
					$tree.tree('addToSelection',node);
				}
			}
		});
	  $tree.on('tree.click',function(e) {
            e.preventDefault();
            var selected_node = e.node;
            if (selected_node.id == undefined) {
                //console.log('The multiple selection functions require that nodes have an id');
            }
            if ($tree.tree('isNodeSelected', selected_node)) {
                $tree.tree('removeFromSelection', selected_node);
				$('#cat'+selected_node.id).attr('checked',false);
            }else{
                $tree.tree('addToSelection',selected_node);
				$('#cat'+selected_node.id).attr('checked',true);
            }
        });
		$('#disc_spans_edit').html('Select category').removeClass('hide');
			editpop=true;
		//$('#disc_span_popup').modal('show');
		//$('#add_popup').modal('hide');
	}else if(spn=='item'){
		$.get(siteurl+'/discount/get-items',function(data){
			$('#disc_span_popup .modal-body').html(data);
			$('#disc_span_popup .modal-title').html('Select Items');
			$('#disc_spans_edit').html('Select Items').removeClass('hide');
			editpop=true;
			if(selectedItems){
				$.each(selectedItems,function(index, value){
					$('input.item[value="' + value + '"]').attr('checked', 'checked');
				});
			}
			//$('#disc_span_popup').modal('show');
			//$('#add_popup').modal('hide');
		});
	}else{
		$('#disc_spans_edit').addClass('hide');
	}
}
function showPopup(){
	$('#disc_span_popup').modal('show');
	$('#add_popup').modal('hide');
	$('#edit_popup').modal('hide');
}
</script> 
 <!-- Modal -->
@stop
