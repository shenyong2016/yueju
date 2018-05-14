<?php 
  $loginedUser = $this->session->userdata('loginedUser');
  // var_dump($tour_list);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>悦居短租-首页</title>
  <base href="<?php echo site_url();?>">
  <link rel="stylesheet" href="assets/css/common.css">
  <link rel="stylesheet" href="assets/css/index.css">
  <link rel="stylesheet" href="assets/css/picZoom.css">
  <link rel="stylesheet" href="assets/css/footer.css">
</head>
<body>
  <!-- header -->
  <?php include 'header.php';?>
  <!-- header -->
  <!-- 轮播图 -->
  <div id="slide-box">
    <div class="slide-imgs">
      <img style="z-index:-1;" src="assets/img/slide/banner-5.jpeg" alt="">
      <img style="z-index:-2;" src="assets/img/slide/banner-2.jpeg" alt="">
      <img style="z-index:-3;" src="assets/img/slide/banner-3.jpeg" alt="">
      <img style="z-index:-4;" src="assets/img/slide/banner-4.jpeg" alt="">
      <img style="z-index:-5;" src="assets/img/slide/banner-1.jpeg" alt="">
    </div>
    <ul class="slide-tab" style="z-index: 0">
      <li><img class="slide-tab-active" src="assets/img/slide/banner-5.jpeg" alt=""></li>
      <li><img src="assets/img/slide/banner-2.jpeg" alt=""></li>
      <li><img src="assets/img/slide/banner-3.jpeg" alt=""></li>
      <li><img src="assets/img/slide/banner-4.jpeg" alt=""></li>
      <li><img src="assets/img/slide/banner-1.jpeg" alt=""></li>
    </ul>
  </div>
  <!-- 轮播图 -->
  <!-- 搜索框 -->
  <div id="serach-box">
    <div class="wrapper">
      <form onsubmit="return false;">
        <div class="search-date">
          <label class="search-text" for="startTime"></label>
          <input type="text" autocomplete="off" placeholder="最低价位" class="startTime" id="startTime">
          <span class="search-icon"></span>
        </div>
        <div class="search-date">
          <label class="search-text" for="endTime"></label>
          <input type="text" autocomplete="off" placeholder="最高价位" class="endTime" id="endTime">
          <span class="search-icon"></span>
        </div>
        <div class="search-content">
          <input type="text" autocomplete="off" class="search-content-val" placeholder="小区名"
          <span class="search-icon"></span>
        </div>
        <input class="search-btn" type="submit" value="搜索">
      </form>
      <img class="search-phone" src="assets/img/tel-bg-v1.png" alt="">
    </div>
  </div>
  <!-- 搜索框 -->
  <!-- 优质房源 -->
  <div id="house-box">
    <div class="wrapper">
      <div class="house-title">
        <p>优质房源</p>
        <p>体验家一般的感觉</p>
      </div>
      <ul class="house-select-tab">
        <li 
        :class="{current: currentIndex == index+1}" 
        v-for="(selectItem,index) in selectTab" data-village="0"
        v-on:click="changeTab(selectItem.value)">{{selectItem.label}}</li>
        
      </ul>
      <div class="house-content">
        <!-- house-group -->
        <div v-for="house in houseList" class="house-group">
          <a :href="'house/detail/'+house.house_id">
            <div class="pic-box">
              <div class="house-mask"></div>          
              <img :src="`../../${house.img_src}`" alt="">
            </div>
          </a>
          <div class="house-desc">
            <p>
              <span class="house-info">{{house.village_name}} {{house.house_name}}</span>
              <span class="house-price">￥{{house.house_price}}.00</span>
            </p>
            <p>{{house.house_address}}</p>
          </div>
        </div>
        <!-- house-group -->
        
      </div>
    </div>
  </div>
  <!-- 优质房源 -->
  <p class="house-more">
    <a href="house/index" class="more-btn">查看更多</a>
  </p>

  <!-- 旅行游记 -->
  <div id="travelogs">
    <div class="wrapper">
      <h2>旅行游记</h2>
      <div class="travel-content">
        
      <?php 
        foreach($tour_list as $tour){
      ?>
        <!-- 旅行游记列表 -->
        <div class="house-group">
          <a href="tour/detail/<?php echo $tour->tour_id;?>">
            <div class="pic-box">
              <div class="house-mask"></div>          
              <img src="<?php echo $tour->tour_img_src;?>" alt="">
            </div>
          </a>
          <div class="house-desc">
            <p>
              <span class="house-info tour-info"><?php echo $tour->tour_title;?></span>
              <span class="house-price"></span>
            </p>
            <p style="color:skyblue;"><?php echo $tour->tour_tag?></p>
          </div>
        </div>
        <!-- 旅行游记列表 -->
        <?php
          }
        ?>  
      </div>
    </div>
  </div>
  <!-- 旅行游记 -->
  <p class="house-more">
    <a href="tour/index" class="more-btn">查看更多</a>
  </p>
  

  <!-- footer -->
  <?php include 'footer.php';?>
  <!-- footer -->
  <!-- 登录dialog -->
  <?php include 'dialog.php';?>
  <!-- 登录dialog -->
  <input type="hidden" id="current-index" value="index">
  <script src="assets/js/jquery-1.12.4.min.js"></script>
  <script src="assets/js/vue.min.js"></script>
  <script src="assets/js/axios.min.js"></script> 
  <script src="assets/js/header.js"></script>
  <script src="assets/js/index.js"></script>
  <!-- <script src="assets/js/picZoom.js"></script>  -->
  <script>
    new Vue({
      el: '#house-box',
      data: {
        selectTab: [
          {
            label: '哈尔滨悦居连锁公寓•康泰嘉园店',
            value: 1
          },
          {
            label: '哈尔滨悦居连锁公寓•熙俊印象店',
            value: 2
          },
          {
            label: '哈尔滨悦居连锁公寓•群力家园店',
            value: 3
          },
          {
            label: '哈尔滨悦居连锁公寓•雨阳名居店',
            value: 4
          },
          {
            label: '哈尔滨悦居连锁公寓•玫瑰湾店',
            value: 5
          },
          {
            label: '哈尔滨悦居连锁公寓•新怡园店',
            value: 6
          }
        ],
        currentIndex: 1,
        houseList: [],
      },
      created(){
        this.loadHouseData(1);
      },
      methods: {
        changeTab(villageType){
          if(this.currentIndex == villageType) return;
          this.currentIndex = villageType;
          this.loadHouseData(villageType);                  
        },
        loadHouseData(villageType){
          axios.get('house/get_house_by_village_type', {
            params: {villageType}
          }).then(res => {
            this.houseList = res.data;
          });
        }
      },
      mounted(){
        $('.house-content, .travel-content').on('mouseover','.pic-box', function(){
          $(this).children('img').stop().animate({
            width: 390,
            height: 237,
            marginLeft: -10,
            marginTop: -6,
          });
          $(this).children('.house-mask').stop().animate({
            opacity: 0.4
          });
        });
        $('.house-content, .travel-content').on('mouseout', '.pic-box', function(){
          $(this).children('img').stop().animate({
            width: 370,
            height: 225,
            marginLeft: 0,
            marginTop: 0,
          });   
          $(this).children('.house-mask').stop().animate({
            opacity: 0
          }); 
        });
      }
    });
  </script>
</body>
</html>