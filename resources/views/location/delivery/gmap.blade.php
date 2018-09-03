@extends('layouts.plane')
@section('body')
<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row sub-tab-list">
@include('layouts.messages',['title'=>'Delivery Store Areas','path'=>['#'=>'Delivery Store Areas']])
@include('layouts.menu',['tabList'=>$tabList])
        </div>    
        
<div class="row">
<div class="col-lg-12">
<div class="card-box">
<div class="row">
<div class="col-sm-8">
  
</div>
<div class="col-sm-4">
	<a href="/delivery-area" class="btn btn-default btn-md waves-effect waves-light m-b-30 pull-right"><i class="md md-add"></i> Delivery Stores</a>
</div>
</div>
<div class="row">
	<div class="map-area col-sm-9 nopadding" style="height:500px">
		<div id="map"></div>
	</div>
	
	<div class="col-sm-3">
	<?php if($SelectedAreas){?>
		<h4>Area Lists</h4>
		<table id="areaList" class="table table-danger">
			<tbody >
			<?php $i=0;foreach($SelectedAreas as $key=>$area){ $i++;?>
			<tr id="area-<?php echo $key; ?>"><td></td><td><?php echo 'Area '.$i;?></td><td></td><td><button class="btn btn-danger" type="button" onclick="deleteArea('<?php echo $area->id; ?>')"><i class="fa fa-trash-o"></i></button></td></tr>
			<?php }?>
			</tbody>
			</table>
			<?php }?>
	<button class="btn btn-primary col-sm-offset-2" type="button" onclick="addArea()"><i class="fa fa-plus"></i> Add Area</button>
	<button class="btn btn-primary" type="button" onclick="cancel()">cancel</button>
	</div>
</div>

</div>
</div>
</div>
</div>
</div>
<style>  
  #map {
	height: 100%;
	width: 100%;
  }
  .highlight{background-color:#badaf5cc}
  #areaList tr{cursor: pointer;}
</style>
<script>
var siteurl='<?php echo url('/');?>';
var map;
var crsf='{{ csrf_token() }}';
var polygonArray = [];
  function initMap() {
   map = new google.maps.Map(document.getElementById('map'), {
	  center: {lat: <?php echo $storeLat ?>, lng: <?php echo $storeLng ?>},
	  zoom: 11
	});
	var marker = new google.maps.Marker({
		position: {lat: <?php echo $storeLat ?>, lng: <?php echo $storeLng ?>},
		map: map
	  });
	  
	 <?php if($SelectedAreas){ foreach($SelectedAreas as $key=>$area){
			$pathArr=[];
			foreach($area->map_data as $arr){
				$pathArr[]=['lat'=>(float)$arr['lat'],'lng'=>(float)$arr['lng']];
			}
		 ?>
			 var selectedArea<?php echo $key; ?> = new google.maps.Polygon({
				paths:<?php echo json_encode($pathArr);?>,
				//strokeColor: '#000',
				strokeOpacity: 0.8,
				strokeWeight: 2,
				fillColor: '#FFC107',
				fillOpacity: 0.35,
				id:'area-<?php echo $key; ?>'
			  });
			selectedArea<?php echo $key; ?>.setMap(map);
			google.maps.event.addListener(selectedArea<?php echo $key; ?>,"mouseover",function(polygon) {
				$('#areaList tr').removeClass('highlight');
			   $('#'+this.id).addClass('highlight');
				  this.setOptions({
						strokeColor: '#ff5b5b',
						strokeWeight: 3,
				  });
			});
			google.maps.event.addListener(selectedArea<?php echo $key; ?>,"mouseout",function(polygon) {
				$('#areaList tr').removeClass('highlight');
				  this.setOptions({
						strokeColor: '#000',
						strokeOpacity: 0.8,
						strokeWeight: 2,
				  });
			});
			
			var tarea = google.maps.geometry.spherical.computeArea(selectedArea<?php echo $key; ?>.getPath());
			  //console.log((tarea/(1000*1000)).toFixed(2)+' sq km');
			  $('#area-<?php echo $key; ?> td').eq(2).html((tarea/(1000*1000)).toFixed(2)+' sq km');
		<?php }}?> 
  }
 var drawingManager;
function addArea(){
	drawingManager = new google.maps.drawing.DrawingManager({
			  drawingMode: google.maps.drawing.OverlayType.POLYGON,
			  drawingControl: false,
			  circleOptions: {
				fillColor: '#ffff00',
				fillOpacity: 1,
				strokeWeight: 5,
				clickable: false,
				editable: true,
				zIndex: 1
			  }
			});
			drawingManager.setMap(map);
			google.maps.event.addListener(drawingManager, 'polygoncomplete', function(polygon) {
				for (var i = 0; i < polygon.getPath().getLength(); i++) {
					polygonArray.push({lat:polygon.getPath().getAt(i).lat(),lng:polygon.getPath().getAt(i).lng()});
				}
				if(polygonArray.length>0){
					$.ajax({
					method:'POST',
					url:siteurl+'/delivery/save-gmap-data',
					dataType: "JSON",
					data: {id:'<?php echo $id;?>',data:polygonArray,'_token':crsf},
					beforeSend:function(){
						//$('#loader').removeClass('hide');
					},
					success:function(res){
						if(res.status=='success'){
							//$('#loader').addClass('hide');
							window.location.reload();
						}
					}
				  });
				}
			});
}
function cancel(){
	drawingManager.setMap(null);
}
function deleteArea(aId){
	$.ajax({
		method:'POST',
		url:siteurl+'/delivery/delete-gmap-area',
		dataType: "JSON",
		data: {id:aId,'_token':crsf},
		beforeSend:function(){
			//$('#loader').removeClass('hide');
		},
		success:function(res){
			if(res.status=='success'){
				//$('#loader').addClass('hide');
				window.location.reload();
			}
		}
	  });
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDwqtAnfT69akRlCk5ln84DGLWzwraLOh8&libraries=geometry,drawing&callback=initMap"
         async defer></script>

@stop