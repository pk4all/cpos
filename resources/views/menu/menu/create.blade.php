@extends('layouts.plane')
@section('body')

<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row sub-tab-list">
            @include('layouts.messages',['title'=>'Add New Menu','path'=>['/menu'=>'Modifier','#'=>'Create']])
            @include('layouts.menu',['tabList'=>$tabList])
            <div class="col-12">
                <div class="card-box">
                    <p class="text-muted m-b-30 font-14">
                    </p>
                    {!! Form::open(array('url' => 'item/store','class'=>'form-horizontal','enctype'=>'multipart/form-data', 'method'=>'post')) !!}

                    <div class="row">

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Category</label>
                            <div class="col-9">
                            {!! Form::select('category', $categories, Input::old('category'), array('required','class'=>'form-control', 'id' => 'menuCategory','placeholder'=>'Select')) !!}
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
                            <label class="col-3 col-form-label">Image</label>
                            <div class="col-9">
                                {!! Form::file('image', Input::old('image'), array('required','class'=>'form-control','id'=>'fileHelp')) !!}
                                <small id="fileHelp" class="form-text text-muted">Please upload image in png,jpg format</small>
                            </div>
                        </div>

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Thumb-Image</label>
                            <div class="col-9">
                                {!! Form::file('thumb_image', Input::old('thumb_image'), array('required','class'=>'form-control','id'=>'fileHelp')) !!}
                                <small id="fileHelp" class="form-text text-muted">Please upload image in png,jpg format</small>
                            </div>
                        </div>

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Tax</label>
                            <div class="col-9">
                            {!! Form::select('tax', $taxType, Input::old('tax'), array('class'=>'form-control','placeholder'=>'Select Tax')) !!}
                            </div>
                        </div>


                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">SEO Title</label>
                            <div class="col-9">
                            {!! Form::text('seo_title', Input::old('seo_title'), array('class'=>'form-control','placeholder'=>'Enter SEO Title')) !!}
                            </div>
                        </div>
                        


                       
 <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Short Description</label>
                            <div class="col-9">
                            {!! Form::textarea('short_description', Input::old('short_description'), array('class'=>'form-control','placeholder'=>'Enter Short Description','rows'=>3)) !!}
                            </div>
                        </div>
                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Group</label>
                            <div class="col-9">
                            {!! Form::select("groups[]",$groups,Input::old("groups"), array('multiple' => true,'class' => 'form-control margin selectpicker', 'data-selected-text-format'=>"count", 'data-style'=>"btn-white")) !!}
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
                            {!! Form::select("included_modifier_groups[]",$modifierGroups ,Input::old("included_modifier_groups"), array('multiple' => true,'id' => 'includedModifierGroup',  'class' => 'form-control margin selectpicker', 'data-selected-text-format'=>"count", 'data-style'=>"btn-white")) !!}
                            </div>
                        </div>

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Modifier</label>
                            <div class="col-9">
                            {!! Form::select("included_modifiers[]",$modifiers,Input::old("included_modifiers"), array('multiple' => true, 'id' => 'includedModifiers',  'class' => 'form-control margin selectpicker', 'data-selected-text-format'=>"count", 'data-style'=>"btn-white")) !!}
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
                            {!! Form::select("modifier_groups[]",$modifierGroups,Input::old("modifier_groups"), array('multiple' => true, 'id' => 'modifierGroup',  'class' => 'form-control margin selectpicker', 'data-selected-text-format'=>"count", 'data-style'=>"btn-white")) !!}
                            </div>
                        </div>

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Modifier</label>
                            <div class="col-9">
                            {!! Form::select("modifiers[]",$modifiers,Input::old("modifiers"), array('multiple' => true, 'id' => 'modifiers',  'class' => 'form-control margin selectpicker', 'data-selected-text-format'=>"count", 'data-style'=>"btn-white")) !!}
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
    var selectedModifiers = $('#includedModifiers').val();
    var addedModifiers = [];
    $('#includedModifiers').html('');
    selectedGroups.forEach(function(group){
        if(group != 0){
                count++;
                var option = "";
                $.ajax({
                    url : '/modifier-group/get-group-modfiers/'+group,
                    type : 'get',
                    success : function(data){
                        var modifiers = JSON.parse(data);
                        for(modifier of modifiers){
                            var selected = '';
                            if(selectedModifiers.indexOf(modifier['_id']) > -1){
                                selected = 'selected';
                            }
                            if(addedModifiers.indexOf(modifier['_id']) < 0){
                                addedModifiers.push(modifier['_id']);
                                option += "<option value=" + modifier['_id'] + " "+selected+">" + modifier['name'] + "</option>";
                            }
                        }
                        $('#includedModifiers').append(option);
                        
                    },
                    error : function(err){

                    }
                });
            }
    });
});

   $(document).on('change', '#modifierGroup', function(){
    var selectedGroups = $(this).val();
    var selectedModifiers = $('#modifiers').val();
    var addedModifiers = [];
    var count = 0;
    $('#modifiers').html('');
    selectedGroups.forEach(function(group){       
        if(group != 0){
                count++;
                var option = "";
                $.ajax({
                    url : '/modifier-group/get-group-modfiers/'+group,
                    type : 'get',
                    success : function(data){
                        var modifiers = JSON.parse(data);
                        for(modifier of modifiers){
                            var selected = '';
                            if(selectedModifiers.indexOf(modifier['_id']) > -1){
                                selected = 'selected';
                            }
                            if(addedModifiers.indexOf(modifier['_id']) < 0){
                                addedModifiers.push(modifier['_id']);
                                option += "<option value=" + modifier['_id'] + " "+selected+">" + modifier['name'] + "</option>";
                            }
                        }
                        $('#modifiers').append(option);
                        
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