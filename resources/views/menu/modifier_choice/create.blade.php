@extends('layouts.plane')
@section('body')

<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            @include('layouts.messages',['title'=>'Add New Modifier Choice','path'=>['/modifier_choice'=>'modifier_choice','#'=>'Create']])
            @include('layouts.menu',['tabList'=>$tabList])
            <div class="col-12">
                <div class="card-box">
                    <p class="text-muted m-b-30 font-14">
                    </p>
                    {!! Form::open(array('url' => 'modifier_choice/store','class'=>'form-horizontal','enctype'=>'multipart/form-data', 'method'=>'post')) !!}

                    <div class="row">
                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Choice Name </label>
                            <div class="col-9">
                            {!! Form::text('name', Input::old('name'), array('required','class'=>'form-control','placeholder'=>'Enter Choice Name')) !!}
                            </div>
                        </div>
                        
                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Multiplied By</label>
                            <div class="col-9">
                            {!! Form::number('multiplied_by', Input::old('multiplied_by'), array('required','class'=>'form-control','placeholder'=>'Enter Multiplied By value', 'step' => '0.01')) !!}
                            </div>
                        </div>
                        

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Description</label>
                            <div class="col-9">
                                {!! Form::textarea('description', Input::old('description'), array('required','class'=>'form-control','placeholder'=> 'Write description here', 'cols'=>'10', 'rows'=>'5','required'=>'required')) !!}
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
   
});   
</script>
@yield('custome_script')
@overwrite
@stop