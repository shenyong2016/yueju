<?php $loginedUser = $this -> session -> userdata('loginedUser');?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>订单详情</title>
  <base href="<?php echo site_url();?>">
  <link rel="stylesheet" href="assets/css/common.css">
  <link rel="stylesheet" href="assets/css/footer.css">
  <link rel="stylesheet" href="assets/css/order_detail.css">
  <!-- <link rel="stylesheet" href="assets/css/elementUI.css">     -->
  <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">    
</head>
<body>
  <!-- header -->
  <?php include 'header.php';?>
  <!-- header -->
  <div id="order-info">
    <div class="wrapper">
      <div class="order-name">订单详情</div>      
      <div class="order-content" style="width: 90%;display: flex; margin: 0px auto; padding: 30px;">
        <div class="order-left">
          <!-- house-group -->
          <div class="house-group">
            <a :href=`house/detail/${orderInfo.house_id}`>
              <div class="pic-box">
                <img :src="`../../${orderInfo.img_src}`" alt="">
              </div>
            </a>
          </div>
          <!-- house-group -->
        </div>
        <div class="order-right">
          <p class="order-list">
            <span class="order-list-title">订单编号：</span>
            <span class="order-list-con">{{orderInfo.order_num}}</span>
          </p>
          <p class="order-list">
            <span class="order-list-title">房源信息：</span>
            <span class="order-list-con order-list-house">{{orderInfo.village_name}} {{orderInfo.house_name}} （{{orderInfo.house_address}}）</span>
          </p>
          <p class="order-list">
            <span class="order-list-title">入住日期：</span>
            <span class="order-list-con">{{orderInfo.start_time.split(' ')[0]}}</span>
          </p>
          <p class="order-list">
            <span class="order-list-title">退房日期：</span>
            <span class="order-list-con">{{orderInfo.end_time.split(' ')[0]}}</span>
          </p>
          <p class="order-list">
            <span class="order-list-title">联系人：</span>
            <span class="order-list-con">{{orderInfo.real_name}}</span>
          </p>
          <p class="order-list">
            <span class="order-list-title">手机号码：</span>
            <span class="order-list-con">{{orderInfo.phone_num}}</span>
          </p>
          <p class="order-list">
            <span class="order-list-title">紧急联系人：</span>
            <span class="order-list-con">{{orderInfo.emergency_tel}}</span>
          </p>
          <p class="order-list">
            <span class="order-list-title">订单费用：</span>
            <span class="order-list-con">￥{{orderInfo.total_price}}.00元</span>
          </p>
        </div>
      </div>
      <div class="order-comment" style="width: 90%; display: flex; margin: 0px auto;">
        <div>
          <p class="order-status">
            <i class="el-icon-circle-plus"></i><span>评价订单</span>
          </p>
          <p class="comment-list">
            <span class="comment-list-title">整洁卫生</span>
            <el-rate
              v-model="cleanVal"
              show-score
              text-color="#ff9900"
              score-template="{value}">
            </el-rate>
            <span class="comment-list-title">交通位置</span>
            <el-rate
              v-model="trafficVal"
              show-score
              text-color="#ff9900"
              score-template="{value}">
            </el-rate>
            <span class="comment-list-title">管理服务</span>
            <el-rate
              v-model="manageVal"
              show-score
              text-color="#ff9900"
              score-template="{value}">
            </el-rate>
            <span class="comment-list-title">设施装修</span>
            <el-rate
              v-model="facilityVal"
              show-score
              text-color="#ff9900"
              score-template="{value}">
            </el-rate>
          </p>
          <p>
            <button v-on:click="commitEvaluation" class="submit-comment">提交评价</button>
          </p>
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
    new Vue({
      el: '#order-info',
      data: {
        orderNum: '',
        orderInfo: {
          start_time: '',
          end_time: ''
        },
        cleanVal: 0,
        trafficVal: 0,
        manageVal: 0,
        facilityVal: 0,
        houseId: 0,
      },
      methods: {
        loadOrderInfo(){
          axios.get('order/get_order_info', {
            params: {
              orderNum: this.orderNum
            }
          }).then(res => {
            console.log(res.data);
            this.orderInfo = res.data.order;
            this.houseId = this.orderInfo.house_id;
          });
        },
        commitEvaluation(){
          const {cleanVal,trafficVal,manageVal,facilityVal,houseId,orderNum} = this;
          axios.get('order/commit_evaluation', {
            params: {
              cleanVal,trafficVal,manageVal,facilityVal,houseId,orderNum              
            }
          }).then(res => {
            if(res.data == 'success'){
              this.$message({
                  type: 'success',
                  message: '订单评价成功!',
                  duration: 1000
              });
              setTimeout(() => {
                window.location.href = `order/order_detail?order_num=${this.orderNum}`;                              
              }, 2000);
            }else{
              this.$message({
                type: 'error',
                message: '订单评价失败!',
                duration: 1000
              });
            }
          });
        }
      },
      created(){
        this.orderNum = window.location.href.split('?')[1].split('=')[1];                
        this.loadOrderInfo();
      }
    });
  
  </script>
</body>
</html>