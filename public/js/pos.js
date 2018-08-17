function PosModel() {
        var self = this;
        self.brands=ko.observableArray(0);
        self.selBrand=ko.observable(0);
        self.selBrandId=ko.observable(0);
        self.categories=ko.observableArray(0);
        self.selCategory=ko.observable(0);
        self.items=ko.observableArray(0);
        self.cartItems=ko.observableArray(0);
        $.get(siteurl+'/positem/'+store_id,function(data){
            //getDataVar = JSON.parse(data);
             getDataVar = data;
            //console.log(getDataVar);
            self.brands(getDataVar.data.brands);
            self.selBrandId(self.brands()[0]._id);
            self.selBrand(self.brands()[0]);
            self.categories(getDataVar.data.category[self.selBrandId()]);
            self.selCategory(self.categories()[0]._id);
            self.items(getDataVar.data.items[self.selCategory()]);
        });
        self.changeCats=function(indx,data){
            self.selBrandId(data._id);
            self.selBrand(data);
            self.categories(getDataVar.data.category[data._id]);
            self.selCategory(self.categories()[0]._id);
            self.items(getDataVar.data.items[self.selCategory()]);
            $('.categories_list ul li').removeClass('active');
            $('.categories_list ul li').eq(indx).addClass('active');
            //console.log(self.categories());
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
           var brand=self.selBrand();
           var cdata={item:data,brand:brand}
          self.cartItems.push(cdata);
          sCV+=Number(data.price);
          self.subCartValue(sCV.toFixed(2));
          tCV+=Number(data.price);
          self.totalCartValue(tCV.toFixed(2));
       }
       self.pay=function(){
           if(self.cartItems().length>0){
               $('#pay_order').modal('show');
           }else{
               alert('Please select Item(s)');
           }
       }
       self.order=function(){
           var orderData={store_id:store_id,cart_items:self.cartItems(),sub_cart_total:self.subCartValue,total_pay:self.totalCartValue,discount:'',shipping:''};
           
           $.ajax({
                method:'POST',
                url:siteurl+'/add-order',
                data:{'_token':crsf,'data':orderData},
                dataType: "JSON",
                beforeSend:function(){
                        //$('#loader').removeClass('hide');
                },
                success:function(res){
                        //$('#loader').addClass('hide');
                        if(res.status==='success'){
                            window.location.href=siteurl+res.action;
                        }
                        if(res.status==='error'){
                                //$('#msg').html(res.msg);
                                //$('#alert').modal('show');
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
    init: function(el) {
	/* $(el).scrollingTabs('destroy');
         $(el)
        .scrollingTabs({
            enableSwiping: true
        });
        */
    },
    update:function(el){
        $(el).scrollingTabs('refresh');
    }
};
ko.options.useOnlyNativeEvents = true;
ko.options.deferUpdates = true;
ko.applyBindings(pm); 

