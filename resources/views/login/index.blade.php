@extends('posLayouts.login')
@section('body')
        <div class="loginpage">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-7">
                        <div class="banner_info">
                            <a href="#"><img src="{{ asset("assets/images/login/logo.png")}}" alt="logo"></a>
                            <h3>Toast Go<sup>TM</sup>: The Future of the POS Is In Your Hand</h3>
                            <p>Boost revenue, increase efficiency, and delight your guests.</p>
                        </div>
                        <div class="login_footer">
                            <p>
                                Powered by 
                                <a class="tost" href="">Toast</a>
                                <span>�</span>
                                � Toast, Inc. 2018. All Rights Reserved.
                                <span>�</span>
                                <a href="">Privacy Policy</a>
                                <span>�</span>
                                <a href="">Terms of Service</a>
                                <span>�</span>
                                <a href="">Toast&nbsp;Blog</a>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-5 dialpad_sec text-center">
                         <!-- ko ifnot: newReg() --> 
                        <div class="content">
                            <form id="login" method="post" action="/" autocomplete="off">
                                <!-- ko if: selectedUser() -->
                                <div class="form-group">
                                    <div class="text-center">
                                <div class="user-thumb">
                                    <img src="/assets/images/users/avatar-1.jpg" class="img-responsive bx-shadow rounded-circle img-thumbnail" alt="thumbnail">
                                </div>
                                <h4 class="font-18">
                                    
                                    <div class="btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false" data-bind="text:selectedUser();"> Dropdown </button>
                                             <!-- ko if: users().length>1 --> 
                                            <div class="dropdown-menu" x-placement="top-start" data-bind="foreach:users">
                                                <a class="dropdown-item" href="javascript:void(0)" data-bind="text:$data,click: $parent.changeSelectedUser">Dropdown One</a>
                                            </div>
                                               <!-- /ko -->
                                        </div>
                                   
                                </h4>
                                
                            </div>
                                <input id="pin" type="password" value="" placeholder="Enter your PIN" name="pin" onfocus="emlFocus(this);" maxlength="6" required="true" onkeydown="return false;" autocomplete="off" autofill="off">
                                </div>
                                 <!-- /ko -->
                                <div class="dailer">
                                    <table cellspacing="0">
                                        <tr>
                                            <td><button type="button" value="7" onclick="keyPad(this)">7</button></td>
                                            <td><button type="button" value="8" onclick="keyPad(this)">8</button></td>
                                            <td><button type="button" value="9" onclick="keyPad(this)">9</button></td>
                                        </tr>
                                        <tr>
                                            <td><button type="button" value="4" onclick="keyPad(this)">4</button></td>
                                            <td><button type="button" value="5" onclick="keyPad(this)">5</button></td>
                                            <td><button type="button" value="6" onclick="keyPad(this)">6</button></td>
                                        </tr>
                                        <tr>
                                            <td><button type="button" value="1" onclick="keyPad(this)">1</button></td>
                                            <td><button type="button" value="2" onclick="keyPad(this)">2</button></td>
                                            <td><button type="button" value="3" onclick="keyPad(this)">3</button></td>
                                        </tr>
                                        <tr>
                                            <td><button type="reset" class="reset" value="Clear">Clear</button></td>
                                            <td><button type="button" value="0" onclick="keyPad(this)">0</button></td>
                                            <td><button type="button" class="submit" value="Login" onclick="login()">Login</button></td>
                                        </tr>
                                    </table>
                                </div>
                            
                            </form>
                         <button class="checkin-btn" onclick="newRegs();">New User</button>
                        </div>
                       
                         <!-- /ko -->
                          <!-- ko if: newReg() --> 
                           <div class="content">
                              <!-- ko if: stp1() -->  
                            <form id="user" method="post" action="/" onsubmit="checkUser();return false;" autocomplete="off">
                                 <div class="form-group">
                                <input id="username" type="text" value="" placeholder="Username" name="email" required="true" autocomplete="off">
                                 </div>
                                 <div class="form-group">
                                <input id="password" type="password" value="" placeholder="Password" name="password" required="true" autocomplete="off">
                                 </div>
                                 <div class="form-group">
                                <button class="btn btn-success btn-custom waves-effect waves-light" type="submit">Register</button>
                                <button class="btn btn-danger btn-custom waves-effect waves-light" onclick="cancelReg();" type="button">Cancel</button>
                                 </div>
                            </form>
                               <!-- /ko -->
                               <!-- ko if: stp2() -->  
                            <form id="setPinForm" method="post" action="/" autocomplete="off">
                                <input id="setpin" type="password" value="" placeholder="PIN" name="setpin" required="true" onfocus="emlFocus(this);" onkeydown="return false;" autocomplete="off">
                                <input id="setpin2" type="password" value="" placeholder="Confirm PIN" name="csetpin" required="true" onfocus="emlFocus(this);" onkeydown="return false;" autocomplete="off">
                                
                                   <div class="dailer">
                                    <table cellspacing="0">
                                        <tr>
                                            <td><button type="button" value="7" onclick="keyPad(this)">7</button></td>
                                            <td><button type="button" value="8" onclick="keyPad(this)">8</button></td>
                                            <td><button type="button" value="9" onclick="keyPad(this)">9</button></td>
                                        </tr>
                                        <tr>
                                            <td><button type="button" value="4" onclick="keyPad(this)">4</button></td>
                                            <td><button type="button" value="5" onclick="keyPad(this)">5</button></td>
                                            <td><button type="button" value="6" onclick="keyPad(this)">6</button></td>
                                        </tr>
                                        <tr>
                                            <td><button type="button" value="1" onclick="keyPad(this)">1</button></td>
                                            <td><button type="button" value="2" onclick="keyPad(this)">2</button></td>
                                            <td><button type="button" value="3" onclick="keyPad(this)">3</button></td>
                                        </tr>
                                        <tr>
                                            <td><button class="checkin-btn" type="reset">Clear</button></td>
                                            <td><button type="button" value="0" onclick="keyPad(this)">0</button></td>
                                            <td><button class="checkin-btn" type="button" onclick="setPin();return false;">Set Pin</button></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="form-group">
                                <button class="btn btn-danger btn-custom waves-effect waves-light" onclick="cancelReg();" type="button">Cancel</button>
                                 </div>
                            </form>
                               <!-- /ko -->
                        </div>
                         <!-- /ko -->
                    </div>
                </div>
            </div>
        </div>
 <link href="{{asset('assets/plugins/sweet-alert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">
 <script src="{{asset('assets/plugins/sweet-alert2/sweetalert2.min.js')}}" async></script>
 <script type="text/javascript" async>
var crsf='{{csrf_token()}}';
var siteurl='<?php echo url('/');?>';
var users=<?php echo $users; ?>;
</script>
<script src="{{ asset("js/pinlogin.js")}}" type="text/javascript" async></script>
@stop