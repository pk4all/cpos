<div >
	
    <div >
    	<ul id="sortable">
    		@if(is_array($data->included_modifier_groups))
                @foreach($data->included_modifier_groups as $modifier_groups)
                <li data-group-id="{{$modifier_groups['_id']}}">
                	<span class="icon"></span>
                	{{$modifier_groups['name']}}
                </li>
                @endforeach
            @endif
    		
    	</ul>
    </div>
    <br>
    <div id="statusMsg"></div>
</div>

@section('custome_script')
<script>
$(function(){
	$('#sortable').sortable({
		stop: function( event, ui ) {
            var newOrder = [];
            var _token = $("input[name='_token']").val();
            $('#sortable li').each(function(){
                newOrder.push($(this).attr('data-group-id'));
            }); 
            $.ajax({
            	url : '/item/save-sort-order/{{$data->id}}',
            	type : 'POST',
            	data : { _token:_token, newOrder:newOrder},
            	success : function(data){
            		statusData = JSON.parse(data);
            		if(statusData.status == 'success'){
            			$('#statusMsg').show().css({color:'green'}).html(statusData.message);
            			setTimeout(function(){
            				$('#statusMsg').hide('slow');
            			}, 2000);
            		}
            	},
            	error: function(err){

            	}
            });
        }
	});
});
@yield('custome_script')