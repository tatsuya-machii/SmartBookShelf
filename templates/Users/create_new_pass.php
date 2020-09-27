<main>
  <div id="login_container">
    <p id="login_index">Smart Book Shelf</p>
    <div id="icon">
      <i class="fas fa-book-open"></i>
    </div>
    <p>仮パスワードと新しいパスワードを入力してください。</p>

      <?= $this->Form->create() ?>
      <?= $this->Form->control('email', ['required' => true, 'label'=>false, 'class'=>'hidden', 'value'=> $_SESSION['email'] ]) ?>
      <?= $this->Form->control('temporary_password', ['required' => true, 'label'=>false, 'placeholder'=>'temporary_password']) ?>
      <?= $this->Form->control('password', ['required' => true, 'label'=>false, 'placeholder'=>'password']) ?>
        <?= $this->Form->submit('仮パスワードを発行', ['class' => "btn btn-warning"]); ?>
      <?= $this->Form->end() ?>



  </div>
</main>
