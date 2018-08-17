
<li class='{{$brand['_id']}} hide'>
    <div class="head-sec">
        <div class="left-sec">{{$brand['name']}}</div>
        <div class="right-sec">Order#{{isset($order['order_id'])?$order['order_id']:''}} {{$key+1}}/{{$count}}</div>
    </div>

    <div class="body-sec">


        @if(is_array($order['cart_items']))
        {{--*/ $count = 1 /*--}}
        @foreach($order['cart_items'] as $key=>$product)
        @if($brand['_id'] == $product['brand']['_id'])
        <div class="item-list">
            <div class="item">
                <h3>
                    <span class="num">{{$count++}}</span>
                    <span class="title">{{$product['item']['name']}}</span>
                </h3>
            </div>

        </div>
        @endif
        @endforeach
        @endif


    </div>

    <div class="footer-sec">
        <div class="left-sec timer">00:00</div>
        <div class="right-sec"><a href="javascript:void(0)">Complete</a>
        </div>
    </div>

</li>