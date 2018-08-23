@extends('posLayouts.pos')
@section('body')

        <div class="container text-center" id="customer">
            <div class="numberbox">
                <h3>CUSTOMER PHONE NUMBER</h3>
		<form id="customer_form" class="form-horizontal" action="/" onsubmit="findCustomer(); return false;">
                    <input id="cphone" type="tel" placeholder="Phone Number" name="phone" required="required">
                <button type="submit">Get Customer Details</button>
		</form>
            </div>
        </div>

  <div class="container text-center userlogin-page">
      <!-- ko if: customer() --> 
            <div class="whitebox" data-bind="with:customer()">
                <div class="dropdown pull-right">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="javascript:void(0);" data-bind="click:$parent.editCustomer">Edit</a></li>
                        <li><a href="javascript:void(0);" data-bind="click:$parent.blockCustomer">Block</a></li>
                    </ul>
                </div>
                <h4>Customer Details</h4>
                <h2 data-bind="text:name">Andrew Smith </h2>
                <p><strong>Mobile :</strong><span data-bind="text:phone">97105723456</span></p>
                <p><strong>Address :</strong> <span data-bind="text:apartment_no+', '+street_no+', '+street_name+'-'+city">West Cluster, Fayha Circle &nbsp;- Jumeirah Heights</span></p>
                <p><strong>Country :</strong> <span>Dubai</span></p>
            </div>
     <!-- /ko -->
<!-- ko if: store() --> 
      <div class="whitebox">
          <div data-bind="with:store()">
                <h4>Store Details</h4>
                <h2 data-bind="text:name">Dubai Marina</h2>
                <p class="address">
                <address data-bind="text:address.label+', '+address.city +', '+address.state+', '+address.country+', '+address.zip_code"> 
                    G05, West Avenue Bldg Dubai Marina, Dubai, UAE </address>
                <abbr title="Phone">P:</abbr> <span data-bind="text:phone">800 NKD</span></p>
          </div>
          <!-- ko if: orderTypes().length>0 --> 
            <div data-bind="foreach:orderTypes"> 
                <button data-bind="text:$data.name,click:$parent.chkOrderType" class="green-btn">Pickup</button>
            </div>
          <!-- /ko -->
       </div>
      <!-- /ko -->
      
            <div id="change-customer" class="whitebox hide">
                <button class="red-btn" onclick="changeCustomer();">Change Customer</button>
            </div>
        </div>
        
<!-----Modals---->
<div id="add-new-customer" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
	<div class="modal-content">
	<div class="modal-header"> 
	<h4 class="modal-title">Add New Customer</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
	</div>
	<form id="new_customer" action="/" method="post" onsubmit="saveCustomer(); return false;">
            <div class="modal-body" >
	<div class="row">
	<div class="col-md-6">
	<div class="form-group">
	<label for="name" class="control-label">Name</label>
        <input type="text" class="form-control" name="name" id="name" required="" placeholder="Name" >
	</div>
	</div>
	<div class="col-md-6">
	<div class="form-group">
	<label for="phone" class="control-label" >Phone Number</label>
        <input type="text" class="form-control" name="phone" id="phone" required="" placeholder="Phone Number" data-bind="value:phone();">
	</div>
	</div>
	</div>
	
	<div class="row hide">
	<div class="col-md-6 hide">
	<div class="form-group">
	<label for="sname" class="control-label">Surname</label>
	<input type="text" class="form-control" name="sur_name" id="sname" placeholder="Doe">
	</div>
	</div>
	
	<div class="col-md-6 hide">
	<div class="form-group">
	<label for="email" class="control-label" >Email</label>
	<input type="email" class="form-control" name="email" id="email"  placeholder="Email">
	</div>
	</div>
	</div>
	<div class="row hide">
	<h5>Customer Address</h5>
	</div>
	
	<div class="row">
	<div class="col-md-6">
	<div class="form-group">
	<label for="city" class="control-label">City/Postal Code</label>
	<input type="text" class="form-control" name="city" id="city" required="" placeholder="City/Postal Code" >
	</div>
	</div>
	<div class="col-md-6">
	<div class="form-group">
	<label for="apartment_no" class="control-label">Apartment Number</label>
	<input type="text" class="form-control" name="apartment_no" id="apartment_no" placeholder="Apartment Number" >
	</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-6">
	<div class="form-group">
	<label for="street_no" class="control-label">Street Number</label>
	<input type="text" class="form-control" name="street_no" id="street_no" placeholder="Street Number" >
	</div>
	</div>
	<div class="col-md-6">
	<div class="form-group">
	<label for="street_no" class="control-label">Street/Building Name</label>
	<input type="text" class="form-control" name="street_name" id="street_name" placeholder="Street/Building Name" >
	</div>
	</div>
	</div>
	</div>
	<div class="modal-footer">
	<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
        
	<button id="save" type="submit" data-loading-text='Saving...' class="btn btn-info waves-effect waves-light">Add Customer</button>
       
       
	</div>
            <div class="alert-danger"></div>    
	</form>
	</div>
	</div>
