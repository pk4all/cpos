<div class="row">
    <div class="col-sm-12">
        <div class="card-box">
            <div class="table-responsive">
                <div class="row">
                    <div class="col-sm-8">

                    </div>
                    <div class="col-sm-4">
                        <a href="/user-roles/create" class="btn btn-default btn-md waves-effect waves-light m-b-30 pull-right"><i class="md md-add"></i> Add New</a>
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
                        @if($data->user_type==2)
                        <tr class='warning'>
                            @else
                        <tr>
                            @endif
                            <td>{{$data->role_name}}</td>
                            <td>
                                @if(count($data->permission)>0)  
                                {{ ucwords(str_replace("_"," ",implode($data->permission,', ')))}}
                                @endif
                            </td>
                            <td class="table-actions-bar">
                                <a href="{{ URL::to('user-roles/edit/' .$data->_id) }}" class="on-default edit-row table-action-btn" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                                <a href="javascript:void(0);" class="on-default remove-row"  data-placement="top" data-href="{{ URL::to('user-roles/destroy/' . $data->_id) }}" title="Delete" data-toggle="modal" data-target="#confirmDelete" data-original-title="Delete" data-message="Are you sure you want to delete this Role ?"><i class="fa fa-trash-o"></i></a>
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