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
