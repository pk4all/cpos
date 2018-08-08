@extends('layouts.plane')
@section('body')
<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            @include('layouts.messages',['title'=>'Edit Brands','path'=>['/brands'=>'Brands','#'=>'Edit']])
            @include('layouts.menu',['tabList'=>$tabList])
            <div class="col-12">
                <div class="card-box">
                    <p class="text-muted m-b-30 font-14">
                    </p>
                    {!! Form::open(array('url' => 'brands/update/'.$brands_data->_id,'class'=>'form-horizontal','enctype'=>'multipart/form-data', 'method'=>'post')) !!}

                    <div class="row">
                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Name</label>
                            <div class="col-9">
                                {!! Form::text('name', $brands_data['name'], array('required','class'=>'form-control','placeholder'=>'Enter Brand Name')) !!}
                            </div>
                        </div>
                        <div class="form-group row col-sm-6">
                            <label class="col-3 col-form-label">Select Stores</label>
                            <div class="col-9">
                                {!! Form::select('store_city[]', $storeCity, array_column($brands_data->stores,'_id'), ['multiple' => true, 'class' => 'form-control margin']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Logo</label>
                            <div class="col-9">
                                {!! Form::file('logo', Input::old('logo'), array('required','class'=>'form-control','id'=>'fileHelp')) !!}
                                <small id="fileHelp" class="form-text text-muted">Please upload image in png,jpg format</small>
                            </div>
                        </div>

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Description</label>
                            <div class="col-9">
                                {!! Form::textarea('description', $brands_data['description'], array('required','class'=>'form-control','placeholder'=> 'Write description here', 'cols'=>'10', 'rows'=>'5','required'=>'required')) !!}
                            </div>
                        </div>
                    </div>




                    {!! Form::submit('Save!', array('class' => 'btn btn-primary')) !!}
                    {!! Form::close() !!}
                </div>

            </div> </div>



    </div> <!-- end Panel -->
</div> <!-- end container -->
@section('custome_script')
<script>

</script>
@yield('custome_script')
@overwrite
@stop
