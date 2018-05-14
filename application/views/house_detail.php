<?php $loginedUser = $this -> session -> userdata('loginedUser');?>
<!-- <?php var_dump($house_info)?> -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>悦居短租-房源详情</title>
  <base href="<?php echo site_url();?>">
  <link rel="stylesheet" href="assets/css/common.css">
  <link rel="stylesheet" href="assets/css/jquery-ui.min.css">    
  <link rel="stylesheet" href="assets/css/datePicker.css">
  <link rel="stylesheet" href="assets/css/houseDetail.css">
  <link rel="stylesheet" href="assets/css/footer.css">
</head>
<body>
  <!-- header -->
  <?php include 'header.php'?>
  <!-- header -->

  <!-- 房屋信息 -->
  <div id="house-detail">
    <div class="wrapper">
      <!-- 房屋图片 -->
      <div class="house-container">
        <div class="house-imgs">
          <?php 
            foreach($house_imgs as $img_item){
          ?>
            <img src="<?php echo '../../'.$img_item -> img_src?>" alt="">
          <?php
            }
          ?>
        </div>
        <ul class="house-tab">
          <?php 
            foreach($house_imgs as $img_item){
          ?>
            <li></li>
          <?php
            }
          ?>
        </ul>
        <div class="left-btn"></div>
        <div class="right-btn"></div>      
      </div>
      <!-- 房屋图片 -->
      <div class="house-info">
        <div class="left-info">
          <div class="house-search">
            <p class="title">
              <span class="house-address"></span>
              哈尔滨市 > <?php echo $house_info -> house_location?> > <?php echo $house_info -> house_address;?>
              <span class="price">￥<?php echo $house_info->house_price;?>.00</span>
            </p>
          </div>
          <div class="date-change-box" >
            <div class="change-control-group">
              <span>入住</span>
              <div class="demo-time">
                <label for="stayIn"></label>
                <input id="stayIn" type="text" autocomplete="off" placeholder="年-月-日">
              </div>
            </div>
            <div class="change-control-group">
              <span>退房</span>
              <div class="demo-time">
                <label for="checkOut"></label>
                <input type="text" id="checkOut" autocomplete="off" placeholder="年-月-日">
              </div>
            </div>
            <div class="change-control-group">
              <a href="javascript:;" data-user="<?php echo $loginedUser ? $loginedUser->username : ''; ?>" 
                 data-house-id="<?php echo $this->uri->segment(3)?>" class="filter-btn">预定</a>
            </div>
          </div>
          <div class="house-other-info">
            <div class="other-nav">
              <span class="current-border">房源信息</span>
              <span>入住须知</span>
              <span>房源点评</span>
            </div>
          </div>
          <div class="house-other-content">
            <div class="base-info">
              <div class="list-info">
                <ul>
                  <li><span class="list-title">小区名称</span><p class="detail-info"><?php echo $house_info -> village_name;?></p></li>
                  <li><span class="list-title">房间类型</span><p class="detail-info"><?php echo $house_info -> house_type;?></p></li>
                  <li><span class="list-title">使用面积</span><p class="detail-info"><?php echo $house_info -> house_user_area;?>.00平方米</p></li>
                  <li><span class="list-title">建筑面积</span><p class="detail-info"><?php echo $house_info -> house_build_area;?>.00平方米</p></li>
                  <li><span class="list-title">交通情况</span><p class="detail-info"><?php echo $house_info -> house_traffic;?></p></li>
                  <li><span class="list-title">房源详情</span><p class="detail-info"><?php echo $house_info -> house_details;?></p></li>
                </ul>
              </div>
            </div>
            <div class="note-in-info list-info">
             <li><span class="list-title">入住须知</span><p class="detail-info"><?php echo $house_info -> house_note;?></p></li>
            </div>
            <div class="comment-info list-info">
              <div class="start-title">
                <span class="score-text">综合评价</span>
                <span class="score-total"><?php echo $evaluation_score['total_val'] == 0 ? 5 : $evaluation_score['total_val'];?></span>分
              </div>
              <div class="rating-item">
                <span class="text-box">整洁卫生<b><?php echo $evaluation_score['clean_val'] == 0 ? 5 : $evaluation_score['clean_val'];?></b>分</span>
                <span class="text-box">交通位置<b><?php echo $evaluation_score['traffic_val'] == 0 ? 5 : $evaluation_score['traffic_val'];?></b>分</span>
                <span class="text-box">管理服务<b><?php echo $evaluation_score['manage_val'] == 0 ? 5 : $evaluation_score['manage_val'];?></b>分</span>
                <span class="text-box">设施装修<b><?php echo $evaluation_score['facility_val'] == 0 ? 5 : $evaluation_score['facility_val'];?></b>分</span>
              </div>
            </div>
          </div>

          <!-- 百度地图 -->
          <div id="map-container" data-position="<?php echo $house_info->house_lng_lat;?>"></div>
          <!-- 百度地图 -->         
        </div>
        <div class="right-info">
          <h3>推荐房源</h3>
          <ul class="recommend-house">
          <?php 
            foreach($house_recommended as $houseItem){
          ?>
            <li>
              <a href="house/detail/<?php echo $houseItem -> house_id?>"><img src="<?php echo '../../'.$houseItem -> img_src;?>" alt=""></a>
              <p>
                 <?php echo $houseItem -> village_name;?> <?php echo $houseItem -> house_name;?>
                <span>￥<?php echo $houseItem -> house_price;?></span>
              </p>
            </li>
          <?php
            }
          ?>
          </ul>
        </div>
      </div>




    </div>
  </div>
  <!-- 房屋信息 -->



  <!-- footer -->
  <?php include 'footer.php';?>
  <!-- footer -->

  <!-- 登录dialog -->
  <?php include 'dialog.php';?>
  <!-- 登录dialog -->
  <input type="hidden" id="current-index" value="house">    
  <script src="assets/js/jquery-1.12.4.min.js"></script>
  <script src="assets/js/jquery-ui.min.js"></script>  
  <script src="assets/js/datePicker.js"></script>
  <script src="assets/js/header.js"></script>
  <script src="assets/js/houseDetail.js"></script>
  <!-- 调用百度地图 -->
  <script src="http://api.map.baidu.com/api?v=2.0&ak=kG6euGNp2MPBEVx9ERoCfeWVl6nzKtz0"></script>
  <script>
    var position = $('#map-container').data('position').split(',');
    var map = new BMap.Map("map-container");// 创建地图实例  
    var point = new BMap.Point(...position);// 创建点坐标  
    map.setCurrentCity('哈尔滨');    
    map.centerAndZoom(point, 15);// 初始化地图，设置中心点坐标和地图级别  
    map.enableScrollWheelZoom(true);
    map.addControl(new BMap.NavigationControl({
      type: BMAP_NAVIGATION_CONTROL_SMALL
    }));
    map.addControl(new BMap.MapTypeControl());
    map.addControl(new BMap.ScaleControl());
    //添加覆盖物 
    var myIcon = new BMap.Icon("assets/img/marker_red_sprite.png", new BMap.Size(20, 25));      
    // 创建标注对象并添加到地图   
    var marker = new BMap.Marker(point, {icon: myIcon});    
    map.addOverlay(marker);   
    
    

    


  
  
  </script>
</body>
</html>