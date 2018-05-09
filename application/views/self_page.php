<?php $loginedUser = $this -> session -> userdata('loginedUser');?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>个人主页</title>
  <base href="<?php echo site_url();?>">
  <link rel="stylesheet" href="assets/css/common.css">
  <link rel="stylesheet" href="assets/css/footer.css">
  <link rel="stylesheet" href="assets/css/selfPage.css">
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
  <div id="self-page">
    <div class="wrapper">
      <div class="authorinfo">
        <div class="authorinfo-bg"></div>
        <div class="authorinfo-content">
          <div class="authorinfo-pic">
            <img v-if="userInfo.head_img" :src="userInfo.head_img" alt="">        
            <img v-else src="assets/img/head-default.png" alt="">
          </div>
          <div class="authorinfo-name">
            <h2>{{userInfo.username}}</h2>
            <a href="javascript:;" data-user="<?php echo $loginedUser ? $loginedUser->username : '';?>" class="btn btn-primary btn-lg sent-page">发表文章</a>
          </div>
        </div>
      </div>

      <div class="blog-content">
        <ul class="blog-list">
          <h4>TA的文章</h4>

          <!-- 游记列表 -->              
          <li v-for="tour in tourList" class="blog-article">
            <div class="article-pic">
                <img :src="tour.tour_img_src" alt="">
            </div>
            <div class="blog-article-info">
              <div class="blog-article-info-up">
                <div class="author-pic">
                  <a>
                    <img v-if="tour.head_img" :src="tour.head_img" alt="">                                              
                    <img v-else src="assets/img/head-default.png" alt="">                            
                  </a>
                </div>
                <div class="blog-article-info-title">
                  <h4><a :href="`tour/detail/${tour.tour_id}`">{{tour.tour_title}}</a></h4>
                  <p><a class="author-name">作者：{{tour.username}}</a></p>
                </div>
              </div>
              <div class="blog-article-info-content">
              {{tour.tour_content}}
              </div>
              <p class="blog-article-info-tags">
                <b>
                    标签：
                </b>
                <!-- 处理标签 -->
                
                <span v-for="item in tour.tag" class="sel-tags">{{item}}</span>
              </p>
            </div>
          </li>   
          <!-- 游记列表 -->  

          <!-- 分页 -->
          <pagination :total="tourCount" :page-size="pageSize" v-on:paginate="loadSomeoneTourList"></pagination>
        
          <!-- 分页 -->
          
        </ul>

        <div class="banner-content">
          <div class="fine-community">
            <h4>社区精选</h4>
            <a v-for="house in recommenedHouseList" :href="`house/detail/${house.house_id}`">
              <div :style="`background-image: url(${house.img_src})`" class="fine-community-show">{{house.house_name}}</div>
            </a>
          </div>

          <div class="fine-article">
            <h4>热门文章</h4>
            <ul>
              <li v-for="tour in hotTourList"><a :href="`tour/detail/${tour.tour_id}`">{{tour.tour_title}}</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- footer -->
  <?php include 'footer.php';?>
  <!-- footer -->
  <!-- dialog -->
  <?php include 'dialog.php';?>
  <!-- dialog -->  
  <input type="hidden" id="current-index" value="">    
  <script src="assets/js/jquery-1.12.4.min.js"></script>  
  <script src="assets/js/header.js"></script>
  <script src="assets/js/vue.min.js"></script>
  <script src="assets/js/axios.min.js"></script>
  <script src="assets/js/pagination.js"></script>
  <script>
    new Vue({
      el: '#self-page',
      data: {
        userId: <?php echo $this->uri->segment(3)?>,
        tourList: [],
        tourCount: 0,
        page: 1,
        pageSize: 3,
        userInfo: {},
        hotTourList: [],
        recommenedHouseList: []
      },
      methods: {
        loadSomeoneTourList(page){
          var {userId, pageSize} = this;
          axios.get('tour/get_someone_tour_list', {
            params: {
              userId, page, pageSize
            }
          }).then(res => {
            var tourArr = res.data.tour;
            this.tourCount = res.data.tour_count;
            for(var i=0; i<tourArr.length; i++){
              tourArr[i].tag = tourArr[i].tour_tag.split('-');
            }
            this.tourList = tourArr;
          });
        },
        loadOtherInfo(){
          axios.get('tour/get_other_info', {
            params: {
              userId: this.userId
            }
          }).then(res => {
            this.userInfo = res.data.user_info;
            this.hotTourList = res.data.tour_info;
            this.recommenedHouseList = res.data.house_info;
            
          });
        }
      },
      created(){
        this.loadSomeoneTourList(this.page);
        this.loadOtherInfo();
      },
      mounted(){
        $('.sent-page').on('click', function(){
          var username = $(this).data('user');
          if(!username){
            alert('用户先登录');
            $('#dialog').show(600);            
            return;
          }
          window.location.href = 'tour/tour_publish';
        });
      }
    });
  
  
  
  
  
  
  
  
  </script>
</body>
</html>