<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $user
 */
?>
<main>
  <div id="login_container">
    <p id="login_index">Smart Book Shelf</p>
    <div id="icon">
      <i class="fas fa-book-open"></i>
    </div>
          <?= $this->Form->create($user) ?>
          <fieldset>
              <?=
                  $this->Form->control('username', ['label' => false, 'placeholder' => 'name']),
                  $this->Form->control('email', ['label' => false, 'placeholder' => 'email']),
                  $this->Form->control('password', ['label' => false, 'placeholder' => 'password']),
                  $this->Form->submit('登　　録', ['class' => "btn btn-warning"]);
              ?>
          </fieldset>
          <?= $this->Form->end() ?>
      <?= $this->HTML->link('アカウントをお持ちの方', '/users/login', ['class'=>'grayLink']) ?>
    </div>
  </main>
