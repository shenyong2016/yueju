<div id="header">
    <div class="wrapper">
      <a class="logo" href="">
        <img src="assets/img/logo-v3.png" alt="">
      </a>
      <img class="header-desc" src="assets/img/desc.png" alt="">      
      <ul class="nav-tab">
        <li class="nav-tab-item"><a href="welcome/index">首页</a></li>
        <li class="nav-tab-item"><a href="house/index">房源中心</a></li>
        <li class="nav-tab-item"><a href="tour/index">旅行游记</a></li>
        <li class="nav-tab-item"><a data-user="<?php echo $loginedUser ? $loginedUser->username : '';?>" class="person-center" href="javascript:;">个人中心</a></li>
        <li class="nav-tab-item"><a href="welcome/about">关于悦居</a></li>
        <li class="nav-tab-item" style="display: none;"><a href="welcome/about"></a></li>        
        <li class="login-register">
          <?php if($loginedUser){
          ?>
            <a href="welcome/user" style="color: rgb(169, 142, 103);"><?php echo $loginedUser -> username;?>已登录</a> 
            <a href="welcome/logout">注销</a>             
          <?php 
            }else{
          ?>
            <a  href="javascript:;">登录/注册</a>                      
          <?php
            }
          ?>
        </li>
      </ul>
    </div>
  </div>