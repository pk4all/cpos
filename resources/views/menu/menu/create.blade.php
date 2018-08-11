@extends('layouts.plane')
@section('body')

<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            @include('layouts.messages',['title'=>'Add New Menu','path'=>['/menu'=>'Modifier','#'=>'Create']])
            @include('layouts.menu',['tabList'=>$tabList])
            <div class="col-12">
                <div class="card-box">
                    <p class="text-muted m-b-30 font-14">
                    </p>
                    {!! Form::open(array('url' => 'menu/store','class'=>'form-horizontal','enctype'=>'multipart/form-data', 'method'=>'post')) !!}

                    <div class="row">

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Category</label>
                            <div class="col-9">
                            {!! Form::select('category', $categories, Input::old('category'), array('required','class'=>'form-control', 'id' => 'menuCategory')) !!}
                            </div>
                        </div>

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Sub Category</label>
                            <div class="col-9">
                            {!! Form::select('sub_category', $subCategories, Input::old('category'), array('class'=>'form-control', 'id' => 'subCategory', 'placeholder'=>'Select')) !!}
                            </div>
                        </div>

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Menu Name</label>
                            <div class="col-9">
                            {!! Form::text('name', Input::old('name'), array('required','class'=>'form-control','placeholder'=>'Enter Modifier Name')) !!}
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
                            <label class="col-3 col-form-label">Price Title</label>
                            <div class="col-9">
                            {!! Form::text('price_title', Input::old('price_title'), array('required','class'=>'form-control','placeholder'=>'Enter Price Title')) !!}
                            </div>
                        </div>

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Price</label>
                            <div class="col-9">
                            {!! Form::number('price', Input::old('price'), array('required','class'=>'form-control','placeholder'=>'Enter Price Title', 'step' => '0.01')) !!}
                            </div>
                        </div>

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">SEO Title</label>
                            <div class="col-9">
                            {!! Form::text('seo_title', Input::old('seo_title'), array('class'=>'form-control','placeholder'=>'Enter SEO Title')) !!}
                            </div>
                        </div>

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Tax</label>
                            <div class="col-9">
                            {!! Form::text('tax', Input::old('tax'), array('class'=>'form-control','placeholder'=>'Enter Tax')) !!}
                            </div>
                        </div>

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Group</label>
                            <div class="col-9">
                            {!! Form::select("groups[]",$groups,Input::old("groups"), array('multiple' => true, 'class'=>'form-control','id' => 'dependentModifierGroup', 'placeholder' => 'Select')) !!}
                            </div>
                        </div>

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Short Description</label>
                            <div class="col-9">
                            {!! Form::textarea('short_description', Input::old('short_description'), array('class'=>'form-control','placeholder'=>'Enter Short Description')) !!}
                            </div>
                        </div>

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Special Instruction</label>
                            <div class="col-9">
                            {!! Form::textarea('spl_instruction', Input::old('spl_instruction'), array('class'=>'form-control','placeholder'=>'Enter Special Instruction')) !!}
                            </div>
                        </div>



                    </div>
                    <div class="row">
                        <label class="col-12 col-form-label font-weight-bold">Included Modifiers</label>
                    </div>
                    <div class="row section">                        
                        
                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Modifier Group</label>
                            <div class="col-9">
                            {!! Form::select("included_modifier_groups[]",$modifierGroups ,Input::old("included_modifier_groups"), array('multiple' => true, 'class'=>'form-control','id' => 'includedModifierGroup')) !!}
                            </div>
                        </div>

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Modifier</label>
                            <div class="col-9">
                            {!! Form::select("included_modifiers[]",$modifiers,Input::old("included_modifiers"), array('multiple' => true, 'class'=>'form-control','placeholder'=>'Select', 'id' => 'includedModifiers')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-12 col-form-label font-weight-bold">Modifiers</label>
                    </div>
                    <div class="row section">                        
                        
                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Modifier Group</label>
                            <div class="col-9">
                            {!! Form::select("modifier_groups[]",$modifierGroups,Input::old("modifier_groups"), array('multiple' => true, 'class'=>'form-control','id' => 'modifierGroup')) !!}
                            </div>
                        </div>

                        <div class ="row col-12 modifier-options" id="modifierOptions">
                            {!! Form::hidden("group_name[]", Input::old("group_name"), array('class'=>'form-control  group_name')) !!}
                            {!! Form::hidden("group_id[]", Input::old("group_id"), array('class'=>'form-control  group_id')) !!}
                            <label class="col-12 col-form-label font-weight-bold group-name">FFFF</label>
                            <div class="form-group row  col-sm-6">
                                <label class="col-3 col-form-label">Modifier</label>
                                <div class="col-9">
                                {!! Form::select("modifier[]",$modifiers,Input::old("modifier"), array('class'=>'form-control  modifier','placeholder'=>'Select', 'id' => 'modifiers')) !!}
                                </div>
                            </div>

                            <div class="form-group row  col-sm-6">
                                <label class="col-3 col-form-label">Is Required?</label>
                                <div class="col-9">
                                {!! Form::select('is_required', $yesNoOptions, Input::old('is_required'), array('class'=>'form-control')) !!}
                                </div>
                            </div>

                            <div class="form-group row  col-sm-6">
                                <label class="col-3 col-form-label">Choice</label>
                                <div class="col-9">
                                {!! Form::select('choice[]', $choices,Input::old('choice'), array('class'=>'form-control')) !!}
                                </div>
                            </div>

                            <div class="form-group row  col-sm-6">
                                <label class="col-3 col-form-label">Min Choice</label>
                                <div class="col-9">
                                {!! Form::text('min_choice[]', Input::old('min_choice'), array('class'=>'form-control','placeholder'=>'Enter Min Choice')) !!}
                                </div>
                            </div>

                            <div class="form-group row  col-sm-6">
                                <label class="col-3 col-form-label">Max Choice</label>
                                <div class="col-9">
                                {!! Form::text('max_choice[]', Input::old('max_choice'), array('class'=>'form-control','placeholder'=>'Enter Max Choice')) !!}
                                </div>
                            </div>

                            <div class="form-group row  col-sm-6">
                                <label class="col-3 col-form-label">Free modifiers</label>
                                <div class="col-9">
                                {!! Form::number('free_modifier[]', Input::old('free_modifier'), array('class'=>'form-control','placeholder'=>'Enter No of Free Modifiers')) !!}
                                </div>
                            </div>

                            <div class="form-group row  col-sm-6">
                                <label class="col-3 col-form-label">Display Price</label>
                                <div class="col-9">
                                {!! Form::select('display_price[]', $yesNoOptions, Input::old('display_price'), array('class'=>'form-control')) !!}
                                </div>
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
   $(document).on('change', '#menuCategory', function(){
    if($(this).val() != 0){
        var option = "";
        $.ajax({
            url : '/category/get-sub-category/'+$(this).val(),
            type : 'get',
            success : function(data){
                var subCategories = JSON.parse(data);
                console.log(subCategories);
                for(subCategoryId in subCategories){
                    option += "<option value=" + subCategoryId + ">" + subCategories[subCategoryId] + "</option>";
                }
                $('#subCategory').html(option);
                
            },
            error : function(err){

            }
        });
    }
   });


   $(document).on('change', '#includedModifierGroup', function(){
    var selectedGroups = $(this).val();
    var count = 0;
    selectedGroups.forEach(function(group){
        $('#includedModifiers').html('');
        count++;
        if(group != 0){
                if(count == 1){
                    var option = "<option value='0'>Select</option>";
                }else{
                    var option = "";
                }
                var option = "";
                $.ajax({
                    url : '/modifier-group/get-group-modfiers/'+group,
                    type : 'get',
                    success : function(data){
                        var modifiers = JSON.parse(data);
                        for(modifier of modifiers){
                            option += "<option value=" + modifier['_id'] + ">" + modifier['name'] + "</option>";
                        }
                        $('#includedModifiers').html(option);
                        
                    },
                    error : function(err){

                    }
                });
            }
    });
});

   $(document).on('change', '#modifierGroup', function(){
    var selectedGroups = $(this).val();
    $('.newlyAdded').remove();
    $('#modifierOptions').addClass('hide');
    selectedGroups.forEach(function(group){
        if(group != 0){
            var groupName = $('#modifierGroup').find('option[value="'+group+'"]').text();
            var modifierOptions = $('#modifierOptions').clone();
            modifierOptions.removeClass('hide').addClass('newlyAdded').attr('id', '');
            modifierOptions.find('.group-name').html(groupName);
            modifierOptions.find('.group_name').val(groupName);
            modifierOptions.find('.group_id').val(group);
            modifierOptions.insertBefore('#modifierOptions');
            var option = "<option value='0'>Select</option>";
            $.ajax({
                url : '/modifier-group/get-group-modfiers/'+group,
                type : 'get',
                success : function(data){
                    var modifiers = JSON.parse(data);
                    for(modifier of modifiers){
                        option += "<option value=" + modifier['_id'] + ">" + modifier['name'] + "</option>";
                    }
                    modifierOptions.find('.modifier').html(option);
                    
                },
                error : function(err){

                }
            });
           
        }
    });
    


   });

});   
</script>
@yield('custome_script')
@overwrite
@stop