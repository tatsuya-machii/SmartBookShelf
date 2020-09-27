$(function(){
  var user_id = $('.user_id').text();
  var friends_id = $('.friends_id').text();

  // ページ読み込み時の処理
  // friendレコードの有無の確認・ボタンの表示
  $(window).on('load', function(){
    $.ajax({
      type: 'post',
      url: '/SBS/friends/test',
      beforeSend: function (xhr) {
        xhr.setRequestHeader('X-CSRF-Token', $('input[name="_csrfToken"]').val())
      },
      data: {
        'user_id':user_id,
        'friends_id':friends_id
      }
    }).done(function(data){
      if(data == "already"){
        $('#friend_add')
        .text('友だち解除')
        .addClass('already')
      }else{
          $('#friend_add')
          .text('友だちに追加')

      }
    })

  })



  // 友だち追加・解除ボタンクリック時の動作
  $('#friend_add').on('click', function(){
    if ($('#friend_add').hasClass('already')) {
      // 友だち解除機能
      $.ajax({
        type: 'post',
        url: "/SBS/friends/delete",
        beforeSend: function (xhr) {
          xhr.setRequestHeader('X-CSRF-Token', $('input[name="_csrfToken"]').val());
        },
        data: {
          'user_id':user_id,
          'friends_id':friends_id
        }
      }).done(function(data){
        if(data == "success"){
          $('#friend_add')
          .text('友だちに追加')
          .removeClass('already')
        }
      })
    }else{
      // 友だち追加機能
      $.ajax({
        type: 'post',
        url: "/SBS/friends/add",
        beforeSend: function (xhr) {
          xhr.setRequestHeader('X-CSRF-Token', $('input[name="_csrfToken"]').val());
        },
        data: {
          'user_id':user_id,
          'friends_id':friends_id
        }
      }).done(function(data){
        if(data == "success"){
          $('#friend_add')
          .text('友だち解除')
          .addClass('already')
        }
      })
    }
  })

})
