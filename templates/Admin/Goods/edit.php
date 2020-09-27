<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Good $good
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $good->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $good->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Goods'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="goods form content">
            <?= $this->Form->create($good) ?>
            <fieldset>
                <legend><?= __('Edit Good') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('post_id', ['options' => $posts]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
