@extends('layouts.plane')
@section('body')

<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            @include('layouts.messages',['title'=>'Add New Company','path'=>['/company'=>'company','#'=>'Create']])
            <div class="col-12">
                <div class="card-box">
                    <p class="text-muted m-b-30 font-14">
                    </p>
                    {!! Form::open(array('url' => 'company/update/'.$company_data->_id,'class'=>'form-horizontal')) !!}
                    <div class="form-group-custom">
                        {!! Form::text('name', $company_data->name, array('required')) !!}
                        <label class="control-label">Company Name</label><i class="bar"></i>
                    </div>
                    <div class="form-group-custom">
                        {!! Form::email('email', $company_data->email, array('required')) !!}
                        <label class="control-label">Email</label><i class="bar"></i>
                    </div>
                    <div class="form-group-custom">
                        {!! Form::text('database', isset($company_data->database)?$company_data->database:'', array('readonly')) !!}
                        <label class="control-label">Database</label><i class="bar"></i>
                    </div>
                    <div class="form-group-custom">
                        {!! Form::select('user_id', $users, $company_data->user_id, array('class' => 'form-control','id'=>'_user_id')) !!}
                        <label class="control-label">User</label><i class="bar"></i>
                    </div>
                    <div class="form-group-custom">
                        {!! Form::text('domain', $company_data->domain, array('required')) !!}
                        <label class="control-label">Domain</label><i class="bar"></i>
                    </div>
                    <div class="form-group-custom">
                        {!! Form::date('validity', $company_data->validity, array('required')) !!}
                        <label class="control-label">Validity</label><i class="bar"></i>
                    </div>
                    <div class="form-group-custom">
                        {!! Form::text('plan',  $company_data->plan, array('required')) !!}
                        <label class="control-label">Plan</label><i class="bar"></i>
                    </div>
                    {!! Form::submit('Save!', array('class' => 'btn btn-primary')) !!}
                    {!! Form::close() !!}
                </div>

            </div> </div>



    </div> <!-- end Panel -->
</div> <!-- end container -->
@stop
