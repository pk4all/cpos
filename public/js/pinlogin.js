 
function PosModel() {
        var self = this;
        self.newReg=ko.observable(false);
        self.stp1=ko.observable(false);
        self.stp2=ko.observable(false);
        self.logUser=ko.observable(false);
        self.$elm=ko.observable('#pin');
        self.users=ko.observableArray(users);
        self.selectedUser=ko.observable(false);
        self.selectedUser(getCookie('selectedUser'));
        if(!self.selectedUser()){
            // $('#login button').attr('disabled',true);
        }else{
            //$('#login button').removeAttr('disabled');
        }
       
        self.changeSelectedUser=function(user){
            self.selectedUser(user);
            setCookie('selectedUser',user,365);
        }
        
    }
var pm=new PosModel();
emlFocus=function($elm){
    pm.$elm($elm);
    //alert($($elm).attr('id'));
}
function keyPad(obj){
    $elm=pm.$elm();
    var pin = $($elm).val();
    var num=$(obj).val();
    if(pin.length<6){
        $($elm).val(pin+num);
    }
}    
function newRegs(){
    pm.newReg(true);
    pm.stp1(true);
}
function cancelReg(){
    pm.newReg(false);
    pm.stp1(false);
    pm.stp2(false);
    pm.logUser(false);
}
function cancelPin(){
    pm.newReg(false);
    pm.stp1(false);
    pm.stp2(false);
}
function checkUser(){
   // var userData=$('#user').serialize();
    var form=$('#user')[0];
    var formData = new FormData(form);
    formData.append('_token',crsf);
    $.ajax({
                method:'POST',
                url:siteurl+'/pos/check-user',
                data:formData,
                dataType: "JSON",
                processData: false,
                contentType: false,
                cache: false,
                beforeSend:function(){
                        //$('#loader').removeClass('hide');
                },
                success:function(res){
                        //$('#loader').addClass('hide');
                        if(res.status==='success'){
                            pm.stp1(false);
                            pm.stp2(true);
                            pm.logUser(res.user);
                            $('#user')[0].reset();
                           pm.$elm('#setpin'); 
                        }
                        if(res.status==='error'){
                            swal(res.msg);
                        }
                },
                statusCode: {
                        403: function() {
                          window.location.reload();
                        }
                  }
        });
} 

function setPin(){
    var pin=$('#setpin').val();
    var pin2=$('#setpin2').val();
    if(pin.length==0 || pin.length<6){
        swal('Enter 6 digit PIN');
    }else if(pin2.length==0 || pin2.length<6){
        swal('Enter 6 digit confirm PIN');
    }else if(pin!=pin2){
        swal('Both PIN not matched');
    }else{
        $.ajax({
                method:'POST',
                url:siteurl+'/pos/set-pin',
                data:{_token:crsf,id:pm.logUser(),pin:pin},
                dataType: "JSON",
                beforeSend:function(){
                        //$('#loader').removeClass('hide');
                },
                success:function(res){
                    
                        if(res.status==='success'){
                            pm.newReg(false);
                            pm.stp1(false);
                            pm.stp2(false);
                            pm.logUser(false); 
                            pm.users(res.users);
                            pm.selectedUser(res.user);
                            setCookie('selectedUser',res.user,365);
                            $('#login button').removeAttr('disabled');
                        }
                        if(res.status==='error'){
                            swal(res.msg);
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

function login(){
    var pin=$('#pin').val();
    var user=pm.selectedUser();
    if(pin.length==0 || pin.length<6){
        swal('Enter your 6 digit PIN');
    }else{
        $.ajax({
                method:'POST',
                url:siteurl+'/pos/user-login',
                data:{_token:crsf,user:user,pin:pin},
                dataType: "JSON",
                beforeSend:function(){
                        //$('#loader').removeClass('hide');
                },
                success:function(res){
                    
                        if(res.status==='success'){
                            window.location.href=res.action;
                        }
                        if(res.status==='error'){
                            swal(res.msg);
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

ko.options.useOnlyNativeEvents = true;
ko.options.deferUpdates = true;
ko.applyBindings(pm);
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

