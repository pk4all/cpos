@extends('layouts.plane')
@section('body')
<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            @include('layouts.messages',['title'=>'Edit Brands','path'=>['/modifier'=>'Modifier','#'=>'Edit']])
            @include('layouts.menu',['tabList'=>$tabList])
            <div class="col-12">
                <div class="card-box">
                    <p class="text-muted m-b-30 font-14">
                    </p>
                    {!! Form::open(array('url' => 'modifier/update/'.$modifier_data->_id,'class'=>'form-horizontal','enctype'=>'multipart/form-data', 'method'=>'post')) !!}

                    <div class="row">
                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Name</label>
                            <div class="col-9">
                                {!! Form::text('name', $modifier_data->name, array('required','class'=>'form-control','placeholder'=>'Enter Brand Name')) !!}
                            </div>
                        </div>

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Image</label>
                            <div class="col-9">
                                <img src="{{env('IMAGE_PATH').$modifier_data->image}}" style="width: 50px; height: 50px;">
                                {!! Form::file('image', Input::old('image'), array('class'=>'form-control','id'=>'fileHelp')) !!}
                                <small id="fileHelp" class="form-text text-muted">Please upload image in png,jpg format</small>
                            </div>
                        </div>
                        
                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">PLU Code</label>
                            <div class="col-9">
                            {!! Form::text('plu_code', $modifier_data->plu_code, array('required','class'=>'form-control','placeholder'=>'Enter PLU Code')) !!}
                            </div>
                        </div>

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Price</label>
                            <div class="col-9">
                            {!! Form::number('price', $modifier_data->price, array('required','class'=>'form-control','placeholder'=>'Enter Price', 'step' => '0.01')) !!}
                            </div>
                        </div>

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Choice Charge</label>
                            <div class="col-9">
                            {!! Form::select('choice_charge', $yesNoOptions, $modifier_data->choice_charge, array('required','class'=>'form-control')) !!}
                            </div>
                        </div>

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Dependent Modifier Group</label>
                            <div class="col-9">
                            {!! Form::select("dependent_modifier_group",$dependentModifierGroups, array_column($modifier_data->dependent_modifier_group,'_id'), array('class'=>'form-control', 'id' => 'dependentModifierGroup')) !!}
                            </div>
                        </div>

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Dependent Modifier</label>
                            <div class="col-9">
                            {!! Form::select("dependent_modifier",$selectGroupsModifiers, array_column($modifier_data->dependent_modifier,'_id'), array('class'=>'form-control','placeholder'=>'Select', 'id' => 'dependentModifiers')) !!}
                            </div>
                        </div>

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Dependent Modifier Count</label>
                            <div class="col-9">
                            {!! Form::number('dependent_modifier_count', $modifier_data->dependent_modifier_count, array('class'=>'form-control','placeholder'=>'Enter Dependent Modifier Count')) !!}
                            </div>
                        </div>

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">No Modifier</label>
                            <div class="col-9">
                            {!! Form::select("no_modifier",$yesNoOptions, $modifier_data->no_modifier, array('class'=>'form-control')) !!}
                            </div>
                        </div>

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Modifier Choices</label>
                            <div class="col-9">
                            {!! Form::select("modifier_choices[]",$modifierChoices, array_column($modifier_data->modifier_choices,'_id'), array('multiple'=> true, 'class'=>'form-control')) !!}
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
    $(document).on('change', '#dependentModifierGroup', function(){
    //alert('gggg');
    if($(this).val() != 0){
        var option = "<option value='0'>Select</option>";
        $.ajax({
            url : '/modifier-group/get-group-modfiers/'+$(this).val(),
            type : 'get',
            success : function(data){
                var modifiers = JSON.parse(data);
                for(modifier of modifiers){
                    option += "<option value=" + modifier['_id'] + ">" + modifier['name'] + "</option>";
                }
                $('#dependentModifiers').html(option);
                
            },
            error : function(err){

            }
        });
    }
   });
});
</script>
@yield('custome_script')
@overwrite
@stop
