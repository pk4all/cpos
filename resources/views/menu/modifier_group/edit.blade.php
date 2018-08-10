@extends('layouts.plane')
@section('body')
<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
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
                            {!! Form::select('modifiers[]', $modifiers, array_column($modifier_group_data->modifiers,'_id'), array('multiple' => true,'class'=>'form-control')) !!}
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
});
</script>
@yield('custome_script')
@overwrite
@stop
