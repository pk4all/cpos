<li class="{{$brand['_id']}}" id="{{$order['_id']}}-{{$brand['_id']}}">
    <div class="head-sec brand{{$key+1}}">
        <div class="left-sec">{{$brand['name']}}</div>
        <div class="right-sec">Order#{{isset($order['order_id'])?$order['order_id']:''}} {{$key+1}}/{{$count}}</div>
    </div>

    <div class="body-sec">

        @if(is_array($order['cart_items']))
        @php ($count = 1)
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
        <div class="right-sec"><a href="javascript:void(0)" onclick="complete('{{$order['_id']}}','{{$brand['_id']}}')">Complete</a>
        </div>
    </div>

</li>