</div>
<div id="edit-customer" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
	<div class="modal-content">
	<div class="modal-header">
          <h4 class="modal-title">Edit Customer</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
	</div>
	<form id="edit_customer" action="/" method="post" onsubmit="saveEditCustomer(); return false;">
            <div class="modal-body" data-bind="with:customer()">
	<div class="row">
	<div class="col-md-6">
	<div class="form-group">
	<label for="name" class="control-label">Name</label>
        <input type="text" class="form-control" name="name" id="name" required="" placeholder="Name" data-bind="value:name">
	</div>
	</div>
	<div class="col-md-6">
	<div class="form-group">
	<label for="phone" class="control-label" >Phone Number</label>
	<input type="text" class="form-control" name="phone" id="phone" required="" placeholder="Phone Number" data-bind="value:phone;">
	</div>
	</div>
	</div>
	
	<div class="row hide">
	<div class="col-md-6 hide">
	<div class="form-group">
	<label for="sname" class="control-label">Surname</label>
	<input type="text" class="form-control" name="sur_name" id="sname" placeholder="Doe">
	</div>
	</div>
	
	<div class="col-md-6 hide">
	<div class="form-group">
	<label for="email" class="control-label" >Email</label>
	<input type="email" class="form-control" name="email" id="email"  placeholder="Email">
	</div>
	</div>
	</div>
	<div class="row hide">
	<h5>Customer Address</h5>
	</div>
	
	<div class="row">
	<div class="col-md-6">
	<div class="form-group">
	<label for="city" class="control-label">City/Postal Code</label>
	<input type="text" class="form-control" name="city" id="city" required="" placeholder="City/Postal Code" data-bind="value:city">
	</div>
	</div>
	<div class="col-md-6">
	<div class="form-group">
	<label for="apartment_no" class="control-label">Apartment Number</label>
	<input type="text" class="form-control" name="apartment_no" id="apartment_no" placeholder="Apartment Number" data-bind="value:apartment_no">
	</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-6">
	<div class="form-group">
	<label for="street_no" class="control-label">Street Number</label>
	<input type="text" class="form-control" name="street_no" id="street_no" placeholder="Street Number" data-bind="value:street_no">
	</div>
	</div>
	<div class="col-md-6">
	<div class="form-group">
	<label for="street_no" class="control-label">Street/Building Name</label>
	<input type="text" class="form-control" name="street_name" id="street_name" placeholder="Street/Building Name" data-bind="value:street_name">
	</div>
	</div>
	</div>
	</div>
	<div class="modal-footer">
	<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
      
	<button id="edit" type="submit" data-loading-text='Saving...' class="btn btn-info waves-effect waves-light">Edit Customer</button>
      
	</div>
            <div class="alert-danger"></div>
	</form>
	</div>
	</div>
</div>
<!-- /.modals -->
 <link href="{{asset('assets/plugins/sweet-alert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">
 <script src="{{asset('assets/plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
