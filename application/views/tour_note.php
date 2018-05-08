<?php $loginedUser = $this -> session -> userdata('loginedUser');?>
<!-- <?php var_dump($tour_list)?> -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>悦居短租-旅行游记</title>
  <base href="<?php echo site_url();?>">
  <link rel="stylesheet" href="assets/css/common.css">
  <link rel="stylesheet" href="assets/css/footer.css">
  <link rel="stylesheet" href="assets/css/tourNote.css">
</head>
<body>
  <!-- header -->
  <?php include 'header.php';?>
  <!-- header -->
 
  <!-- 游记列表 -->
  <!-- 游记列表 -->
  <div class="travel-blog-content">
    <div class="wrapper">
        <div class="content-main">
          <div class="content-main-left">
            <ul class="blog-list">
              <li class="content-title">
                <h4>游记列表</h4>
                <a class="subm" data-user="<?php echo $loginedUser ? $loginedUser->username : '';?>" href="javascript:;"><p class="submit-blog">发表游记</p></a>
              </li>

              <?php 
                foreach($tour_list as $tour){
              ?>
              <!-- 游记列表 -->              
                <li class="blog-article">
                  <div class="article-pic">
                      <img src="<?php echo $tour->tour_img_src;?>" alt="">
                  </div>
                  <div class="blog-article-info">
                    <div class="blog-article-info-up">
                      <div class="author-pic">
                        <a data-user="<?php echo $loginedUser ? $loginedUser->username : ''; ?>" href="javascript:;">
                          <img src="<?php echo $tour->head_img ? $tour->head_img : 'assets/img/head-default.png';?>" alt="">                            
                        </a>
                      </div>
                      <div class="blog-article-info-title">
                        <h4><a href="tour/detail/<?php echo $tour->tour_id;?>"><?php echo $tour->tour_title;?></a></h4>
                        <p><a class="author-name" data-user="<?php echo $loginedUser ? $loginedUser->username : ''; ?>" href="javascript:;"><?php echo $tour->username;?></a></p>
                      </div>
                    </div>
                    <div class="blog-article-info-content"><?php echo $tour->tour_content;?> 
                        <a href="">[详情]</a>
                    </div>
                    <p class="blog-article-info-tags">
                      <b>
                          标签：
                      </b>
                      <!-- 处理标签 -->
                      <?php 
                        $tour_tag_list = explode('-', $tour->tour_tag);
                        for($i=0; $i<count($tour_tag_list); $i++){
                          echo '<span class="sel-tags">'.$tour_tag_list[$i].'</span>';    
                        }
                      ?>
                    </p>
                  </div>
                </li>   
              <!-- 游记列表 -->  
              <?php
                }
              ?>                             
            </ul>
            <!--分页-->            
            <div class="paginate">
              <ul class="paginate-content">
                <?php echo $this->pagination->create_links();?>
              </ul>
            </div>
		  		<!--分页--> 
          </div> 
        

          <div class="banner-content">
            <div class="fine-community">
                <h4>社区精选</h4>
                <?php 
                  foreach($house_list as $house){
                ?>
                <a href="house/detail/<?php echo $house->house_id;?>">
                  <div style="background-image: url(<?php echo $house->img_src;?>)" class="fine-community-show">悦居公寓</div>
                </a>
                <?php
                  }
                ?>
            </div>
            <div class="fine-article">
              <h4>热门文章</h4>
              <ul>
                <?php 
                  foreach($hot_tour_list as $tour){
                ?>
                  <li><a href="tour/detail/<?php echo $tour->tour_id;?>"><?php echo $tour->tour_title;?></a></li>                    
                <?php
                  }
                ?>
              </ul>
            </div>
            </div>
        </div>
    </div>
  </div>
  <!-- 游记列表 -->

  <!-- dialog -->
  <?php include 'dialog.php';?>
  <!-- dialog -->  
  <!-- footer -->
  <?php include 'footer.php';?>
  <!-- footer -->
  <input type="hidden" id="current-index" value="tour">  
  <script src="assets/js/jquery-1.12.4.min.js"></script>
  <script src="assets/js/header.js"></script>
  <script>
    $('.subm').on('click', function(){
      var user = $(this).data('user');
      if(!user){
        alert('用户未登录，请先登录');
        $('#dialog').show(600);
        return;
      }
      window.location.href = 'tour/tour_publish';
    });
    
    $('.author-pic a, .author-name').on('click', function(){
      var user = $(this).data('user');
      if(!user){
        alert('用户未登录，请先登录');
        $('#dialog').show(600);
        return;
      }
      window.location.href = "welcome/user";
    });


  </script>
</body>
</html>