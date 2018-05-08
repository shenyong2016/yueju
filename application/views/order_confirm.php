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
  <link rel="stylesheet" href="assets/css/footer.css">
  <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">      
  <link rel="stylesheet" href="assets/css/confirmorder.css">  
</head>
<body>
  <!-- header -->
  <?php include 'header.php';?>
  <!-- header -->
  <div id="confirmorder">
    <div class="wrapper">
      <el-alert
        title="订单提交成功"
        type="success"
        show-icon>
      </el-alert>
      <div class="orderinfo">
        <div style="width: 90%;display: flex; margin: 0px auto; padding: 30px;">
          <span class="order-title">订单编号</span>
          <span class="order-num">{{orderInfo.order_num}}</span>
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
                  <td>{{orderInfo.start_time}}</td>
                  <td>{{orderInfo.end_time}}</td>
                  <td class="third">{{orderInfo.village_name}} {{orderInfo.house_name}}{{orderInfo.house_address}}</td>
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
                  <td>{{orderInfo.real_name}}</t>
                  <td>{{orderInfo.phone_num}}</td>
                  <td class="third">{{orderInfo.emergency_tel}}</td>
                </tr>
              </tbody>
            </table>
        </div>

        <span class="houseinfo-span1">订单费用：</span>        
        <div style="width: 90%;display: flex; margin: 0px auto; padding: 30px;">
          <span class="order-title">订单费用：</span>
          <span class="order-num">￥{{orderInfo.total_price}}.00</span>
        </div>
        <div class="commit">
          <button v-on:click="commitOrder">去支付</button>
        </div>
      </div>
    </div>
  </div>
  <!-- footer -->
  <?php include 'footer.php';?>
  <!-- footer -->
  <input type="hidden" id="current-index" value="">    
  <script src="assets/js/jquery-1.12.4.min.js"></script>
  <script src="assets/js/header.js"></script>   
  <script src="assets/js/vue.min.js"></script>
  <script src="assets/js/axios.min.js"></script>  
  <script src="assets/js/elementUI.js"></script> 
  <script>
    $('.close-order').on('click', function(){
      $('.submitsuccess').hide(400);
    });

    new Vue({
      el: '#confirmorder',
      data: {
        orderNum: <?php echo $this->input->get('order_num');?>,
        orderInfo: {}
      },
      methods: {
        commitOrder(){
          axios.get('order/pay_order', {
            params: {
              orderNum: this.orderNum
            }
          }).then(res => {
            if(res.data == 'success'){
              this.$message({
                type: 'success',
                message: '订单支付成功，即将跳到订单详情',
                showClose: true,
                duration: 2000            
              });   
              setTimeout(() => {
                window.location.href = 'order/order_detail?orderNum='+this.orderNum;
              }, 2000);   
            }else{
              this.$message({
                type: 'error',
                message: '订单支付失败',
                showClose: true,
                duration: 2000            
              });
            }
          });
        },
        loadOrderInfo(){
          axios.get('order/get_order_info', {
            params: {
              orderNum: this.orderNum
            }
          }).then(res => {
            this.orderInfo = res.data.order;
          });
        }
      },
      created(){
        this.orderNum = window.location.href.split('?')[1].split('=')[1];
        this.$message({
          type: 'success',
          message: '恭喜你，订单提交成功',
          showClose: true,
          duration: 2000            
        });
        this.loadOrderInfo();
        console.log(this.orderNum);
      },
    });
    
  
  
  
  </script>
</body>
</html>