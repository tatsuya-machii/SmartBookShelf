<?php

require "../../vendor/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;
  // twitter_login
  if (isset($_GET["twitter_login"])) {
  // twitter API
  define('TWITTER_API_KEY', '6f2GcwbdYhwua09KJxiYG2KvN');//Consumer Key (API Key)
  define('TWITTER_API_SECRET', 'xJTKZ9mN60TaiOvX0jm2eEgN5XIrVRCZJ0alKJ7fxK52cQKWh3');//Consumer Secret (API Secret)
  define('CALLBACK_URL', 'http://192.168.33.10/SBS/users/callback');//Twitterから認証した時に飛ぶページ場所

  //「abraham/twitteroauth」ライブラリのインスタンスを生成し、Twitterからリクエストトークンを取得する
  $connection = new TwitterOAuth(TWITTER_API_KEY, TWITTER_API_SECRET);
  $request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => CALLBACK_URL));

  //リクエストトークンはcallback.phpでも利用するのでセッションに保存する
  $_SESSION['oauth_token'] = $request_token['oauth_token'];
  $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
  //Twitterの認証画面のURL
  $oauthUrl = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
  header('Location: '.$oauthUrl);
  exit;
  }

?>
<main>
  <div id="login_container">
    <p id="login_index">Smart Book Shelf</p>
    <div id="icon">
      <i class="fas fa-book-open"></i>
    </div>

      <?= $this->Form->create() ?>
        <p class="error"><?php if(!empty($message["login_error"])){echo $message["login_error"];}?></p>
        <p class="error"><?php if(!empty($message["withdrawal"])) {echo $message["withdrawal"];}?></p>
        <p class="error"><?php  if (isset($message["mail"]))echo $message["mail"]; ?></p>
        <?= $this->Form->control('email', ['required' => true, 'label'=>false, 'placeholder'=>'email']) ?>
        <p class="error"><?php  if (isset($message["password"]))echo $message["password"]; ?></p>
        <?= $this->Form->control('password', ['required' => true, 'label'=>false, 'placeholder' => "password"]) ?>
        <?= $this->Form->submit('ログイン', ['class' => "btn btn-warning"]); ?>
      <?= $this->Form->end() ?>

    <a href="?twitter_login=1">
      <?= $this->HTML->image('base/sign-in-with-twitter-btn.png', array('margin' =>'0 auto')) ?>
    </a>
    <?= $this->HTML->link('新規アカウント作成', '/users/add', ['class'=>'grayLink']) ?>
    </br>
    <?= $this->HTML->link('パスワードをお忘れですか？', '/users/forget', ['class'=>'grayLink']) ?>
    <a class="grayLink" href="signup.php"></a></br>


  </div>
</main>
