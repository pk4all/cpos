<div class="row">
    <div class="col-sm-12">
        <div class="card-box">
            <div class="table-responsive">
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
                            <td>{{$data->first_name}}</td>
                            <td>{{$data->last_name}}</td>
                            <td>{{$data->email}}</td>
                            <td>{{$data->role_name}}</td>
                            <td>
                                <a href="{{ URL::to('users/edit/' .$data->_id) }}" class="on-default edit-row" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                                <a href="javascript:void(0);" class="on-default remove-row"  data-placement="top" data-href="{{ URL::to('users/destroy/' . $data->_id) }}" title="Delete" data-toggle="modal" data-target="#confirmDelete" data-original-title="Delete" data-message="Are you sure you want to delete this User ?"><i class="fa fa-trash-o"></i></a>
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
