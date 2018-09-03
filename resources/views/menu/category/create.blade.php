@extends('layouts.plane')
@section('body')

<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row sub-tab-list">
            @include('layouts.messages',['title'=>'Add New Category','path'=>['/category'=>'Category','#'=>'Category']])
            @include('layouts.menu',['tabList'=>$tabList])
            <div class="col-12">
                <div class="card-box">
                    <p class="text-muted m-b-30 font-14">
                    </p>
                    {!! Form::open(array('url' => 'category/store','class'=>'form-horizontal','enctype'=>'multipart/form-data', 'method'=>'post')) !!}

                    <div class="row">
                        <?php
                        use Illuminate\Support\Facades\Route;
                        $currentPath= Route::getFacadeRoot()->current()->uri();?>
                        @if($currentPath=='sub-category/create')
                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Parent Category</label>
                            <div class="col-9">
                            {!! Form::select('parent', $category_list, null, ['class' => 'form-control margin']) !!}
                            </div>
                        </div>
                       @endif
                        <div class="form-group row  col-sm-6">
                            @if($currentPath=='sub-category/create')
                            <label class="col-3 col-form-label">Sub Category Name</label>
                            @else
                            <label class="col-3 col-form-label">Category Name</label>
                            @endif
                            <div class="col-9">
                            {!! Form::text('name', Input::old('name'), array('required','class'=>'form-control','placeholder'=>'Enter Category Name')) !!}
                            </div>
                        </div>

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Display Name</label>
                            <div class="col-9">
                            {!! Form::text('display_name', Input::old('display_name'), array('required','class'=>'form-control','placeholder'=>'Enter Display Name')) !!}
                            </div>
                        </div>
                       
                         
                        <!-- <div class="form-group row col-sm-6">
                            <label class="col-3 col-form-label">Select Store</label>
                            <div class="col-9">
                            {!! Form::select('store', $store_list, null, ['required', 'id' => 'store',  'class' => 'form-control margin']) !!}
                            </div>
                        </div> -->

                        <div class="form-group row col-sm-6">
                            <label class="col-3 col-form-label">Select Brand</label>
                            <div class="col-9">
                            {!! Form::select('brand[]', $brandList , null, ['required', 'multiple' => true, 'id' => 'brand',  'class' => 'form-control margin selectpicker', 'data-selected-text-format'=>"count", 'data-style'=>"btn-white"]) !!}
                            </div>
                        </div>

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Short Description</label>
                            <div class="col-9">
                            {!! Form::textarea('description', Input::old('description'), array('class'=>'form-control','placeholder'=>'Enter Category Short Description', 'rows' => 3)) !!}
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
   $("#store").on('change', function () {
        // var option = "";
        // $('#store_city :selected').each(function (i) {
        //     if ($(this.length)) {
        //         option += "<option value=" + $(this).val() + ">" + $(this).text() + "</option>";
        //     }
        // });
        var selectedStore = $(this).val();
        
        if(selectedStore !=  0){
            //alert(selectedStore);
            var option = "";
            $.ajax({
                url :'/brands/get_store_brand/'+selectedStore,
                type : 'GET',
                success : function(data){
                    var brands = JSON.parse(data);
                    for(brand of brands){
                         option += "<option value=" + brand['_id'] + ">" + brand['name'] + "</option>";
                    }
                    $('#brand').append(option);
                }
            })
        }
    }); 
});   
</script>
@yield('custome_script')
@overwrite
@stop