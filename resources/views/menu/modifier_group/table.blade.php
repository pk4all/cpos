<div class="row">
    <div class="col-sm-12">
        <div class="card-box">
            <div class="table-responsive">
                <div class="row">
                    <div class="col-sm-8">

                    </div>
                    <div class="col-sm-4">
                        <a href="/modifier-group/create" class="btn btn-default btn-md waves-effect waves-light m-b-30 pull-right"><i class="md md-add"></i> Add New</a>
                    </div>
                </div>
                <table id="mainTable" class="table table-striped m-b-0" style="cursor: pointer;">
                    <thead>
                        <tr>
                            @foreach($tbl_header as $header)
                            <th>{{$header}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($tbl_data)>0)  
                        @foreach($tbl_data as $data)
                        <tr>
                           
                            <td>{{$data->name}}</td>
                            <td>
                                <img src="{{env('IMAGE_PATH').$data->image}}" style="width: 50px; height: 50px;">
                            </td>
                            <td>
                            @if(is_array($data->modifiers))
                                @foreach($data->modifiers as $modifier)
                                <span class="badge">{{$modifier['name']}}</span>&nbsp;&nbsp;
                                @endforeach
                            @endif
                            </td>
                            <td>
                                <a href="{{ URL::to('modifier-group/edit/' .$data->_id) }}" class="on-default edit-row" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                                @if(isset($data['status']) && $data['status']=='enable')
                                <a class="md md-visibility" href="{{ URL::to('modifier-group/update-status/' .$data['_id']) }}" title="click for disable " data-value="Status"></a>
                                @else
                                <a class="md md-visibility-off" href="{{ URL::to('modifier-group/update-status/' .$data['_id']) }}" title="click for Enable " data-value="Status"></a>
                                @endif


                                <a href="javascript:void(0);" class="on-default remove-row"  data-placement="top" data-href="{{ URL::to('modifier-group/destroy/' . $data->_id) }}" title="Delete" data-toggle="modal" data-target="#confirmDelete" data-original-title="Delete" data-message="Are you sure you want to delete this Brands ?"><i class="fa fa-trash-o"></i></a>
                            </td>

                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="{{count($tbl_header)}}" class="text-center text-danger">
                                No Result Found
                            </td>
                        </tr>
                        @endif
                    </tbody>

                </table>
                <input style="position: absolute; display: none;"></div>
        </div>
    </div>
</div>
{!! $tbl_data->render()!!}