$(function(){
  
  $('.house-group .pic-box').on('mouseover', function(){
    // console.log(12345);
    $(this).children('img').stop().animate({
      width: 390,
      height: 237,
      marginLeft: -10,
      marginTop: -6,
    });
    $(this).children('.house-mask').stop().animate({
      opacity: 0.4
    });
  });
  $('.house-group .pic-box').on('mouseout', function(){
    $(this).children('img').stop().animate({
      width: 370,
      height: 225,
      marginLeft: 0,
      marginTop: 0,
    });   
    $(this).children('.house-mask').stop().animate({
      opacity: 0
    }); 
  });
});

