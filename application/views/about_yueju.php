<?php $loginedUser = $this -> session -> userdata('loginedUser');?>
<!-- <?php var_dump($yueju_info)?> -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <base href="<?php echo site_url();?>">
  <title>悦居短租-关于悦居</title>
  <link rel="stylesheet" href="assets/css/common.css">
  <link rel="stylesheet" href="assets/css/footer.css">
  <link rel="stylesheet" href="assets/css/yueju.css">
</head>
<body>
  <!-- header -->
  <?php include 'header.php';?>
  <!-- header -->
  <div class="banner">
    <img src="assets/img/banner1-v2.jpg" alt="">
  </div>
  <div class="about-box">
    <div class="wrapper">
      <div class="bread-box">
        <a href="">首页</a>
        &gt;
        <span href="">关于我们</span>
      </div>
      <div class="content">
        <div class="sidebar-box">
          <ul>
            <li><a href="javascript:;">关于我们</a></li>
          </ul>
        </div>
        <div class="main-content">
          <h3 class="content-txt">关于我们</h3>
          <?php 
            $content = explode('。',$yueju_info->yueju_content);
            for($i=0; $i<count($content); $i++){
              echo '<p>'. $content[$i] .'</p>';
            }
          ?>
        </div>
      </div>
    </div>
  </div>


  <!-- footer -->
  <?php include 'footer.php';?>
  <!-- footer -->
  <input type="hidden" id="current-index" value="about">    
  <script src="assets/js/jquery-1.12.4.min.js"></script>  
  <script src="assets/js/header.js"></script>


</body>
</html>