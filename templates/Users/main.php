
<?= $this->Html->script(['friend'])?>


  <main>
    <?php
      if ($user->id == $_SESSION['Auth']['id']){
        $user_name = $_SESSION["Auth"]["username"];
        $id = $_SESSION['Auth']['id'];
        $role = $_SESSION['Auth']['role'];
        $user_image = $_SESSION["Auth"]["image"];
      }else{
        $id = $user->id;
        $user_name = $user->username;
        $role = $user->role;
        $user_image = $user->image;
        ?>
        <!-- ajaxで使用 -->
        <p class="hidden user_id"><?= $_SESSION['Auth']['id'] ?></p>
        <p class="hidden friends_id"><?= $id ?></p>
        <?php
      };
    ?>
    <!-- ajaxで使用 -->
    <p class="hidden current_pages_user_id"><?= $id ?></p>


    <!-- HOME SECTION -->
    <section id="home">
      <div id="user_inform" class="container">
        <div class="row">
          <div class="col-lg-12 col-sm-12">
            <p class="index text-center">アカウント情報</p>
          </div>
            <div class="col-lg-2 col-sm-2 col-xs-12">
              <?php if (isset($user_image) ){ ?>
                <?= $this->HTML->image('users/'.$user_image, ['class'=>'user_icon']) ?>
              <?php }else{ ?>
                  <i class="fas fa-user main_icon"></i><!-- $user_image -->
              <?php } ?>

            </div>
            <div id="user_text" class="col-lg-9 col-sm-9  col-xs-12 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
              <p>名前：<?php echo $user_name ?></p>

              <?php if ($id == $_SESSION['Auth']['id']){ ?>
                <p>メールアドレス：<?php echo $_SESSION["Auth"]["email"] ?></p>
              <?php } ?>
                <p>友だち：
                  <a href="/SBS/friends/index/<?= $id ?>">
                    <?= $count ?>人
                  </a>
                </p>
            </div>

            <!-- 編集 or 友だち追加 -->
            <div class="col-lg-2 col-md-2 col-sm-3 col-lg-offset-10 col-md-offset-10 col-sm-offset-9 text-right">
              <?php if ($id == $_SESSION['Auth']['id']){ ?>
                <?= $this->Html->link('編集する', "/users/edit/".$id , ['class' => 'edit_link']) ?>
              <?php }else{ ?>
                <a id="friend_add"></a><!-- 友だち追加・削除ボタン -->
              <?php }; ?>
            </div>
        </div><!-- row -->
      </div><!-- user_inform -->
    </section>

    <!-- Book_Shelf SECTION -->
    <section id="book_shelf">
      <div class="container">
        <div class="row">
          <?php if ($_SESSION['Auth']['role'] == 1 && $id == $_SESSION['Auth']['id'] ) { ?>
            <!--                                         管理者画面                                        -->
            <div class="col-lg-12 col-md-12 col-sm-12">
              <p class="index">管理者専用ページ</p>
              <p class="index_right"><strong>メインページ</strong></p>
              <p>
                <?= $this->Html->link('ユーザー一覧', ['controller'=>'admin/users', 'action'=>'index', 'class'=>'top']) ?>
              </p>
              <p>
                <?= $this->Html->link('本一覧', ['controller'=>'admin/books', 'action'=>'index', 'class'=>'top']) ?>
              </p>
              <p>
                <?= $this->Html->link('レビュー一覧', ['controller'=>'admin/posts', 'action'=>'index', 'class'=>'top']) ?>
              </p>
              <p>
                <?= $this->Html->link('いいね一覧', ['controller'=>'admin/goods', 'action'=>'index', 'class'=>'top']) ?>
              </p>
              <p>
                <?= $this->Html->link('友だち一覧', ['controller'=>'admin/friends', 'action'=>'index', 'class'=>'top']) ?>
              </p>
            </div>
          <?php }else{ ?>
            <!--                                         一般ユーザー画面                                        -->
            <div class="col-lg-12 col-sm-12">
              <p class="index"><?php echo $user_name; ?>さんの本棚</p>
              <?php if(empty($_GET["user_id"]) || $_GET["user_id"] == $_SESSION["Auth"]["id"]): ?>
                <?= $this->HTML->link('本を追加する',['controller'=>'Books', 'action'=>'index']) ?>
              <?php endif; ?>


              <div id="book_shelf_container">
                <?php if (isset($posts)): ?>
                  <?php foreach ($posts as $post): ?>

                    <div class="book_container">
                      <div class="book_image">
                        <!-- 本のイメージはDBにimageの登録があり、同名のイメージ画像が保存されている場合のみ表示する。 -->
                        <?php if (!empty($post['image']) && file_exists('img/books/'.$post['image'])){ ?>
                          <p><?= $this->HTML->image('books/'.$post['image'], ['class'=>'book_icon']); ?></p>
                        <?php }else{ ?>
                          <i class="fas fa-book-open"></i>
                        <?php } ?>

                      </div>
                      <p>名前：<?= h($post['bookname']); ?></p>
                      <p>おすすめ度：
                        <span class="range-group">

                          <?php for ($j=1; $j <= h($post['recommends']); $j++):?>
                            <?= $this->HTML->image('base/star-on.png'); ?>

                          <?php endfor ?>
                          <?php if ( h($post['recommends']) < 5){
                            for ($j = h($post['recommends']); $j < 5; $j++):?>
                              <?= $this->HTML->image('base/star-off.png'); ?>
                            <?php endfor;?>
                          <?php } ?>

                        </span>
                      </p>
                      <p>追加日時：<?= h($post['created']) ?></p>

                      <p>
                        <?= $this->Html->link('詳しく見る', '/posts/view/'.$post['id']); ?>
                      </p>
                    </div>
                  <?php endforeach ?>

                <?php endif; ?>
              </div>
            </div>

          <?php } ?>
        </div>
      </div>
    </section>

  </main>
