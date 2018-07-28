@extends('layouts.plane')
@section('body')

<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            @include('layouts.messages',['title'=>'User Roles','path'=>['/user-roles'=>'User Role','/user-roles/create'=>'Create']])
            <div class="col-12">
                 <div class="card-box">
                    <div class="row">
                        <div class="col-12">
                            <div class="p-20">
                                {!! Form::open(array('url' => 'user-roles/store','class'=>'form-horizontal')) !!}
                                <div class="form-group row">
                                    {!! Form::label('role_name', 'Role Name',['class'=>'col-2 col-form-label']) !!}
                                    <div class="col-10">
                                        {!! Form::text('role_name', Input::old('role_name'), array('class' => 'form-control','required')) !!}
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
                                            <input type='checkbox' class='permission-checkbox' name='permissions[]' value='{{$key}}'>
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