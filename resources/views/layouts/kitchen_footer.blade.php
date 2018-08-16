<footer>
    <span style="color: #505050;">Dispatch Screen</span>
    <!--<span class="order-no">Order1</span>-->
    <ul>
      <li>
        <select name="screen" class="screen" onchange="changeScreen(this)">
          <option value="master" selected="selected">Expo</option>
          <option value="1">Right Bite Express</option>
          <option value="4">NKD Pizza</option>
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