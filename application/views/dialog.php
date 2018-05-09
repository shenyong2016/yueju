<style>
  #dialog{
    display: none;
  }
  .dialog-mask{
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    background: #000;
    opacity: 0.3;
    filter: alpha(opacity=30);
  }
  .dialog-box{
    /* text-align: center; */
    width: 500px;
    height: 440px;
    background: #fff;
    border-radius: 5px;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }
  .dialog-box h2{
    margin: 20px 0 20px 0;
    font-weight: 700;
    font-size: 24px;
    color: #2d3b4a;
    text-align: center;
  }
  .register, .login{
    padding: 0 20px;
    display: none;
  }
  .login{
    display: block;
  }
  .dialog-list{
    padding: 10px 0 4px 0;
    width: 428px;
    border-bottom: 1px solid #dde2e6;
    clear: both;
  }
  .dialog-pic{
    width: 100px;
    height: 40px;
    float: left;
    text-align: center;
    padding-top: 8px;
  }
  .dialog-pic img{
    width: 24px;
    height: 24px;
    vertical-align: middle;
  }
  .dialog-list input{
    width: 200px;
    height: 40px;
    border: 0;
    color: #9ea8b3;
    font-size: 16px;
    font-weight: 600;
    outline: none;
    cursor: pointer;
  }
  .tip-name{
    color: #f00;
    font-size: 14px;
  }
  .dialog-list .btn-big{
    width: 428px;
    height: 60px;
    background: #39c6a7;
    border: none;
    color: #fff;
    font-size: 24px;
    font-weight: 700;
    text-align: center;
    line-height: 60px;
    border-radius: 4px;
    margin-top: 30px;
    outline: none;
    cursor: pointer;
  }
  .login-tab-btn{
    cursor: pointer;
    font-size: 16px;
    color: #8b959f;
    padding: 0 2px;
  }
  .dialog-close{
    position: absolute;
    top: 5px;
    right: 5px;
    cursor: pointer;
  }
  .reg-code, .login-code{
    padding: 8px 8px;
    background: #dde2e6;
    color: #f00;
    font-size: 16px;
    border-radius: 1px;
    cursor: pointer;
  }
</style>
<div id="dialog">
  <div class="dialog-mask"></div>
  <div class="dialog-box">
  <img class="dialog-close" src="assets/img/close.png" alt="">
  <!-- 注册 -->
    <div class="register">
      <h2>注册账号</h2>
      <!-- 用户名 -->
      <form action="welcome/register" method="post" id="submit-form"> 
        <div class="dialog-list">
          <div class="dialog-pic">
            <img src="assets/img/user.png" alt="">
          </div>
          <input id="reg-name" name="username" type="text" autocomplete="off" placeholder="用户名为6-12位数字或字母">
          <span id="name-msg" class="tip-name"></span>
        </div>
        <!-- 密码 -->
        <div class="dialog-list">
          <div class="dialog-pic">
            <img src="assets/img/password.png" alt="">
          </div>
          <input id="reg-pass" type="password" type="password" name="password" autocomplete="off" placeholder="密码为6-16位数字或字母">
          <span id="pass-msg" class="tip-name"></span>
        </div>
        <!-- 验证码 -->
        <div class="dialog-list">
          <div class="dialog-pic">
            <img src="assets/img/set.png" alt="">
          </div>
          <input id="reg-code" type="text" autocomplete="off" placeholder="验证码">
          <span class="reg-code" onselectstart="return false;"></span>
        </div>
        <!-- 注册 -->
        <div class="dialog-list" style="border-bottom: transparent;">
          <input id="reg-btn" class="btn-big" value="立即注册" type="submit">
        </div>
      </form> 
    </div>
  
    <!-- 注册 -->

    <!-- 登录 -->
    <div class="login">
      <h2>登录账号</h2>
      <!-- 用户名 -->
      <div class="dialog-list">
        <div class="dialog-pic">
          <img src="assets/img/user.png" alt="">
        </div>
        <input id="log-name" type="text" autocomplete="off" placeholder="用户名">
        <span class="tip-name"></span>
      </div>
      <!-- 密码 -->
      <div class="dialog-list">
        <div class="dialog-pic">
          <img src="assets/img/password.png" alt="">
        </div>
        <input id="log-pass" type="password" type="password" autocomplete="off" placeholder="密码">
        <span class="tip-name"></span>
      </div>
      <!-- 验证码 -->
      <div class="dialog-list">
        <div class="dialog-pic">
          <img src="assets/img/set.png" alt="">
        </div>
        <input id="login-code" type="text" autocomplete="off" placeholder="验证码">
        <span class="login-code" onselectstart="return false;"></span>
      </div>
      <!-- 登录 -->
      <div class="dialog-list" style="border-bottom: transparent;">
        <input id="login-btn" class="btn-big" value="登录" type="button">
      </div>
    </div>
    <!-- 登录 -->
    <p style="text-align: center; margin-top: 20px;">
      <span class="login-tab-btn" onselectstart="return false;">没有账号？马上注册》</span> 
    </p>
  </div>
