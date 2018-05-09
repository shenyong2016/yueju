<?php $loginedUser = $this -> session -> userdata('loginedUser');?>
<!-- <?php var_dump($loginedUser)?> -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>悦居短租-个人中心</title>
  <base href="<?php echo site_url();?>">
  <link rel="stylesheet" href="assets/css/common.css">  
  <link rel="stylesheet" href="assets/css/footer.css">
  <link rel="stylesheet" href="assets/css/personCenter.css">
  <link rel="stylesheet" href="assets/css/elementUI.css">  
  <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">  
  <style>
    .pagination{
      width: 100%;
      display: -webkit-flex; /* Safari */
      display: flex;
      flex-direction: row;
      flex-wrap: nowrap;
      justify-content: center;
    }
    .pagination li{
      width: 30px;
      height: 30px;
      background: #ccc;
      color: #fff;
      text-align: center;
      line-height: 30px;
      cursor: pointer;
      margin-left: 10px;      
    }
    .pagination li.active{
      background: #65CEA7;
    }
  </style>
</head>
<body>
  <!-- header -->
  <?php include 'header.php';?>
  <!-- header -->
  
  <div id="person" v-loading="loading">
    <div class="wrapper">
      <!-- left-sideBar开始 -->
      <div class="sidebar-container">
        <ul id="sidebar">
          <div id="sidebar-son">
            <li>              
              <img src="assets/img/sidebar1.jpg" alt="" class="img-pos">
              <span>订单管理</span>  
            </li>

            <li>
              <img src="assets/img/sidebar7.png" alt="" class="img-pos">
              <span>游记管理</span>  
            </li>

            <li>
              <img src="assets/img/sidebar5.jpg" alt="" class="img-pos">
              <span>个人资料</span>  
            </li>

            <li>
              <img src="assets/img/sidebar6.jpg" alt="" class="img-pos">
              <span>密码设置</span>  
            </li>
          </div>
        </ul>
      </div>
      <!-- left-sideBar结束 -->   

      <!-- right-content开始 -->
      <div class="right-content">
        <!-- 订单 -->
        <div class="order-manage">
          <div class="tab-bar">
            <span class="unfilled-order btn">未完成订单</span>
            <span class="done-order btn">已完成订单</span>
          </div>
          <div class="tab-bar-content">

            <div class="unfilled-order-content parent-div">
              <!-- 未完成 -->
              <div v-for="order in unfinishedOrderList" class="marginbottom house-ad unfilled">
                <div class="house-detail">
                  <a :href="`house/detail/${order.house_id}`">
                    <div class="img-container">
                      <img :src="order.img_src" alt="">
                    </div>
                    <ul class="house-description">
                      <li class="house-detail-title">{{order.village_name}} {{order.house_name}}</li>
                      <li class="house-address">地址：{{order.house_address}}</li>
                      <li class="in-out-time">入住时间:{{order.start_time.split(' ')[0]}}——离开时间：{{order.end_time.split(' ')[0]}}</li>
                    </ul>
                  </a>
                </div>
                <div class="right-double-btn">
                  <div class="button left-single-bt">
                    <a class="order-btns cancel_order" v-on:click="deleteOrder(order.order_num)" href="javascript:;">取消订单</a>
                  </div>
                  <div class="button right-single-btn">
                    <a class="order-btns" :href="`order/confirmorder?order_num=${order.order_num}`">去支付</a>
                  </div>
                </div>
              </div>
              <!-- 分页 -->
              <pagination :total="unfinishedOrderCount" :page-size="unfinishPageSize" v-on:paginate="loadUnfinishedOrderList"></pagination>
              <!-- 分页 -->
              <!-- 未完成 -->
            </div>

            <div class="done-order-content parent-div">
              <!-- 已完成 -->
              <div v-for="order in finishedOrderList" class="marginbottom house-ad unfilled">
                <div class="house-detail">
                  <a :href="`house/detail/${order.house_id}`">
                    <div class="img-container">
                      <img :src="order.img_src" alt="">
                    </div>
                    <ul class="house-description">
                      <li class="house-detail-title">{{order.village_name}} {{order.house_name}}</li>
                      <li class="house-address">地址：{{order.house_address}}</li>
                      <li class="in-out-time">入住时间:{{order.start_time.split(' ')[0]}}——离开时间：{{order.end_time.split(' ')[0]}}</li>
                    </ul>
                  </a>
                </div>
                <div class="right-double-btn">
                  <div class="button right-single-btn add-class">
                    <a class="order-btns" :href="`order/order_detail?order_num=${order.order_num}`">查看订单</a>
                  </div>
                </div>
              </div>
              <!-- 分页 -->
              <pagination :total="finishedOrderCount" :page-size="finishPageSize" v-on:paginate="loadFinishedOrderList"></pagination>
              <!-- 分页 -->
              <!-- 已完成 -->
            </div>
          </div>
        </div>
        <!-- 订单 -->

        <!-- 游记 -->
        <div class="tour-manage">
          <div class="tour-bar">
            <span>我的游记</span>
            <a href="tour/tour_publish">发表文章</a>
          </div>
          <div class="show-content-main">
            <ul class="my-blogs">
              <li v-for="tour in tourList">
                <h5 class="blogs-name">
                  <a :href="'tour/detail/'+tour.tour_id">{{tour.tour_title}}</a>
                </h5>
                <div class="blogs-editor">
                  <a :href="'tour/tour_publish/'+tour.tour_id">编辑</a>
                  <a v-on:click="deleteTour(tour.tour_id)" href="javascript:;">删除</a>
                </div>
                <p class="blogs-date">发表日期：{{tour.publish_time}}</p>
              </li>
            </ul>
            <!-- 分页 -->
            <pagination :total="tourCount" :page-size="tourPageSize" v-on:paginate="loadTourList"></pagination>
            <!-- 分页 -->
          </div>
        </div>
        <!-- 游记 -->

        <!-- 个人 -->
        <div class="user-manage">
          <div class="data_container">
            <div class="data_wrap">
              <div>
                <h2 class="data_tit">账号管理</h2>
                <span class="info_tit info_username">用户名</span>
                <p style="font-size: 20px;"><?php echo $loginedUser->username;?></p>
              </div>
              <div style="margin-top: 10px;">
                <span class="info_tit info_name">您的真实姓名是</span>
                <input class="input_l" type="text" v-model="realName">
                <span class="info_tit">性别</span>
                <input type="radio" class="sex_item" value="男" name="sex" v-model="sex">男
                <input type="radio" class="sex_item" value="女" name="sex" v-model="sex">女       
                <br>
                <span class="info_tit">填写身份证号</span>
                <br>
                <input type="text" class="input_l" v-model="ID">  
                <br>
                <input type="submit" v-on:click="submitUser" class="btn_submit" value="确认">       
              </div>
              <div class="photo">
                <div class="head-img">
                  <img v-if="headImg" :src="headImg" alt="">
                  <img v-else="" src="assets/img/head-default.png" alt="">   
                </div>
                <div class="upload-head">
                  <span class="head-title" v-on:click="clickFile">上传头像</span>
                  <input ref="headFile" accept="image/gif, image/jpeg,image/png,image/jpg" v-on:change="uploadHeadImg" class="head-file" type="file">
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- 个人 -->

        <!-- 密码 -->
        <div class="pass-manage">
          <div class="data_container">
            <div class="data_wrap">
              <div>
                  <h2 class="data_tit">密码修改</h2>
                  <span class="info_tit info_name">新密码</span>
                  <input class="input_l" type="password"  v-model="newPass">
                  <input type="submit" v-on:click="updatePass" class="btn_submit" value="确定">       
                </div>
            </div>
          </div>
        </div>
        <!-- 密码 -->
        
      </div>
      <!-- right-content结束 -->
    </div>
  </div>



  <!-- footer -->
  <?php include 'footer.php'?>
  <!-- footer -->
  <input type="hidden" id="current-index" value="user">    
  <script src="assets/js/jquery-1.12.4.min.js"></script>
  <script src="assets/js/header.js"></script>  
  <script src="assets/js/vue.min.js"></script>
  <script src="assets/js/axios.min.js"></script>  
  <script src="assets/js/pagination.js"></script>  
  <script src="assets/js/elementUI.js"></script>  
  <script>
    new Vue({
      el: '#person',
      data: {
        loading: false,
        tourList: [],//游记列表
        finishedOrderList: [],//已完成订单列表
        unfinishedOrderList: [],//未完成订单列表
        finishedOrderCount: 0,
        unfinishedOrderCount: 0,        
        tourCount: 0,
        tourPageSize: 4,
        tourPage: 1,
        finishPageSize: 2,
        finishedPage: 1,
        unfinishPageSize: 2,
        unfinishedPage: 1,
        realName: '',
        sex: '',
        ID: '',
        headImg: '',
        oldPass: '',
        newPass: '',
        userId: ''
      },
      methods: {
        deleteOrder(orderNum){
          this.$confirm('确认删除该订单，是否继续?', '提示', {
            confirmButtonText: '确定',
            cancelButtonText: '取消',
            type: 'warning'
          }).then(res => {
            console.log(123456);
            axios.get('order/delete_order', {
              params: {orderNum}
            }).then(res => {
              if(res.data == 'success'){
                this.$message({
                  type: 'success',
                  message: '删除成功!',
                  duration: 1000
                });
                this.loadUnfinishedOrderList(1);
              }else{
                this.$message({
                  type: 'error',
                  message: '删除失败!',
                  duration: 1000
                });
              }
            });
          }).catch(error => {
            this.$message({
              type: 'info',
              message: '已取消删除',
              duration: 1000              
            });   
          });
        },
        updatePass(){
          // console.log(this.oldPass+'==='+this.newPass);
          if(this.oldPass == this.newPass){
            this.$message({
              type: 'warning',
              message: '新密码不得与原密码相同',
              showClose: true,
              duration: 1000              
            });
            return;
          }else if(!/[a-zA-Z0-9]{6,16}/.test(this.newPass)){
            this.$message({
              type: 'warning',
              message: '密码为6-16位的数字或字母',
              showClose: true,
              duration: 1000              
            });
            return;
          }
          axios.get('welcome/update_pass', {
            params: {
              newPass: this.newPass,
            }
          }).then(res => {
            if(res.data == 'success'){
              this.$message({
                type: 'success',
                message: '密码修改成功',
                showClose: true,
                duration: 1000              
              });
              setTimeout(() => {
                window.location.href = 'welcome/user';
              }, 2000);
            }else{
              this.$message({
                type: 'error',
                message: '密码修改失败',
                showClose: true,
                duration: 1000              
              });
            }
          });
        },
        clickFile(){
          this.$refs.headFile.click();
        },
        uploadHeadImg(){
          if(this.headImg){//修改图片将之前的头像删除
            axios.get('tour/delete_img', {
              params: {imgSrc: this.headImg}
            });
          }
          var oFormData = new FormData();
          oFormData.append('img', this.$refs.headFile.files[0]);
          var config = {
            headers:{'Content-Type':'multipart/form-data'}
          }; 
          axios.post('tour/upload_tour_img',oFormData,config).then(res => {
            this.headImg = res.data;
          }) 
        },
        submitUser(){
          var {realName,sex,ID,headImg} = this;
          if(!/^[\u4E00-\u9FA5]{2,}$/.test(realName)){
            this.$message({
              type: 'warning',
              message: '请填写规范中文姓名',
              showClose: true,
              duration: 1000              
            });
            return;
          }
          if(!sex){
            this.$message({
              type: 'warning',
              message: '请选择性别',
              showClose: true,
              duration: 1000              
            });
            return;
          }
          if(!/^(\d{17})(\d|[xX])$/.test(ID)){
            this.$message({
              type: 'warning',
              message: '请输入正确的身份证号码',
              showClose: true,
              duration: 1000              
            });
            return;
          }
          if(!headImg){
            this.$message({
              type: 'warning',
              message: '请上传头像',
              showClose: true,
              duration: 1000              
            });
            return;
          }
          axios.get('welcome/update_user_info', {
            params: {realName,sex,ID,headImg}
          }).then(res => {
            if(res.data == 'success'){
              this.$message({
                type: 'success',
                message: '个人信息完善成功',
                showClose: true,
                duration: 1000                
              });
              setTimeout(() => {
                window.location.href = 'welcome/user';                
              }, 2000);
            }else{
              this.$message({
                type: 'error',
                message: '个人信息完善失败',
                showClose: true,
                duration: 1000                
              });
            }
          });
        },
        loadTourList(page){//获取游记列表
          this.loading = true;
          axios.get('tour/get_tour_self_list', {
            params: {
              tourPageSize: this.tourPageSize,page
            }
          }).then(res => {
            this.tourList = res.data.tour;
            this.tourCount = res.data.tour_count;
            this.loading = false;          
          });
        },
        loadFinishedOrderList(page){
          this.loading = true;
          axios.get('order/get_finished_order', {
            params: {
              finishPageSize: this.finishPageSize, page
            }
          }).then(res => {
            this.finishedOrderList = res.data.order;
            this.finishedOrderCount = res.data.order_count;
            this.loading = false;
          });
        },
        loadUnfinishedOrderList(page){
          this.loading = true;
          axios.get('order/get_unfinished_order', {
            params: {
              unfinishPageSize: this.unfinishPageSize, page
            }
          }).then(res => {
            // console.log(res);
            this.unfinishedOrderList = res.data.order;
            this.unfinishedOrderCount = res.data.order_count;
            this.loading = false;            
          });
        },
        loadUserInfo(){
          this.loading = true;          
          axios.get('welcome/get_user_info').then(res => {
            // console.log(res);
            var userInfo = res.data;
            this.realName = userInfo.real_name;
            this.sex = userInfo.sex;
            this.ID = userInfo.ID_number;
            this.headImg = userInfo.head_img;
            this.oldPass = userInfo.password;
            this.userId = userInfo.user_id;
            this.loading = false;                      
          });
        },
        deleteTour(tourId){
          this.$confirm('确认删除该条游记，是否继续?', '提示', {
            confirmButtonText: '确定',
            cancelButtonText: '取消',
            type: 'warning'
          }).then(() => {
            axios.get('tour/delete_tour',{
              params:{tourId}
            }).then(res => {
              if(res.data == 'success'){
                this.$message({
                  type: 'success',
                  message: '删除成功!',
                  duration: 1000
                });
                this.loadTourList(1);
              }else{
                this.$message({
                  type: 'error',
                  message: '删除失败!',
                  duration: 1000
                });
              }  
            });
            
          }).catch(() => {
            this.$message({
              type: 'info',
              message: '已取消删除',
              duration: 1000              
            });          
          });          
        }
      },
      created(){
        this.loadTourList(this.tourPage);
        this.loadUserInfo();
        this.loadFinishedOrderList(this.finishedPage);
        this.loadUnfinishedOrderList(this.unfinishedPage);
      },
      mounted(){
        // 主菜单切换
        var $slideBar = $('#sidebar-son li');
        var $rightContent = $('.order-manage, .tour-manage, .user-manage, .pass-manage');
        $slideBar.eq(0).addClass('active');
        $slideBar.eq(0).children('span').addClass('active');        
        $rightContent.hide().eq(0).show();//修改
        $slideBar.on('click', function(){
          $(this).addClass('active').siblings().removeClass('active');
          $(this).children('span').addClass('active').parent('li').siblings().children('span').removeClass('active');
          $rightContent.eq($(this).index()).show().siblings().hide();
        });

        // 订单切换
        var $tabBar = $('.tab-bar span');
        var $orderContent = $('.parent-div');
        $tabBar.eq(0).addClass('selected');
        $orderContent.hide().eq(0).show();
        $('.tab-bar span').on('click', function(){
          $(this).addClass('selected').siblings().removeClass('selected');
          $orderContent.eq($(this).index()).show().siblings().hide();
        });
      }
    });
  
  
  </script> 
</body>
</html>