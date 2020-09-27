$(function(){
  $('.ajax_range > a').on('click', function(){

    var index = $(this).index();
    for (var i = 0; i <= index; i++) {
      $('.ajax_range > a > img').eq(i).attr('src', '../../img/base/star-on.png');
    }
    if (index < 4) {
      for (var i = index + 1; i < 5; i++) {
        $('.ajax_range > a > img').eq(i).attr('src', '../../img/base/star-off.png');
      };
    }
    $('.input-range').attr('value', index + 1);
    return false;
  })
})
