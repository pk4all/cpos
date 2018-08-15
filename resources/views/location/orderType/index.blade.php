@extends('layouts.plane')
@section('body')
<?php $type = ['area' => 'Define By Area', 'gmap' => '  Define On Google Map']; ?>
<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            @include('layouts.messages',['title'=>'Order Types','path'=>['#'=>'Order Types']])
            @include('layouts.menu',['tabList'=>$tabList])
        </div>    

        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col-sm-8">

                        </div>
                        <div class="col-sm-4">
                            <a href="javascript:void(0)" class="btn btn-default btn-md waves-effect waves-light m-b-30 pull-right" onclick="add();"><i class="md md-add"></i> Add Order Type</a>
                        </div>
                    </div>
                    <div class="">
                        @if(count($list)>0) 
                        <table class="table table-hover m-0 table table-actions-bar">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Store</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $key=>$data)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$data->name}}</td>
                                    <td>{{$data->type}}</td>
                                    <td>
                                        @if($data->store_id)
                                        @foreach($data->store_id as $id)
                                        <span class="badge">
                                            @if(isset($stores[$id]))
                                                {{$stores[$id]}}
                                            @endif 
                                        </span>
                                        @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        @if($data->status=='enable')
                                        <input type="checkbox" checked data-plugin="switchery" data-color="#5d9cec" data-size="small" data-id="{{$data->id}}" class="status" onchange="status(this);"/>
                                        @else
                                        <input type="checkbox" data-plugin="switchery" data-color="#5d9cec" data-size="small" data-id="{{$data->id}}" class="status" onchange="status(this);"/>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" class="btn btn-sm btn-primary waves-effect waves-light" onclick="edit('{{$data->id}}');"><i class="md md-edit"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <div class="text-center text-danger">
                            No Result Found
                        </div>
                        @endif
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
        @include('layouts.deleteconfirm')
    </div> <!-- end Panel -->
</div> <!-- end container -->
<!-- Modal -->
<div class="modal" id="add_popup" tabindex="-1" role="dialog"  aria-hidden="false">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
            </div>
            <div class="modal-body">		

                {!! Form::open(array('url' => '#',"id"=>"add",'onsubmit'=>"savedata();return false;")) !!}
                <div class="panel panel-default">
                    <div class="panel-body panel-body-nopadding row">
                        <div class="col-8">
                            <div class="form-group row">
                                <label class="col-4 col-form-label">Order Type Label</label>
                                <div class="col-8">
                                    <div class="input text required"><input name="name" class="form-control required" required="required" maxlength="255" id="name" type="text"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 control-label">Order Type</label>
                                <div class="col-sm-8">
                                    <label style="padding:10px" for="order-type-pickup"><input name="type" value="Pickup" id="order-type-pickup" type="radio">  Pickup</label><label style="padding:10px" for="order-type-delivery"><input name="type" value="Delivery" id="order-type-delivery" type="radio">  Delivery</label><label style="padding:10px" for="order-type-dining"><input name="type" value="Dining" id="order-type-dining" type="radio">  Dining</label>
                                </div>
                            </div>

                        </div>
                        <div class="col-4">
                            <div class="form-group row">
                                <h4>Stores</h4>
                                <div class="col-12">

                                    @if($stores)
                                    <div class="ckbox ckbox-primary">
                                        <input name="store_id[]" value="0" id="checkbox0" onclick="checkAll(this);" type="checkbox">
                                        <label for="checkbox0">All Stores</label>
                                    </div>
                                    @foreach($stores as $key=>$store)
                                    <div class="ckbox ckbox-primary">
                                        <input name="store_id[]" value="{{$key}}" id="{{$key}}" type="checkbox">
                                        <label for="{{$key}}">{{$store}}</label>
                                    </div>
                                    @endforeach
                                    @endif

                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button id="save" class="btn btn-primary" type="submit">Save</button>
                </div>
                </form>	
            </div>
        </div>
    </div>
