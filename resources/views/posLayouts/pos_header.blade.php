<!-- Navigation Bar-->
 <div class="topwhite_bar">
     <?php $store=session('store');
           $ordertype=session('order_type');
          
     ?>
	<div class="container-fluid">
		<button class="graybtn" onclick="window.location.href='/';">Dashboard</button>
                @if($orderTypes)
                @foreach($orderTypes as $typ)
                <a href="" class="{{$typ['_id']==$ordertype['_id']?'greenbtn':'graybtn'}}">{{$typ['name']}}</a>
                @endforeach
                @endif
 
                <p>{{$store['name']}}, {{$store['address']['label']}}, {{$store['address']['city']}}, {{$store['address']['state']}}, {{$store['address']['country']}}, {{$store['phone']}}</p>
                <button class="graybtn expandbtn"><i class="fa fa-arrows-alt"></i></button>
        </div>
     
</div>
<!-- End Navigation Bar-->
