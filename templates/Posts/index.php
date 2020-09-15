<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $posts
 */
?>
<!-- HOME SECTION -->
<section id="review_book_search">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12">
        <p class="index">最近の投稿</p>
      </div>
      <!-- 入力フォーム -->
      <form class="clearfix">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <p><strong>ユーザー名</strong></p>
          <input class="search user_name" type="text" name="search_user_name" placeholder="ユーザー名">
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <p><strong>本のタイトル</strong></p>
          <input class="search book_name" type="text" name="search_book_name" placeholder="本のタイトル">
        </div>
      </form><!-- 入力フォーム -->
      <div class="col-lg-12 col-md-12 col-sm-12">
        <table class="table table-hover">
          <thead>
            <tr>
              <th><?= $this->Paginator->sort('user_id') ?></th>
              <th><?= $this->Paginator->sort('book_id') ?></th>
              <th><?= $this->Paginator->sort('recommends') ?></th>
                <th class="hidden-xs"><?= $this->Paginator->sort('created') ?></th>
            </tr>
          </thead>
          <tbody id="ajax_review_list">
            <?php foreach ($posts as $post): ?>
                <tr>
                  <td>
                    <p>
                        <i class="fas fa-user small_icon user"></i>
                    </p>
                    <p>
                      <?= $this->html->link(h($post->user->username), ['controller' => 'users', 'acttion' => 'main','?' => ['user_id' => $this->Number->format($post->user_id)]]) ?>
                    </p>
                  </td>
                  <td>
                    <p>
                        <i class="fas fa-book-open small_icon"></i>
                    </p>
                    <p>
                      <?= $this->Html->link(h($post->book->bookname), ['controller' => 'posts', 'action' => 'view', $this->Number->format($post->book_id)]) ?>
                    </p>
                  </td>
                  <td>
                    <p class="recommends_box">
                      <span class="range-group">

                        <?php for ($j=1; $j <= $post["recommends"]; $j++):?>
                          <?= $this->Html->image('base/star-on.png') ?>
                        <?php endfor ?>
                        <?php if ($post["recommends"] < 5) {for ($j=$post["recommends"]; $j < 5; $j++):?>
                          <?= $this->Html->image('base/star-off.png') ?>
                        <?php endfor;} ?>

                      </span>
                    </p>
                  </td>
                  <td class="hidden-xs"><p><?= h($post->created) ?></p></td>
                </tr>
            <?php endforeach; ?>

          </tbody>
        </table>

      </div>


    </div><!-- row -->
  </div><!-- user_inform -->
</section>

<script>
$(function(){

  $(function search_reviews(){
    $('input.search').on("input", function(){
      $.ajax({
        type: "get",
        url: "/SBS/posts/ajax",
        datatype:"text",
        data:{"search_user_name": $("input.user_name").val(),"search_book_name": $("input.book_name").val()}
      })

      .done(function(data,type){
        // var data = $.parseJSON(data);
        var json1 = data;
        var posts = JSON.parse(json1);
        $("#ajax_review_list").empty();

        $.each(posts, function(arr, key){
        //
        // var html = html + "<p>" + key["user_image"];
        // var html = html + "</p><p><a href='main.php?user_id=" + key["user_id"] + "'>" + key["user_name"]+ "</a></p></td>";

          var html ="<tr><td>";
          var html = html + "<p>" + key["userimage"];
          var html = html + "</p><p>" + key["username"]+ "</p></td>";
          var html = html + "<td>";
          var html = html + "<p>" + key["bookimage"];
          var html = html + "</p><p>" + key["bookname"] + "</p></td>";
          var html = html + "<td><span class='range-group'" + key["recommends"] + "</span></td>";
          var html = html + "<td>" + key["created"] + "</td></tr>"
          $('#ajax_review_list').append(html);
        });
        //
      })
      .fail(function(data){
        console.log('通信失敗');
        console.log(data);
      });
    })
  })
})

</script>
