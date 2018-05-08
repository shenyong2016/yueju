$(function(){
  // 轮播图
  // 轮播图高度自适应
  $('#slide-box').height($('body').width()/1920*490);
  $(window).on('resize', function(){
    $('#slide-box').height($('body').width()/1920*490);  
  });

  var $tab = $('.slide-tab li img');
  var $imgs = $('.slide-imgs img');
  var $slideBox = $('#slide-box');
  var iNow = 0;
  var timer;
  // $imgs.hide();
  // $imgs.eq(0).show();
  $tab.on('click', function(){
    // console.log($(this).parent('li').index());
    iNow = $(this).parent('li').index();
    changeImg($(this).parent('li').index());
  });
  function runSlide(){
    timer = setInterval(function(){
      iNow++;
      if (iNow == 5) iNow = 0;
      changeImg(iNow);
    }, 3000);
  }
  runSlide();
  $slideBox.on('mouseover', function(){
    clearInterval(timer);
  }).on('mouseout', function(){
    runSlide();
  });
  function changeImg(index){
    $tab.eq(index).addClass('slide-tab-active').parent('li').siblings().children('img').removeClass('slide-tab-active');
    $imgs.eq(index).stop(200).fadeIn().siblings().stop(200).fadeOut();
  }

  // var date = new Date();
  // $('#startTime').val(date.getFullYear()+'-'+(date.getMonth()+1) +'-'+date.getDate());
  // $('#endTime').val(date.getFullYear()+'-'+(date.getMonth()+1) +'-'+date.getDate());
  
  // 点击搜索跳转页面
  $(".search-btn").on('click', function(){
    var minPrice = $('#startTime').val();
    var maxPrice = $('#endTime').val();
    var content = $('.search-content-val').val();
    // console.log($startTime + '=' + $endTime + '=' + $contents);
    if(!/^\d*$/.test(minPrice) || !/^\d*$/.test(maxPrice)){
      alert('价钱请输入数字');
      return;
    }
    window.location.href = 'house/search_index?minPrice='+ minPrice +'&maxPrice='+ maxPrice + '&content='+ content;
  });

  
  


  //日期组件
  // $startPicker = $("#startTime");
  //   $endPicker = $("#endTime");
  //   $startPicker.datepicker( "option", "dateFormat", "yy-mm-dd");
  //   $startPicker.datepicker({
  //     defaultDate: "+1w",
  //     changeYear: true,
  //     changeMonth: true,
  //     showButtonPanel:true,
  //     numberOfMonths: 1,
  //     onClose: function( selectedDate ) {
  //       $endPicker.datepicker( "option", "minDate", selectedDate );
  //     }
  //   });

  //   $endPicker.datepicker( "option", "dateFormat", "yy-mm-dd");
  //   $endPicker.datepicker({
  //     defaultDate: "+1w",
  //     changeYear: true,  
  //     showButtonPanel:true,        
  //     changeMonth: true,
  //     numberOfMonths: 1,
  //     onClose: function( selectedDate ) {
  //       $startPicker.datepicker( "option", "maxDate", selectedDate );
  //     }
  //   }); 
  
 
});