</div>

<div class="modal" id="edit_popup" tabindex="-1" role="dialog">
    <div class="modal-dialog  modal-lg" role="document">
        <div  class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Delivery Store</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body"> 

            </div>
        </div>
    </div>
</div>



<script src="{{ asset('assets/plugins/switchery/js/switchery.min.js')}}"></script>
<link rel="stylesheet" href="{{ ('assets/plugins/switchery/css/switchery.min.css')}}" />

<style>
    .mails td:last-of-type {
        width: auto;
    }
</style>
<script>
                                            var siteurl = '<?php echo url('/'); ?>';
                                            var crsf = '{{csrf_token()}}';
                                            function add(){
                                            $('#add_popup .modal-title').html('Add Delivery Store');
                                            $('#add_popup').modal('show');
                                            }
                                            var $btn;
                                            function savedata(){
                                            var form = $('#add')[0];
                                            var formData = new FormData(form);
                                            $.ajax({
                                            method:'POST',
                                                    url:siteurl + '/order-type/save',
                                                    dataType: "JSON",
                                                    data: formData,
                                                    processData: false,
                                                    contentType: false,
                                                    cache: false,
                                                    beforeSend:function(){
                                                    $btn = $('#save').button('loading');
                                                    $('.error-message').remove();
                                                    },
                                                    success:function(res){
                                                    $btn.button('reset');
                                                    if (res.status == 'success'){
                                                    $('#save').html(res.msg);
                                                    window.location.href = siteurl + '/order-type';
                                                    }
                                                    if (res.status == 'error'){
                                                    $('#msg').html('<span class="error-message">' + res.msg + '</span>');
                                                    }
                                                    }
                                            });
                                            }

                                            function edit(id){
                                            //$('#loader').removeClass('hide');
                                            $('#edit_popup').modal('show');
                                            $.get(siteurl + '/order-type/edit/' + id, function(data){
                                            $('#loader').addClass('hide');
                                            $('#edit_popup .modal-body').html(data);
                                            $('#edit_popup').modal('show');
                                            });
                                            }
                                            function saveEditdata(){
                                            var form = $('#edit')[0];
                                            var formData = new FormData(form);
                                            $.ajax({
                                            method:'POST',
                                                    url:siteurl + '/order-type/save-edit',
                                                    dataType: "JSON",
                                                    data: formData,
                                                    processData: false,
                                                    contentType: false,
                                                    cache: false,
                                                    beforeSend:function(){
                                                    $btn = $('#saveEdit').button('loading');
                                                    $('.error-message').remove();
                                                    },
                                                    success:function(res){
                                                    $btn.button('reset');
                                                    if (res.status == 'success'){
                                                    $('#saveEdit').html(res.msg);
                                                    window.location.href = siteurl + '/order-type';
                                                    }
                                                    if (res.status == 'error'){
                                                    $('#edit-msg').html('<span class="error-message">' + res.msg + '</span>');
                                                    }
                                                    }
                                            });
                                            }

                                            function status(obj){
                                            if (obj.checked == true){
                                            var status = 'enable';
                                            } else{
                                            var status = 'disable';
                                            }
                                            $.ajax({
                                            method:'POST',
                                                    url:siteurl + '/order-type/change-status',
                                                    dataType: "JSON",
                                                    data: {id:$(obj).data('id'), status:status, _token:'{{ csrf_token()}}'},
                                                    beforeSend:function(){
                                                    //$('#loader').removeClass('hide');
                                                    },
                                                    success:function(res){
                                                    //$('#loader').addClass('hide');
                                                    }
                                            });
                                            }

                                            function checkAll(obj){
                                            if ($(obj).prop("checked") == true){
                                            $('input[name="store_id[]"]').prop('checked', true);
                                            }
                                            else if ($(obj).prop("checked") == false){
                                            $('input[name="store_id[]"]').prop('checked', false);
                                            }
                                            }
</script>
<!-- Modal -->
@stop
