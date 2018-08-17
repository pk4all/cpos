@extends('layouts.kitchen')
@section('body')
<div class="main-container" id="expo">
    <ul class="grid-list" id="Completed-list">
        @if(count($orderData)>0)
        @foreach($orderData as $order)
        <li>
            <div class="head-sec">
                <div class="right-sec">Order#{{isset($order['order_id'])?$order['order_id']:''}}</div>
            </div>
            <div class="body-sec">
                <div class="all-brand">
                    @if(is_array($order['brand_status']))
                    @foreach($order['brand_status'] as $key=>$brand)
                    <div class="brand">
                        <div class="brand{{$key+1}}">
                            <div class="left-sec">{{$brand['name']}}</div>

                            <!-- <div class="right-sec">Ready</div> -->

                            <div class="right-sec brand-status">{{$brand['status']}}</div>

                        </div>
                        @if(is_array($order['cart_items']))
                        @foreach($order['cart_items'] as $key=>$product)
                        @if($brand['_id'] == $product['brand']['_id'])
                        <div class="item-list">
                            <div class="item">
                                <h3>
                                    <span class="num">{{$key+1}}</span>
                                    <span class="title">{{$product['item']['name']}}</span>
                                </h3>
<!--                                <ul class="menu-list">
                                    <li>
                                        <span>Crust: Gluten Free</span>
                                    </li>
                                </ul>-->
                                <ul class="menu-list">
                                    <li>
                                        <span></span>
                                    </li>
                                </ul>

                            </div>
                        </div>
                        @endif
                        @endforeach
                        @endif
                    </div>
                    @endforeach
                    @endif
                    <!-- <div class="brand">
                      <div class="brand4">
                        <div class="left-sec">NKD</div>
        
                        <div class="right-sec">Ready</div>
        
                        <div class="right-sec">In Kitchen</div>
        
                      </div>
        
                      <div class="item-list">
                        <div class="item">
                          <h3>
                            <span class="num">1</span>
                            <span class="title">superbiotic</span>
                          </h3>
                          <ul class="menu-list">
                            <li>
                              <span>Crust: Gluten Free</span>
                            </li>
                          </ul>
                          <ul class="menu-list">
                            <li>
                              <span></span>
                            </li>
                          </ul>
        
                        </div>
                      </div>
                    </div>
                    -->
                </div>
            </div>


            <div class="footer-sec">
                <div class="left-sec timer">00:00</div>
                <div class="right-sec">
                    @if(strtolower($order['order_status'])=='ready')   
                    <button type="button" class="dispach_btn">Dispatch</button>
                    @endif
                </div>
            </div>

        </li>
        @endforeach
        @endif


    </ul>
    @if(count($orderData)>0)
    @foreach($orderData as $order)
    @if(is_array($order['brand_status']))
    <ul class="grid-list" id="Completed-list">
        @foreach($order['brand_status'] as $key=>$brand)
        @if(strtolower($brand['status'])!='ready')  
        @include('pos.brand_kitchen',['brand'=>$brand,'order'=>$order,'key'=>$key,'count'=>count($order['brand_status'])])
        @endif
        @endforeach
    </ul>

    @endif           
    @endforeach
    @endif
</div>




@stop