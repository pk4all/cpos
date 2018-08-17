@extends('layouts.plane')
@section('body')
<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row sub-tab-list">
            @include('layouts.messages',['title'=>'Edit Brands','path'=>['/modifier-group'=>'modifier-group','#'=>'Edit']])
            @include('layouts.menu',['tabList'=>$tabList])
            <div class="col-12">
                <div class="card-box">
                    <p class="text-muted m-b-30 font-14">
                    </p>
                    {!! Form::open(array('url' => 'modifier-group/update/'.$modifier_group_data->_id,'class'=>'form-horizontal','enctype'=>'multipart/form-data', 'method'=>'post')) !!}

                    <div class="row">
                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Group Name</label>
                            <div class="col-9">
                                {!! Form::text('name', $modifier_group_data->name, array('required','class'=>'form-control','placeholder'=>'Enter Choice Name')) !!}
                            </div>
                        </div>

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Image</label>
                            <div class="col-9">
                                <img src="{{env('IMAGE_PATH').$modifier_group_data->image}}" style="width: 50px; height: 50px;">
                                {!! Form::file('image', Input::old('image'), array('class'=>'form-control','id'=>'fileHelp')) !!}
                                <small id="fileHelp" class="form-text text-muted">Please upload image in png,jpg format</small>
                            </div>
                        </div>

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Add Modifiers</label>
                            <div class="col-9">
                            {!! Form::select('modifiers[]', $modifiers, array_column($modifier_group_data->modifiers,'_id'), array('multiple' => true,'id' => 'modifier', 'class' => 'form-control margin selectpicker', 'data-selected-text-format'=>"count", 'data-style'=>"btn-white")) !!}
                            </div>
                        </div>


                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Choice</label>
                            <div class="col-9">
                                {!! Form::select('choice', $choices, $modifier_group_data->choice, array('class'=>'form-control','placeholder'=> 'Select Choice')) !!}
                            </div>
                        </div>


                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Is required</label>
                            <div class="col-9">
                                {!! Form::select('is_required', $yesNoOptions, $modifier_group_data->is_required, array('class'=>'form-control')) !!}
                            </div>
                        </div>


                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Min Choice</label>
                            <div class="col-9">
                                {!! Form::number('min_choice', $modifier_group_data->min_choice, array('class'=>'form-control','placeholder'=> 'Enter Min Choice')) !!}
                            </div>
                        </div>

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Max Choice</label>
                            <div class="col-9">
                                {!! Form::number('max_choice', $modifier_group_data->max_choice, array('class'=>'form-control','placeholder'=> 'Enter Max Choice')) !!}
                            </div>
                        </div>

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">No. Of Modifiers</label>
                            <div class="col-9">
                                {!! Form::number('no_of_modifiers', $modifier_group_data->no_of_modifiers, array('class'=>'form-control','placeholder'=> 'Enter No Of Modifiers')) !!}
                            </div>
                        </div>


                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Default Modifiers</label>
                            <div class="col-9">
                                {!! Form::select('default_modifier', $defaultModifiers, array_column($modifier_group_data->default_modifier,'_id'), array('class'=>'form-control','placeholder'=> 'Select', 'id'=>'defaultModifier')) !!}
                            </div>
                        </div>
                        
                        
                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Description</label>
                            <div class="col-9">
                                {!! Form::textarea('description', $modifier_group_data['description'], array('required','class'=>'form-control','placeholder'=> 'Write description here', 'cols'=>'10', 'rows'=>'5')) !!}
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
   $(document).on('change', '#modifier', function(){
    var selectedModifiers = $('#defaultModifier').val();
    console.log(selectedModifiers);
    $('#defaultModifier').html("<option value='0'>Select</option>");
    $(this).find('option:selected').each(function(){
        var selectedOption = $(this).clone();
        if(selectedOption.attr('value') != selectedModifiers){
            selectedOption.prop('selected', false);
        }
        $('#defaultModifier').append(selectedOption);
    });
   });
});
</script>
@yield('custome_script')
@overwrite
@stop
