@extends('layouts.plane')
@section('body')

<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            @include('layouts.messages',['title'=>'Add New Payment','path'=>['/payments'=>'Payments','#'=>'Create']])
            @include('layouts.menu',['tabList'=>$tabList])
            <div class="col-12">
                <div class="card-box">
                    <p class="text-muted m-b-30 font-14">
                    </p>
                    {!! Form::open(array('url' => 'payment/store','class'=>'form-horizontal','enctype'=>'multipart/form-data', 'method'=>'post')) !!}

                    <div class="row">
                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Name</label>
                            <div class="col-9">
                            {!! Form::text('name', Input::old('name'), array('required','class'=>'form-control','placeholder'=>'Enter Payment Name')) !!}
                            </div>
                        </div>
                        <div class="form-group row col-sm-6">
                            <label class="col-3 col-form-label">Payment Type</label>
                            <div class="col-9">
                            {!! Form::select('payment_type', $paymentTypes, null, ['class' => 'form-control margin']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Payment Icon</label>
                            <div class="col-9">
                                {!! Form::file('logo', Input::old('logo'), array('required','class'=>'form-control','id'=>'fileHelp')) !!}
                                <small id="fileHelp" class="form-text text-muted">Please upload image in png,jpg format</small>
                            </div>
                        </div>
                    </div>
                    {!! Form::submit('Save!', array('class' => 'btn btn-primary')) !!}
                    {!! Form::close() !!}
                </div>

            </div> 


        </div>



    </div> <!-- end Panel -->




</div> <!-- end container -->
@section('custome_script')
<script>
$(function(){
   $("#store_city").on('change', function () {
        var option = "";
        $('#store_city :selected').each(function (i) {
            if ($(this.length)) {
                option += "<option value=" + $(this).val() + ">" + $(this).text() + "</option>";
            }
        });
    }); 
});   
</script>
@yield('custome_script')
@overwrite
@stop