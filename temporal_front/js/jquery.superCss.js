/*
Small handy artificial css properties
*/
function respond(){
  //make elements to be vertically centered
  $(".scss-vcenter").each(function(){
    var parentHeight=$(this).parent().height();
    var myHeight=$(this).height();
    $(this).css({"margin-top":(parentHeight-myHeight)/2+"px"});
  });
  //make elements to fill their container
  $(".scss-fill").each(function(){
    // var myHeight=$(this).height();
    // $(this).css({"position":"relative","margin-top":"50%","top":myHeight/2+"px"});
  });
}
$(window).on("scroll resize load",function(){
  respond();
});
