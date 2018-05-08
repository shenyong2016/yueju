$(function(){
  //搜索下拉框
  $('.select_btn').on('click',function(){
    $('.search_list').toggle();
  });
  $('.search_list li').on('click',function(){
      $('.select_btn').html($(this).html());
      $('.select_hidden').val($(this).html());
      $('.search_list').hide();
  });
  $(document).on('mousedown',function(e){
      if(!$(e.target).is($('.select_btn')) && !$(e.target).is($('.search_list')) && $(e.target).parent('.search_list').length === 0){
          $('.search_list').css('display','none');
      }
  });

  //日期组件
  // $startPicker = $( "#dpd1" );
  // $endPicker = $( "#dpd2" );
  // $startPicker.datepicker( "option", "dateFormat", "yy-mm-dd");
  // $startPicker.datepicker({
  //   defaultDate: "+1w",
  //   changeYear: true,
  //   changeMonth: true,
  //   numberOfMonths: 1,
  //   onClose: function( selectedDate ) {
  //     $endPicker.datepicker( "option", "minDate", selectedDate );
  //   }
  // });

  // $endPicker.datepicker( "option", "dateFormat", "yy-mm-dd");  
  // $endPicker.datepicker({
  //   defaultDate: "+1w",
  //   changeYear: true,    
  //   changeMonth: true,
  //   numberOfMonths: 1,
  //   onClose: function( selectedDate ) {
  //     $startPicker.datepicker( "option", "maxDate", selectedDate );
  //   }
  // });







});