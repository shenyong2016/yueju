$(function(){
  // header导航
  $currentIndex = $('#current-index').val();
  $navTab = $('.nav-tab .nav-tab-item a');
  // console.log($currentIndex);
  var iNow = 0;
  var hoverIndex;
  switch($currentIndex){
    case 'index':
      iNow = 0;
      break;
    case 'house':
      iNow = 1;
      break;
    case 'tour':
      iNow = 2;
      break;
    case 'user':
      iNow = 3;
      break;
    case 'about':
      iNow = 4;
      break; 
    default:
      iNow = 5;
      break;
  }
  // console.log(iNow);
  changeTab(iNow);
  $navTab.on('mouseover', function(){ 
    hoverIndex = $(this).parent('li').index();  
    changeTab(hoverIndex);
    $navTab.eq(iNow).addClass('tab-active');     
  });
  $navTab.hover(function(){
    $navTab.eq(hoverIndex).addClass('tab-active');         
  }, function(){
    if(iNow != hoverIndex){//当前导航页的索引与hover的索引
      $navTab.eq(hoverIndex).removeClass('tab-active');                 
    }
  });

  $('.login-register a').on('mouseover', function(){
    $(this).addClass('login-active');
  }).on('mouseout', function(){
    $(this).removeClass('login-active');
  });

  function changeTab(index){
    $navTab.eq(index).addClass('tab-active').parent('.nav-tab-item').siblings()
    .children('a').removeClass('tab-active');
  }

  // 判断用户登录后进入个人中心页面
  $('.person-center').on('click', function(){
    var user = $(this).data('user');
    if(!user){
      alert('用户未登录，请先登录');
      $('#dialog').show(600);
      return;
    }
    window.location.href = 'welcome/user';
  });
});