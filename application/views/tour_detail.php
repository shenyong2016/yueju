<?php $loginedUser = $this -> session -> userdata('loginedUser');?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <base href="<?php echo site_url();?>">
  <title>游记详情</title>
  <link rel="stylesheet" href="assets/css/common.css">
  <link rel="stylesheet" href="assets/css/footer.css">
  <link rel="stylesheet" href="assets/css/elementUI.css">
  <link rel="stylesheet" href="assets/css/tourDetail.css">
</head>
<body>
  <!-- header -->
  <?php include 'header.php';?>
  <!-- header -->
  
  <section id="tour-app">
    <div id="tour-content" class="wrapper">      
      <img class="tour-img" :src="tourData.tour_img_src" alt="">
      <h2>{{tourData.tour_title}}</h2>
      <div class="blog-info">
        <img v-if="tourData.head_img" :src="tourData.head_img" alt="">
        <img v-else src="assets/img/head-default.png" alt="">
        <div class="info-left">
          <span class="author">
            <a href="welcome/user">{{tourData.username}}</a>
          </span>
          <span>{{tourData.publish_time}}</span>
        </div>
      </div>
    </div>
    <div id="blog-body" class="wrapper">
      <div id="blog-wrap">
        <div id="blog-tag" class="clearfix">
          <el-tag v-for="tag in tourTagList"
            :type="tag.type">{{tag.name}}</el-tag>
        </div>
        <div class="blog-content">
          <p v-for="item in tourContent">{{item}}。</p>
        </div>
      </div>
      <div id="blog-side-bar">
          <h3>推荐公寓</h3>
          <ul>
            <li v-for="house in houseList">
              <a :href="'house/detail/'+house.house_id">
                <div>
                  <img :src="house.img_src" alt="">
                </div>
                <p>{{house.village_name}} {{house.house_name}}</p>
                <div class="bind">
                  <span>￥{{house.house_price}}/天</span>
                </div>
              </a>
            </li>
          </ul>
        </div>
    </div>
  </section>
  
  <!-- footer -->
  <?php include 'footer.php';?>
  <!-- footer -->

  <!-- dialog -->
  <?php include 'dialog.php';?>
  <!-- dialog -->
  <input type="hidden" id="current-index" value="tour">    
  <script src="assets/js/jquery-1.12.4.min.js"></script>
  <script src="assets/js/vue.min.js"></script>
  <script src="assets/js/axios.min.js"></script>
  <script src="assets/js/elementUI.js"></script>
  <script src="assets/js/header.js"></script>
  <script>
    new Vue({
      el: '#tour-app',
      data: {
        tourId: <?php echo $this->uri->segment(3)?>,
        houseList: [],
        tourData: {},
        tourTagList: [],
        tourContent: []
      },
      created(){
        // console.log(this.tourId);
        axios.get('tour/get_tour_detail',{
          params: {
            tourId: this.tourId
          }
        }).then(res => {
          this.houseList = res.data.house;
          this.tourData = res.data.tour;
          this.tourContent = res.data.tour.tour_content.split('。');
          console.log(this.tourContent);
          var tageType = ['success','info','warning','danger'];
          var tourTag = this.tourData.tour_tag.split('-');
          for(var i=0; i<tourTag.length; i++){
            this.tourTagList.push({
              name: tourTag[i],
              type: tageType[i]
            });
          }
          console.log(this.tourData);
        });
      }
    });
  </script>
</body>
</html>