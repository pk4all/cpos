@extends('layouts.plane')
@section('body')

<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            @include('layouts.messages',['title'=>'Add New Category','path'=>['/location'=>'Location','#'=>'Category']])
            <div class="col-12">
                <div class="card-box">
                    <p class="text-muted m-b-30 font-14">
                    </p>
                    {!! Form::open(array('url' => 'category/store','class'=>'form-horizontal','enctype'=>'multipart/form-data', 'method'=>'post')) !!}

                    <div class="row">
                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Parent Category</label>
                            <div class="col-9">
                            {!! Form::select('parent_id', $category_list, null, ['class' => 'form-control margin']) !!}
                            </div>
                        </div>

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Category Name</label>
                            <div class="col-9">
                            {!! Form::text('name', Input::old('name'), array('required','class'=>'form-control','placeholder'=>'Enter Category Name')) !!}
                            </div>
                        </div>
                       
                         
                        <div class="form-group row col-sm-6">
                            <label class="col-3 col-form-label">Select Store</label>
                            <div class="col-9">
                            {!! Form::select('store', $store_list, null, ['required', 'id' => 'store',  'class' => 'form-control margin']) !!}
                            </div>
                        </div>

                        <div class="form-group row col-sm-6">
                            <label class="col-3 col-form-label">Select Barnd</label>
                            <div class="col-9">
                            {!! Form::select('brand', [0=>'Select Brand'], null, ['required', 'id' => 'brand',  'class' => 'form-control margin']) !!}
                            </div>
                        </div>

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Category Short Description</label>
                            <div class="col-9">
                            {!! Form::textarea('description', Input::old('description'), array('class'=>'form-control','placeholder'=>'Enter Category Short Description')) !!}
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