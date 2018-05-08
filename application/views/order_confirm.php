<?php $loginedUser = $this -> session -> userdata('loginedUser');?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>确认订单</title>
  <base href="<?php echo site_url();?>">
  <link rel="stylesheet" href="assets/css/common.css">  
  <link rel="stylesheet" href="assets/css/confirmorder.css">
  <link rel="stylesheet" href="assets/css/footer.css">
</head>
<body>
  <!-- header -->
  <?php include 'header.php';?>
  <!-- header -->
  <div id="confirmorder">
    <div class="wrapper">
      <div class="submitsuccess">
        <div class="el-alert">
          <span class="complate-order"></span>
          <span class="order-tishi">订单提交成功!</span>
          <span class="close-order"></span>
        </div>
      </div>
      <div class="orderinfo">
        <div style="width: 90%;display: flex; margin: 0px auto; padding: 30px;">
          <span class="order-title">订单编号</span>
          <span class="order-num">2018042409532387633</span>
        </div>
        <span class="houseinfo-span1">入住信息：</span>
        <div style="width: 90%; margin: 0px auto; padding: 20px;">
          <table>
              <thead>
                <tr>
                  <th>入住日期</th>
                  <th>退房日期</th>
                  <th class="third">房源信息</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>2018-04-25</td>
                  <td>2018-04-26</td>
                  <td class="third">悦居公寓 康泰嘉园 简约三室 三床房(哈尔滨市道里区群力新区滇池东路2129号（康泰嘉园南2门右侧）)</td>
                </tr>
              </tbody>
            </table>
        </div>

        <span class="houseinfo-span1">预定信息：</span>
        <div style="width: 90%; margin: 0px auto; padding: 20px;">
          <table class="userinfo">
              <thead>
                <tr>
                  <th>联系人</th>
                  <th>手机号码</th>
                  <th class="third">紧急联系人电话</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>沈勇</t>
                  <td>13900000000</td>
                  <td class="third">13900000000</td>
                </tr>
              </tbody>
            </table>
        </div>

        <span class="houseinfo-span1">订单费用：</span>        
        <div style="width: 90%;display: flex; margin: 0px auto; padding: 30px;">
          <span class="order-title">订单费用：</span>
          <span class="order-num">￥358.00</span>
        </div>
        <div class="commit">
          <button v-on:click="commitOrder">提交订单</button>
        </div>
      </div>
    </div>
  </div>
  <!-- footer -->
  <?php include 'footer.php';?>
  <!-- footer -->





  <input type="hidden" id="current-index" value="user">    
  <script src="assets/js/jquery-1.12.4.min.js"></script>
  <script src="assets/js/header.js"></script>   
  <script>
    $('.close-order').on('click', function(){
      $('.submitsuccess').hide(400);
    });
  
  
  
  
  </script>
</body>
</html>