
  <main>
    <?php if (empty($_GET["user_id"])){
      $user_name = $_SESSION["Auth"]["username"];
      if (isset($_SESSION["Auth"]["image"])) {
        $user_image = $_SESSION["Auth"]["image"];
      }
    }else{
      $user_name = $result[0]["user_name"];
      $user_image = $result[0]["user_image"];
    }; ?>
    <!-- HOME SECTION -->
    <section id="home">
      <div id="user_inform" class="container">
        <div class="row">
          <div class="col-lg-12 col-sm-12">
            <p class="index text-center">アカウント情報</p>
          </div>
            <div class="col-lg-2 col-sm-2 col-xs-12">
              <?php if (empty($_GET["user_id"]) || $_GET["user_id"] == $_SESSION["user"]["id"]){ ?>
                <?php if (isset($_SESSION["user"]["image"]) && file_exists("../../wabroot/img/users/".$_SESSION["user"]["image"])){ ?>
                  <img class="user_icon" src="../../img/users/<?php echo $_SESSION["user"]["id"]; ?>.jpg" alt="ユーザーアイコン"><!-- $user_image -->
                <?php }else{ ?>
                    <i class="fas fa-user main_icon"></i><!-- $user_image -->
                <?php } ?>
              <?php }else{ ?>
                <?php if (isset($_GET["user_image"]) && file_exists("../../img/users/".$_GET["user_image"])){ ?>
                  <img class="user_icon" src="../../img/users/<?php echo $_GET["user_id"]; ?>.jpg" alt="ユーザーアイコン"><!-- $user_image -->
                <?php }else{ ?>
                    <i class="fas fa-user main_icon"></i><!-- $user_image -->
                <?php } ?>

              <?php } ?>

            </div>
            <div id="user_text" class="col-lg-9 col-sm-9  col-xs-12 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
              <p>名前：<?php echo $user_name ?></p>
              <?php if (empty($_GET["user_id"]) || $_GET["user_id"] == $_SESSION["user"]["id"]): ?>
                <p>メールアドレス：<?php echo $_SESSION["Auth"]["email"] ?></p>
              <?php endif; ?>
                <p>友だち：
                  <a href="friend_index.php<?php if(!empty($_GET["user_id"]) && $_GET["user_id"] != $_SESSION["user"]["id"]){echo "?user_id=".$_GET["user_id"];} ?>">
                    <span id="ajax_friends"></span>人
                  </a>
                </p>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-3 col-lg-offset-10 col-md-offset-10 col-sm-offset-9 text-right">
              <?php if (empty($_GET["user_id"]) || $_GET["user_id"] == $_SESSION["user"]["id"]){ ?>
                <?= $this->Html->link('編集する', '/users/edit/'.$_SESSION['Auth']['id'], ['class' => 'edit_link']) ?>
              <?php }else{ ?>
                <div id="friend_add"></div>
              <?php }; ?>
            </div>
        </div><!-- row -->
      </div><!-- user_inform -->
    </section>
    <section id="book_shelf">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 col-sm-12">
            <p class="index"><?php echo $user_name; ?>さんの本棚</p>
            <?php if(empty($_GET["user_id"]) || $_GET["user_id"] == $_SESSION["user"]["id"]): ?>
              <a href="review_book_search.php">本を追加する</a>
            <?php endif; ?>


            <div id="book_shelf_container">
              <?php if (isset($posts)): ?>
                <?php foreach ($posts as $post): ?>

                  <div class="book_container">
                    <div class="book_image">
                      <?php if (isset($post['image'])){ ?>
                        <p><?= $this->HTML->image('base/default.jpg',array('width'=> '100px', 'height'=> '100px')); ?></p>
                        <p><?= $this->HTML->image('base/default.jpg'); ?></p>
                        <?= h($post->image) ?>
                      <?php }else{ ?>
                        <i class="fas fa-book-open"></i>
                      <?php } ?>

                    </div>
                    <p>名前：<?= h($post['bookname']); ?></p>
                    <p>おすすめ度：
                      <span class="range-group">

                        <!-- <?php for ($j=1; $j <= h($post['recommends']); $j++):?>
                          <img src="../../img/base/star-on.png">
                        <?php endfor ?>
                        <?php if ( h($post['recommends']) < 5){
                          for ($j = h($post['recommends']); $j < 5; $j++):?>
                            <img src="../../img/base/star-off.png">
                          <?php endfor;?>
                        <?php } ?> -->

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
        </div>
      </div>
    </section>
    <p><?= ($_SESSION['Auth']['id']); ?></p>

  </main>
