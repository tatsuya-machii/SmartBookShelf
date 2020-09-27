$(function(){

  // 友だち追加・解除ボタンクリック時の動作
  $('input.search').on('input', function(){
      $.ajax({
        type: 'post',
        url: "/SBS/books/search",
        beforeSend: function (xhr) {
          xhr.setRequestHeader('X-CSRF-Token', $('input[name="_csrfToken"]').val());
      },data: {
        'book_name':$('input.name').val(),
        'author':$('input.author').val()
      }
      }).done(function(data){
        // json形式から配列に変換
        var books = JSON.parse(data);
        $('#ajax_books_lists').empty();
        $.each(books, function(arr, key){
          var html = "<tr><td>";
          var html = html + "<p>" + key['image'] +"</p></td><td>";
          var html = html + "<p><a href='/SBS/posts/add/" + key['id'] + "'>" + key['bookname'] + "</a></p></td>";
          var html = html + "<td><p>" + key['author'] +"</p></td>";
          var html = html + "<td><p>" + key['publisher'] +"</p></td>";
          var html = html + "<td><p>" + key['created'] +"</p></td>";
          var html = html + "<td><a href='/SBS/posts/add/" + key['id'] + "' class='button'>追加</a></td>";

          $('#ajax_books_lists').append(html);

        })

      });

  })

})
