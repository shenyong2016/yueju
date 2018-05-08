
<?php $loginedUser = $this -> session -> userdata('loginedUser');?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <base href="<?php echo site_url();?>">
  <title>提交订单</title>
  <link rel="stylesheet" href="assets/css/common.css">
  <link rel="stylesheet" href="assets/css/houseOrder.css">
  <link rel="stylesheet" href="assets/css/footer.css">  
  <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">    
</head>
<body>
  <!-- header -->
  <?php include 'header.php';?>
  <!-- header -->
  <div id="order-app">
    <div class="wrapper">
      <div class="house-info">
        <div class="houseinfo-div1">入住信息</div>
        <div class="house-table" style="width: 85%; margin: 0px auto; padding: 20px;">
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
                <td>{{startTime}}</td>
                <td>{{endTime}}</td>
                <td class="third">{{houseData.village_name}} {{houseData.house_name}} {{houseData.house_address}}</td>
              </tr>
            </tbody>
          </table>  
        </div>
      </div>
      <div class="userinfo">
        <div class="userinfo-div1">预定人信息</div>
        <div style="width: 350px; margin: 0px auto;">
          <p class="user-list">
            <span>真实姓名</span>
            <input type="text" v-model="realName">
          </p>
          <p class="user-list">
            <span>手机号码</span>
            <input type="text" v-model="phoneNum">
          </p>
          <p class="user-list">
            <span>紧急联系</span>
            <input type="text" v-model="emergencyTel">
          </p>
        </div>
      </div>
      <div class="orderinfo">
        <div class="orderinfo-div1">订单费用信息</div>
        <table class="orderinfo-div2">
          <thead>
            <th></th>
            <th>日均价</th>
            <th>总价</th>
          </thead>
          <tbody>
            <td>{{houseData.village_name}} {{houseData.house_name}}</td>
            <td>￥{{unitPrice}}元</td>
            <td>￥{{totalPrice}}元</td>
          </tbody>
        </table>
        <div class="orderinfo-div4">
          <span>订单总金额:</span>
          <span class="grossnum">￥{{totalPrice}}元</span>
        </div>
      </div>
      <div class="commit">
          <button v-on:click="commitOrder">提交订单</button>
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
      el: '#order-app',
      data: {
        realName: '',
        phoneNum: '',
        emergencyTel: '',
        startTime: '',
        endTime: '',
        houseId: <?php echo $this->input->get('houseId')?>,
        houseData: {},
        unitPrice: 0,
        totalPrice: 0
      },
      methods: {
        commitOrder(){
          if(!/^[\u4E00-\u9FA5]{2,}$/.test(this.realName)){
            this.$message({
              type: 'warning',
              message: '请填写规范的中文姓名',
              showClose: true,
              duration: 1000              
            });
            return;
          }
          if(!/^(13|15|17)\d{9}$/.test(this.phoneNum) || !/^(13|15|17)\d{9}$/.test(this.emergencyTel)){
            this.$message({
              type: 'warning',
              message: '请填写正确的手机号码',
              showClose: true,
              duration: 1000              
            });
            return;
          }
          const {realName,phoneNum,emergencyTel,startTime,endTime,totalPrice,houseId} = this;
          axios.get('order/submit_order', {
            params: {
              realName,phoneNum,emergencyTel,startTime,endTime,totalPrice,houseId
            }
          }).then(res => {
            console.log(res);
            if(res.data.msg == 'success'){
              window.location.href = 'order/confirmorder?order_num='+ res.data.order_num;                              
            }else{
              this.$message({
                type: 'error',
                message: '订单提交失败',
                showClose: true,
                duration: 1000              
              });
            }
          });
        },
        loadHouseData(){
          return new Promise((resolve) => {//解决异步请求相关问题
            axios.get('house/get_house_detail', {
              params: {
                houseId: this.houseId
              }
            }).then(res => {
              resolve(res.data);
            });
          });          
        },
        getTotalPrice(){
          var startTime = new Date(this.startTime).getTime();
          var endTime = new Date(this.endTime).getTime();
          var totalDays = Math.floor(endTime-startTime)/(24*3600*1000);
          this.unitPrice = Number(this.houseData.house_price);
          this.totalPrice = totalDays * this.unitPrice;
        }
      },
      created(){
        this.loadHouseData().then(res => {
          this.houseData = res;
          this.getTotalPrice();                          
        });
        var paramArr = window.location.href.split('?')[1].split('&');
        this.startTime = paramArr[1].split('=')[1];
        this.endTime = paramArr[2].split('=')[1];        
      }
    });
  </script>
</body>
</html>     