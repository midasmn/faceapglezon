// ページトップへ
$(function(){
  var pageTop = $("#page-top");
  pageTop.hide();
  pageTop.click(function () {
    $('body, html').animate({ scrollTop: 0 }, 600);
    return false;
  });
  $(window).scroll(function () { 
    if($(this).scrollTop() >= 200) { 
      pageTop.fadeIn();
    } else {
      pageTop.fadeOut();
    }
  });
});
