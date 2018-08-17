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
                                    <th>Unit Price</th>
                                    <th class="quantity">Quantity</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody data-bind="foreach:cartItems">
                                <tr >
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
                        <button type="button" class="btn btn-success">
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
            <ul class="nav nav-tabs brand1" data-bind="foreach:categories,catTab">
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

<script>
  var getDataVar='';
  var crsf='{{ csrf_token()}}';
  var siteurl='<?php echo url('/');?>';
  
  var brandImgUrl='http://nkd.com/assets/images/uploaded_image/';
    function PosModel() {
        var self = this;
        self.brands=ko.observableArray(0);
        self.selBrandId=ko.observable(0);
        self.categories=ko.observableArray(0);
        self.selCategory=ko.observable(0);
        self.items=ko.observableArray(0);
        self.cartItems=ko.observableArray(0);
        $.get(siteurl+'/positem/5b6711bc71add87dab29cc52',function(data){
            getDataVar = JSON.parse(data);
            //console.log(getDataVar);
            self.brands(getDataVar.data.brands);
            self.selBrandId(self.brands()[0]._id);
            self.categories(getDataVar.data.category[self.selBrandId()]);
            self.selCategory(self.categories()[0]._id);
            self.items(getDataVar.data.items[self.selCategory()]);
        });
        self.changeCats=function(indx,data){
            self.selBrandId(data._id);
            self.categories(getDataVar.data.category[data._id]);
            self.selCategory(self.categories()[0]._id);
            self.items(getDataVar.data.items[self.selCategory()]);
            $('.categories_list ul li').removeClass('active');
            $('.categories_list ul li').eq(indx).addClass('active');
        }
        
       self.changeItems=function(indx,data){
           self.selCategory(data._id);
           self.items(getDataVar.data.items[self.selCategory()]);
        }
        
       self.subCartValue=ko.observable(0.00);
       self.totalCartValue=ko.observable(0);
       var sCV=0;
       var tCV=0;
       self.addToCart=function(data){
           var brandId=self.selBrandId();
           var cdata={item:data,brand:brandId}
          self.cartItems.push(cdata);
          sCV+=Number(data.price);
          self.subCartValue(sCV.toFixed(2));
           tCV+=Number(data.price);
          self.totalCartValue(tCV.toFixed(2));
         
       } 
    }
 var pm=new PosModel();
ko.bindingHandlers.brandCro = {
    init: function() {
        $(".categories_list ul").mCustomScrollbar({
            scrollButtons:{
              enable:true
            }
      });
    }
 }
 
ko.bindingHandlers.catTab = {
    init: function() {
	setTimeout(function(){
            /* $('.catname-lists ul')
            .scrollingTabs({
                enableSwiping: true
            })
            .on('ready.scrtabs', function() {
                $('.tab-content').show();
            });*/
        },2000);
    },
    update:function(){
        setTimeout(function(){
          /* $('.catname-lists ul')
            .scrollingTabs({
                enableSwiping: true
            })
            .on('ready.scrtabs', function() {
                $('.tab-content').show();
            });*/
        },2000);
    }
};
ko.options.useOnlyNativeEvents = true;
ko.options.deferUpdates = true;
ko.applyBindings(pm);   
</script>
@stop
