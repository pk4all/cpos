@extends('layouts.plane')
@section('body')

<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            @include('layouts.messages',['title'=>'Add New Modifier Choice','path'=>['/modifier'=>'Modifier','#'=>'Create']])
            @include('layouts.menu',['tabList'=>$tabList])
            <div class="col-12">
                <div class="card-box">
                    <p class="text-muted m-b-30 font-14">
                    </p>
                    {!! Form::open(array('url' => 'modifier/store','class'=>'form-horizontal','enctype'=>'multipart/form-data', 'method'=>'post')) !!}

                    <div class="row">
                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Modifier Name</label>
                            <div class="col-9">
                            {!! Form::text('name', Input::old('name'), array('required','class'=>'form-control','placeholder'=>'Enter Choice Name')) !!}
                            </div>
                        </div>

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Image</label>
                            <div class="col-9">
                                {!! Form::file('image', Input::old('image'), array('required','class'=>'form-control','id'=>'fileHelp')) !!}
                                <small id="fileHelp" class="form-text text-muted">Please upload image in png,jpg format</small>
                            </div>
                        </div>


                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">PLU Code</label>
                            <div class="col-9">
                            {!! Form::text('plu_code', Input::old('plu_code'), array('required','class'=>'form-control','placeholder'=>'Enter PLU Code')) !!}
                            </div>
                        </div>

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Dependent Modifier Group</label>
                            <div class="col-9">
                            {!! Form::select("dependent_modifier_group",$dependentModifierGroups,Input::old("dependent_modifier_group"), array('class'=>'form-control','placeholder'=>'Select Dependent Modifier Group')) !!}
                            </div>
                        </div>

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Dependent Modifier</label>
                            <div class="col-9">
                            {!! Form::select("dependent_modifier",$dependentModifiers,Input::old("dependent_modifier"), array('class'=>'form-control','placeholder'=>'Select Dependent Modifier')) !!}
                            </div>
                        </div>

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Dependent Modifier Count</label>
                            <div class="col-9">
                            {!! Form::number('dependent_modifier_count', Input::old('dependent_modifier_count'), array('class'=>'form-control','placeholder'=>'Enter Dependent Modifier Count')) !!}
                            </div>
                        </div>

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">No Modifier</label>
                            <div class="col-9">
                            {!! Form::select("no_modifier",$yesNoOptions,Input::old("no_modifier"), array('class'=>'form-control')) !!}
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