</div>
<script src="assets/js/jquery-1.12.4.min.js"></script>
<script>
  $(function(){
    var $url = window.location.href;
    // console.log($url);
    var flag = false;
    $('.login-tab-btn').on('click', function(){
      if(flag){
        $('.login').show();
        $('.register').hide();
        $('.login-tab-btn').html('没有账号？马上注册》');;
      }else{
        $('.login').hide();
        $('.register').show();
        $('.login-tab-btn').html('已有账号？登录》');
      }
      flag = !flag;
    });

    // 关闭弹出层
    $('.dialog-close').on('click', function(){
      $('#dialog').hide(400);
    });

    // 打开弹出层
    $('.login-register').on('click', function(){
      // console.log(123456);
      $('#dialog').show(600);
    });

    // 切换验证码
    $(window).on('load', function(){
      $('.login-code, .reg-code').trigger('click');  
    })
    $('.login-code, .reg-code').on('click', function(){
      var upperCode = createCode(4);
      $(this).html(upperCode);
    });
    function createCode(count){
      var resultStr = '';
      var codeStr = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0987654321abcdefghijklmnopqrstuvwxyz';
      for(var i=0; i<count; i++){
        var index = Math.random() * 62;
        resultStr += codeStr.charAt(index);
      }
      return resultStr;
    }
    var obj = {

    };
    var obj = {
      bSubmit : true
    };
    // 注册用户名
    $('#reg-name').on('blur', function(){
      var $rName = $(this).val();
      if(!/[a-zA-Z0-9]{6,12}/.test($rName)){
        $('#name-msg').html('用户名格式不正确');
        obj.bSubmit = false;
      }else{
        $.get('welcome/check_register', {username: $rName}, function(res){
          if(res == 'success'){
            $('#name-msg').html('该用户名已注册');
            obj.bSubmit = false;        
          }else{
            $('#name-msg').html('');
            obj.bSubmit = true;        
          }
        }, 'text');
      }
    });
    
    // 注册密码
    $('#reg-pass').on('blur', function(e, param){
      if(!/[a-zA-Z0-9]{6,16}/.test($(this).val())){
        $('#pass-msg').html('密码格式不正确');
        param && (param.bSubmit = false);
      }else{
        $('#pass-msg').html('');    
        param && (param.bSubmit = false);        
      }
    });


    $('#submit-form').on('submit', function(){
      var regCode = $('#reg-code').val().toUpperCase();
      var picCode = $('.reg-code').html().toUpperCase(); 
      // console.log(regCode + "======"+ picCode);     
      $('#reg-name').trigger('blur');
      $('#reg-pass').trigger('blur', obj);
      if(!(regCode == picCode)){
        alert('验证码不正确');
        obj.bSubmit = false;        
      }else{
        obj.bSubmit = true;                
      }
      return obj.bSubmit;
    });

    // 用户登录
    $('#login-btn').on('click', function(){
      var username = $('#log-name').val();
      var password = $('#log-pass').val();
      var loginCode = $('#login-code').val().toUpperCase();
      var loginPic = $('.login-code').html().toUpperCase();
      // console.log(username+ "==="+password);
      if(!(loginCode == loginPic)){
        alert('验证码输入有误');
      }else{
        $.post('welcome/login', {
          username: username,
          password: password
        }, function(res){
          console.log(res);
          if(res == 'success'){
            window.location = $url;
          }else if(res == 1){
            alert('用户名错误');
          }else if(res == 2){
            alert('密码错误');
          }else if(res == 3){
            alert('用户名或密码错误');
          }
        }, 'text');
      }
    });
  });
</script>