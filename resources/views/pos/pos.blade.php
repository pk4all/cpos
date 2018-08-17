@extends('posLayouts.pos')
@section('body')

<div class="pickup-page">
    <div class="container-fluid">
        <?php $customer=session('customer');?>
        <div class="orderlists">
                    <h2><a href="javascript:void(0)" class="editbtn"><i class="fa fa-edit"></i></a>Order for {{$customer['name']}} ({{$customer['phone']}})</h2>
                    <div class="table-responsive itemlist">
                        <table class="table">
                            <thead>
                                <tr> 
                                    <th>Items</th>
                                    <th>Price</th>
                                    <th class="quantity">Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody data-bind="foreach:cartItems">
                                <tr>
                                    <td>
                                        <a class="action" href="#"><i class="fa fa-trash error"></i></a>
                                        <a class="action" href="#"><i class="fa fa-edit"></i></a>
                                        <p data-bind="text:$data.item.name">Grilled Chicken with Potato Mash</p>
                                    </td>
                                    <td data-bind="text:'AED '+$data.item.price"> 45.00</td>
                                    <td class="quantity">
                                        <button><i class="fa fa-plus"></i></button>
                                        <span>1</span>
                                        <button><i class="fa fa-minus"></i></button>
                                    </td>
                                    <td data-bind="text:'AED '+$data.item.price">AED 45.00</td>
                                </tr>
                              
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive calculation">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="count">Products count ( 0 )</td>
                                    <td>Sub Total</td>
                                    <td data-bind="text:'AED '+subCartValue()">AED 0.00</td>
                                </tr>
                                <tr>
                                    <td colspan="2">Discount on Cart</td>
                                    <td>AED 0.00</td>
                                </tr>
                                <tr>
                                    <td colspan="2">Shipping</td>
                                    <td>AED 0.00</td>
                                </tr>
                                <tr class="net">
                                    <td colspan="2">Net Payable</td>
                                    <td data-bind="text:'AED '+totalCartValue()">AED 0.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="btn-group">
                        <button data-bind="click:pay" type="button" class="btn btn-success">
                            <i class="fa fa-money"></i>
                            <span>Pay</span>
                        </button>
                        <button type="button" class="btn btn-warning">
                            <i class="fa fa-gift"></i>
                            <span>Discount</span>
                        </button>
                        <button type="button" class="btn btn-danger">
                            <i class="fa fa-refresh"></i>
                            <span>Cancel</span>
                        </button>
                    </div>

                </div>
        
        
         <!-- ko if: brands().length>0 -->
        <div class="categories_list">
            <ul data-bind="foreach:brands,brandCro">
                <li data-bind="attr:{class:$index()==0?'active':''},click:$parent.changeCats.bind($data, $index())"><a href="javascript:void(0)"><img data-bind="attr:{src:brandImgUrl+$data.logo}" src="{{ asset('assets/images/order/brand-bunfire.png')}}"></a></li>
            </ul>
        </div>
        <!-- /ko -->
       <div class="cat_description">
    <div class="brandtab_content active">
        <!-- ko if: categories().length>0 -->
        <div class="catname-lists">
            <ul class="nav nav-tabs brand1" data-bind="foreach:$root.categories,catTab">
                <li data-bind="attr:{class:'gradient'+($index()+1)},click:$parent.changeItems.bind($data, $index())"><a href="javascript:void(0)" data-bind="text:$data.name">Brand 1 Category1</a></li>
            </ul>
        </div>
        <!-- /ko -->
    <div class="tab-content">
        <div class="boxes active gradient1" data-bind="foreach:items">
            <div class="common" data-bind="click:$parent.addToCart"><a href="javascript:void(0)" data-bind="text:$data.name">Item Name 1 <br> 2 lines</a></div>    
    </div>
    </div>
    </div>
</div>
    </div> 
</div>

	<div id="pay_order" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    
                    <h4 class="modal-title">Order Payment</h4>
                    <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>-->
                </div>
    <div class="modal-body">
    <div id="pay_sec" class="row" >
	<button class="btn btn-default waves-effect waves-light btn-lg m-b-5 btn-size" style="width:150px; height:150px;margin-right: 10px;" data-bind="click:order">Cash</button>
	<button class="btn btn-default waves-effect waves-light btn-lg m-b-5 btn-size" style="width:150px; height:150px;" data-bind="click:order">Card</button>
		
					</div>
				</div>
				<div class="modal-footer">
                    <button type="button" class="btn btn-inverse btn-info waves-effect" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-danger btn-info waves-effect hide" onclick="order();">OK</button>
                </div>
			</div>
			</div>	
	</div>
<?php $store=session('store'); ?>
<script>
  var getDataVar='';
  var crsf='{{ csrf_token()}}';
  var siteurl='<?php echo url('/');?>';
  var store_id="{{$store['_id']}}";
  var customer='<?php echo json_encode($customer); ?>';
  var brandImgUrl='http://nkdpizza.cpos360.com/assets/images/uploaded_image/';
</script>
<script src="{{ asset('js/pos.js')}}"></script>
@stop