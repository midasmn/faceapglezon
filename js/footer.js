
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

// ソーシャルボタン　フェードイン・アウト
$(function(){
  $(window).bind("scroll", function() {
  if ($(this).scrollTop() > 150) { 
    $(".social-button").fadeIn();
  } else {
    $(".social-button").fadeOut();
  }

  // ソーシャルボタンリンクを右下に固定
  $(".social-button").css({"position":"fixed","bottom": "100px"});

  });
});