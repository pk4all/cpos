@extends('layouts.plane')
@section('body')
<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            @include('layouts.messages',['title'=>'Edit Brands','path'=>['/payment'=>'Brands','#'=>'Edit']])
            <div class="col-12">
                <div class="card-box">
                    <p class="text-muted m-b-30 font-14">
                    </p>
                    {!! Form::open(array('url' => 'payment/update/'.$payment_data->_id,'class'=>'form-horizontal','enctype'=>'multipart/form-data', 'method'=>'post')) !!}

                    <div class="row">
                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Name</label>
                            <div class="col-9">
                                {!! Form::text('name', $payment_data['name'], array('required','class'=>'form-control','placeholder'=>'Enter Brand Name')) !!}
                            </div>
                        </div>
                        <div class="form-group row col-sm-6">
                            <label class="col-3 col-form-label">Payment Type</label>
                            <div class="col-9">
                                {!! Form::select('payment_type', $paymentType, $payment_data->type, ['class' => 'form-control margin', 'id' => 'paymentType']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Payment Icon</label>
                            <div class="col-9">
                                <img src="{{env('IMAGE_PATH').$payment_data->logo}}" style="width: 50px; height: 50px;">
                                {!! Form::file('logo', Input::old('logo'), array('required','class'=>'form-control','id'=>'fileHelp')) !!}
                                <small id="fileHelp" class="form-text text-muted">Please upload image in png,jpg format</small>
                            </div>
                        </div>

                    </div>
                    <div class="row quick-options">
                        <label class="col-12 col-form-label">Quick Cash Options</label>
                    </div>
                    <div class="row quick-options" id="quickOptions">

                        @if(count($payment_data->quick_options)>0)  
                        @foreach($payment_data->quick_options as $label => $value)
                        @if($label == 'NA')
                        {{$label = $value =''}}
                        @endif
                        <div class="row col-sm-12 quick-option">
                            <div class="form-group row  col-sm-6">
                                <label class="col-3 col-form-label">Label</label>
                                <div class="col-9">
                                   
                                    {!! Form::text('label[]', $label, array('class'=>'form-control','placeholder'=>'Option Label')) !!}
                                
                                </div>
                            </div>

                            <div class="form-group row  col-sm-6">
                                <label class="col-3 col-form-label">Value</label>
                                <div class="col-8">
                                    
                                    {!! Form::text('value[]', $value, array('class'=>'form-control','placeholder'=>'Option Value')) !!}
                                
                                </div>
                                <div class="col-1 add-new">
                                    <span class="addmoreStoreTiming" style="z-index: 999999" title="Add more Option"><i class="ion-plus-circled"></i></span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
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
    @if($payment_data->type != 'Cash') 
    $('.quick-options').hide();
    @endif
$(document).on('click', '.add-new', function(){
     var newOption = $("#quickOptions .quick-option:first").clone();
     newOption.find('input[name="label[]"]').val('');
     newOption.find('input[name="value[]"]').val('');
     $("#quickOptions").append(newOption);
});
$('#paymentType').change(function(){
    if($(this).val() == 'Cash'){
        $('.quick-options').show();
    }else{
        $('.quick-options').hide();
    }
});
});
</script>
@yield('custome_script')
@overwrite
@stop
