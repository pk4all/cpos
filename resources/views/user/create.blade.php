@extends('layouts.plane')
@section('body')

<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            @include('layouts.messages',['title'=>'Add New User','path'=>['/users'=>'company','#'=>'Create']])
            <div class="col-12">
                <div class="card-box">
                    <p class="text-muted m-b-30 font-14">
                    </p>
                    {!! Form::open(array('url' => 'users/store','class'=>'form-horizontal')) !!}
                    <div class="form-group-custom">
                        {!! Form::text('first_name', Input::old('first_name'), array('required')) !!}
                        <label class="control-label">First Name</label><i class="bar"></i>
                    </div>
                    <div class="form-group-custom">
                        {!! Form::text('last_name', Input::old('last_name'), array('required')) !!}
                        <label class="control-label">Last Name</label><i class="bar"></i>
                    </div>
                    <div class="form-group-custom">
                        {!! Form::email('email', Input::old('email'), array('required')) !!}
                        <label class="control-label">Email</label><i class="bar"></i>
                    </div>
                    <div class="form-group-custom">
                        {!! Form::password('password', null, array('required')) !!}
                        <label class="control-label">Password</label><i class="bar"></i>
                    </div>
                    <div class="form-group-custom">
                        {!! Form::select('manager_id', $user, null, array('class' => 'form-control','id'=>'_manager')) !!}
                        <label class="control-label">Manager</label><i class="bar"></i>
                    </div>
                    <div class="form-group-custom">
                        {!! Form::select('user_role', $user_role, Input::old('user_role'), array('name'=>'user_role','class' => 'form-control','id'=>'_user_role')) !!}
                        <label class="control-label">Role</label><i class="bar"></i>
                    </div>
                    <div class="form-group-custom">
                        {!! Form::select('user_status', $user_status, Input::old('user_status'), array('name'=>'user_status','class' => 'form-control','id'=>'_user_status')) !!}
                        <label class="control-label">Status</label><i class="bar"></i>
                    </div>
                    
                    {!! Form::submit('Save!', array('class' => 'btn btn-primary')) !!}
                    {!! Form::close() !!}
                </div>

            </div> </div>



    </div> <!-- end Panel -->
</div> <!-- end container -->
@stop

