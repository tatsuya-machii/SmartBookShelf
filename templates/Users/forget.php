<main>
  <div id="login_container">
    <p id="login_index">Smart Book Shelf</p>
    <div id="icon">
      <i class="fas fa-book-open"></i>
    </div>

    <?= $this->Form->create() ?>

      <p class="error"><?php if(!empty($result["error"])) {echo $result["error"];}?></p>
      <p style="width:300px;">
        登録されたメールアドレスを入力し、送信ボタンを押してください。
        登録が確認できた場合はメールで仮パスワードを送信します。
        メールの内容に沿ってお手続きください。
      </p>
      <?= $this->form->control('email', array('label' => false, 'required' => true, 'placeholder' => 'email')) ?>
      <?= $this->form->submit('送　　信',array('class' => 'btn btn-warning')) ?>
      <?= $this->Form->end() ?>
    <?= $this->HTML->link('ログイン画面に戻る', '/users/login', ['class' => 'grayLink']) ?>


  </div>
</main>
