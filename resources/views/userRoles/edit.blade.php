@extends('layouts.plane')
@section('body')

<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            @include('layouts.messages',['title'=>'User Roles Edit','path'=>['/user-roles'=>'User Role','#'=>'Edit Roles']])
            <div class="col-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col-12">
                            <div class="p-20">
                                {!! Form::open(array('url' => 'user-roles/update/'.$role_data->_id)) !!}
                                <div class="form-group row">
                                    {!! Form::label('role_name', 'Role Name',['class'=>'col-2 col-form-label']) !!}
                                    <div class="col-10">
                                        {!! Form::text('role_name',  $role_data->role_name, array('class' => 'form-control','required')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Select All Permissions</label>
                                    <input type='checkbox' id="selecctall" name='common_checked' value=''>
                                    <div class="row">
                                        @if(count($permissions)>0)  
                                        @foreach($permissions as $key=>$data)
                                        <div class='col-lg-2'>
                                            <label for="{{$key}}">{{$data}}</label>
                                            @if(in_array($key,$role_data->permission))
                                            <input type='checkbox' class='permission-checkbox' name='permissions[]' value='{{$key}}' checked="">
                                            @else
                                            <input type='checkbox' class='permission-checkbox' name='permissions[]' value='{{$key}}'>
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
                        </div>

                    </div>
                    <!-- end row -->

                </div> 
            </div> </div>



    </div> <!-- end Panel -->
</div> <!-- end container -->
@stop
