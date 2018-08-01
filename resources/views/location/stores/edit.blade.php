@extends('layouts.plane')
@section('body')
<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            @include('layouts.messages',['title'=>'Edit Store','path'=>['/stores'=>'Store','#'=>'Edit']])
            <div class="col-12">
                <div class="card-box">
                    <p class="text-muted m-b-30 font-14">
                    </p>
                    {!! Form::open(array('url' => 'stores/update/'.$stores_data->_id,'class'=>'form-horizontal')) !!}

                    <div class="row">
                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Name</label>
                            <div class="col-9">
                                {!! Form::text('name', $stores_data['name'],  array('required','class'=>'form-control','placeholder'=>'Enter Store Name')) !!}
                            </div>
                        </div>
                        <div class="form-group row col-sm-6">
                            <label class="col-3 col-form-label">Email</label>
                            <div class="col-9">
                                {!! Form::email('email', $stores_data['email'],  array('required','class'=>'form-control','placeholder'=>'Enter Store Email')) !!}
                            </div>
                        </div>
                        <div class="form-group row col-sm-6">
                            <label class="col-3 col-form-label">Notify Email</label>
                            <div class="col-9">
                                {!! Form::email('notification_email', $stores_data['notification_email'],  array('required','class'=>'form-control','placeholder'=>'Enter Store Notification Email')) !!}
                            </div>
                        </div>
                        <div class="form-group row  col-sm-6">
                            <label class="col-3 col-form-label">Phone</label>
                            <div class="col-9">
                                {!! Form::text('phone', $stores_data['phone'],  array('required','class'=>'form-control','placeholder'=>'Enter Store Phone')) !!}
                            </div>
                        </div>
                        <div class="form-group row col-sm-6">
                            <label class="col-3 col-form-label">Print Label</label>
                            <div class="col-9">
                                {!! Form::text('print_label', $stores_data['print_label'],  array('required','class'=>'form-control','placeholder'=>'Enter Store Print Label')) !!}
                            </div>
                        </div>
                        <div class="form-group row col-sm-6">
                            <label class="col-3 col-form-label">Tax ID</label>
                            <div class="col-9">
                                {!! Form::text('tax_id', $stores_data['tax_id'],  array('required','class'=>'form-control','placeholder'=>'Enter Store Tax ID')) !!}
                            </div>
                        </div>
                        <!--<div class="form-group row col-sm-6">
                            <label class="col-3 col-form-label">Image</label>
                            <div class="col-9">
                            {!! Form::text('image', $stores_data['image'],  array('required','class'=>'form-control','placeholder'=>'Enter Store image')) !!}
                            </div>
                        </div>-->
                        <div class="form-group row col-sm-6">
                            <label class="col-3 col-form-label">Address</label>
                            <div class="col-9">
                                {!! Form::text("address[label]", $stores_data['address']['label'], array('required','class'=>'form-control','placeholder'=>'Enter Store Address')) !!}
                            </div>
                        </div>
                        <div class="form-group row col-sm-6">
                            <label class="col-3 col-form-label">City</label>
                            <div class="col-9">
                                {!! Form::text("address[city]", $stores_data['address']['city'], array('required','class'=>'form-control','placeholder'=>'Enter Store City')) !!}
                            </div>
                        </div>
                        <div class="form-group row col-sm-6">
                            <label class="col-3 col-form-label">State</label>
                            <div class="col-9">
                                {!! Form::text("address[state]", $stores_data['address']['state'], array('required','class'=>'form-control','placeholder'=>'Enter Store State')) !!}
                            </div>
                        </div>
                        <div class="form-group row col-sm-6">
                            <label class="col-3 col-form-label">Country</label>
                            <div class="col-9">
                                {!! Form::select("address[country]",$contryList, $stores_data['address']['country'], array('required','class'=>'form-control','placeholder'=>'Enter Store Country')) !!}
                            </div>
                        </div>
                        <div class="form-group row col-sm-6">
                            <label class="col-3 col-form-label">Zip Code</label>
                            <div class="col-9">
                                {!! Form::text("address[zip_code]", $stores_data['address']['zip_code'], array('required','class'=>'form-control','placeholder'=>'Enter Store Zip Code')) !!}
                            </div>
                        </div>
                        <div class="form-group row col-sm-6">
                            <label class="col-3 col-form-label">Radius</label>
                            <div class="col-9">
                                {!! Form::number('radius', $stores_data['radius'],  array('required','class'=>'form-control','placeholder'=>'Enter Store Radius')) !!}
                            </div>
                        </div>
                        <div class="form-group row col-sm-6">
                            <label class="col-3 col-form-label">Latitude</label>
                            <div class="col-9">
                                {!! Form::text('latitude', $stores_data['latitude'],  array('required','class'=>'form-control','placeholder'=>'Enter Store Latitude')) !!}
                            </div>
                        </div>
                        <div class="form-group row col-sm-6">
                            <label class="col-3 col-form-label">Longitude</label>
                            <div class="col-9">
                                {!! Form::text('longitude', $stores_data['longitude'],  array('required','class'=>'form-control','placeholder'=>'Enter Store Longitude','placeholder'=>'Enter Store Longitude')) !!}
                            </div>
                        </div>

                    </div>
                   @foreach($stores_data['store_timing'] as $key=>$timing)
                    <div class="row">
                        <div class="form-group row col-sm-6">
                            <label class="col-3 col-form-label">Day From</label>
                            <div class="col-4 clockpicker " data-placement="top" data-align="top" data-autoclose="true">
                                 {!! Form::select("store_timing[from_day][]",$days, $timing[''], array('required','class'=>'form-control','placeholder'=>'Enter Store Country')) !!}
                            </div>
                            <label class="col-1 col-form-label">To</label>
                            <div class="col-4 clockpicker " data-placement="top" data-align="top" data-autoclose="true">
                                {!! Form::select("store_timing[to_day][]",$days, $stores_data['address']['country'], array('required','class'=>'form-control','placeholder'=>'Enter Store Country')) !!}
                            </div>

                        </div>
                        <div class="form-group row col-sm-6">
                            <label class="col-3 col-form-label">Time From</label>
                            <div class="col-4 clockpicker " data-placement="top" data-align="top" data-autoclose="true">
                                {!! Form::text("store_timing[from_time][]", $stores_data['address']['zip_code'], array('required','class'=>'form-control','placeholder'=>'Select Store Timing')) !!}
                            </div>
                            <label class="col-1 col-form-label">To</label>
                            <div class="col-4 clockpicker " data-placement="top" data-align="top" data-autoclose="true">
                               {!! Form::text("store_timing[to_time][]", $stores_data['address']['zip_code'], array('required','class'=>'form-control','placeholder'=>'Select Store Timing')) !!}
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="row">
                        <div class="form-group row col-sm-6">
                            <label class="col-3 col-form-label">Day From</label>
                            <div class="col-4 clockpicker " data-placement="top" data-align="top" data-autoclose="true">
                                 {!! Form::select("store_timing[from_day][]",$days, $stores_data['address']['country'], array('required','class'=>'form-control','placeholder'=>'Enter Store Country')) !!}
                            </div>
                            <label class="col-1 col-form-label">To</label>
                            <div class="col-4 clockpicker " data-placement="top" data-align="top" data-autoclose="true">
                                {!! Form::select("store_timing[to_day][]",$days, $stores_data['address']['country'], array('required','class'=>'form-control','placeholder'=>'Enter Store Country')) !!}
                            </div>

                        </div>
                        <div class="form-group row col-sm-6">
                            <label class="col-3 col-form-label">Time From</label>
                            <div class="col-4 clockpicker " data-placement="top" data-align="top" data-autoclose="true">
                                {!! Form::text("store_timing[from_time][]", $stores_data['address']['zip_code'], array('required','class'=>'form-control','placeholder'=>'Select Store Timing')) !!}
                            </div>
                            <label class="col-1 col-form-label">To</label>
                            <div class="col-4 clockpicker " data-placement="top" data-align="top" data-autoclose="true">
                               {!! Form::text("store_timing[to_time][]", $stores_data['address']['zip_code'], array('required','class'=>'form-control','placeholder'=>'Select Store Timing')) !!}
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
    $('.clockpicker').clockpicker({
        donetext: 'Done'
    });
</script>
@yield('custome_script')
@overwrite
@stop
