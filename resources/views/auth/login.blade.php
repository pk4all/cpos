@extends('layouts.plane')
@section('body')
<div class="account-pages"></div>
<div class="clearfix"></div>
<div class="wrapper-page">
<div style="text-align:center;">
<img src="{{ asset("assets/images/logo-cpos.png")}}" alt="Logo CPOS360">
<h5>A Complete cloud solution for your restaurant customer and order management to delivery</h5>
</div>

            <div class="card-box">
                <div class="p-20">
                    <form class="form-horizontal m-t-20" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <div class="form-group-custom {{ $errors->has('email') ? ' has-error' : '' }}">
                            <input type="text" id="email" name='email' required="required" value="{{ old('email') }}" />
                            <label class="control-label" for="email">Username</label><i class="bar"></i>
                        </div>
                        
                        <div class="form-group-custom {{ $errors->has('password') ? ' has-error' : '' }}">
                            <input type="password" id="password" name='password' required="required"/>
                            <label class="control-label" for="password">Password</label><i class="bar"></i>
                        </div>

                        <div class="form-group ">
                            <div class="col-12">
                                <div class="checkbox checkbox-primary">
                                    <input id="checkbox-signup" type="checkbox" name='remember' {{ old('remember') ? 'checked' : '' }}>
                                    <label for="checkbox-signup">
                                        Remember Me
                                    </label>
                                </div>
                                 @if ($errors->has('password'))
                                    <span class="danger">
                                        {{ $errors->first('password') }}
                                    </span>
                                @endif
                                 @if ($errors->has('email'))
                                    <span class="danger">
                                        {{ $errors->first('email') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group text-center m-t-40">
                            <div class="col-12">
                                <button class="btn btn-danger btn-block text-uppercase waves-effect waves-light"
                                        type="submit">Log In
                                </button>
                            </div>
                        </div>

                        <div class="form-group m-t-30 m-b-0">
                            <div class="col-12">
                                <a href="{{ route('password.request') }}" class="text-dark"><i class="fa fa-lock m-r-5"></i> Forgot
                                    your password?</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <!--<div class="row">
                <div class="col-sm-12 text-center">
                    <p class="text-white">Don't have an account? <a href="page-register.html" class="text-white m-l-5"><b>Sign Up</b></a>
                    </p>

                </div>
            </div>-->

        </div>
@stop