<script>
var crsf='{{ csrf_token()}}';
var siteurl='<?php echo url('/');?>';
var SweetAlert = function () {};
    function PosModel() {
        var self = this;
        self.customer=ko.observable();
        self.store=ko.observable();
        self.actionMsg=ko.observable();
	self.phone=ko.observable(false);
        self.orderTypes=ko.observableArray(0);
        self.chkOrderType=function(type){
            $.ajax({
                method:'POST',
                url:siteurl+'/order',
                data:{'_token':crsf,'ordertype':type},
                dataType: "JSON",
                beforeSend:function(){
                        $('#loader').removeClass('hide');

                },
                success:function(res){
                        $('#loader').addClass('hide');
                        if(res.status==='success'){
                                window.location.href=siteurl+res.action;
                        }
                },
                statusCode: {
                        403: function() {
                          window.location.reload();
                        }
                  }
            });
        }
        self.editCustomer=function(data){
            self.customer(data);
            $('#edit-customer').modal('show');
        }
        self.blockCustomer=function(data){
            $.ajax({
                method:'POST',
                url:siteurl+'/block-customer',
                data:{'_token':crsf,'_id':data._id},
                dataType: "JSON",
                beforeSend:function(){
                       // $('#loader').removeClass('hide');
                },
                success:function(res){
                        //$('#loader').addClass('hide');
                        if(res.status==='success'){
                                pm.customer(false);
                                pm.store(false);
                                pm.orderTypes(false);
                                $('#customer').removeClass('hide');
                                $('#change-customer').addClass('hide');
                                swal('Customer has been blocked');
                        }
                },
                statusCode: {
                        403: function() {
                          window.location.reload();
                        }
                  }
        });
      }
    }
 var pm=new PosModel();
 
 function findCustomer(){
        var phone=$('#cphone').val();
        $.ajax({
                method:'POST',
                url:siteurl+'/customer',
                data:{'_token':crsf,'phone':phone},
                dataType: "JSON",
                beforeSend:function(){
                        //$('#loader').removeClass('hide');

                },
                success:function(res){
                        $('#loader').addClass('hide');
                        if(res.status==='blocked'){
                             swal({
                                 text:'This Customer is blocked',
                                 showCancelButton: true,
                                 confirmButtonText: 'Restore',
                                 cancelButtonText: 'Cancel'
                             }).then(function(){
                              $.ajax({
                                method:'POST',
                                url:siteurl+'/restore-customer',
                                data:{'_token':crsf,'_id':res.id},
                                dataType: "JSON",
                                beforeSend:function(){

                                },
                                success:function(res){
                                if(res.status=='success'){
                                    pm.customer(res.customer);
                                    pm.store(res.store);
                                    pm.orderTypes(res.orderTypes);
                                    $('#customer').addClass('hide');
                                    $('#change-customer').removeClass('hide');
                     swal('Restored!','Customer has been restored','success')
                                }
                               }
                           });  
                        });
                    }
                        if(res.status==='new'){
                                $('#new_customer')[0].reset();
                                $('#add-new-customer').modal('show');
                                pm.phone(res.phone);
                                pm.customer(false);
                                pm.store(false);
                                pm.orderTypes(false);
                            }
                        if(res.status==='success'){
                                $('#add-new-customer').modal('hide');
                                pm.customer(res.customer);
                                pm.store(res.store);
                                pm.orderTypes(res.orderTypes);
                                $('#customer').addClass('hide');
                                $('#change-customer').removeClass('hide');
                        }
                },
                statusCode: {
                        403: function() {
                          window.location.reload();
                        }
                  }
        });
    }
  var $btn;  
 function saveCustomer(){
	var form=$('#new_customer')[0];
	var formData = new FormData(form);
	formData.append('_token',crsf);
	$.ajax({
            method:'POST',
            url:siteurl+'/save-customer',
            dataType: "JSON",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            beforeSend:function(){
                    $btn = $('#save').button('loading');
                    $('.error-message').remove();
                    $('.alert-danger').html('');
            },
            success:function(res){
                    $btn.button('reset');
                    if(res.status==='success'){
                            $('#new_customer')[0].reset();
                            $('#add-new-customer').modal('hide');
                            pm.customer(res.customer);
                            pm.store(res.store);
                            pm.orderTypes(res.orderTypes);
                            $('#customer').addClass('hide');
			    $('#change-customer').removeClass('hide');
                    }
                    if(res.status==='error'){
                        $.each(res.errors, function(key, value){
                                $('.alert-danger').show();
                                $('.alert-danger').append('<p>'+value+'</p>');
                        });
                    }
            },
            statusCode: {
                    403: function() {
                      window.location.reload();
                    }
              }
	});
}

function saveEditCustomer(){
	var form=$('#edit_customer')[0];
	var formData = new FormData(form);
	formData.append('_token',crsf);
        if(pm.customer()){
            formData.append('_id',pm.customer()._id);
        }
	$.ajax({
            method:'POST',
            url:siteurl+'/save-edit-customer',
            dataType: "JSON",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            beforeSend:function(){
                    $btn = $('#edit').button('loading');
                    $('#edit-customer .error-message').remove();
                    $('#edit-customer .alert-danger').html('');
            },
            success:function(res){
                    $btn.button('reset');
                    if(res.status==='success'){
                            $('#edit_customer')[0].reset();
                            $('#edit-customer').modal('hide');
                            pm.customer(res.customer);
                            pm.store(res.store);
                            pm.orderTypes(res.orderTypes);
                            $('#customer').addClass('hide');
			    $('#change-customer').removeClass('hide');
                    }
                    if(res.status==='error'){
                        $.each(res.errors, function(key, value){
                                $('#edit-customer .alert-danger').show();
                                $('#edit-customer .alert-danger').append('<p>'+value+'</p>');
                        });
                    }
            },
            statusCode: {
                    403: function() {
                      window.location.reload();
                    }
              }
	});
}
function changeCustomer(){
    pm.customer(false);
    pm.store(false);
    $('#cphone').val('');
    $('#customer').removeClass('hide');
    $('#change-customer').addClass('hide');
}

ko.options.useOnlyNativeEvents = true;
ko.options.deferUpdates = true;
ko.applyBindings(pm);   
</script>		
@stop

