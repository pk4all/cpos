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
                        <li><a href="#">Edit</a></li>
                        <li><a href="#">Block</a></li>
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
      <div class="whitebox" data-bind="with:store()">
                <h4>Store Details</h4>
                <h2 data-bind="text:name">Dubai Marina</h2>
                <p class="address">
                <address data-bind="text:address.label+', '+address.city +', '+address.state+', '+address.country+', '+address.zip_code"> 
                    G05, West Avenue Bldg Dubai Marina, Dubai, UAE </address>
                <abbr title="Phone">P:</abbr> <span data-bind="text:phone">800 NKD</span></p>
                <button class="green-btn">Pickup</button>
                <button class="green-btn">Delievery</button>
            </div>
      <!-- /ko -->
      
            <div id="change-customer" class="whitebox hide">
                <button class="red-btn" onclick="changeCustomer();">Change Customer</button>
            </div>
        </div>
        
       



<div id="add-new-customer" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
	<div class="modal-content">
	<div class="modal-header">
	<h4 class="modal-title">Add New Customer</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
	</div>
	<form id="new_customer" action="/" method="post" onsubmit="saveCustomer(); return false;">
	<div class="modal-body">
	<div class="row">
	<div class="col-md-6">
	<div class="form-group">
	<label for="name" class="control-label">Name</label>
	<input type="text" class="form-control" name="name" id="name" required="" placeholder="Name">
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
	<input type="text" class="form-control" name="city" id="city" required="" placeholder="City/Postal Code">
	</div>
	</div>
	<div class="col-md-6">
	<div class="form-group">
	<label for="apartment_no" class="control-label">Apartment Number</label>
	<input type="text" class="form-control" name="apartment_no" id="apartment_no" placeholder="Apartment Number">
	</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-6">
	<div class="form-group">
	<label for="street_no" class="control-label">Street Number</label>
	<input type="text" class="form-control" name="street_no" id="street_no" placeholder="Street Number">
	</div>
	</div>
	<div class="col-md-6">
	<div class="form-group">
	<label for="street_no" class="control-label">Street/Building Name</label>
	<input type="text" class="form-control" name="street_name" id="street_name" placeholder="Street/Building Name">
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
</div><!-- /.modals -->

<script>
var crsf='{{ csrf_token()}}';
var siteurl='<?php echo url('/');?>';
    function PosModel() {
        var self = this;
        self.customer=ko.observable();
        self.store=ko.observable();
        self.actionMsg=ko.observable();
	self.phone=ko.observable(false);
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
                        $('#loader').removeClass('hide');

                },
                success:function(res){
                        $('#loader').addClass('hide');
                        if(res.status==='new'){
                                $('#new_customer')[0].reset();
                                $('#add-new-customer').modal('show');
                                pm.phone(res.phone);
                                pm.customer(false);
                                pm.store(false);
                            }
                        if(res.status==='success'){
                                $('#add-new-customer').modal('hide');
                                pm.customer(res.customer);
                                pm.store(res.store);
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

