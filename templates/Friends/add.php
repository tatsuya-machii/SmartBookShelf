<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Friend $friend
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Friends'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="friends form content">
            <?= $this->Form->create($friend) ?>
            <fieldset>
                <legend><?= __('Add Friend') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('friends_id', ['options' => $users, 'model'=> 'User']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
