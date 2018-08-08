@extends('layouts.plane')
@section('body')

<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            @include('layouts.messages',['title'=>'Add New Surcharge','path'=>['/location'=>'Location','#'=>'Surcharge']])
            @include('layouts.menu',['tabList'=>$tabList])
            <div class="col-12">
                <div class="card-box">
                    <p class="text-muted m-b-30 font-14">
                    </p>
                    {!! Form::open(array('url' => 'surcharge/update/'.$surcharge_data->_id,'class'=>'form-horizontal', 'method'=>'post')) !!}

                    <div class="row">
                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Surcharge Name</label>
                            <div class="col-9">
                                {!! Form::text('name', $surcharge_data->name, array('required','class'=>'form-control','placeholder'=>'Enter Surcharge Name')) !!}
                            </div>
                        </div>

                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Surcharge Amount</label>
                            <div class="col-9">
                                {!! Form::text('amount', $surcharge_data->amount, array('required','class'=>'form-control','placeholder'=>'Enter Surcharge Amount')) !!}
                            </div>
                        </div>
                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Surcharge Type</label>
                            <div class="col-9">
                                {!! Form::select('type', $surcharge_type, $surcharge_data->type, ['class' => 'form-control margin']) !!}
                            </div>
                        </div>
                        <div class="form-group row col-sm-6">
                            <label class="col-3 col-form-label">Select Order Type</label>
                            <div class="col-9">
                                {!! Form::select('order_type[]', $order_type_list, array_column($surcharge_data->order_type,'_id'), ['multiple' => true, 'class' => 'form-control margin']) !!}
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
