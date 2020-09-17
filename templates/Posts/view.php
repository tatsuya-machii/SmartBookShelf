<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $post
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Post'), ['action' => 'edit', $post->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Post'), ['action' => 'delete', $post->id], ['confirm' => __('Are you sure you want to delete # {0}?', $post->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Posts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Post'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="posts view content">
            <h3><?= h($post->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($post->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Recommends') ?></th>
                    <td><?= $this->Number->format($post->recommends) ?></td>
                </tr>
                <tr>
                    <th><?= __('User Id') ?></th>
                    <td>name:<?= h($post->user->username); ?>, ID:<?= $this->Number->format($post->user_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Book Id') ?></th>
                    <td>name:<?= h($post->book->bookname); ?>, ID:<?= $this->Number->format($post->book_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($post->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($post->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($post->description)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Impression') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($post->impression)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('good') ?></strong>
                <blockquote>
                  <p class="hidden user_id"><?= $_SESSION['Auth']['id'] ?></p>
                  <p class="hidden post_id"><?= $post->id ?></p>

                    <a id="good_add" href=""><?= $this->Html->image('base/good.jpg',['class'=>'good', 'alt'=>'いいね！']) ?></a>
                  <span> </span>
                  <?= $this->Html->link('件', ['controller'=> 'posts', 'action'=>'add', '?'=>['review_id'=>h($post->id)]],['class'=>'good_count']) ?>
                </blockquote>
            </div>
        </div>
    </div>
    <script>
  $(function(){
    goods_test();
    check_good_recode();

    // 読み込み時のレコード確認
    function check_good_recode(){
      var user_id = $(".user_id").text();
      var post_id = $(".post_id").text();

      $(window).on('load', function(){
        $.ajax({
          type: "post",
          url: "/SBS/goods/button",
          beforeSend: function (xhr) {
            xhr.setRequestHeader('X-CSRF-Token', $('input[name="_csrfToken"]').val());
          },
          data: {'user_id':user_id,'post_id':post_id}
        }).done(function(data){
          $data = JSON.parse(data);
          $('.good_count').empty();
          $('.good_count').append($data.count + "件");



          if ($data.btn) {
            $('#good_add').addClass($data['btn']);
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
            url: '/SBS/goods/delete',
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

  </script>

</div>
