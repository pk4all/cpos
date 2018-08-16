@extends('posLayouts.pos')
@section('body')

<div class="pickup-page">
    <div class="container-fluid">
        <?php $customer=session('customer');?>
        <div class="orderlists">
                    <h2><a href="#" class="editbtn"><i class="fa fa-edit"></i></a>Order for {{$customer['name']}} ({{$customer['phone']}})</h2>
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
                            <tbody>
                                <tr>
                                    <td>
                                        <a class="action" href="#"><i class="fa fa-trash error"></i></a>
                                        <a class="action" href="#"><i class="fa fa-edit"></i></a>
                                        <p>Grilled Chicken with Potato Mash</p>
                                    </td>
                                    <td>AED 45.00</td>
                                    <td class="quantity">
                                        <button><i class="fa fa-plus"></i></button>
                                        <span>1</span>
                                        <button><i class="fa fa-minus"></i></button>
                                    </td>
                                    <td>AED 45.00</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a class="action" href="#"><i class="fa fa-trash error"></i></a>
                                        <a class="action" href="#"><i class="fa fa-edit"></i></a>
                                        <p>Rocky Road</p>
                                    </td>
                                    <td>AED 48.00</td>
                                    <td class="quantity">
                                        <button><i class="fa fa-plus"></i></button>
                                        <span>1</span>
                                        <button><i class="fa fa-minus"></i></button>
                                    </td>
                                    <td>AED 48.00</td>
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
                                    <td>AED 0.00</td>
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
                                    <td>AED 0.00</td>
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
            <ul data-bind="foreach:brands">
                <li data-bind="attr:{class:$index()==0?'active':''},click:$parent.changeCats.bind($data, $index())"><a href="#"><img data-bind="attr:{src:brandImgUrl+$data.logo}" src="{{ asset('assets/images/order/brand-bunfire.png')}}"></a></li>
            </ul>
        </div>
        <!-- /ko -->
       <div class="cat_description">
    <div class="brandtab_content active">
        <!-- ko if: categories().length>0 -->
        <div class="catname-lists">
            <ul class="nav nav-tabs brand1" data-bind="foreach:categories,catData">
                <li data-bind="attr:{class:'gradient'+($index()+1)},click:$parent.changeItems.bind($data, $index())"><a href="#" data-bind="text:$data.name">Brand 1 Category1</a></li>
            </ul>
        </div>
        <!-- /ko -->
    <div class="tab-content">
    <div class="boxes active gradient1">
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
        <div class="common"><a href="#">Item Name 1 <br> 2 lines</a></div>
    </div>

    </div>
    </div>
</div>
    </div> 
</div>

<script>
  var getDataVar={"response":200,"status":"success","data":{"brands":[{"_id":"5b74d60071add83ce935a242","name":"NKDPizza","logo":"brand-nkd_5b753644c541b.png"},{"_id":"5b75367d71add848e5534dd2","name":"Right Bite","logo":"brand-right-bite_5b75367d1d782.png"},{"_id":"5b75369471add848c85d5f72","name":"Tawook","logo":"brand-tawook_5b7536946343a.png"},{"_id":"5b7536a371add848de4db302","name":"Bunfire","logo":"brand-bunfire_5b7536a3a7230.png"},{"_id":"5b7536c171add848e5534dd3","name":"Jack's Place","logo":"brand-jacks_5b7536c133c2c.png"}],"category":{"5b74d60071add83ce935a242":[[{"_id":"5b6b088871add84de815bc52","parent":[],"name":"Pizzas","description":"Pizzas"},{"_id":"5b6b08ac71add87f42707f92","parent":[],"name":"Salads","description":"Salads"},{"_id":"5b6bc50271add8223609e892","parent":[],"name":"Sides","description":"Sides"},{"_id":"5b73e17c71add827443a5db2","parent":[],"name":"Deserts","description":"Deserts"},{"_id":"5b73e18f71add825f4758342","parent":[],"name":"Beverages","description":"Beverages"},{"_id":"5b73e1a771add8295a315442","parent":[{"_id":"5b6b088871add84de815bc52","name":"Pizzas"}],"name":"From the Farm","description":"From the Farm"},{"_id":"5b73e1b871add829f65f2cb2","parent":[{"_id":"5b6b088871add84de815bc52","name":"Pizzas"}],"name":"From the Field","description":"From the Field"}]],"5b75367d71add848e5534dd2":[[{"_id":"5b6b088871add84de815bc52","parent":[],"name":"Pizzas","description":"Pizzas"},{"_id":"5b6b08ac71add87f42707f92","parent":[],"name":"Salads","description":"Salads"},{"_id":"5b73e17c71add827443a5db2","parent":[],"name":"Deserts","description":"Deserts"},{"_id":"5b73e18f71add825f4758342","parent":[],"name":"Beverages","description":"Beverages"}]],"5b75369471add848c85d5f72":[[{"_id":"5b6b08ac71add87f42707f92","parent":[],"name":"Salads","description":"Salads"},{"_id":"5b73e17c71add827443a5db2","parent":[],"name":"Deserts","description":"Deserts"},{"_id":"5b73e18f71add825f4758342","parent":[],"name":"Beverages","description":"Beverages"}]],"5b7536a371add848de4db302":[[{"_id":"5b73e17c71add827443a5db2","parent":[],"name":"Deserts","description":"Deserts"},{"_id":"5b73e18f71add825f4758342","parent":[],"name":"Beverages","description":"Beverages"}]],"5b7536c171add848e5534dd3":[[{"_id":"5b6bc50271add8223609e892","parent":[],"name":"Sides","description":"Sides"},{"_id":"5b73e17c71add827443a5db2","parent":[],"name":"Deserts","description":"Deserts"},{"_id":"5b73e18f71add825f4758342","parent":[],"name":"Beverages","description":"Beverages"}]]},"items":[],"modifer":[]}};  
  var crsf='{{ csrf_token()}}';
  var siteurl='<?php echo url('/');?>';
  var brandImgUrl='http://nkd.com/assets/images/uploaded_image/';
    function PosModel() {
        var self = this;
        self.brands=ko.observableArray(getDataVar.data.brands);
        self.defBrandId=ko.observable(self.brands()[0]._id);
        self.categories=ko.observableArray(getDataVar.data.category[self.defBrandId()][0]);
        self.items=ko.observableArray(0);
        
        self.changeCats=function(indx,data){
            self.categories(getDataVar.data.category[data._id][0]);
            console.log(self.categories());
            $('.categories_list ul li').removeClass('active');
            $('.categories_list ul li').eq(indx).addClass('active');
        }
        
       self.changeItems=function(indx,data){  
            console.log(self.categories());
            
        } 
    }
 var pm=new PosModel();

ko.bindingHandlers.catData = {
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
