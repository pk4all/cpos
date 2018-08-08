@extends('layouts.plane')
@section('body')

<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            @include('layouts.messages',['title'=>'Edit Category','path'=>['/menu'=>'Menu','#'=>'Category']])
            @include('layouts.menu',['tabList'=>$tabList])
            <div class="col-12">
                <div class="card-box">
                    <p class="text-muted m-b-30 font-14">
                    </p>
                    {!! Form::open(array('url' => 'category/update/'.$category_data->_id,'class'=>'form-horizontal', 'method'=>'post')) !!}

                    <div class="row">
                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Parent Category</label>
                            <div class="col-9">
                            {!! Form::select('parent', $category_list, array_column($category_data->parent,'_id'), ['class' => 'form-control margin']) !!}
                            </div>
                        </div>

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Category Name</label>
                            <div class="col-9">
                                {!! Form::text('name', $category_data->name, array('required','class'=>'form-control','placeholder'=>'Enter Category Name')) !!}
                            </div>
                        </div>

                        <div class="form-group row col-sm-6">
                            <label class="col-3 col-form-label">Select Store</label>
                            <div class="col-9">
                            {!! Form::select('store', $store_list,  array_column($category_data->store,'_id'), ['class' => 'form-control margin']) !!}
                            </div>
                        </div>


                        <div class="form-group row col-sm-6">
                            <label class="col-3 col-form-label">Select Order Type</label>
                            <div class="col-9">
                                {!! Form::select('brand', $brand_list, array_column($category_data->brand,'_id'), ['class' => 'form-control margin']) !!}
                            </div>
                        </div>


                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Category Short Description</label>
                            <div class="col-9">
                            {!! Form::textarea('description', $category_data->description, array('class'=>'form-control','placeholder'=>'Enter Category Short Description')) !!}
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
    $(function () {
        $("#order_type").on('change', function () {
            var option = "";
            $('#order_type :selected').each(function (i) {
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
