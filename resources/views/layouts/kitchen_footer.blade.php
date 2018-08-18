<footer>
    <span style="color: #505050;">Dispatch Screen</span>
    <!--<span class="order-no">Order1</span>-->
    <ul>
      <li>
        <select name="screen" class="screen" >
          <option value="master" selected="selected">Expo</option>
		  @if($barnds) 
		@foreach($barnds as $brand)
          <option value="{{$brand['_id']}}">{{$brand['name']}}</option>
		@endforeach
		@endif
        </select>
      </li>

      <li>
        <a href="javascript:void();" class="tab active" id="Completed">Completed Order</a>
      </li>
      <li>
        <a href="javascript:void();">
          <i class="fa fa fa-chevron-left"></i> Prev</a>
      </li>
      <li>
        <a href="javascript:void();">next
          <i class="fa fa fa-chevron-right"></i>
        </a>
      </li>
      <li>
        <a href="javascript:void();" onclick="fullscreen()">
          <i class="fa fa fa-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </footer>
 <script>
 $(function(){
	 $('#Completed-list-brand li').hide();
	 $('.screen').change(function(evnt){
		  evnt.preventDefault();
		 var brand=$(this).val();
		 if(brand=='master'){
			// $('#Completed-list-brand li').hide();
			// $('#Completed-list').show();
			 location.reload();

		 }else{
			 $('#Completed-list').hide();
			  $('#Completed-list-brand li').hide();
			 var cls="." + brand.toString();
			 $(cls).show();
		 }
	 });
 });
 function complete(ord_id,brand_id){
	 $.get('/complete-order/'+ord_id+'/'+brand_id,function(data){
		 if(data.status=='success'){
			 var id='#'+ord_id+'-'+brand_id;
			 $(id).remove();
		 }
	 });
 }
 function dispatch(ord_id){
	 $.get('/dispatch-order/'+ord_id,function(data){
		 if(data.status=='success'){
			 var id='#'+ord_id;
			 $(id).remove();
		 }else if(data.status=='error'){
			 alert(data.errors);
		 }
	 });
 }
 
 </script> 