$(function(){
  // 房屋图片切换
  $imgs = $('.house-imgs img');
  $tabs = $('.house-tab li');
  var iNow = 0;
  $('.house-container').hover(function(){
    $('.left-btn, .right-btn').show();
  }, function(){
    $('.left-btn, .right-btn').hide();    
  });
  $imgs.eq(0).addClass('selected');
  $tabs.eq(0).addClass('selected');
  $tabs.on('mouseover', function(){
    iNow  = $(this).index();
    changeImgs($(this).index());
  });

  $('.left-btn').on('click', function(){
    iNow++;
    iNow = iNow == 4 ? 0 : iNow;
    changeImgs(iNow);
  });
  $('.right-btn').on('click', function(){
    iNow--;
    iNow = iNow == -1 ? 3 : iNow;
    changeImgs(iNow);
  });
  function changeImgs(index){
    $tabs.eq(index).addClass('selected').siblings().removeClass('selected');
    $imgs.eq(index).addClass('selected')
    .siblings().removeClass('selected');
  }

  // 房屋信息切换
  var $infoContent = $('.base-info, .note-in-info, .comment-info');
  $infoContent.hide().eq(0).show();
  $('.other-nav span').on('click', function(){
    console.log($(this).index());
    $(this).addClass('current-border').siblings().removeClass('current-border');
    $infoContent.eq($(this).index())
    .show().siblings().hide();
  });

  // 获取该房源已经预定的时间
  var houseId = $('.filter-btn').data('house-id');
  var disabledDays = []; //datepicker中不能预定的房源的日期 
  $.ajax({
    type: 'get',
    url: 'order/get_house_reserve_time',
    data: {
      houseId
    },
    dataType: 'json',
    success(timeData){
      for(var i=0; i<timeData.length; i++){
        var start = timeData[i].start_time;
        var end = timeData[i].end_time;
        // 获取某一时间段内的所有时间
        function getDate(datestr){
          var temp = datestr.split("-");
          var date = new Date(temp[0],temp[1],temp[2]);
          return date;
        }
        var startTime = getDate(start);
        var endTime = getDate(end);
        while((endTime.getTime()-startTime.getTime())>=0){
          var year = startTime.getFullYear();
          var month = startTime.getMonth().toString().length==1 ? "0"+startTime.getMonth().toString() : startTime.getMonth();
          var day = startTime.getDate().toString().length==1 ? "0"+startTime.getDate() : startTime.getDate();
          startTime.setDate(startTime.getDate()+1);
          disabledDays.push(year+"-"+month+"-"+day);    
        }
        // 获取某一时间段内的所有时间        
      }
    },
  });

  // 时间组件
  // var disabledDays=["2018-05-12","2018-05-14","2018-06-16","2018-10-16"];
  var date = new Date();
  $startPicker = $( "#stayIn" );
  $endPicker = $( "#checkOut" );
  $startPicker.datepicker( "option", "dateFormat", "yy-mm-dd");
  $startPicker.datepicker({
    // defaultDate: new Date(),
    minDate: new Date(),
    changeYear: true,
    changeMonth: true,
    numberOfMonths: 1,
    onClose( selectedDate ) {
      $endPicker.datepicker( "option", "minDate", selectedDate);
    },
    beforeShowDay(date){
      var y = date.getFullYear();      
      var m = '0' + Number(date.getMonth() + 1);
      var d = '0' + date.getDate();
      var formatDate = y+"-"+m.substring(m.length-2,m.length)+"-"+d.substring(d.length-2,d.length)
      //inArray实现数组的匹配
      if($.inArray(formatDate, disabledDays) != -1){
          //此处要返回一个数组，disabledDays是添加样式的类
          return [false];
      }
      return [true];
    }
  });

  $endPicker.datepicker( "option", "dateFormat", "yy-mm-dd");  
  $endPicker.datepicker({
    // defaultDate: new Date(),
    minDate: new Date(),    
    changeYear: true,    
    changeMonth: true,
    numberOfMonths: 1,
    onClose( selectedDate ) {
      $startPicker.datepicker( "option", "maxDate", selectedDate );
    },
    beforeShowDay(date){
      var y = date.getFullYear();      
      var m = '0' + Number(date.getMonth() + 1);
      var d = '0' + date.getDate();
      var formatDate = y+"-"+m.substring(m.length-2,m.length)+"-"+d.substring(d.length-2,d.length)
      //inArray实现数组的匹配
      if($.inArray(formatDate, disabledDays) != -1){
          //此处要返回一个数组，disabledDays是添加样式的类
          return [false];
      }
      return [true];
    }
  }); 
  

























});