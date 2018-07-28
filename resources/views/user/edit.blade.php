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
                    {!! Form::open(array('url' => 'users/update/'.$user_data->_id , 'id'=>'edit_users','class'=>'form-horizontal')) !!}
                    <div class="form-group-custom">
                        {!! Form::text('first_name',$user_data->first_name, array('required')) !!}
                        <label class="control-label">First Name</label><i class="bar"></i>
                    </div>
                    <div class="form-group-custom">
                        {!! Form::text('last_name', $user_data->last_name, array('required')) !!}
                        <label class="control-label">Last Name</label><i class="bar"></i>
                    </div>
                    <div class="form-group-custom">
                        {!! Form::email('email', $user_data->email, array('required')) !!}
                        <label class="control-label">Email</label><i class="bar"></i>
                    </div>
                    <div class="form-group-custom">
                        {!! Form::password('password', null, array()) !!}
                        <label class="control-label">Password</label><i class="bar"></i>
                    </div>
                    <div class="form-group-custom">
                        {!! Form::select('manager_id', $user, $user_data->manager_id, array('class' => 'form-control','id'=>'_manager')) !!}
                        <label class="control-label">Manager</label><i class="bar"></i>
                    </div>
                    <div class="form-group-custom">
                        {!! Form::select('user_role', $user_role, $user_data->user_role, array('name'=>'user_role','class' => 'form-control','id'=>'_user_role')) !!}
                        <label class="control-label">Role</label><i class="bar"></i>
                    </div>
                    <div class="form-group-custom">
                        {!! Form::select('user_status', $user_status, $user_data->status, array('name'=>'user_status','class' => 'form-control','id'=>'_user_status')) !!}
                        <label class="control-label">Status</label><i class="bar"></i>
                    </div>
                    <div class="form-group">
                        <label>Custom Permissions</label> 
                        <input type='checkbox' id="selecctall" name='common_checked' value=''>
                        <div class="row">
                            @if(count($permissions)>0)  
                            @foreach($permissions as $key=>$data)
                            <div class='col-lg-2'>
                                <label for="{{$key}}">{{$data}}</label>
                                @if(is_array($user_data['permissions']) && in_array($key,$user_data['permissions']))
                                <input type='checkbox' class='permission-checkbox' name='custom_permissions[]' value='{{$key}}' checked="">
                                @else
                                <input type='checkbox' class='permission-checkbox' name='custom_permissions[]' value='{{$key}}'>
                                @endif
                            </div>
                            @endforeach
                            @endif
                            <div class='col-lg-2'>
                            </div>
                        </div>
                    </div>


                    {!! Form::submit('Save!', array('class' => 'btn btn-primary')) !!}
                    {!! Form::close() !!}
                </div>

            </div> </div>



    </div> <!-- end Panel -->
</div> <!-- end container -->
@stop
