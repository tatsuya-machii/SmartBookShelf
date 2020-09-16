<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- fontawesome読み込み -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
  <!-- js読み込み -->
  <?= $this->Html->script(['jquery', 'bootstrap'])?>
  <!-- css読み込み -->
  <?= $this->Html->css(['main', 'base', 'bootstrap']) ?>
  <title>Smart Book Shelf</title>
  <body>
    <header>
      <h1 class="hidden">Smart_Book_Shelf</h1>
      <!-- bootstrapを使ったヘッダー作成 -->
      <div class="container">
          <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
              <div class="navbar-header">
                  <a class="navbar-brand" href="#">  <i class="fas fa-book-open"></i>Smart Book Shelf</a>
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#gnav">
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                  </button>
              </div>
              <div class="collapse navbar-collapse" id="gnav">
                  <ul class="nav navbar-nav navbar-right">
                    <?php if ($_SESSION["Auth"]["id"]==1){ ?>
                      <li><a href="../admin/main.php"><?php echo $_SESSION["Auth"]["username"] ?></a></li>
                      <li>
                        <?= $this->Html->link('ログアウト', ['controller' => 'users', 'action' => 'logout', '?' => ['logout' => 1] ]) ?>
                      </li>
                    <?php }else{ ?>


                      <li><?= $this->HTML->link($_SESSION['Auth']['username'], '/users/main') ?></li>
                      <li>
                        <?= $this->Html->link('投稿一覧', '/posts/index') ?>
                      </li>
                      <li>
                        <?= $this->Html->link('ログアウト', '/users/logout?logout=1') ?>
                      </li>
                    <?php }; ?>
                  </ul>
                </div><!-- /.navbar-collapse -->
              </div>
          </nav>
      </div><!-- /container -->
    </header>



    <main class="main">
        <div class="container">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>
    <footer>
      <div id="footer">
        <?= $this->HTML->image('base/footer_img.png', array('alt' => 'フッターイメージ')) ?>
      </div>
    </footer>
</body>
</html>
