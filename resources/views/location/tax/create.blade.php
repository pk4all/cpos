@extends('layouts.plane')
@section('body')

<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row sub-tab-list">
            @include('layouts.messages',['title'=>'Add New Tax','path'=>['/location'=>'Location','#'=>'Tax']])
            @include('layouts.menu',['tabList'=>$tabList])
            <div class="col-12">
                <div class="card-box">
                    <p class="text-muted m-b-30 font-14">
                    </p>
                    {!! Form::open(array('url' => 'tax/store','class'=>'form-horizontal','enctype'=>'multipart/form-data', 'method'=>'post')) !!}

                    <div class="row">
                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Tax Name</label>
                            <div class="col-9">
                            {!! Form::text('name', Input::old('name'), array('required','class'=>'form-control','placeholder'=>'Enter Tax Name')) !!}
                            </div>
                        </div>
                       
                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Tax Amount</label>
                            <div class="col-9">
                            {!! Form::text('amount', Input::old('amount'), array('required','class'=>'form-control','placeholder'=>'Enter Tax Amount')) !!}
                            </div>
                        </div>
                         <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Tax Type</label>
                            <div class="col-9">
                            {!! Form::select('type', $tax_type, null, ['required', 'class' => 'form-control margin']) !!}
                            </div>
                        </div>
                        <div class="form-group row col-sm-6">
                            <label class="col-3 col-form-label">Select Store</label>
                            <div class="col-9">
                            {!! Form::select('store[]', $store_list, null, ['required', 'multiple' => true,  'class' => 'form-control margin selectpicker', 'data-selected-text-format'=>"count", 'data-style'=>"btn-white"]) !!}
                            </div>
                        </div>
                        <div class="form-group row col-sm-6">
                            <label class="col-3 col-form-label">Select Order Type</label>
                            <div class="col-9">
                            {!! Form::select('order_type[]', $order_type_list, null, ['required', 'multiple' => true,  'class' => 'form-control margin selectpicker', 'data-selected-text-format'=>"count", 'data-style'=>"btn-white"]) !!}
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