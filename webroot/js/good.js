// posts/viewで読み込み


$(function(){
  goods_test();
  check_good_recode();

  // 読み込み時のレコード確認
  function check_good_recode(){
    var user_id = $(".user_id").text();
    var post_id = $(".post_id").text();
    var csrf = $('input[name=_csrfToken]').val();

    $(window).on('load', function(){
      $.ajax({
        type: "post",
        url: "/SBS/goods/button",
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-CSRF-Token', $('input[name="_csrfToken"]').val());
        },
        // ,
        data: {'user_id':user_id,'post_id':post_id}
      }).done(function(data){
        var data = JSON.parse(data);
        $('.good_count').empty();
        $('.good_count').append(data.count + "件");

        if (data.btn=='already') {
          $('#good_add').addClass('already');
        }
      })
    })
  }

  function goods_test(){

    $(document).on('click', '#good_add', function(){
      var user_id = $(".user_id").text();
      var post_id = $(".post_id").text();

      if ($('#good_add').hasClass("already")) {
        // いいねレコードの削除
        $.ajax({
          type: 'post',
          url: '/SBS/goods/ajax_delete',
          beforeSend: function (xhr) {
            xhr.setRequestHeader('X-CSRF-Token', $('input[name="_csrfToken"]').val());
          },
          data: {'user_id':user_id,'post_id':post_id}
        }).done(function(data){
          $('.good_count').empty();
          $('.good_count').append(data + "件");
          $('#good_add').removeClass("already");
        })
      }else{
        // いいねレコードの追加
        $.ajax({
          type: 'post',
          url: '/SBS/goods/add',
          beforeSend: function (xhr) {
            xhr.setRequestHeader('X-CSRF-Token', $('input[name="_csrfToken"]').val());
          },
          data: {'user_id':user_id,'post_id':post_id}
        }).done(function(data){
          $('.good_count').empty();
          $('.good_count').append(data + "件");
          $('#good_add').addClass("already");
        })

      }
      return false;
    })

  }

})
