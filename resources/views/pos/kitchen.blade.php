@extends('layouts.kitchen')
@section('body')
<div class="main-container">
    <ul class="grid-list" id="Completed-list">
      @if(count($orderData)>0)
      @foreach($orderData as $order)
      <li>
        <div class="head-sec">
          <div class="right-sec">Order#{{$order['order_id']}}</div>
        </div>
        <div class="body-sec">
          <div class="all-brand">
            @if(is_array($order['orderTracking']))
            @foreach($order['orderTracking'] as $brand)
            <div class="brand">
              <div class="brand1">
                <div class="left-sec">{{$brand['brand']['name']}}</div>

                <!-- <div class="right-sec">Ready</div> -->

                <div class="right-sec brand-status">{{$brand['status']}}</div>

              </div>
              @if(is_array($order['products']))
              @foreach($order['products'] as $product)
              @if($brand['brand']['_id'] == $product['Brand']['_id'])
              <div class="item-list">
                <div class="item">
                  <h3>
                    <span class="num">1</span>
                    <span class="title">{{$product['name']}}</span>
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
            <button type="button" class="dispach_btn">Dispatch</button>
          </div>
        </div>

      </li>
      @endforeach
      @endif


    </ul>

  </div>
@stop